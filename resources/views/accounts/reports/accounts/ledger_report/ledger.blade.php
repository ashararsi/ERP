@extends('layouts.app')
@section('stylesheet')
    <link rel="stylesheet" href="{{ url('adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <style>
        .col-md-4, .col-md-12 {
            padding: 10px;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Ledger Report</h4>

                </div><!-- end card header -->

                <div class="card-body">
                    <form id="ledger-form">
                        {{ csrf_field()}}

                        <input type="hidden" id="branch_id_selected"
                               @if(isset($branch)) value="{{ $branch->id }}" @endif>

                        <input type="hidden" id="start_date_selected"
                               @if(isset($start_date)) value="{{ $start_date }}" @endif>

                        <input type="hidden" id="end_date_selected"
                               @if(isset($end_date)) value="{{ $end_date }}" @endif>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Select Date</label>
                                    <input class="form-control" name="date_range" type="text" id="date_range"
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
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Select Ledger</label>
                                    <select multiple name='leadger_idd[]' class="form-control" id="search_ledger_id">
                                        @if(isset($ledger))
                                            <option selected value="{{$ledger->id}}">{{ $ledger->name }}</option>
                                        @else
                                            <option value="">---Select---</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12" style="">
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-primary"
                                            style="width: 100%;margin-top: 25px;font-size: 13px;margin-bottom: 5px;height: 40px;"
                                            onclick="fetch_ledger()">Search
                                    </button>
                                    <div style="display: flex !important; ">
                                        <button type="submit" class="btn btn-sm btn-default"
                                                formaction="ledger-report-print?type=print" formmethod="post"
                                                style="margin:10px 5px 5px 5px;width: 50%;font-size: 13px;height: 40px;background:lightgray;"
                                                formtarget="_blank"><i class="fa fa-print"
                                                                       style="display:block !important;"></i>Print
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-default"
                                                formaction="ledger-report-print?type=excel" formmethod="post"
                                                style="margin:10px 5px 5px 5px;width: 50%;font-size: 13px;height: 40px;background:lightgreen;color: white"
                                                formtarget="_blank">Excel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <div class="panel-body pad table-responsive">
                        <table class="table table-bordered data_table" style="text-transform:none;">
                            <thead>
                            <tr style="text-align:center;">
                                <th style="text-align:center;">Date</th>
                                <th style="text-align:center;">Voucher Number</th>
                                <th style="text-align:center;">Voucher Type</th>
                                <th style="text-align:center;">Narration</th>
                                <th style="text-align:center;">DR</th>
                                <th style="text-align:center;">CR</th>
                                <th style="text-align:center;">Opening Balance</th>
                            </tr>
                            </thead>
                            <tbody id="getData"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('javascript')
    <script src="{{ url('adminlte') }}/bower_components/select2/dist/js/select2.full.min.js"></script>

    <script src="{{ url('adminlte') }}/bower_components/PACE/pace.min.js"></script>
    <!-- date-range-picker -->
    <script src="{{ url('adminlte') }}/bower_components/moment/min/moment.min.js"></script>
    <script
        src="{{ url('adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script>
        function fetch_ledger() {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('admin.ledger_report_print')}}',
                data: $("#ledger-form").serialize(),
                beforeSend: function () {
                    showLoader();
                },
                success: function (data1) {
                    var htmlData = "";
                    var data2 = data1.data;
                    for (j in data2) {

                        var data = data2[j];
                        htmlData += '<tr>';
                        htmlData += '<th colspan="6">' + data.ledger_name + '</th>';
                        htmlData += data.ob;
                        htmlData += '</tr>';

                        for (i in data.data) {

                            htmlData += '<tr>';
                            htmlData += '<td>' + data.data[i].voucher_date + '</td>';
                            htmlData += '<td><a href="/admin/show/' + data.data[i].voucher_id + '" target="_blank">' + data.data[i].number + '</a></td>';
                            htmlData += '<td>' + data.data[i].vt + '</td>';
                            // htmlData+='<td>'+data.data[i].narration+'</td>';
                            // htmlData += '<td><a href="/admin/bpv-edit?id=' + data.data[i].voucher_id + '" target="_blank">' + data.data[i].narration + '</a></td>';
                            htmlData += '<td>' + data.data[i].narration + '</a></td>';
                            htmlData += '<td style="text-align: right;">' + data.data[i].dr_amount + '</td>';
                            htmlData += '<td style="text-align: right;">' + data.data[i].cr_amount + '</td>';
                            htmlData += '<td style="text-align: right;">' + data.data[i].balance + '</td>';
                            htmlData += '</tr>';

                        }

                        htmlData += '<tr>';
                        htmlData += '<td colspan="4"></td>';
                        htmlData += '<th style="text-align: right;">' + data.total_dr + '</th>';
                        htmlData += '<th style="text-align: right;">' + data.total_cr + '</th>';
                        htmlData += '<th style="text-align: right;">' + data.balance + '</th>';
                        htmlData += '</tr>';

                    }


                    $("#getData").html(htmlData);
                }, complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    // $('#loader').addClass('hidden')
                    hideLoader();
                }
            })
        }

        $(document).ready(function () {

            let branch_id_selected = $('#branch_id_selected').val();
            let ledger_selected = $('#ledger_selected').val();
            let start_date_selected = $('#start_date_selected').val();
            let end_date_selected = $('#end_date_selected').val();

            // if (branch_id_selected != '') {
            //     myFunction();
            // }

            // $('.select2').select2({
            //     placeholder: 'Select an option',
            //     allowClear: true,
            // });
            let customOptionSelected = false;

            $('#search_ledger_id').select2({
                placeholder: 'Select an option',
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.ledger_search')}}',
                    dataType: 'json',
                    delay: 500,
                    transport: function (params, success, failure) {
                        if (customOptionSelected) {
                            // Do not make the AJAX call if the custom option is selected
                            return $.ajax();
                        }

                        return $.ajax({
                            url: params.url,
                            dataType: params.dataType,
                            data: {
                                item: params.data.term,
                                company_id: $("#company_id").val(),
                                branch_id: $("#branch_id").val(),
                                type: $("#search_type").val()
                            },
                            success: success,
                            failure: failure
                        });
                    },
                    processResults: function (data) {
                        let newData = data;

                        @if(!isset($ledger))
                        if (!customOptionSelected) {
                            // Only add the custom option if it's not selected
                            newData.push({id: 0, text: 'All Ledgers'});
                        }
                        @endif

                            return {
                            results: newData
                        };
                    },
                }
            }).on('select2:select', function (e) {
                if (e.params.data.id === 0) {
                    customOptionSelected = true;
                }
            }).on('select2:unselect', function (e) {
                customOptionSelected = false;
            });


            var this_financial_year_start, this_financial_year_end, last_financial_year_start, last_financial_year_end;

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
                startDate: start_date_selected != 0 ? start_date_selected : this_financial_year_start,
                endDate: end_date_selected != 0 ? end_date_selected : this_financial_year_end,
            });

            $('#date_range').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            fetch_ledger();
        });

        function myFunction() {
            var company_id = document.getElementById("company_id").value;
            let branch_id_selected = $('#branch_id_selected').val();

            $.ajax({
                url: '{{url('admin/load-branches-against-company')}}',
                type: 'get',
                data: {
                    "company_id": company_id
                }, beforeSend: function () {
                    showLoader();
                },
                success: function (data) {
                    $("#bID").empty();

                    $("#bID").append("<option value = ''>---Select Branches---</option>");
                    for (i in data) {
                        if (branch_id_selected == data[i].id) {
                            $("#bID").append("<option selected value=" + data[i].id + ">" + data[i].name + "</option>");
                        } else {
                            $("#bID").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
                        }
                    }
                    if (branch_id_selected != '') {
                        fetch_ledger();
                    }
                }, complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    // $('#loader').addClass('hidden')
                    hideLoader();
                }
            })
        }
    </script>
@stop


