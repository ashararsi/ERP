@extends('admin.layout.main')
@section('css')
    <style>
        #example_wrapper {
            margin-top: 70px !important;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Ledgers</h4>

                    <a href="{{ route('admin.ledger.create') }}" style="float:right;"
                       class="btn btn-success pull-right">Add New Ledgers</a>
                </div><!-- end card header -->
                <div class="card-body">

                    <div class="clearfix"></div>
                    <!-- /.box-header -->
                    <div class="panel-body pad table-responsive">
                        <table class="table table-bordered" style="text-transform:none;">
                            <thead>
                            <tr style="text-align:center;">
                                <th style="text-align:center;">Sr.No</th>
                                <th style="text-align:center;">Number</th>
                                <th style="text-align:center;">Name</th>
                                <th style="text-align:center;">Opening Balance</th>
                                <th style="text-align:center;">Action</th>
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
@stop
@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        function fetch_ledger() {

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route( 'admin.load-ledger' ) }}',
                data: $("#ledger-form").serialize(),
                beforeSend: function () {
                    showLoader();
                },
                success: function (data) {
                    var htmlData = "";
                    var k = 1;
                    for (i in data.data) {
                        var id = data.data[i].id;
                        var opening_balance = data.data[i].opening_balance;
                        if (opening_balance != 'undefined' && opening_balance != '' && opening_balance != null) {

                        } else {
                            opening_balance = 0;
                        }

                        htmlData += '<tr>';
                        htmlData += '<td>' + k + '</td>';
                        htmlData += '<td>' + data.data[i].number + '</td>';
                        htmlData += '<td>' + data.data[i].name + '</td>';
                        htmlData += '<td>' + numberWithCommas(opening_balance) + '</td><td>';
                        htmlData += '<a href="{{ url('admin/ledger') }}/' + id + '/edit" class="link-success fs-15"><i class="ri-edit-2-line"></i></a>';
                        htmlData += `<form style="display: inline-block;" method="POST" action="/admin/ledger/:id" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                    @csrf
                        @method('DELETE')
                        <button class="link-danger fs-15" type="submit" style="border: none; background-color: transparent;">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                        </form>`;
                        htmlData = htmlData.replace(':id', id);
                        htmlData += '</td></tr>';
                        k++;
                    }
                    $("#getData").html(htmlData);
                    $('#fetch_ob').html(data.ob);
                },
                complete: function () {
                    hideLoader();
                }
            });
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }

        function myFunction() {
            var company_id = document.getElementById("company_id").value;

            $.ajax({
                url: '{{url('admin/load-branches-against-company')}}',
                type: 'get',
                data: {
                    "company_id": company_id
                },
                success: function (data) {
                    $("#branch_id").empty();

                    $("#branch_id").append("<option value = 'null'>---Select Branches---</option>");
                    for (i in data) {
                        $("#branch_id").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                    }
                }
            })
        }

        $(document).ready(function () {
            fetch_ledger();
        });

    </script>
@endsection



