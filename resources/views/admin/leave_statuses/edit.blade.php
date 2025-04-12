@extends('admin.layout.main')
@section('title')
    Leaves Status
@stop
@section('css')

@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Edit City</h3>
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
                    <form method="post" action="{!! route('admin.city.update', $city->id) !!}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- City Name Field -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>City Name</label>
                                    <input type="text" required class="form-control" name="name" value="{{ old('name', $city->name) }}">
                                </div>
                            </div>

                            <!-- Country Dropdown -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Country</label>
                                    <select name="country_id" class="form-control" required>
                                        <option value="" disabled>Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}"  @if($city->country_id == $country->id)   'selected'  @endif>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Status Field -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="Active" {{ $city->status == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ $city->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            <a href="{!! route('admin.city.index') !!}" class="btn btn-sm btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
