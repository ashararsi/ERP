@extends('admin.layout.main')
@section('stylesheet')
    <link rel="stylesheet"
          href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">

    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"/>
@stop
@section('content')
    <style>
        #example_wrapper {
            margin-top: 70px !important;
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Voucher</h4>

{{--                        <div class="btn-group pull-right" role="group" style="float:right;"--}}
{{--                             aria-label="Button group with nested dropdown">--}}
{{--                            <div class="btn-group" role="group">--}}
{{--                                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle"--}}
{{--                                        data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                    Add New Voucher--}}
{{--                                </button>--}}
{{--                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">--}}

{{--                                        <li><a class="dropdown-item" href="{{ route('admin.gjv-create') }}">GJV ---}}
{{--                                                Journal Voucher</a></li>--}}


{{--                                        <li><a class="dropdown-item" href="{{ route('admin.crv-create') }}">CRV - Cash--}}
{{--                                                Receipt Voucher</a></li>--}}


{{--                                        <li><a class="dropdown-item" href="{{ route('admin.cpv-create') }}">CPV - Cash--}}
{{--                                                Payment Voucher</a></li>--}}


{{--                                        <li><a class="dropdown-item" href="{{ route('admin.brv-create') }}">BRV - Bank--}}
{{--                                                Receipt Voucher</a></li>--}}

{{--                                        <li><a class="dropdown-item" href="{{ route('admin.bpv-create') }}">BPV - Bank--}}
{{--                                                Payment Voucher</a></li>--}}

{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                </div><!-- end card header -->
                <div class="card-body">
{{--                    <form id="ledger-form">--}}
{{--                        {{ csrf_field()}}--}}
{{--                        <div class="row">--}}

{{--                                @php--}}
{{--                                    $company_session=  Session::get('company_session');--}}
{{--                                    if(!$company_session) {--}}
{{--                                        $company_session=0;--}}
{{--                                    }--}}

{{--                                $branch_session=  Session::get('branch_session');--}}
{{--                                    if(!$branch_session){--}}
{{--                                         $branch_session=0;--}}
{{--                                    }--}}
{{--                                @endphp--}}

{{--                                    <select style="display: none;" name='company_id'--}}
{{--                                            class="form-control input-sm select2"--}}
{{--                                            id="company_id"--}}
{{--                                            onchange="myFunction()">--}}
{{--                                        <option value="">---Select Company---</option>--}}
{{--                                        @foreach($company as $singleCompany)--}}
{{--                                            @if($company_session==$singleCompany->id)--}}
{{--                                                <option selected--}}
{{--                                                        value="{{$singleCompany->id}}">{{$singleCompany->name}}</option>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                    <select style="display: none;" name='branch_id'--}}
{{--                                            class="form-control input-sm select2"--}}
{{--                                            id="branch_id">--}}
{{--                                        @php--}}
{{--                                            $html='';--}}
{{--                                                if( $branch_session!=0){--}}
{{--                                               $branch= \App\Models\Branch::find($branch_session);--}}
{{--                                                 $html='<option selected value="'.$branch->id.'"> '.$branch->name.'</option>';--}}
{{--                                                }--}}
{{--                                        @endphp--}}
{{--                                        {!! $html !!}--}}
{{--                                    </select>--}}

{{--                                    @php--}}
{{--                                        $companies=\App\Models\Company::all();--}}
{{--                                        $branchs=\App\Models\Branch::where('company_id',$company_session)->get();--}}
{{--                                    @endphp--}}
{{--                                    <select style="display: none;" name='company_id'--}}
{{--                                            class="form-control input-sm select2"--}}
{{--                                            id="company_id"--}}
{{--                                            onchange="myFunction()">--}}
{{--                                        <option value="">Select Company</option>--}}
{{--                                        @foreach($companies as $company)--}}
{{--                                            @if(Auth::user()->isAbleTo('Company_'.$company->id))--}}
{{--                                                <option @if($company_session==$company->id) selected--}}
{{--                                                        @endif value="{{$company->id}}">{{$company->name}}</option>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                    <select style="display: none;" name='branch_id'--}}
{{--                                            class="form-control input-sm select2"--}}
{{--                                            id="branch_id">--}}
{{--                                        <option value="">Select Branch</option>--}}
{{--                                        @foreach($branchs as $item)--}}
{{--                                            @if(Auth::user()->isAbleTo('Branch_'.$item->id))--}}
{{--                                                <option @if($branch_session==$item->id) selected--}}
{{--                                                        @endif  value="{!! $item->id !!}">{!! $item->name !!}</option>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}


{{--                            <div class="col-md-6" style="padding:5px;">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Select Date</label>--}}
{{--                                    <input type="text" id="date_range" name="date_range" class="form-control"--}}
{{--                                           autocomplete="off">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-6" style="padding:5px;">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Select Voucher Type</label>--}}
{{--                                    <select name='voucher_type' class="form-control input-sm select2">--}}
{{--                                        <option value="">---Select Voucher Type---</option>--}}

{{--                                            <option value="1">General Voucher</option>--}}
{{--                                              <option value="2">Cash Receipt Voucher</option>--}}
{{--                                              <option value="3">Cash Payment Voucher</option>--}}
{{--                                              <option value="4">Bank Receipt Voucher</option>--}}
{{--                                             <option value="5">Bank Payment Voucher</option>--}}

{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-6" style="padding:5px;">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Search By Narration</label>--}}
{{--                                    <input type="text" name="narration" placeholder="Search By Narration"--}}
{{--                                           class="form-control"/>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-3" style="padding:5px;">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Search By Instrument Number</label>--}}
{{--                                    <input type="text" name="instrument_no"--}}
{{--                                           placeholder="Search By Instrument Number"--}}
{{--                                           class="form-control">--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-3" style="padding:5px;">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Search By Voucher Number</label>--}}
{{--                                    <input type="number" name="voucher_no"--}}
{{--                                           placeholder="Search By Voucher Number"--}}
{{--                                           class="form-control"/>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-4" style="padding:5px;">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>More Filters</label>--}}
{{--                                    <select name='filters' class="form-control filters"--}}
{{--                                            id="filters">--}}
{{--                                        <option value="">---Select Filter---</option>--}}
{{--                                        <option value="single_amount">Single Amount</option>--}}
{{--                                        <option value="range_amount">Range Amount</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-4 amount_field" style="padding:5px;">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Amount</label>--}}
{{--                                    <input value="0" type="number" name="amount"--}}
{{--                                           class="form-control"/>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-4 amount_range_fields" style="padding:5px;">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Min Amount</label>--}}
{{--                                    <input value="0" type="number" name="min_amount"--}}
{{--                                           class="form-control"/>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-4 amount_range_fields" style="padding:5px;">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label>Max Amount</label>--}}
{{--                                    <input value="0" type="number" name="max_amount"--}}
{{--                                           class="form-control"/>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <div class="col-md-12" style="">--}}
{{--                                <div class="form-group">--}}
{{--                                    <button type="button" class="btn btn-sm btn-primary"--}}
{{--                                            style="width: 100%;margin-top: 25px;font-size: 13px;margin-bottom: 25px;height: 40px;"--}}
{{--                                            onclick="fetch_ledger()">Search--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
                    <div class="clearfix"></div>
                    <!-- /.box-header -->
                    <div class="panel-body pad table-responsive">
                        <div class="clearfix mt-5">
                            <div class="panel-body pad table-responsive">
                                <table class="table table-bordered datatable" style="text-transform:none;">
                                    <thead>
                                    <tr style="text-align:center;">
                                        <th style="text-align:center;">Sr.No</th>
                                        <th style="text-align:center;">Entry Type</th>
                                        <th style="text-align:center;">Voucher Date</th>
                                        <th style="text-align:center;">Number</th>
                                        <th style="text-align:center;">Narration</th>
                                        <th style="text-align:center;">Dr.Amount</th>
                                        <th style="text-align:center;">Cr.Amount</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($entries as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $item->entry_type->code }}</td>
                                            <td>{{ $item->voucher_date }}</td>
                                            <td>{{ $item->number }}</td>
                                            <td>{{ $item->narration }}</td>
                                            <td>{{ number_format($item->dr_total) }}</td>
                                            <td>{{ number_format($item->cr_total) }}</td>
                                            <td>

                                                <a class="btn btn-warning" href="download/{{ $item->id }}">PDF</a>
                                                <a class="btn btn-primary" href="show/{{ $item->id }}">View</a>
                                                <a class="btn btn-success"
                                                   href="{!! url('admin/brv-edit/'.$item->id) !!}"
                                                   style="margin-right: 10px;">Edit</a>

                                            </td>
                                            {{--                                            <td>--}}
                                            {{--                                                <button id="btnGroupDrop{{ $loop->index }}" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">--}}
                                            {{--                                                    Action--}}
                                            {{--                                                </button>--}}
                                            {{--                                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop{{ $loop->index }}">--}}
                                            {{--                                                    <li><a class="dropdown-item" href="{{ route('admin.bpv-edit') }}">View</a></li>--}}
                                            {{--                                                    <li><a class="dropdown-item" href="{{ route('admin.bpv-edit') }}">Edit</a></li>--}}
                                            {{--                                                    <li><a class="dropdown-item" href="{{ route('admin.bpv-edit') }}">Get Pdf</a></li>--}}
                                            {{--                                                    <li><a class="dropdown-item" href="{{ route('admin.bpv-edit') }}">Print</a></li>--}}
                                            {{--                                                    <li><a class="dropdown-item" href="{{ route('admin.bpv-edit') }}">Status</a></li>--}}
                                            {{--                                                </ul>--}}
                                            {{--                                            </td>--}}

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script
        src="https://ivyacademic.org/public/theme/assets/plugins/select2/js/select2.min.js"></script>
    <script src="{{ url('js/voucher/journal_voucher/create_modify.js') }}"
            type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
          rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @include('admin.layout.datatable')


    <script>
        $(document).ready(function () {
            $('.datatable').DataTable({
                dom: 'Bfrtip', // Include buttons in the DataTable
                buttons: [
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn btn-primary'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Download PDF',
                        className: 'btn btn-danger'
                    }
                ]
            });
            $('.amount_field').hide();
            $('.amount_range_fields').hide();

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
                startDate: moment(),
                endDate: moment(),
            });

            $('#date_range').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });

            // fetch_ledger();

        });

        $("#filters").change(function () {
            var filterValue = $(this).val();
            if (filterValue != '') {
                if (filterValue == 'single_amount') {
                    $('.amount_field').show();
                    $('.amount_range_fields').hide();
                } else if (filterValue == 'range_amount') {
                    $('.amount_field').hide();
                    $('.amount_range_fields').show();
                }
            } else {
                $('.amount_field').hide();
                $('.amount_range_fields').hide();
            }
        });

    </script>

    <script>

        {{--function fetch_ledger() {--}}

        {{--    $.ajax({--}}
        {{--        type: "POST",--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        },--}}
        {{--        url: "{{ route('admin.load-voucher') }}",--}}
        {{--        data: $("#ledger-form").serialize(),--}}
        {{--        beforeSend: function () {--}}
        {{--            showLoader();--}}
        {{--        },--}}
        {{--        success: function (data) {--}}
        {{--            var action_edit = "";--}}
        {{--            var action_view = "";--}}
        {{--            var action_pdf = "";--}}
        {{--            var action_delete = "";--}}
        {{--            var action_all = "";--}}
        {{--            var htmlData = "";--}}
        {{--            var k = 1;--}}
        {{--            for (i in data.data) {--}}
        {{--                var id = data.data[i].id;--}}

        {{--                htmlData += '<tr>';--}}
        {{--                htmlData += '<td>' + k + '</td>';--}}
        {{--                htmlData += '<td>' + data.data[i].code + '</td>';--}}
        {{--                htmlData += '<td>' + data.data[i].voucher_date + '</td>';--}}
        {{--                htmlData += '<td>' + data.data[i].number + '</td>';--}}
        {{--                htmlData += '<td>' + data.data[i].narration + '</td>';--}}
        {{--                htmlData += '<td>' + numberWithCommas(data.data[i].dr_total) + '</td>';--}}
        {{--                htmlData += '<td>' + numberWithCommas(data.data[i].cr_total) + '</td>';--}}

        {{--                htmlData += '<td>';--}}
        {{--                for (j in data.data[i].entry_items) {--}}
        {{--                    let entry_items = data.data[i].entry_items[j];--}}
        {{--                    if (entry_items.dc == 'd') {--}}
        {{--                        htmlData += numberWithCommas(entry_items.amount) + '<br>';--}}
        {{--                    } else {--}}
        {{--                        htmlData += '';--}}
        {{--                    }--}}
        {{--                }--}}
        {{--                htmlData += '</td>';--}}

        {{--                htmlData += '<td>';--}}
        {{--                for (j in data.data[i].entry_items) {--}}
        {{--                    let entry_items = data.data[i].entry_items[j];--}}
        {{--                    if (entry_items.dc == 'c') {--}}
        {{--                        htmlData += numberWithCommas(entry_items.amount) + '<br>';--}}
        {{--                    } else {--}}
        {{--                        htmlData += '';--}}
        {{--                    }--}}
        {{--                }--}}
        {{--                htmlData += '</td>';--}}

        {{--                htmlData += '<td>';--}}

        {{--                <?php--}}
        {{--                if (Auth::user()->isAbleTo('print-voucher'))--}}
        {{--                {--}}
        {{--                    ?>--}}
        {{--                    htmlData += '<a class="btn btn-warning" href="download/' + id + '">PDF</a><br>';--}}
        {{--                    <?php--}}
        {{--                }--}}
        {{--                ?>--}}

        {{--                <?php--}}
        {{--                if (Auth::user()->isAbleTo('show-voucher'))--}}
        {{--                {--}}
        {{--                    ?>--}}
        {{--                    htmlData += '<a class="btn btn-primary" href="show/' + id + '">View</a><br>';--}}
        {{--                    <?php--}}
        {{--                }--}}
        {{--                ?>--}}

        {{--                <?php--}}
        {{--                if (Auth::user()->isAbleTo('accounts-edit-voucher'))--}}
        {{--                {--}}
        {{--                    ?>--}}
        {{--                    htmlData += '<a class="btn btn-success" href="bpv-edit/' + id + '">Edit</a>';--}}
        {{--                    <?php--}}
        {{--                }--}}
        {{--                ?>--}}

        {{--                    htmlData += '</td></tr>';--}}

        {{--                k++;--}}

        {{--            }--}}
        {{--            $("#getData").html(htmlData);--}}

        {{--            setTimeout(function () {--}}
        {{--                $('.datatable').DataTable();--}}
        {{--            }, 1000);--}}
        {{--        }--}}
        {{--        , complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.--}}
        {{--            // $('#loader').addClass('hidden')--}}
        {{--            hideLoader();--}}
        {{--        }--}}
        {{--    });--}}
        {{--}--}}

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
                }
                , beforeSend: function () {
                    showLoader();
                }
                , success: function (data) {
                    $("#branch_id").empty();

                    $("#branch_id").append("<option value = ''>---Select Branches---</option>");
                    for (i in data) {
                        $("#branch_id").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
                    }

                }
                , complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                    // $('#loader').addClass('hidden')
                    hideLoader();
                }
            })
        }
    </script>
@endsection
