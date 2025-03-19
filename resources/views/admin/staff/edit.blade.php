@extends('admin.layout.main')
@section('title')
    Role Edit
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card "><div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4"> Edit </h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{!! route('admin.suppliers.update',$supplier->id) !!}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <!-- Supplier Name -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Supplier Name</label>
                                        <input type="text" required id="name" class="form-control" name="name"
                                           value="{!! $supplier->name !!}"    placeholder="Enter supplier name">
                                    </div>
                                </div>

                                <!-- Contact Person -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contact_person">Contact Person</label>
                                        <input type="text" id="contact_person" class="form-control"
                                             value="{!! $supplier->contact_person !!}"   name="contact_person" placeholder="Enter contact person">
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" required id="email" class="form-control" name="email"
                                               value="{!! $supplier->email !!}"         placeholder="Enter email">
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" id="phone" class="form-control" name="phone"
                                               value="{!! $supplier->phone !!}"       placeholder="Enter phone number">
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <textarea id="address" class="form-control" name="address"
                                                  placeholder="Enter address">    {!! $supplier->address !!}    </textarea>
                                    </div>
                                </div>

                                <!-- Country -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="country">Country</label>
                                        <input type="text" id="country" class="form-control" name="country"
                                           value="{!! $supplier->country !!}"    placeholder="Enter country">
                                    </div>
                                </div>

                                <!-- City -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <input type="text" id="city" class="form-control" name="city"
                                             value="{!! $supplier->city !!}"   placeholder="Enter city">
                                    </div>
                                </div>

                                <!-- Postal Code -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="postal_code">Postal Code</label>
                                        <input type="text" value="{!! $supplier->postal_code !!}" id="postal_code" class="form-control" name="postal_code"
                                               placeholder="Enter postal code">
                                    </div>
                                </div>

                                <!-- Tax ID -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tax_id">Tax ID</label>
                                        <input type="text" id="tax_id" class="form-control" name="tax_id"
                                               value="{!! $supplier->tax_id !!}"    placeholder="Enter tax ID">
                                    </div>
                                </div>
                                <!-- Conversion Factor -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="conversion_factor">Conversion Factor</label>
                                        <input type="number" step="0.01" required id="conversion_factor"
                                               class="form-control" name="conversion_factor"
                                               value="{!! $supplier->conversion_factor !!}"    placeholder="Enter conversion factor">
                                    </div>
                                </div>
                                <!-- Submit Button -->
                            </div>
                            <div class="row">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    <a href="{!! route('admin.units.index') !!}"
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
