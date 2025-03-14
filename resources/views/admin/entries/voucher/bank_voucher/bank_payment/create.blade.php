@extends('admin.layout.main')

@section('css')
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
@stop

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h3 class="float-start">Create Bank Payment Voucher</h3>
                <a href="{{ route('admin.entries.index') }}" class="btn btn-success float-end">Back</a>

                <form method="POST" action="{{ route('admin.bpv-store') }}" id="validation-form">
                    @csrf
                    <input type="hidden" name="entry_type_id" value="5">

                    <div class="mt-4">
                        @include('accounts.entries.voucher.bank_voucher.bank_receipt.fields', [
                            'companyId' => $companyId,
                            'branchId' => $branchId,
                            'vendor' => $vendor,
                            'vendorDropdown' => $vendorDropdown
                        ])
                    </div>

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>

                @include('accounts.entries.voucher.bank_voucher.bank_receipt.intrument_entries_template', [
                    'vendor' => $vendor,
                    'vendorDropdown' => $vendorDropdown
                ])

                <div class="mt-5">
                    <div class="table-responsive">
                        <table class="table table-bordered datatable">
                            <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Entry Type</th>
                                <th>Voucher Date</th>
                                <th>Number</th>
                                <th>Narration</th>
                                <th>Dr. Amount</th>
                                <th>Cr. Amount</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($entries as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->entry_type->code }}</td>
                                    <td>{{ $item->voucher_date }}</td>
                                    <td>{{ $item->number }}</td>
                                    <td>{{ $item->narration }}</td>
                                    <td>{{ number_format($item->dr_total) }}</td>
                                    <td>{{ number_format($item->cr_total) }}</td>
                                    <td>
                                        @can('print-voucher')
                                            <a class="btn btn-warning btn-sm" href="download/{{ $item->id }}">PDF</a>
                                        @endcan
                                        @can('show-voucher')
                                            <a class="btn btn-primary btn-sm" href="show/{{ $item->id }}">View</a>
                                        @endcan
                                        @can('accounts-edit-voucher')
                                            <a class="btn btn-success btn-sm" href="{{ url('admin/bpv-edit/'.$item->id) }}">Edit</a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')

@endsection
