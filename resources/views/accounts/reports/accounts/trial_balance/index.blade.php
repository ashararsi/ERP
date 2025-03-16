@extends('layouts.app')
@section('stylesheet')
    <link rel="stylesheet" href="{{ url('adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <style>
        #example_wrapper {
            margin-top: 70px !important;
        }

        .col-md-4 {
            padding: 10px;
        }

        .col-md-6 {
            padding: 10px;
        }

        .col-md-12 {
            padding: 10px;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Trial Balance Report</h4>
                </div><!-- end card header -->
                <div class="card-body row">
                    <div class="col-md-4" style="float:left">
                        <div class="form-group">
                            {!! Form::label('date_range', 'Date Range*', ['class' => 'control-label']) !!}
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input id="date_range" class="form-control" name="date_range" type="text"
                                       autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4" style="float:left">
                        <div class="form-group">
                            {!! Form::label('view_as', 'View As', ['class' => 'control-label']) !!}
                            <select name="view_as" id="view_as" class="form-control view_as">
                                <option value="0">Groups & Ledgers</option>
                                <option value="1">Ledgers Only</option>
                            </select>
                        </div>
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
                                       $branch= \App\Models\Branches::find($branch_session);
                                         $html='<option selected value="'.$branch->id.'"> '.$branch->name.'</option>';
                                        }
                                @endphp
                                {!! $html !!}
                            </select>
                        @else
                            @php
                                $companies=\App\Models\Company::all();
                                $branchs=\App\Models\Branches::where('company_id',$company_session)->get();
                            @endphp
                            <select style="display: none;" name='company_id'
                                    class="form-control input-sm select2"
                                    id="company_id"
                                    onchange="myFunction()">
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    @if(Auth::user()->isAbleTo('Company_'.$company->id))
                                        <option @if($company_session==$company->id) selected
                                                @endif value="{{$company->id}}">{{$company->name}}</option>
                                    @endif
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <button type="button" class="btn btn-sm btn-primary"
                                    style="width: 100%;font-size: 13px;margin-top: 25px;height: 40px;"
                                    onclick="loadReport();" id="load_report">Load Report
                            </button>
                        </div>
                    </div>
                </div>

                <div id="content"></div>

                {!! Form::open(['method' => 'POST', 'target' => '_blank', 'route' => ['admin.trial-balance-report-print'], 'id' => 'report-form']) !!}
                {!! Form::hidden('date_range', null, ['id' => 'date_range-report']) !!}
                {!! Form::hidden('branch_id', null, ['id' => 'branch_id-report']) !!}
                {!! Form::hidden('employee_id', null, ['id' => 'employee_id-report']) !!}
                {!! Form::hidden('company_id', null, ['id' => 'company_id-report']) !!}
                {!! Form::hidden('department_id', null, ['id' => 'department_id-report']) !!}
                {!! Form::hidden('entry_type_id', null, ['id' => 'entry_type_id-report']) !!}
                {!! Form::hidden('account_type_id', null, ['id' => 'account_type_id-report']) !!}
                {!! Form::hidden('group_id', null, ['id' => 'group_id-report']) !!}
                {!! Form::hidden('medium_type', null, ['id' => 'medium_type-report']) !!}
                {!! Form::hidden('view_as', null, ['id' => 'view_as-report']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    </div>
@stop
@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="{{ url('adminlte') }}/bower_components/select2/dist/js/select2.full.min.js"></script>

    <script src="{{ url('adminlte') }}/bower_components/PACE/pace.min.js"></script>
    <!-- date-range-picker -->
    <script src="{{ url('adminlte') }}/bower_components/moment/min/moment.min.js"></script>
    <script src="{{ url('adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="{{ asset('js/trial_balance.js')}}"></script>
    <script>
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

                url: '{{route('admin.trial-balance-report-print')}}',
                type: "POST",
                data: {
                    date_range: $('#date_range').val(),
                    company_id: $('#company_id').val(),
                    branch_id: $('#branch_id').val(),
                    account_type_id: $('#account_type_id-report').val(),
                    medium_type: 'web',
                    view_as: $('#view_as').val(),
                    "_token": "{{ csrf_token() }}",
                }, beforeSend: function () {
                    showLoader();
                },
                success: function (response) {
                    $('#content').html(response);
                    $('#load_report').html('Load Report').removeAttr('disabled');
                }, complete: function () {
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



