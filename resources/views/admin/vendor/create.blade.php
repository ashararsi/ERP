@extends('admin.layout.main')

@section('title')
    Create Vendor
@stop

@section('content')
    <div class="container-fluid">
        <div class="row w-100 mt-4">
            <h3 class="text-22 text-center text-bold w-100 mb-4">Create Vendor</h3>
        </div>
        <div class="card">
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
                <form method="post" action="{{ route('admin.vendor.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="vendor_name" class="form-label">Vendor Name</label>
                            <input type="text" class="form-control" id="vendor_name" name="vendor_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cnic" class="form-label">CNIC</label>
                            <input type="text" class="form-control" id="cnic" name="cnic">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ntn" class="form-label">NTN</label>
                            <input type="text" class="form-control" id="ntn" name="ntn">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="salestaxno" class="form-label">Sales Tax No</label>
                            <input type="text" class="form-control" id="salestaxno" name="salestaxno">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="contact" name="contact">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" class="form-control" id="type" name="type">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="service_type" class="form-label">Service Type</label>
                            <input type="text" class="form-control" id="service_type" name="service_type">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="acc_no" class="form-label">Account No</label>
                            <input type="text" class="form-control" id="acc_no" name="acc_no">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pra_no" class="form-label">PRA No</label>
                            <input type="text" class="form-control" id="pra_no" name="pra_no">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pra_type" class="form-label">PRA Type</label>
                            <input type="text" class="form-control" id="pra_type" name="pra_type">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sales_tax" class="form-label">Sales Tax</label>
                            <input type="text" class="form-control" id="sales_tax" name="sales_tax">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bank_branch_code" class="form-label">Bank Branch Code</label>
                            <input type="text" class="form-control" id="bank_branch_code" name="bank_branch_code">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bank_branch_name" class="form-label">Bank Branch Name</label>
                            <input type="text" class="form-control" id="bank_branch_name" name="bank_branch_name">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save Vendor</button>
                            <a href="{!! route('admin.vendor.index') !!}" class="btn btn-sm btn-danger">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
