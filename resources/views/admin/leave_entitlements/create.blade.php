@extends('admin.layout.main')
@section('title')
    Leaves Entitlement
@stop
@section('css')

@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Create Leave Entitlement</h3>
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
                    <form method="post" action="{!! route('admin.leave-entitlement.store') !!}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                                {{-- Employee --}}
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>Employee</label>
                                        </div>
                                        <select name="employee_id" class="form-control" >
                                            <option value="" disabled selected>Select Employee</option>
                                            @foreach($data_create['Staff'] as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Leave Type --}}
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>Leave Type</label>
                                        </div>
                                        <select name="leave_type_id" class="form-control" >
                                            <option value="" disabled selected>Select Leave Type</option>
                                            @foreach($data_create['HrmLeaveTypes'] as $type)
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- No of Days --}}
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>No of Days</label>
                                        </div>
                                        <input type="number" step="0.01" name="no_of_days" class="form-control" required value="0.00">
                                    </div>
                                </div>
                                {{-- Days Used --}}
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>Days Used</label>
                                        </div>
                                        <input type="number" step="0.01" name="days_used" class="form-control" required value="0.00">
                                    </div>
                                </div>
                                {{-- Start Date --}}
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>Start Date</label>
                                        </div>
                                        <input type="date" name="start_date" class="form-control">
                                    </div>
                                </div>
                                {{-- End Date --}}
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>End Date</label>
                                        </div>
                                        <input type="date" name="end_date" class="form-control">
                                    </div>
                                </div>
                                {{-- Status --}}
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>Status</label>
                                        </div>
                                        <select name="status" class="form-control" required>
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            <a href="{!! route('admin.leave-entitlement.index') !!}" class="btn btn-sm btn-danger">Cancel</a>
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



