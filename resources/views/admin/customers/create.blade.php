@extends('admin.layout.main')
@section('css')
    <link rel="stylesheet"
          href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <style>
        #example_wrapper {
            margin-top: 70px !important;
        }

        .col-md-3 {
            padding: 10px;
        }

        .col-md-6 {
            padding: 10px;
        }

        .col-md-4 {
            padding: 10px;
        }

        .col-md-12 {
            padding: 10px;
        }

        .accordion {
            background-color: #0ab39c;
            color: white;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active, .accordion:hover {
        }


        .panel {
            padding: 0 18px;
            display: block;
            background-color: white;
            overflow: hidden;


        }

        .form-group {
            float: left !important;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Create Customer</h3>
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
                    <form method="post" action="{!! route('admin.customers.store') !!}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-6">
                                <div class=" ">
                                    <div class="input-label">
                                        <label>Customer code</label>
                                    </div>
                                    <input type="text" required class="form-control" name="customer_code" value="{{ old('customer_code') }}">
                                </div>
                            </div>

                            {{-- Name --}}
                            <div class="col-md-6">
                                <div class=" ">
                                    <div class="input-label">
                                        <label>Name</label>
                                    </div>
                                    <input type="text" required class="form-control" name="name" value="{{ old('name') }}">
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <div class=" ">
                                    <div class="input-label">
                                        <label>Email</label>
                                    </div>
                                    <input type="email" required class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6">
                                <div class=" ">
                                    <div class="input-label">
                                        <label>Phone</label>
                                    </div>
                                    <input type="tel" class="form-control" name="phone"
                                           value="{{ old('phone') }}"
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
                                        <option value="{{ $spo->id }}">{{ $spo->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="">
                                    <div class="input-label">
                                        <label>Status</label>
                                    </div>
                                    <select name="status" class="form-control" required>
                                        <option value="Active" selected>Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                              {{-- City Name --}}
                              <div class="col-md-6">
                                <div class="input-label">
                                    <label>Select City</label>
                                </div>
                                <select name="city_id" id="city_id" class="form-control">
                                    <option value="">Select a city</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-6">
                                <label for="area_id">Select Area</label>
                                    <select name="area_id" id="area_id" class="form-control" required>
                                        <option value="">Select area</option>
                                        {{-- Will be populated by JS --}}
                                    </select>
                            </div>

                            {{-- NTN --}}
                            <div class="col-md-6">
                                <div class="input-label">
                                    <label>NTN</label>
                                </div>
                                <input type="text" class="form-control" name="ntn" value="{{ old('ntn') }}">
                            </div>

                            <div class="col-md-6">
                                <div class="input-label">
                                    <label>STN</label>
                                </div>
                                <input type="text" class="form-control" name="stn" value="{{ old('stn') }}">
                            </div>

                            {{-- CNIC --}}
                            <div class="col-md-6">
                                <div class="input-label">
                                    <label>CNIC</label>
                                </div>
                                <input required name="cnic_card" id="cnic_card" type="text"
                                class="form-control cnic_card"
                                data-inputmask="'mask': '99999-9999999-9'"
                                placeholder="XXXXX-XXXXXXX-X" onchange="checkCNIC(this)"
                                value="{{old('cnic_card')}}"/>                            </div>
                            {{-- Address --}}
                            <div class="col-md-12">
                                <div class=" ">
                                    <div class="input-label">
                                        <label>Address</label>
                                    </div>
                                   <textarea   class="form-control" name="address" >
                                       {{ old('address') }}
                                   </textarea>
                                </div>
                            </div>

                        </div>
                        <br>




                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            <a href="{!! route('admin.city.index') !!}" class="btn btn-sm btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@stop
@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ url('adminlte') }}/bower_components/moment/min/moment.min.js"></script>
    <script
        src="{{ url('adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script
        src="{{ url('adminlte') }}/bower_components/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="{{ url('adminlte') }}/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="{{ url('js/admin/employees/create_modify.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            $('#is_bank_name_required').hide();
            $('#banknotexist').hide();
            $('#bankexist').hide();
            $('#iban_exist').hide();

            $('.phone').mask('0000-0000000');
            $('.cnics').mask('00000-0000000-0');
            $('.home_phone').mask('000-00000000');
            $('.reg_no').mask('00-00000');

            $('.radio').change(function (event) {
                if (!$('.radio:checked').length) {
                    $('.radio').prop('required', true);
                    event.preventDefault();
                } else {
                    $('.radio').prop('required', false);
                }
            });

        });
    </script>

<script>
    var checkCNIC = function (textBox) {

        debugger;

        var regexp = new RegExp('^[0-9+]{5}-[0-9+]{7}-[0-9]{1}$');
        var check = textBox.value;
        if (!regexp.test(check)) {

            alert('Please Enter Valid 13 Digits CNIC with (-)');
            $(textBox).css('border-color', 'red');
            return false;

        } else {
            $(textBox).css('border-color', 'green');
            $(textBox).value = check;
            return true;
        }
    }
</script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.js-example-basic-single').select2();
            $('.role').select2();


            $('.primary_branch').select2();
            $('.status').select2();


        });

        $(".radio").change(function () {

            if ($(this).val() == "no") {
                $('#banknotexist').show();
                $('#bankexist').hide();
                $('#iban_exist').hide();
                $('#is_bank_name_required').hide();
            } else if ($(this).val() == "yes") {

                $('#banknotexist').hide();
                $('#bankexist').show();
                $('#iban_exist').show();
                $('#is_bank_name_required').show();
            }

        });

        // $(".iban_radio").change(function(){
        //     if($(this).val()=="no" || $(this).val()=="No"){
        //         $('#is_bank_name_required').show();
        //         $('#is_iban_bank').val('No');
        //     }
        //     if($(this).val()=="Yes" || $(this).val()=="yes"){
        //         $('#is_bank_name_required').hide();
        //         $('#is_iban_bank').val('Yes');
        //     }
        // });

    </script>

    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }


    </script>

<script>
    $(document).ready(function () {

        $('#city_id').on('change', function () {
            const cityId = $(this).val();
            $('#area_id').html('<option value="">Loading...</option>');
            const getAreasUrl = "{{ route('admin.get-areas', ['city' => 'CITY_ID']) }}";

            if (cityId) {
                $.ajax({
                    url: getAreasUrl.replace('CITY_ID', cityId),
                    method: 'GET',
                    success: function (data) {
                        let options = '<option value="">Select area</option>';
                        data.forEach(function (area) {
                            options += `<option value="${area.id}">${area.name}</option>`;
                        });
                        $('#area_id').html(options);
                    }
                });
            } else {
                $('#area_id').html('<option value="">Select area</option>');
            }
        });
    });
</script>

@stop



