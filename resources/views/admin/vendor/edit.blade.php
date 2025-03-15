@extends('admin.layout.main')

@section('title')
    Edit Vendor
@stop

@section('content')
    <div class="container-fluid">
        <div class="row w-100 mt-4">
            <h3 class="text-22 text-center text-bold w-100 mb-4">Edit Vendor</h3>
        </div>
        <div class="row mt-4 mb-4">
            <div class="col-12 text-right">
                <a href="{!! route('admin.vendor.index') !!}" class="btn btn-secondary btn-sm">Back to List</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.vendor.update', $v->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="vendor_name" class="form-label">Vendor Name</label>
                            <input type="text" class="form-control" id="vendor_name" name="vendor_name" value="{{ $v->vendor_name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cnic" class="form-label">CNIC</label>
                            <input type="text" class="form-control" id="cnic" name="cnic" value="{{ $v->cnic }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ntn" class="form-label">NTN</label>
                            <input type="text" class="form-control" id="ntn" name="ntn" value="{{ $v->ntn }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="salestaxno" class="form-label">Sales Tax No</label>
                            <input type="text" class="form-control" id="salestaxno" name="salestaxno" value="{{ $v->salestaxno }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $v->email }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="contact" name="contact" value="{{ $v->contact }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $v->address }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" value="{{ $v->category }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" class="form-control" id="type" name="type" value="{{ $v->type }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="service_type" class="form-label">Service Type</label>
                            <input type="text" class="form-control" id="service_type" name="service_type" value="{{ $v->service_type }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks">{{ $v->remarks }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="acc_no" class="form-label">Account No</label>
                            <input type="text" class="form-control" id="acc_no" name="acc_no" value="{{ $v->acc_no }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pra_no" class="form-label">PRA No</label>
                            <input type="text" class="form-control" id="pra_no" name="pra_no" value="{{ $v->pra_no }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pra_type" class="form-label">PRA Type</label>
                            <input type="text" class="form-control" id="pra_type" name="pra_type" value="{{ $v->pra_type }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sales_tax" class="form-label">Sales Tax</label>
                            <input type="text" class="form-control" id="sales_tax" name="sales_tax" value="{{ $v->sales_tax }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bank_branch_code" class="form-label">Bank Branch Code</label>
                            <input type="text" class="form-control" id="bank_branch_code" name="bank_branch_code" value="{{ $v->bank_branch_code }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="bank_branch_name" class="form-label">Bank Branch Name</label>
                            <input type="text" class="form-control" id="bank_branch_name" name="bank_branch_name" value="{{ $v->bank_branch_name }}">
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Update Vendor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
