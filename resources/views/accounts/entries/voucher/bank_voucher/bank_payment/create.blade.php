@extends('admin.layout.main')
@section('css')
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endsection
@section('content')
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <!--div-->
        <div class="card">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <h3 style="float:left;">Create Bank Payment Voucher</h3>
                    <a href="{{ route('admin.entries.index') }}" style="float:right;"
                       class="btn btn-success pull-right">Back</a>
                </div>
                {!! Form::open(['method' => 'POST', 'route' => ['admin.bpv-store'], 'id' => 'validation-form']) !!}
                <div class="box-body" style="margin-top:40px;">
                    {!! Form::hidden('entry_type_id', old('entry_type_id', '5'),['id'=>'entry_type_id']) !!}
                    @include('accounts.entries.voucher.bank_voucher.bank_receipt.fields',['companyId' => $companyId,'branchId' => $branchId,'vendor'=>$vendor,'vendorDropdown'=>$vendorDropdown])
                    {{--                    @include('accounts.entries.voucher.bank_voucher.bank_payment.fields',['companyId' => $companyId,'branchId' => $branchId])--}}
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            {!! Form::submit(trans('Save'), ['class' => 'btn btn-success globalSaveBtn float-end ']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                    @include('accounts.entries.voucher.bank_voucher.bank_receipt.intrument_entries_template',['vendor'=>$vendor,'vendorDropdown'=>$vendorDropdown])
                    {{--                    @include('accounts.entries.voucher.bank_voucher.bank_payment.intrument_entries_template')--}}
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
                                            @if(Auth::user()->isAbleTo('print-voucher'))
                                                <a class="btn btn-warning" href="download/{{ $item->id }}">PDF</a>
                                            @endif
                                            @if(Auth::user()->isAbleTo('show-voucher'))
                                                <a class="btn btn-primary" href="show/{{ $item->id }}">View</a>
                                            @endif
                                            @if(Auth::user()->isAbleTo('accounts-edit-voucher'))
                                                <a class="btn btn-success"
                                                   href="{!! url('admin/bpv-edit/'.$item->id) !!}"
                                                   style="margin-right:10px;">Edit</a>
                                            @endif
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    @include('admin.layout.datatable')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script src="{{ url('js/voucher/journal_voucher/create_modify.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js" integrity="sha512-RCgrAvvoLpP7KVgTkTctrUdv7C6t7Un3p1iaoPr1++3pybCyCsCZZN7QEHMZTcJTmcJ7jzexTO+eFpHk4OCFAg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        function dr_validation(id) {
            var id = '#entry_item-dr_amount-' + id;
            //console.log(id);
            //var value = $(id).val();
            $(id).keyup(function (event) {

                // skip for arrow keys
                if (event.which >= 37 && event.which <= 40) return;


            });
            //alert(value);
        }

        function cr_validation(id) {
            var id = '#entry_item-cr_amount-' + id;
            console.log(id);
            var value = $(id).val();
            // alert(value);
        }
    </script>

    <script>
        $('.datatable').DataTable();
    </script>
@endsection
