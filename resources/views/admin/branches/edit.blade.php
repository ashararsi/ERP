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
                        <form method="post" action="{!! route('admin.branches.update',$b->id) !!}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="company_id" class="form-label">Company ID</label>
                                    <select id="company_id" class="form-control" name="company_id">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option @if($b->company_id==$company->id) selected @endif value="{{$company->id}}">{{$company->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Branch Name</label>
                                    <input type="text" value="{!! $b->name !!}" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="branch_code" class="form-label">Branch Code</label>
                                    <input type="text" value="{!! $b->branch_code !!}" class="form-control" id="branch_code" name="branch_code">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text"  value="{!! $b->phone !!}" class="form-control" id="phone" name="phone">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cell" class="form-label">Cell</label>
                                    <input type="text"  value="{!! $b->cell !!}"  class="form-control" id="cell" name="cell">
                                </div>
                                {{--                                <div class="col-md-6 mb-3">--}}
                                {{--                                    <label for="city_id" class="form-label">City</label>--}}
                                {{--                                    <select class="form-control" id="city_id" name="city_id">--}}
                                {{--                                        <option value="">Select City</option>--}}
                                {{--                                        --}}{{-- Add dynamic city options here --}}
                                {{--                                    </select>--}}
                                {{--                                </div>--}}
                                <div class="col-md-6 mb-3">
                                    <label for="country_id" class="form-label">Country</label>
                                    <select class="form-control" id="country_id" name="country_id">
                                        <option value="">Select Country</option>
                                        <option @if($b->country_id==1) selected @endif value="1">Pakistan</option>
                                        {{-- Add dynamic country options here --}}
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" value="{!! $b->address!!}" class="form-control" id="address" name="address">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option @if( $b->status==1) selected @endif value="1"  >Active</option>
                                        <option   @if( $b->status==0) selected @endif value="0">Inactive</option>
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
