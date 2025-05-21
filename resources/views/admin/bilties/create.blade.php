@extends('admin.layout.main')

@section('title')
    Create Bilty
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Create Bilty</h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="post" action="{{ route('admin.bilties.store') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="goods_name">Goods Name</label>
                                        <input type="text" required class="form-control" name="goods_name" value="{{ old('goods_name') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="place">Place</label>
                                        <input type="text" required class="form-control" name="place" value="{{ old('place') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bilty_no">Bilty No</label>
                                        <input type="text" required class="form-control" name="bilty_no" value="{{ old('bilty_no') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bilty_date">Bilty Date</label>
                                        <input type="date" required class="form-control" name="bilty_date" value="{{ old('bilty_date') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="courier_date">Courier/Registry Date</label>
                                        <input type="date" required class="form-control" name="courier_date" value="{{ old('courier_date') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="receipt_no">Receipt No</label>
                                        <input type="text" required class="form-control" name="receipt_no" value="{{ old('receipt_no') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cartons">Cartons</label>
                                        <input type="number" required class="form-control" name="cartons" value="{{ old('cartons', 0) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fare">Fare Rs.</label>
                                        <input type="number" required class="form-control" name="fare" value="{{ old('fare', 0) }}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="invoice_ids">Invoices</label>
                                        <select class="form-control select2" name="invoice_ids[]" multiple required>
                                            @foreach($invoices as $invoice)
                                                <option value="{{ $invoice->id }}">{{ $invoice->invoice_number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                        <a href="{{ route('admin.bilties.index') }}" class="btn btn-sm btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: 'Select Invoices'
            });
        });
    </script>
@stop
