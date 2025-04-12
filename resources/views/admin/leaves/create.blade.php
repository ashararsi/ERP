@extends('admin.layout.main')
@section('title')
Leaves
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Create Leaves</h3>
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
                    <form method="post" action="{!! route('admin.hrm-leaves.store') !!}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            {{-- Employee --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Employee</label>
                                    </div>
                                    <select name="employee_id" class="form-control" required>
                                        <option value="" disabled selected>Select Employee</option>
{{--                                        @foreach($employees as $employee)--}}
{{--                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>--}}
{{--                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>

                            {{-- Leave Type --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Leave Type</label>
                                    </div>
                                    <select name="leave_type_id" class="form-control" required>
                                        <option value="" disabled selected>Select Leave Type</option>
{{--                                        @foreach($leaveTypes as $type)--}}
{{--                                            <option value="{{ $type->id }}">{{ $type->name }}</option>--}}
{{--                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>

                            {{-- Work Shift --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Work Shift</label>
                                    </div>
                                    <select name="work_shift_id" class="form-control" required>
                                        <option value="" disabled selected>Select Work Shift</option>
{{--                                        @foreach($workShifts as $shift)--}}
{{--                                            <option value="{{ $shift->id }}">{{ $shift->name }}</option>--}}
{{--                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>

                            {{-- Leave Status --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Leave Status</label>
                                    </div>
                                    <select name="leave_status_id" class="form-control" required>
                                        <option value="" disabled selected>Select Status</option>
{{--                                        @foreach($leaveStatuses as $status)--}}
{{--                                            <option value="{{ $status->id }}">{{ $status->name }}</option>--}}
{{--                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>

                            {{-- Leave Date --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Leave Date</label>
                                    </div>
                                    <input type="date" name="leave_date" class="form-control" required>
                                </div>
                            </div>

                            {{-- Start Time --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Start Time</label>
                                    </div>
                                    <input type="time" name="start_time" class="form-control" required>
                                </div>
                            </div>

                            {{-- End Time --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>End Time</label>
                                    </div>
                                    <input type="time" name="end_time" class="form-control" required>
                                </div>
                            </div>

                            {{-- Shift --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Shift</label>
                                    </div>
                                    <input type="text" name="shift" class="form-control" placeholder="e.g., Morning, Evening" required>
                                </div>
                            </div>

                            {{-- Hours --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Total Hours</label>
                                    </div>
                                    <input type="number" step="0.01" name="hours" class="form-control" required>
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

@stop



