@extends('admin.layout.main')
@section('css')

@stop
@section('content')
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <!--div-->
        <div class="card">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <h3 style="float:left;">Create Cash Receipt Voucher</h3>
                    <a href="{{ route('admin.entries.index') }}" style="float:right;"
                       class="btn btn-success pull-right">Back</a>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                {!! Form::open(['method' => 'POST', 'route' => ['admin.bpv-store'], 'id' => 'validation-form']) !!}
                <div class="box-body" style="margin-top:40px;">
                    {!! Form::hidden('entry_type_id', old('entry_type_id', '2'),['id'=>'entry_type_id']) !!}
                    @include('accounts.entries.voucher.journal_voucher.fields',['companyId' => $companyId,'branchId' => $branchId])
                    {{--                    @include('accounts.entries.voucher.cash_voucher.cash_receipt.fields',['companyId' => $companyId,'branchId' => $branchId])--}}
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            {!! Form::submit(trans('Save'), ['class' => 'btn btn-success globalSaveBtn float-end ']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                    @include('accounts.entries.voucher.journal_voucher.intrument_entries_template')
                    {{--                    @include('accounts.entries.voucher.cash_voucher.cash_receipt.intrument_entries_template')--}}

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
                                                   href="{!! url('admin/crv-edit/'.$item->id) !!}"
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
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
