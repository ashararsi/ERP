@extends('admin.layout.main')
@section('title')
    Customer Edit
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Edit Customer</h3>
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
                    <form method="post" action="{!! route('admin.customers.update', $customer->id) !!}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-label">
                                    <label>Customer Code</label>
                                </div>
                                <input type="text" class="form-control" name="customer_code" value="{{ $customer->customer_code }}" readonly>
                            </div>
                    
                            <div class="col-md-6">
                                <div class=" ">
                                    <div class="input-label">
                                        <label>Name</label>
                                    </div>
                                    <input type="text" required class="form-control" name="name"
                                           value="{{ $customer->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class=" ">
                                    <div class="input-label">
                                        <label>Email</label>
                                    </div>
                                    <input type="email" required class="form-control" name="email"
                                           value="{{ $customer->email }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class=" ">
                                    <div class="input-label">
                                        <label>Phone</label>
                                    </div>
                                    <input type="tel" class="form-control" name="phone"
                                           value="{{ $customer->phone }}"
                                           placeholder="Enter 10-digit phone number"
                                           title="Phone number must be 10 digits">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <div class="input-label">
                                        <label>Status</label>
                                    </div>
                                    <select name="status" class="form-control" required>
                                        <option @if($customer->status==1) selected @endif  value="Active">Active
                                        </option>
                                        <option @if($customer->status==0) selected @endif  value="Inactive">Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                             {{-- City Name --}}
                            <div class="col-md-6">
                                <div class="input-label">
                                    <label>City Name</label>
                                </div>
                                <input type="text" class="form-control" name="city_name" value="{{ $customer->city_name }}">
                            </div>

                            {{-- NTN --}}
                            <div class="col-md-6">
                                <div class="input-label">
                                    <label>NTN</label>
                                </div>
                                <input type="text" class="form-control" name="ntn" value="{{ $customer->ntn }}">
                            </div>

                            {{-- CNIC --}}
                            <div class="col-md-6">
                                <div class="input-label">
                                    <label>CNIC</label>
                                </div>
                                <input type="text" class="form-control" name="cnic" value="{{ $customer->cnic }}">
                            </div>
                            <div class="col-md-12">
                                <div class=" ">
                                    <div class="input-label">
                                        <label>Address</label>
                                    </div>
                                    <textarea class="form-control" name="address">{{$customer->address  }}
                                   </textarea>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            <a href="{!! route('admin.customers.index') !!}" class="btn btn-sm btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
