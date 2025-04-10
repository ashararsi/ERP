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
                    <h3 class="text-22 text-midnight text-bold mb-4">Create City</h3>
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
                    <form method="post" action="{!! route('admin.hrm-leave-types.store') !!}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Name Field -->


                            <!-- City Fields -->
                            <!-- Name -->
                            <div class="col-md-4">
                                <label for="name">Leave Type Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>

                            <!-- Permitted Days -->
                            <div class="col-md-4">
                                <label for="permitted_days">Permitted Days</label>
                                <input type="number" name="permitted_days" class="form-control" value="{{ old('permitted_days', 0) }}" min="0" required>
                            </div>

                            <!-- Condition -->
                            <div class="col-md-4">
                                <label for="condition">Condition</label>
                                <input type="number" name="condition" class="form-control" value="{{ old('condition', 0) }}" min="0" required>
                            </div>

                            <!-- Allowed Number -->
                            <div class="col-md-4">
                                <label for="allowed_number">Allowed Number</label>
                                <input type="number" name="allowed_number" class="form-control" value="{{ old('allowed_number') }}" min="0">
                            </div>

                            <!-- Allowed Type -->
                            <div class="col-md-4">
                                <label for="allowed_type">Allowed Type</label>
                                <select name="allowed_type" class="form-control" required>
                                    <option value="0" {{ old('allowed_type') == 0 ? 'selected' : '' }}>Type 0</option>
                                    <option value="1" {{ old('allowed_type') == 1 ? 'selected' : '' }}>Type 1</option>
                                    <option value="2" {{ old('allowed_type') == 2 ? 'selected' : '' }}>Type 2</option>
                                </select>
                            </div>

                            <!-- Leave Type Status -->
                            <div class="col-md-4">
                                <label for="status">Leave Type Status</label>
                                <select name="status" class="form-control" required>
                                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <!-- Leave Type Created By -->
                            <div class="col-md-4">
                                <label for="created_by">Leave Type Created By</label>
                                <input type="number" name="created_by" class="form-control" value="{{ old('created_by') }}">
                            </div>

                            <!-- Leave Type Updated By -->
                            <div class="col-md-4">
                                <label for="updated_by">Leave Type Updated By</label>
                                <input type="number" name="updated_by" class="form-control" value="{{ old('updated_by') }}">
                            </div>

                            <!-- Leave Type Deleted By -->
                            <div class="col-md-4">
                                <label for="deleted_by">Leave Type Deleted By</label>
                                <input type="number" name="deleted_by" class="form-control" value="{{ old('deleted_by') }}">
                            </div>

                        </div>





                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            <a href="{!! route('admin.hrm-leave-types.index') !!}" class="btn btn-sm btn-danger">Cancel</a>
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
@stop



