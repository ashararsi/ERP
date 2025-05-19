@extends('admin.layout.main')
@section('title')
    User  Create
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-body">
                        <h3 class="text-22 text-midnight text-bold mb-4"> Create User</h3>
                        <div class="row    mt-4 mb-4 ">
                            <div class="col-12 text-right">
                                <a href="{!! route('admin.users.index') !!}" class="btn btn-primary btn-sm "> Back </a>
                            </div>
                        </div>
{{--                        @dd($roles)--}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="w-100">
                            <form action="{!! route('admin.users.store') !!}" enctype="multipart/form-data"
                                  id="form_validation" autocomplete="off" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="input-label">
                                                <label>Role</label>
                                            </div>
                                            <select required id="role"  name="role[]" multiple class="form-control select">
                                                <option value="" disabled>Select Option</option>
                                                @foreach($roles as $item)
                                                    <option value="{!! $item->id !!}" data-name="{{ $item->name }}">{!! $item->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="input-label">
                                                <label>Email</label>
                                            </div>
                                            <input type="email" required class="form-control" value="" name="email">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="input-label">
                                                <label>Name</label>
                                            </div>
                                            <input type="text" required class="form-control" value=" " name="name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="input-label">
                                                <label>Password</label>
                                            </div>
                                            <input type="password" required class="form-control" value=""
                                                   name="password">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="input-label">
                                                <label>Confirm Password</label>
                                            </div>
                                            <input type="password" required class="form-control" value=""
                                                   name="password_confirmation">
                                        </div>
                                    </div>

                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="input-label">
                                                <label>Profile</label>
                                            </div>
                                            <input type="file"   class="form-control dropify" value=" "
                                                   name="profile">
                                        </div>
                                    </div>


                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="input-label">
                                                <label>Phone No</label>
                                            </div>
                                            <input type="text"   class="form-control dropify" value=" "
                                                   name="phone_num">
                                        </div>
                                    </div>


                                </div>

                                <div id="spo-fields" style="display: none;">
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <div class="input-label">
                                                    <label>Company</label>
                                                </div>
                                                <select name="company_id" class="form-control" id="company-select">
                                                    <option value="">Select Company</option>
                                                    @foreach($companies as $company)
                                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <div class="input-label">
                                                    <label>City</label>
                                                </div>
                                                <select name="city_id[]" id="city-select" class="form-control" multiple>
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endforeach
                                                </select>                                             
                                            </div>
                                        </div>
                                        
                                        <div class="col-4">
                                            <div class="form-group">
                                                <div class="input-label">
                                                    <label>Area</label>
                                                </div>
                                                <select name="area_id[]" id="area-select" class="form-control" multiple>
                                                    <option value="">Select Area</option>
                                                </select>                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                
                                <div class="row mt-5 mb-3">
                                    <div class="col-12">
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                            <a href="{!! route('admin.users.index') !!}"
                                               class=" btn btn-sm btn-danger">Cancel </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')

    <link rel="stylesheet" href="{{ asset('dist/admin/assets/plugins/dropify/css/dropify.min.css') }}">
@endsection
@section('js')

    <script type="text/javascript" src="{{ asset('dist/admin/assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('dist/admin/assets/js/pages/forms/dropify.js') }}"></script>

    <script>
        $(document).ready(function () {
            const targetRoleName = 'Spo';
    
            $('#role').on('change', function () {
                let showSpoFields = false;
    
                $('#role option:selected').each(function () {
                    if ($(this).data('name') === targetRoleName) {
                        showSpoFields = true;
                    }
                });
    
                if (showSpoFields) {
                    $('#spo-fields').show();
                } else {
                    $('#spo-fields').hide();
                }
            });
    
            $('#role').trigger('change');
        });
    </script>
    
    
    <script>
        $(document).ready(function () {
            $('#city-select').select2({
                placeholder: "Select Cities"
            });
    
            $('#area-select').select2({
                placeholder: "Select Area"
            });
        });
    </script>
    
    <script>
        $(document).ready(function () {
            $('#city-select').on('change', function () {
                const cityIds = $(this).val();
    
                // if (!cityIds.length) {
                //     $('#area-select').html('<option value="">Select Area</option><option value="all">All</option>');
                //     return;
                // }
    
                $.ajax({
                    url: '{{ route("admin.get-areas-by-cities") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        city_ids: cityIds
                    },
                    success: function (areas) {
                        let options = '<option value="">Select Area</option><option value="all">All</option>';
    
                        areas.forEach(function (area) {
                            options += `<option value="${area.id}">${area.name}</option>`;
                        });
    
                        $('#area-select').html(options);
                    }
                });
            });
        });
    </script>
    
@endsection

