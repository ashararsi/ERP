@extends('layouts.app')
@section('stylesheet')
    <link rel="stylesheet" href="{{ url('adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <style>
        .col-md-4, .col-md-6 {
            padding: 10px;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Profit Loss Report</h4>

                </div><!-- end card header -->

                <div class="card-body">
                    <form id="ledger-form">
                        {{ csrf_field()}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group" style="margin-left: 5px">
                                    <label>Select Date</label>
                                    <input type="text" id="date_range" name="date_range" class="form-control"
                                           autocomplete="off">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-primary"
                                            style="width: 100%;font-size: 13px;margin-top: 5%;height: 40px;"
                                            onclick="FormControls.loadReport();" id="load_report">Search
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-default"
                                            formaction="profit-loss-report-prints?type=print" formmethod="post"
                                            style="margin:5px 5px 5px 5px;width: 100%;font-size: 13px;height: 40px;background:lightgray;"
                                            formtarget="_blank"><i class="fa fa-print"
                                                                   style="display:block !important;"></i>Print
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-default"
                                            formaction="profit-loss-report-prints?type=excel" formmethod="post"
                                            style="margin:5px 5px 5px 5px;width: 100%;font-size: 13px;height: 40px;background:lightgreen;color: white"
                                            formtarget="_blank"><i class="fa fa-print"
                                                                   style="display:block !important;"></i>Excel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <div id="content"></div>

                    {!! Form::open(['method' => 'POST', 'target' => '_blank', 'route' => ['admin.profit-loss-report-prints'], 'id' => 'report-form']) !!}
                    {!! Form::hidden('date_range-report', null, ['id' => 'date_range-report']) !!}
                    {!! Form::hidden('branch_id', null, ['id' => 'branch_id-report']) !!}
                    {!! Form::hidden('company_id', null, ['id' => 'company_id-report']) !!}
                    {!! Form::hidden('medium_type', null, ['id' => 'medium_type-report']) !!}
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
    <script
        src="{{ url('adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script>


        function myFunction() {
            var company_id = document.getElementById("company_id").value;

            $.ajax({
                url: '{{url('admin/load-branches-against-company')}}',
                type: 'get',
                data: {
                    "company_id": company_id
                }, beforeSend: function () {
                    showLoader();
                },
                success: function (data) {
                    $("#branch_id").empty();

                    $("#branch_id").append("<option value = ''>---Select Branches---</option>");
                    for (i in data) {
                        $("#branch_id").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                    }

                }, complete: function () {
                    hideLoader();
                }
            })
        }

        /**
         * Created by mustafa.mughal on 12/7/2017.
         */

//== Class definition
        var FormControls = function () {
            //== Private functions

            var baseFunction = function () {
                // To make Pace works on Ajax calls
                $(document).ajaxStart(function () {
                    Pace.restart()
                })

                // $('.select2').select2();

                $('#account_type_id').select2().on("select2:select", function (e) {
                    if ($(this).val() != '') {
                        $('#load_report').html('<i class="fa fa-spin fa-refresh"></i>&nbsp;Load Report').attr('disabled', true);
                    } else {
                        $('#load_report').html('Load Report').removeAttr('disabled');
                    }
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: route('admin.account_reports.load_groups'),
                        type: "POST",
                        data: {
                            account_type_id: $('#account_type_id').val(),
                        }, beforeSend: function () {
                            showLoader();
                        },
                        success: function (response) {
                            var dropdown = '<select name="group_id" id="group_id" class="form-control select2" style="width: 100%;"> <option value=""> Select a Parent Group </option>' + response.dropdown + '</select>';
                            $('#group_id_content').html(dropdown);
                            $('#group_id').select2();
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
                });

                var this_financial_year_start, this_financial_year_end, last_financial_year_start,
                    last_financial_year_end;

                if (moment() > moment().startOf('year').month(5).date(30)) {

                    this_financial_year_start = moment().startOf('year').month(6).date(1);
                    this_financial_year_end = moment().add(1, 'year').startOf('year').month(5).date(30);

                    last_financial_year_start = moment().subtract(1, 'year').startOf('year').month(6).date(1);
                    last_financial_year_end = moment().startOf('year').month(5).date(30);
                } else {

                    this_financial_year_start = moment().subtract(1, 'year').startOf('year').month(6).date(1);
                    this_financial_year_end = moment().startOf('year').month(5).date(30);

                    last_financial_year_start = moment().subtract(2, 'year').startOf('year').month(6).date(1);
                    last_financial_year_end = moment().subtract(1, 'year').startOf('year').month(5).date(30);
                }

                $('#date_range').daterangepicker({
                    "alwaysShowCalendars": true,
                    locale: {
                        format: 'DD/MM/YYYY',
                    },
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                        'This Fin Year': [this_financial_year_start, this_financial_year_end],
                        'Last Fin Year': [last_financial_year_start, last_financial_year_end],
                    },
                    startDate: this_financial_year_start,
                    endDate: this_financial_year_end,
                });

                $('#date_range').on('apply.daterangepicker', function (ev, picker) {
                    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                });
            }

            var loadReport = function () {

                $('#load_report').html('<i class="fa fa-spin fa-refresh"></i>&nbsp;Load Report').attr('disabled', true);
                $.ajax({

                    url: '{{route('admin.profit-loss-report-prints')}}',
                    type: "POST",
                    data: {
                        date_range: $('#date_range').val(),
                        company_id: $('#company_id').val(),
                        branch_id: $('#branch_id').val(),
                        medium_type: 'web',
                        "_token": "{{ csrf_token() }}",
                    }, beforeSend: function () {
                        showLoader();
                    },
                    success: function (response) {
                        $('#content').html(response);
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

            var printReport = function (medium_type) {
                $('#date_range-report').val($('#date_range').val());
                $('#branch_id-report').val($('#branch_id').val());
                $('#company_id-report').val($('#company_id').val());

                $('#medium_type-report').val(medium_type);
                $('#report-form').submit();
            }

            return {
                // public functions
                init: function () {
                    baseFunction();
                },
                loadReport: loadReport,
                printReport: printReport,
            };
        }();

        jQuery(document).ready(function () {
            FormControls.init();
        });
    </script>
@stop



