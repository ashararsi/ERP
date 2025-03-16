@extends('admin.layout.main')
@section('stylesheet')

@stop
@section('content')
    <div class="row box box-primary" style="background-color: white">
        <div class="row">
            <div class="col-lg-12 mt-3 row">
                <h3>Chart of Accounts</h3>
            </div>
            @if(isset(auth()->user()->roles[0]))
                @php
                    $company_session=  Session::get('company_session');
                    if(!$company_session) {
                        $company_session=0;
                    }

                $branch_session=  Session::get('branch_session');
                    if(!$branch_session){
                         $branch_session=0;
                    }
                @endphp
                @if(auth()->user()->roles[0]->name=="administrator")
                    <select style="display: none;" name='company_id'
                            class="form-control input-sm select2"
                            id="company_id"
                            onchange="myFunction()">
                        <option value="">---Select Company---</option>
                        @foreach($companies as $singleCompany)
                            @if($company_session==$singleCompany->id)
                                <option selected
                                        value="{{$singleCompany->id}}">{{$singleCompany->name}}</option>
                            @endif
                        @endforeach
                    </select>
                    <select style="display: none;" name='branch_id'
                            class="form-control input-sm select2"
                            id="branch_id">
                        @php
                            $html='';
                                if( $branch_session!=0){
                               $branch= \App\Models\Branch::find($branch_session);
                                 $html='<option selected value="'.$branch->id.'"> '.$branch->name.'</option>';
                                }
                        @endphp
                        {!! $html !!}
                    </select>
                @else
                    @php
                        $companies=\App\Models\Company::all();
                        $branchs=\App\Models\Branch::where('company_id',$company_session)->get();
                    @endphp
                    <select style="display: none;" name='company_id'
                            class="form-control input-sm select2"
                            id="company_id"
                            onchange="myFunction()">
                        <option value="">Select Company</option>
                        @foreach($companies as $company)

                                <option @if($company_session==$company->id) selected
                                        @endif value="{{$company->id}}">{{$company->name}}</option>

                        @endforeach
                    </select>
                    <select style="display: none;" name='branch_id'
                            class="form-control input-sm select2"
                            id="branch_id">
                        <option value="">Select Branch</option>
                        @foreach($branchs as $item)
                            @if(Auth::user()->isAbleTo('Branch_'.$item->id))
                                <option @if($branch_session==$item->id) selected
                                        @endif  value="{!! $item->id !!}">{!! $item->name !!}</option>
                            @endif
                        @endforeach
                    </select>
                @endif
            @endif
            <div class="row mt-3">
                <div class="form-group col-md-12">
                    <button type="button" class="btn btn-sm btn-primary"
                            style="width: 100%;font-size: 13px;"
                            onclick="loadReport();" id="load_report">Search
                    </button>
                </div>
            </div>
            <div class="row mt-3">
                <div class="form-group col-md-6">
                    <form action="{{route('admin.chart-of-accounts.store')}}" method="POST" id="print_form">@csrf
                        <input type="hidden" name="company_id" id="company_id_print">
                        <input type="hidden" name="branch_id" id="branch_id_print">
                        <input type="hidden" name="type" value="print">
                        <button type="button" class="btn btn-sm btn-default" id="print_form_button"
                                style="width: 100%;font-size: 13px;background:lightgray;"><i class="fa fa-print"
                                                                                             style="display:block !important;"></i>Print
                        </button>
                    </form>
                </div>
                <div class="form-group col-md-6">
                    <form action="{{route('admin.chart-of-accounts.store')}}" method="POST" id="excel_form">@csrf
                        <input type="hidden" name="company_id" id="company_id_excel">
                        <input type="hidden" name="branch_id" id="branch_id_excel">
                        <input type="hidden" name="type" value="excel">
                        <button type="button" class="btn btn-sm btn-default" id="excel_form_button"
                                style="width: 100%;font-size: 13px;background:lightgreen;color: white">Excel
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12 p-5 panel-body pad table-responsive" id="render_data_div"></div>

    </div>
@stop

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ url('adminlte') }}/bower_components/select2/dist/js/select2.full.min.js"></script>

    <script>

        jQuery(document).ready(function () {
            // $('.select2').select2();
            loadReport();
        });

        $('#print_form_button').click(function (e) {
            e.preventDefault();

            let company_id = $('#company_id').val();
            let branch_id = $('#branch_id').val();

            $('#company_id_print').val(company_id);
            $('#branch_id_print').val(branch_id);

            $('#print_form').submit();
        });

        $('#excel_form_button').click(function (e) {
            e.preventDefault();

            let company_id = $('#company_id').val();
            let branch_id = $('#branch_id').val();

            $('#company_id_excel').val(company_id);
            $('#branch_id_excel').val(branch_id);

            $('#excel_form').submit();
        });

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

                    $("#branch_id").append("<option value = ''>---Select Branches---</option>");
                    for (i in data) {
                        $("#branch_id").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                    }

                }
            })
        }

        function loadReport() {

            $('#load_report').html('<i class="fa fa-spin fa-refresh"></i>&nbsp;Load Report').attr('disabled', true);
            $.ajax({

                url: '{{route('admin.chart-of-accounts.store')}}',
                type: "POST",
                data: {
                    date_range: $('#date_range').val(),
                    company_id: $('#company_id').val(),
                    branch_id: $('#branch_id').val(),
                    type: 'web',
                    "_token": "{{ csrf_token() }}",
                }, beforeSend: function () {
                    showLoader();
                },
                success: function (response) {
                    $('#render_data_div').html(response);
                    $('#load_report').html('Load Report').removeAttr('disabled');
                }, complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    // $('#loader').addClass('hidden')
                    hideLoader();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('#load_report').html('Load Report').removeAttr('disabled');
                    return false;
                }
            });
        }

    </script>
@stop
