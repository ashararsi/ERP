@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{ url('adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <style>
        #example_wrapper {
            margin-top: 70px !important;
        }

        .col-md-3 {
            padding: 10px;
        }

        .col-md-6 {
            padding: 10px;
        }

        .col-md-12 {
            padding: 10px;
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Comparative Profit Loss Report</h4>

                </div><!-- end card header -->

                <div class="card-body">
                    <form id="ledger-form">
                        {{ csrf_field()}}

                        <div class="col-md-3" style="float:left">
                            <div class="form-group">
                                <label>Current Month</label>

                                <input id="date_range" class="form-control" name="date_range" type="text"
                                       autocomplete="off">

                            </div>
                        </div>
                        <div class="col-md-3" style="float:left">
                            <div class="form-group">
                                <label>Previous Month</label>

                                <input id="date_range_1" class="form-control" name="date_range_1" type="text"
                                       autocomplete="off">

                            </div>
                        </div>

                        <div class="col-md-3" style="float:left">
                            <div class="form-group">
                                <label>Current Quater</label>

                                <input id="date_range_2" class="form-control" name="date_range_2" type="text"
                                       autocomplete="off">

                            </div>
                        </div>
                        <div class="col-md-3" style="float:left">
                            <div class="form-group">
                                <label>Previous Quater</label>

                                <input id="date_range_3" class="form-control" name="date_range_3" type="text"
                                       autocomplete="off">

                            </div>
                        </div>
                        <div class="col-md-3" style="float:left">
                            <div class="form-group">
                                <label>Current Year</label>

                                <input id="date_range_4" class="form-control" name="date_range_4" type="text"
                                       autocomplete="off">

                            </div>
                        </div>
                        <div class="col-md-3" style="float:left">
                            <div class="form-group">
                                <label>previous Year</label>

                                <input id="date_range_5" class="form-control" name="date_range_5" type="text"
                                       autocomplete="off">

                            </div>
                        </div>
                    <!--div class="form-group col-md-3 " style = "float:left;">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    {!! Form::text('date_range_previous', null, ['id' => 'date_range_previous', 'class' => 'form-control']) !!}
                        </div>
                    </div-->

                        <div class="form-group col-md-3 @if($errors->has('branch_id')) has-error @endif"
                             style="float:left;">

                            <span id="branch_id_handler"></span>
                        </div>

                        <div class="form-group col-md-2 @if($errors->has('group_id')) has-error @endif">
                            <a href="javascript:void(0);" onclick="FormControls.loadReport();" id="load_report"
                               class="btn btn-success">Load Report</a>


                        </div>

                        <div class="clear clearfix"></div>

                        <div id="content"></div>

                    {!! Form::open(['method' => 'POST', 'target' => '_blank', 'route' => ['admin.cmp-profit-loss-report-prints'], 'id' => 'report-form']) !!}
                    {!! Form::hidden('date_range', null, ['id' => 'date_range-report']) !!}
                    {!! Form::hidden('date_range_1', null, ['id' => 'date_range_1']) !!}
                    {!! Form::hidden('date_range_2', null, ['id' => 'date_range_2']) !!}
                    {!! Form::hidden('date_range_3', null, ['id' => 'date_range_3']) !!}
                    {!! Form::hidden('date_range_4', null, ['id' => 'date_range_4']) !!}
                    {!! Form::hidden('date_range_5', null, ['id' => 'date_range_5']) !!}
                    {!! Form::hidden('branch_id', null, ['id' => 'branch_id-report']) !!}
                    {!! Form::hidden('group_id', null, ['id' => 'group_id-report']) !!}
                    {!! Form::hidden('medium_type', null, ['id' => 'medium_type-report']) !!}
                    {!! Form::close() !!}
                </div>
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

                            $('.select2').select2();

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
                                    },
                                    success: function (response) {
                                        var dropdown = '<select name="group_id" id="group_id" class="form-control select2" style="width: 100%;"> <option value=""> Select a Parent Group </option>' + response.dropdown + '</select>';
                                        $('#group_id_content').html(dropdown);
                                        $('#group_id').select2();
                                        $('#load_report').html('Load Report').removeAttr('disabled');
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        $('#load_report').html('Load Report').removeAttr('disabled');
                                        return false;
                                    }
                                });
                            });

                            $('#date_range').daterangepicker({
                                "alwaysShowCalendars": true,
                                locale: {
                                    // cancelLabel: 'Clear'
                                },
                                ranges: {
                                    'Today': [moment(), moment()],
                                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                                    'Last Year': [moment().subtract(1, 'year').startOf('month'), moment().subtract(1, 'year').endOf('year')],
                                },
                                startDate: moment().subtract(29, 'days'),
                                endDate: moment()
                            });
                            $('#date_range_1').daterangepicker({
                                "alwaysShowCalendars": true,
                                locale: {
                                    // cancelLabel: 'Clear'
                                },
                                ranges: {
                                    'Today': [moment(), moment()],
                                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                                    'Last Year': [moment().subtract(1, 'year').startOf('month'), moment().subtract(1, 'year').endOf('year')],
                                },
                                startDate: moment().subtract(29, 'days'),
                                endDate: moment()
                            });

                            $('#date_range_2').daterangepicker({
                                "alwaysShowCalendars": true,
                                locale: {
                                    // cancelLabel: 'Clear'
                                },
                                ranges: {
                                    'Today': [moment(), moment()],
                                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                                    'Last Year': [moment().subtract(1, 'year').startOf('month'), moment().subtract(1, 'year').endOf('year')],
                                },
                                startDate: moment().subtract(29, 'days'),
                                endDate: moment()
                            });
                            $('#date_range_3').daterangepicker({
                                "alwaysShowCalendars": true,
                                locale: {
                                    // cancelLabel: 'Clear'
                                },
                                ranges: {
                                    'Today': [moment(), moment()],
                                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                                    'Last Year': [moment().subtract(1, 'year').startOf('month'), moment().subtract(1, 'year').endOf('year')],
                                },
                                startDate: moment().subtract(29, 'days'),
                                endDate: moment()
                            });
                            $('#date_range_4').daterangepicker({
                                "alwaysShowCalendars": true,
                                locale: {
                                    // cancelLabel: 'Clear'
                                },
                                ranges: {
                                    'Today': [moment(), moment()],
                                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                                    'Last Year': [moment().subtract(1, 'year').startOf('month'), moment().subtract(1, 'year').endOf('year')],
                                },
                                startDate: moment().subtract(29, 'days'),
                                endDate: moment()
                            });
                            $('#date_range_5').daterangepicker({
                                "alwaysShowCalendars": true,
                                locale: {
                                    // cancelLabel: 'Clear'
                                },
                                ranges: {
                                    'Today': [moment(), moment()],
                                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                                    'Last Year': [moment().subtract(1, 'year').startOf('month'), moment().subtract(1, 'year').endOf('year')],
                                },
                                startDate: moment().subtract(29, 'days'),
                                endDate: moment()
                            });


                            $('input[name="date_range"]').on('apply.daterangepicker', function (ev, picker) {
                                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                            });

                            $('input[name="date_range"]').on('cancel.daterangepicker', function (ev, picker) {
                                // $(this).val('');
                            });
                        }

                        var loadReport = function () {

                            $('#load_report').html('<i class="fa fa-spin fa-refresh"></i>&nbsp;Load Report').attr('disabled', true);
                            $.ajax({

                                url: '{{route('admin.cmp-profit-loss-report-prints')}}',
                                type: "POST",
                                data: {
                                    date_range: $('#date_range').val(),
                                    date_range_1: $('#date_range_1').val(),
                                    date_range_2: $('#date_range_2').val(),
                                    date_range_3: $('#date_range_3').val(),
                                    date_range_4: $('#date_range_4').val(),
                                    date_range_5: $('#date_range_5').val(),
                                    medium_type: 'web',
                                    "_token": "{{ csrf_token() }}",
                                },
                                success: function (response) {
                                    $('#content').html(response);
                                    $('#load_report').html('Load Report').removeAttr('disabled');
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    $('#load_report').html('Load Report').removeAttr('disabled');
                                    return false;
                                }
                            });
                        }

                        var printReport = function (medium_type) {
                            $('#date_range-report').val($('#date_range').val());
                            $('#date_range-report_1').val($('#date_range_1').val());
                            $('#date_range-report_2').val($('#date_range_2').val());
                            $('#date_range-report_3').val($('#date_range_3').val());
                            $('#date_range-report_4').val($('#date_range_4').val());
                            $('#date_range-report_5').val($('#date_range_5').val());
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



