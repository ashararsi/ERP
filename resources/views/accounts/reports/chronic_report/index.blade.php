@extends('layouts.app')
@section('stylesheet')

@endsection
@section('content')

    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <!--div-->
        <div class="card">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <h3 style="float:left;">CHRONIC REPORT</h3>
                    <div class="box box-primary" style="padding-top:40px;">
                        <br>
                        <form id="ledger-form">
                            {{ csrf_field()}}
                            <div class="row">
                                <div class="col-md-4" style="float:left">
                                    <div class="form-group">
                                        <label>Select Session</label>
                                        <select name="session_id" class="form-control input-sm" id="mySelects">
                                            <option value="">---Select---</option>
                                            {!! $sessions !!}
                                        </select>
                                    </div>
                                </div>
                                {{--                                <div class="col-md-4" style="float:left">--}}
                                {{--                                    <div class="form-group">--}}
                                {{--                                        <label>Select Company</label>--}}
                                {{--                                        <select name="company_id" class="form-control input-sm" id="company_id"--}}
                                {{--                                                onchange="myFunction()">--}}
                                {{--                                            <option value="">---Select---</option>--}}
                                {{--                                            {!! $companies !!}--}}
                                {{--                                        </select>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                {{--                                <div class="col-md-4" style="float:left">--}}
                                {{--                                    <div class="form-group">--}}
                                {{--                                        <label>Select Branch</label>--}}
                                {{--                                        <select name='branch_id' class="form-control input-sm select2 branches"--}}
                                {{--                                                id="branch_id" onchange="branches()">--}}
                                {{--                                            <option value="">---Select---</option>--}}
                                {{--                                        </select>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}

                                @include('common-blade.index',['class_company' => 'col-md-4','class_branch' => 'col-md-4','company_id' => 'company_id','branch_id' => 'branch_id' ,'style' => 'float:left'])

                            </div>
                            <div class="row">
                                <div class="col-md-4" style="float:left">
                                    <div class="form-group">
                                        <label>Select Board</label>
                                        <select name="boards" class="form-control input-sm select2" id="boards"
                                                onchange="get_board()"></select>
                                    </div>
                                </div>
                                <div class="col-md-4" style="float:left">
                                    <div class="form-group">
                                        <label>Select Program</label>
                                        <select name="programs" class="form-control input-sm select2" id="programs"
                                                onchange="get_program()"></select>
                                    </div>
                                </div>
                                <div class="col-md-4" style="float:left">
                                    <div class="form-group">
                                        <label>Select Class</label>
                                        <select name='classes' class="form-control input-sm select2"
                                                id="classes" onchange="get_classes()"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" style="float:left">
                                    <div class="form-group">
                                        <label>Select Intake</label>
                                        <select name='intake' class="form-control input-sm select2"
                                                id="intake" onchange="get_intake()"></select>
                                    </div>
                                </div>
                                <div class="col-md-4" style="float:left">
                                    <div class="form-group">
                                        <label>Select Section</label>
                                        <select id="sections" name="sections" class="form-control select2">
                                            <option value="">---Select---</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="">
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-primary"
                                            style="width: 100%;margin-top: 25px;font-size: 13px;height: 40px;"
                                            onclick="fetch_ledger()">Search
                                    </button>
                                    <div style="display: flex !important; ">
                                        <button type="submit" class="btn btn-sm btn-default"
                                                formaction="{{ route( 'admin.chronic_report_print' ) }}?type=print"
                                                formmethod="post"
                                                style="margin:10px 5px 5px 5px;width: 50%;font-size: 13px;height: 40px;background:lightgray;"
                                                formtarget="_blank"><i class="fa fa-print"
                                                                       style="display:block !important;"></i>Print
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-default"
                                                formaction="{{ route( 'admin.chronic_report_print' ) }}?type=excel"
                                                formmethod="post"
                                                style="margin:10px 5px 5px 5px;width: 50%;font-size: 13px;height: 40px;background:lightgreen;color: white"
                                                formtarget="_blank">Excel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                        <!-- /.box-header -->
                        <div class="panel-body pad table-responsive">
                            <table id="records" class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Admission No</th>
                                    <th>Student Name</th>
                                    <th>Current Month Defaulter</th>
                                    <th>Previous Defaulter</th>
                                </tr>
                                </thead>
                                <tr id="fetch_ob"></tr>
                                <tbody id="getData"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('javascript')
    <script src="{{ url('adminlte') }}/bower_components/select2/dist/js/select2.full.min.js"></script>

    <!-- On Fetching Data -->
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });

        function fetch_ledger() {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route( 'admin.chronic_report_print' ) }}',
                data: $("#ledger-form").serialize(),
                beforeSend: function () {
                    showLoader();
                },
                success: function (data) {

                    var htmlData = "";
                    var k = 1;
                    var branch_name = "";
                    var existing_branch_name = "";
                    var existing_class = "";
                    var new_class = "";
                    var total_students = 0;

                    for (i in data.data) {
                        branch_name = data.data[i].branch_name;
                        if (existing_branch_name == branch_name) {
                            new_class = data.data[i].class_name;
                            if (existing_class == new_class) {
                                total_students++;
                                htmlData += '<tr>';
                                htmlData += '<td>' + data.data[i].reg_no + '</td>';
                                htmlData += '<td>' + data.data[i].name + '</td>';
                                htmlData += '<td style = "color:white;background-color:#ef4545;">' + data.data[i].term + '</td>';
                                htmlData += '<td style = "color:white;background-color:#ef4545;">' + data.data[i].shift + '</td>';
                                htmlData += '</tr>';
                                k++;
                            } else {
                                htmlData += '<tr  style = "text-align: center;background-color: #bbb1b1;color: black;font-weight: 700;"><td>Total Students:</td><td colspan = "5">' + total_students + '</td></tr>';
                                total_students = 0;
                                total_students++;
                                existing_class = data.data[i].class_name;
                                htmlData += '<tr  style = "background: #9506e2;color: black;text-align: left;font-weight: 700;"><td colspan = "6">' + data.data[i].class_name + '</td></tr>';

                                htmlData += '<tr>';
                                htmlData += '<td>' + data.data[i].reg_no + '</td>';
                                htmlData += '<td>' + data.data[i].name + '</td>';
                                htmlData += '<td style = "color:white;background-color:#ef4545;">' + data.data[i].term + '</td>';
                                htmlData += '<td style = "color:white;background-color:#ef4545;">' + data.data[i].shift + '</td>';
                                htmlData += '</tr>';
                                k++;
                            }
                        } else {
                            if (k > 1) {
                                htmlData += '<tr  style = "text-align: center;background-color: #bbb1b1;color: black;font-weight: 700;"><td>Total Students:</td><td colspan = "5">' + total_students + '</td></tr>';
                                total_students = 0;
                                total_students++;
                            }

                            existing_branch_name = data.data[i].branch_name;
                            existing_class = data.data[i].class_name;

                            htmlData += '<tr  style = "background: #9506e2;color: black;text-align: left;font-weight: 700;"><td colspan = "6">' + data.data[i].branch_name + '</td></tr>';
                            htmlData += '<tr style = "background: #9506e2;color: black;text-align: left;font-weight: 700;"><td colspan = "6">' + data.data[i].class_name + '</td></tr>';

                            htmlData += '<tr>';

                            htmlData += '<td>' + data.data[i].reg_no + '</td>';
                            htmlData += '<td>' + data.data[i].name + '</td>';
                            htmlData += '<td style = "color:white;background-color:#ef4545;">' + data.data[i].term + '</td>';
                            htmlData += '<td style = "color:white;background-color:#ef4545;">' + data.data[i].shift + '</td>';
                            htmlData += '</tr>';
                            k++;

                        }
                    }
                    htmlData += '<tr  style = "text-align: center;background-color: #bbb1b1;color: black;font-weight: 700;"><td>Total Students:</td><td colspan = "5">' + total_students + '</td></tr>';

                    $("#getData").html(htmlData);
                    $('#fetch_ob').html(data.ob);
                },
                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    // $('#loader').addClass('hidden')
                    hideLoader();
                },
            });
        }

    </script>
    <!-- Company And City Ajax Call  to Get Branch Record-->
    <script>
        function myFunction() {
            {{--var company_id = document.getElementById("company_id").value;--}}

            {{--$.ajax({--}}
            {{--    url: '{{url('admin/load-branches-against-company')}}',--}}
            {{--    type: 'get',--}}
            {{--    data: {--}}
            {{--        "company_id": company_id--}}
            {{--    },--}}
            {{--    success: function (data) {--}}
            {{--        $("#branch_id").empty();--}}

            {{--        $("#branch_id").append("<option value = 'null'>---Select Branches---</option>");--}}
            {{--        for (i in data) {--}}
            {{--            $("#branch_id").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");--}}
            {{--        }--}}

            {{--    }--}}
            // });
        }

        function branches() {

            var branch_id = $('#branch_id').val();
            var session_id = document.getElementById("mySelects").value;


            var op = "";
            $.ajax({
                type: 'get',

                url: '{{ route("admin.load-boards-against-branches") }}',
                data: {
                    'branch_id': branch_id,
                    'session_id': session_id
                },
                success: function (data) {

                    $("#boards").empty();
                    // here price is coloumn name in products table data.coln name

                    $("#boards").append("<option value = 'null'>---Select Boards---</option>");
                    for (i in data) {
                        $("#boards").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                    }


                },
                error: function () {
                }
            });
        }

        function get_board() {
            var session_id = document.getElementById("mySelects").value;
            var board_id = $('#boards').val();
            var branch_id = $('#branch_id').val();


            var a = $('#program').parent();


            var op = "";


            $.ajax({
                type: 'get',
                url: '{{ route("admin.load-programs-against-boards") }}',
                data: {'board_id': board_id, 'branch_id': branch_id, 'session_id': session_id},
                dataType: 'json',//return data will be json
                async: false,
                success: function (data) {

                    $("#programs").empty();
                    // here price is coloumn name in products table data.coln name

                    $("#programs").append("<option value = 'null'>---Select Programs---</option>");
                    for (i in data) {
                        $("#programs").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                    }

                },
                error: function () {
                }
            });
        }

        function get_program() {
            var session_id = document.getElementById("mySelects").value;
            var program_id = $('#programs').val();
            var branch_id = $('#branch_id').val();
            var board_id = $('#boards').val();


            $.ajax({
                type: 'get',
                url: '{{ route("admin.load-classes-against-programs") }}',
                data: {
                    'board_id': board_id,
                    'branch_id': branch_id,
                    'program_id': program_id,
                    'session_id': session_id
                },
                dataType: 'json',//return data will be json
                success: function (data) {
                    $("#classes").empty();
                    // here price is coloumn name in products table data.coln name

                    $("#classes").append("<option value = 'null'>---Select Class---</option>");
                    for (i in data) {
                        $("#classes").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                    }


                },
                error: function () {
                }
            });
        }

        function get_classes() {

            var class_id = $('#classes').val();
            var session_id = document.getElementById("mySelects").value;
            var branch_id = $('#branch_id').val();
            var board_id = $('#boards').val();
            var program_id = $('#programs').val();


            $.ajax({
                type: 'get',
                url: '{{ route("admin.load-intake-against-classes") }}',
                data: {
                    'board_id': board_id,
                    'branch_id': branch_id,
                    'program_id': program_id,
                    'class_id': class_id,
                    'session_id': session_id
                },
                dataType: 'json',//return data will be json
                success: function (data) {
                    $("#intake").empty();

                    $("#intake").append("<option value = 'null'>---Select Intake---</option>");
                    for (i in data) {
                        $("#intake").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                    }


                },
                error: function () {
                }
            });
        }

        function get_intake() {

            var intake_id = $('#intake').val();
            var session_id = document.getElementById("mySelects").value;
            var branch_id = $('#branch_id').val();
            var board_id = $('#boards').val();
            var program_id = $('#programs').val();
            var class_id = $('#classes').val();

            $.ajax({
                type: 'get',
                url: '{!! route('admin.get_student_board_program_class_session_intake') !!}',
                data: {
                    'board_id': board_id,
                    'branch_id': branch_id,
                    'program_id': program_id,
                    'class_id': class_id,
                    'session_id': session_id,
                    'intake_id': intake_id
                },
                dataType: 'json',//return data will be json
                success: function (data) {
                    $('#sections').empty();

                    $("#sections").append("<option value = 'null'>---Select Section---</option>");
                    $.each(data, function (k, v) {
                        $('#sections').append($('<option  class = "class" value=' + v.id + '>' + v.name + '</option>'));
                    });


                },
                error: function () {
                }
            });

        }

    </script>
@endsection
