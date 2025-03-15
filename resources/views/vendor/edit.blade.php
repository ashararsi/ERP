@extends('admin.layout.main')
@section('title')
    Company Edit
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Edit Vendor</h3>
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
                        <form method="post" action="{!! route('admin.vendor.update', $vendor->vendor_id) !!}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="vendor_name" class="form-label">Vendor Name</label>
                                    <input type="text" class="form-control" id="vendor_name" name="vendor_name" value="{{ $vendor->vendor_name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cnic" class="form-label">CNIC</label>
                                    <input type="text" class="form-control" id="cnic" name="cnic" value="{{ $vendor->cnic }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ntn" class="form-label">NTN</label>
                                    <input type="text" class="form-control" id="ntn" name="ntn" value="{{ $vendor->ntn }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="salestaxno" class="form-label">Sales Tax Number</label>
                                    <input type="text" class="form-control" id="salestaxno" name="salestaxno" value="{{ $vendor->salestaxno }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $vendor->email }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact" class="form-label">Contact</label>
                                    <input type="text" class="form-control" id="contact" name="contact" value="{{ $vendor->contact }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="addresss" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="addresss" name="addresss" value="{{ $vendor->addresss }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="type" class="form-labe

        </div>
    </div>
@stop
@section('js')
@endsection
