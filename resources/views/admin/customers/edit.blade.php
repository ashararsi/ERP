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
                                <input type="text" class="form-control" name="customer_code" value="{{ $customer->customer_code }}">
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
                                <div class="input-label">
                                    <label>Assign SPO</label>
                                </div>
                                <select name="spo_id" class="form-control" required>
                                    <option value="">Select SPO</option>
                                    @foreach($spos as $spo)
                                        <option value="{{ $spo->id }}" {{ $customer->spo_id == $spo->id ? 'selected' : '' }}>
                                            {{ $spo->name }}
                                        </option>
                                    @endforeach
                                </select>
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
                            {{-- <div class="col-md-6">
                                <div class="input-label">
                                    <label>City Name</label>
                                </div>
                                <input type="text" class="form-control" name="city_name" value="{{ $customer->city_name }}">
                            </div> --}}

                            <div class="col-md-6">
                                <div class="input-label">
                                    <label>City</label>
                                </div>
                                <select name="city_id" id="city-dropdown" class="form-control" required>
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ $customer->city_id == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <div class="input-label">
                                    <label>Area</label>
                                </div>
                                <select name="area_id" id="area-dropdown" class="form-control" required>
                                    <option value="">Select Area</option>
                                    @if($areas)
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}" {{ $customer->area_id == $area->id ? 'selected' : '' }}>
                                                {{ $area->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            

                            {{-- NTN --}}
                            <div class="col-md-6">
                                <div class="input-label">
                                    <label>NTN</label>
                                </div>
                                <input type="text" class="form-control" name="ntn" value="{{ $customer->ntn }}">
                            </div>

                            {{-- NTN --}}
                            <div class="col-md-6">
                                <div class="input-label">
                                    <label>STN</label>
                                </div>
                                <input type="text" class="form-control" name="stn" value="{{ $customer->stn }}">
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

@section('js')

<script>
    $(document).ready(function () {
        $('#city-dropdown').on('change', function () {
            var cityId = $(this).val();
            $('#area-dropdown').html('<option value="">Loading...</option>');
            const getAreasUrl = "{{ route('admin.get-areas', ['city' => 'CITY_ID']) }}";

            if (cityId) {
                $.ajax({
                    url: getAreasUrl.replace('CITY_ID', cityId),
                    type: 'GET',
                    success: function (data) {
                        let options = '<option value="">Select Area</option>';
                        $.each(data, function (key, area) {
                            options += '<option value="' + area.id + '">' + area.name + '</option>';
                        });
                        $('#area-dropdown').html(options);
                    }
                });
            } else {
                $('#area-dropdown').html('<option value="">Select Area</option>');
            }
        });
    });
</script>
@endsection