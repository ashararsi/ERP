@extends('admin.layout.main')
@section('title')
    Company Edit
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card "><div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4"> Edit </h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{!! route('admin.companies.update',$c->id) !!}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" value="{!! $c->name !!}" id="name" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" class="form-control"  value="{!! $c->description !!}"  id="description" name="description">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ntn" class="form-label">NTN</label>
                                    <input type="text" class="form-control"  value="{!! $c->ntn !!}"  id="ntn" name="ntn">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gst" class="form-label">GST</label>
                                    <input type="text" class="form-control" value="{!! $c->gst !!}"  id="gst" name="gst">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="gst_type" class="form-label">GST Type</label>
                                    <select class="form-control" id="gst_type" name="gst_type">
                                        <option value="">Select GST Type</option>
                                        <option @if($c->gst_type=="fixed") selected @endif value="fixed">Fixed</option>
                                        <option @if($c->gst_type=="percentage") selected @endif  value="percentage">Percentage</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="vat" class="form-label">VAT</label>
                                    <input type="text" value="{!! $c->vat !!}" class="form-control" id="vat" name="vat">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control"  value="{!! $c->phone !!}" id="phone" name="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fax" class="form-label">Fax</label>
                                    <input type="text" class="form-control"  value="{!! $c->fax !!}"  id="fax" name="fax">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" value="{!! $c->address !!}"  id="address" name="address">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="logo" class="form-label">Logo</label>
                                    <input type="file" class="form-control" id="logo" name="logo">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option @if($c->status==1) selected @endif value="1"  >Active</option>
                                        <option @if($c->status==0) selected @endif  value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    <a href="{!! route('admin.companies.index') !!}"
                                       class=" btn btn-sm btn-danger">Cancel </a>
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
@endsection
