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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Create New Staff</h4>
                    <a href="{{ route('admin.staff.index') }}" style="float:right;" class="btn btn-success pull-right">Back</a>

                </div><!-- end card header -->

                <div class="card-body">
                    {!! Form::open(['method' => 'POST', 'route' => ['admin.staff.store'], 'id' => 'validation-form' , 'enctype' => 'multipart/form-data']) !!}
                    {!! Form::token(); !!}
                    <div class="box-body">
                        <p class="accordion"><b>Personal Information</b></p>
                        <div class="panel">
                            <div class="row">

                                <div class="form-group col-md-3 @if($errors->has('first_name')) has-error @endif">
                                    {!! Form::label('first_name', 'First Name*', ['class' => 'control-label']) !!}
                                    <input type="text" name="first_name" class="form-control"
                                           value="{{ old('first_name') }}" required maxlength="50">
                                </div>
                                <div class="form-group col-md-3 @if($errors->has('first_name')) has-error @endif">
                                    {!! Form::label('last_name', 'Last Name*', ['class' => 'control-label']) !!}
                                    <input type="text" name="last_name" class="form-control"
                                           value="{{ old('last_name') }}" required maxlength="50">
                                </div>

                                <div class="form-group col-md-3 @if($errors->has('father_name')) has-error @endif">
                                    {!! Form::label('father_name', 'Father Name/ Husband Name*', ['class' => 'control-label']) !!}
                                    <input type="text" name="father_name" class="form-control"
                                           value="{{ old('father_name') }}" required maxlength="50">
                                </div>
                                <div class="form-group col-md-3 @if($errors->has('relation')) has-error @endif">
                                    {!! Form::label('relation', 'Relation*', ['class' => 'control-label']) !!}
                                    <select name="relation" id="relation" style="width: 100%;"
                                            class="form-control relation" required>
                                        <option>Select Relation</option>
                                        <option value="father" <?php if (old('relation') == "father"): ?>
                                        selected
                                        <?php endif ?>>Father
                                        </option>
                                        <option value="husband" <?php if (old('relation') == "husband"): ?>
                                        selected
                                        <?php endif ?>>Husband
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 @if($errors->has('mother_name')) has-error @endif"
                                     style="display:none;">
                                    {!! Form::label('mother_name', 'Mother Name', ['class' => 'control-label']) !!}
                                    <input type="text" name="mother_name" class="form-control"
                                           value="{{ old('mother_name') }}" maxlength="50">
                                </div>

                                <div class="form-group col-md-3 @if($errors->has('pemail')) has-error @endif">
                                    {!! Form::label('pemail', 'Personal Email*', ['class' => 'control-label']) !!}
                                    <input type="pemail" id="pemail" name="pemail" size="50" value="{{ old('pemail') }}"
                                           class="form-control" required>
                                </div>
                                <div class="form-group col-md-3 @if($errors->has('pemail')) has-error @endif">
                                    {!! Form::label('pemail', 'Email*', ['class' => 'control-label']) !!}
                                    <input type="email" id="email" name="email" size="50" value="{{ old('email') }}"
                                           class="form-control" required>
                                </div>
                                <div class="form-group col-md-3 @if($errors->has('date_of_birth')) has-error @endif">
                                    {!! Form::label('date_of_birth', 'Date of Birth*', ['class' => 'control-label']) !!}
                                    <input type="date" name="date_of_birth" class="form-control"
                                           value="{{ old('date_of_birth') }}" required maxlength="10">
                                </div>
                                <div class="form-group col-md-3 @if($errors->has('gender')) has-error @endif">
                                    {!! Form::label('gender', 'Gender*', ['class' => 'control-label ']) !!}
                                    <select name="gender" id="gender" style="width: 100%;" class="form-control gender">
                                        <option>Select Gender</option>
                                        <option value="male" <?php if (old('gender') == "male"): ?>
                                        selected
                                        <?php endif ?>>Male
                                        </option>
                                        <option value="female" <?php if (old('gender') == "female"): ?>
                                        selected
                                        <?php endif ?>>Female
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 @if($errors->has('gender')) has-error @endif">
                                    {!! Form::label('marital_status', 'Marital Status*', ['class' => 'control-label']) !!}
                                    <select name="marital_status" id="marital_status" class="form-control">
                                        <option>Select Marital Status</option>
                                        <option value="married" <?php if (old('marital_status') == "married"): ?>
                                        selected
                                        <?php endif ?>>Married
                                        </option>
                                        <option value="unmarried" <?php if (old('marital_status') == "unmarried"): ?>
                                        selected
                                        <?php endif ?>>Unmarried
                                        </option>
                                    </select>
                                </div>


                                <div class="form-group  col-md-3 @if($errors->has('city')) has-error @endif">
                                    {!! Form::label('city', 'City*', ['class' => 'control-label']) !!}
                                    <select name="city" id="city" class="form-control" required>
                                        <option value="" disabled selected>Select The City</option>
                                        @foreach($city as $cities)
                                            <option value="{{$cities->name}}">{{$cities->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group  col-md-3 @if($errors->has('address')) has-error @endif">
                                    {!! Form::label('address', 'Address*', ['class' => 'control-label']) !!}
                                    <input type="text" name="address" value="{{ old('address') }}" class="form-control"
                                           required>
                                </div>

                                <div class="form-group col-md-3 @if($errors->has('temp_address')) has-error @endif">
                                    {!! Form::label('temp_address', 'Temporary Address', ['class' => 'control-label']) !!}
                                    <input type="text" name="temp_address" value="{{ old('temp_address') }}"
                                           class="form-control">
                                </div>

                                <div class="form-group  col-md-3 @if($errors->has('home_phone')) has-error @endif">
                                    {!! Form::label('home_phone', 'Home Phone', ['class' => 'control-label']) !!}
                                    <input type="tel" name="home_phone" class="form-control home_phone"
                                           data-mask="000-00000000" placeholder="0XX-XXXXXXX"
                                           value="{{ old('home_phone') }}" maxlength="100">
                                </div>
                                <div class="form-group  col-md-3 @if($errors->has('mobile_1')) has-error @endif">
                                    {!! Form::label('mobile_1', 'Mobile 1*', ['class' => 'control-label']) !!}
                                    <input type="tel" id="mobile_1" value="{{ old('mobile_1') }}"
                                           data-mask="0000-0000000" name="mobile_1" class="form-control phone"
                                           placeholder="03XX-XXXXXXX" required>
                                </div>
                                <div class="form-group  col-md-3 @if($errors->has('mobile_2')) has-error @endif"
                                     style="display:none;">
                                    {!! Form::label('mobile_2', 'Mobile 2', ['class' => 'control-label']) !!}
                                    <input type="tel" id="mobile_2" data-mask="0000-0000000" name="mobile_2"
                                           class="form-control phone" value="{{ old('mobile_2') }}"
                                           placeholder="03XX-XXXXXXX">
                                </div>

                                <div class="form-group  col-md-3 @if($errors->has('cnics')) has-error @endif">
                                {!! Form::label('cnic', 'CNIC*', ['class' => 'control-label']) !!}
                                <!-- <input type="text" name="cnic" placeholder="XXXXX-XXXXXXX-X" data-mask="00000-0000000-0" required="required" class="form-control cnic" /> -->
                                    <input type="text" id="cnics" name="cnic" data-mask="00000-0000000-0"
                                           placeholder="00000-0000000-0" value="{{ old('cnic') }}" required="required"
                                           class="form-control cnics"/>
                                </div>

                                <div class="form-group  col-md-3 @if($errors->has('cnics')) has-error @endif">
                                {!! Form::label('cnic', 'CNIC Expiry Date*', ['class' => 'control-label']) !!}
                                <!-- <input type="text" name="cnic" placeholder="XXXXX-XXXXXXX-X" data-mask="00000-0000000-0" required="required" class="form-control cnic" /> -->
                                    <input type="date" id="expiry_date" name="expiry_date" placeholder="Expiry Date"
                                           value="{{ old('expiry_date') }}" required="required"
                                           class="form-control expiry_date"/>
                                </div>
                            </div>
                        </div>


                        <p class="accordion"><b>Job Description</b></p>
                        <div class="panel">
                            <div class="row">

                            <!--div class="col-md-3 @if($errors->has('reg_no')) has-error @endif" style ="display:none;">
          {!! Form::label('reg_no', 'Registration No*', ['class' => 'control-label']) !!}
                                <input type="text" name="reg_no" placeholder="XX-XXXXX" class="form-control reg_no" value="0" required unique maxlength="10" readonly>
                            </div -->
                                <div class="col-md-3 @if($errors->has('join_date')) has-error @endif">
                                    {!! Form::label('join_date', 'Join Date*', ['class' => 'control-label']) !!}
                                    <input type="date" name="join_date" required value="{{ old('join_date') }}"
                                           class="form-control" required maxlength="10">
                                </div>
                                <div class="form-group col-md-3 @if($errors->has('job_status')) has-error @endif">
                                    {!! Form::label('job_status', 'Job Status*', ['class' => 'control-label']) !!}
                                    <select name="job_status" class="form-control" required="required">

                                        <option value="">Select Job Status</option>


                                        <option value="Full Time" <?php if (old('job_status') == "Full Time"): ?>

                                        selected
                                        <?php endif ?> >Full Time
                                        </option>


                                        <option value="Lecture base" <?php if (old('job_status') == "Lecture base"): ?>
                                        selected
                                        <?php endif ?> >Hourly Based
                                        </option>


                                        <option value="Part Time" <?php if (old('job_status') == "Part Time"): ?>
                                        selected
                                        <?php endif ?> >Part Time
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group  col-md-3 @if($errors->has('city')) has-error @endif">
                                    {!! Form::label('staff_type', 'Staff Type*', ['class' => 'control-label']) !!}
                                    <select name="staff_type_id" id="staff_type_id" class="form-control" required>
                                        <option value="" disabled selected>Select Staff Type</option>
                                        @foreach($staff_type as $staff)
                                            <option value="{{$staff->id}}">{{$staff->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3 @if($errors->has('class_level')) has-error @endif">
                                    {!! Form::label('class_level', 'Class/Level', ['class' => 'control-label']) !!}
                                    <input type="text" name="class_level" placeholder="Enter Class/Level"
                                           class="form-control">
                                </div>

                                <div class="form-group col-md-3 @if($errors->has('filertype')) has-error @endif">
                                    {!! Form::label('filertype', 'Filer Type*', ['class' => 'control-label']) !!}
                                    <select name="filertype" class="form-control" required="required">
                                        <option>Select Type</option>
                                        <option value="Filer" <?php if (old('filertype') == "Filer"): ?>
                                        selected
                                        <?php endif ?> >Filer
                                        </option>
                                        <option value="Non-FIler" <?php if (old('filertype') == "Non-FIler"): ?>
          <?php endif ?> >Non-Filer
                                        </option>
                                    </select>

                                </div>
                                <div class="form-group  col-md-3 @if($errors->has('ntn')) has-error @endif">
                                    <label>NTN*</label>
                                    <input type="text" required="required" value="{{ old('ntn') }}" name="ntn" min="0"
                                           class="form-control"/>
                                </div>


                                <div class="form-group col-md-3 @if($errors->has('qualification')) has-error @endif">
                                    {!! Form::label('qualification', 'Qualification*', ['class' => 'control-label']) !!}
                                    <input type="text" name="qualification" value="{{ old('qualification') }}"
                                           class="form-control" required maxlength="60">
                                </div>
                                <div class="form-group col-md-3 @if($errors->has('experience')) has-error @endif">
                                    {!! Form::label('experience', 'Year of Experience*', ['class' => 'control-label']) !!}
                                    <select class="form-control" name="experience" required>
                                        <option value="">Years of Experience</option>
                                        <?php
                                        for($i = 1; $i <= 20; $i++)
                                        {
                                        ?>
                                        <option value="{{$i}}" <?php if (old('experience') == $i): ?>
                                        selected
                                        <?php endif ?> >{{$i}}</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 @if($errors->has('other_info')) has-error @endif">
                                    {!! Form::label('other_info', 'Other Info', ['class' => 'control-label']) !!}
                                    <input type="text" name="other_info" value="{{ old('other_info') }}"
                                           class="form-control">
                                </div>
                                <div class="form-group col-md-3 @if($errors->has('staff_image')) has-error @endif">
                                {!! Form::label('staff_image', 'Staff Image*', ['class' => 'control-label', ]) !!}
                                <!-- {!! Form::file('images[]',array('class'=>'send-btn')) !!} -->
                                    <input type="file" name="staff_image" value="{{ old('staff_image') }}"
                                           class="form-control"/>
                                </div>
                                <div class="form-group col-md-3 @if($errors->has('skill')) has-error @endif">
                                    {!! Form::label('skill', 'Skill*', ['class' => 'control-label']) !!}
                                    <input type="text" name="skill" value="{{ old('skill') }}" class="form-control"
                                           required maxlength="100">
                                </div>


                                <div class="form-group col-md-3 @if($errors->has('staff_type')) has-error @endif">
                                    {{ Form::label('Primary Branch Name*') }}
                                    <select style="width: 100%" name="branch_id" class="form-control primary_branch"
                                            required="required">
                                        <option value="" selected="selected">Please Select</option>
                                        @foreach($branches as $key => $branch)
                                            <option value="{{$branch['id']}}">{{$branch['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="form-group col-md-12">
                                    {!! Form::label('branch_id', 'Other Branches', ['class' => 'control-label']) !!}
                                    <select style="width: 100%;" class="js-example-basic-single" name="branches[]"
                                            multiple="multiple">

                                        @foreach($branches as $key => $branch)

                                            <option value="{{$branch['id']}}">{{$branch['name']}}</opton>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-3 @if($errors->has('start_day')) has-error @endif">
                                {!! Form::label('start_day', 'Start Day of Contract', ['class' => 'control-label']) !!}

                                <input type="date" name="start_day_contract" value="{{ old('start_day_contract') }}"
                                       class="form-control" maxlength="10">
                            </div>
                            <div class="form-group col-md-3 @if($errors->has('join_date')) has-error @endif">
                                {!! Form::label('end_day', 'End Day of Contract', ['class' => 'control-label']) !!}
                                <input type="date" name="end_day_contract" value="{{ old('end_day_contract') }}"
                                       class="form-control" maxlength="10">

                            </div>
                            <div class="form-group col-md-3 @if($errors->has('probation_period')) has-error @endif">
                                {!! Form::label('probation_period', 'Probation Period*', ['class' => 'control-label']) !!}
                                <select name="probation" class="form-control">
                                    <option>Select Probation</option>
                                    <option value="No Probation">No Probation</option>
                                    <option value="One Month">One Month</option>
                                    <option value="Three Months">Three Months</option>
                                    <option value="Six Months">Six Months</option>
                                    <option value="One Year">One Year</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3 @if($errors->has('staff_type')) has-error @endif">
                                {{ Form::label('Select Designation*') }}
                                <select style="width: 100%" name="designation_id" class="form-control designation_id js-example-basic-single"
                                        required="required">
                                    <option value="" selected="selected">Select Designation</option>
                                    @foreach($designation as $key => $branch)

                                        <option value="{{$branch['id']}}">{{$branch['name']}}</option>
                                    @endforeach

                                </select>
                            </div>

                        </div>
                    </div>


                    <p class="accordion"><b>Bank Account Details</b></p>
                    <div class="panel">


                        <div class="row" style="margin-left: 10px;text-align:center;">
                            <!--<label style="width: 100px;" ><input style="float: left;"  checked=""  type="radio" class="radio" name="bank" value="yes"> Yes</label>-->
                            <!--<label style="width: 100px;" ><input style="float: left;"  type="radio" class="radio" name="bank" value="no"> No</label> -->
                            <div class="col-md-4">
                                <fieldset style=" float: left; ">
                                    Payment source is bank ?
                                    <div class="some-class">
                                        <input type="radio" class="radio" name="bank" value="yes"
                                               id="id_yes" required/>
                                        <label for="id_yes">Yes</label>
                                        <br>
                                        <input type="radio" class="radio" name="bank" value="no" id="id_no" required/>
                                        <label for="id_no">No</label>
                                    </div>
                                </fieldset>
                            </div>
                            <div id="iban_exist" class="col-md-4">
                                <fieldset style=" float: left; ">
                                    Is HBL ?
                                    <div class="some-class">
                                        <input type="radio" class="iban_radio" name="is_iban_bank1"
                                               value="yes" id="iban_yes"/>
                                        <label for="iban_yes">Yes</label>
                                        <br>
                                        <input type="radio" class="iban_radio" name="is_iban_bank1" value="no"
                                               id="iban_no"/>
                                        <input type="hidden" name="is_iban_bank" value="Yes" id="is_iban_bank"/>
                                        <label for="iban_no">No</label>
                                    </div>
                                </fieldset>
                            </div>
                            <div id="is_bank_name_required" class="col-md-4" style="display:none;">
                                <label style=" float: left; ">Bank Name </label>
                                <select class="form-control" name="bank_id" required>
                                    <option value='0'>--Select Bank Name--</option>
                                    @foreach($bank as $banks)
                                        <option value="{{$banks->id}}">{{$banks->bank_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">

                            <div id="bankexist" class="col-md-12">
                                <div class="form-group col-md-4 @if($errors->has('account_title')) has-error @endif"
                                     style="float:left;">
                                    {!! Form::label('account_title', 'Account Title*', ['class' => 'control-label']) !!}
                                    <input type="text" name="account_title" value="{{ old('account_title') }}"
                                           class="form-control">
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('account_number')) has-error @endif"
                                     style="float:left;">
                                    {!! Form::label('account_number', 'Account Number*', ['class' => 'control-label']) !!}
                                    <input type="text" name="account_number" value="{{ old('account_number') }}"
                                           class="form-control">
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('bank_branch')) has-error @endif"
                                     style="float:left;">
                                    {!! Form::label('bank_branch', 'Bank Branch*', ['class' => 'control-label']) !!}
                                    <input type="text" value="{{ old('bank_branch') }}" name="bank_branch"
                                           class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="banknotexist" style="display: none;">
                                <div class="form-group col-md-12">
                                    <select class="form-control" name="payment_type">
                                        <option selected disabled>--Select Payment Type--</option>
                                        <option value="Cash">Cash</option>
                                        <option value="PayOrder">PayOrder</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="accordion"><b>User Details</b></p>
                    <div class="panel">
                        <div class="row">

                            <div id="bankexist" class="col-md-12">
                                <div class="form-group col-md-4 @if($errors->has('password')) has-error @endif"
                                     style="float:left;">
                                    {!! Form::label('password', 'Password*', ['class' => 'control-label']) !!}
                                    {!! Form::text('password',old('password'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                                    <p class="help-block"></p>
                                    @if($errors->has('password'))
                                        <p class="help-block">
                                            {{ $errors->first('password') }}
                                        </p>
                                    @endif
                                </div>
                                <div class="form-group col-md-4 @if($errors->has('roles')) has-error @endif"
                                     style="float:left;">
                                    {!! Form::label('roles', 'Roles*', ['class' => 'control-label']) !!}
                                    {!! Form::select('roles[]', $roles, old('roles'), ['data-placeholder'=>'&nbsp;Select Roles','class' => 'form-control role', 'required' => '','multiple']) !!}
                                    <p class="help-block"></p>
                                    @if($errors->has('roles'))
                                        <p class="help-block">
                                            {{ $errors->first('roles') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <button id="btn" class="btn btn-primary" type="submit">Save</button>
                </div>
            {!! Form::close() !!}


            <!-- <div class="form-group col-md-3 @if($errors->has('staff_type')) has-error @endif">
    {!! Form::label('staff_type', 'Staff Types*', ['class' => 'control-label']) !!}
                <select required="required" name="staff_type" class="form-control">
                  <option disabled="disabled" selected="selected">Select Type</option>
                  <option value="teacher">Teacher</option>
                  <option value="coordinator">Coordinator</option>
                  <option value="Principal">Principal</option>
                </select>
            </div>
-->
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



