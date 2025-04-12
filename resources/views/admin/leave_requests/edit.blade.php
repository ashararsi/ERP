@extends('admin.layout.main')
@section('title')
    Leaves Request
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
                    <form method="post" action="{!! route('admin.hrm-leave-requests.update', $leave_request->id) !!}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            {{-- Employee --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label"><label>Employee</label></div>
                                    <select name="employee_id" class="form-control">
                                        <option value="" disabled selected>Select Employee</option>
                                        @foreach($data_create['Staff'] as $employee)
                                            <option @if($leave_request->employee_id==$employee->id) selected @endif value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Leave Type --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label"><label>Leave Type</label></div>
                                    <select name="leave_type_id" class="form-control">
                                        <option value="" disabled selected>Select Leave Type</option>
                                        @foreach($data_create['LeaveTypes'] as $type)
                                            <option @if($leave_request->leave_type_id==$type->id) selected @endif value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Work Shift --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label"><label>Work Shift</label></div>
                                    <select name="work_shift_id" class="form-control">
                                        <option value="" disabled selected>Select Work Shift</option>
                                        @foreach($data_create['WorkShifts'] as $shift)
                                            <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Leave Status --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label"><label>Leave Status</label></div>
                                    <select name="leave_status" class="form-control">
                                        <option value="1">Pending</option>
                                        <option value="2">Approved</option>
                                        <option value="3" selected>Rejected</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Start Date --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label"><label>Start Date</label></div>
                                    <input type="date" name="start_date" class="form-control">
                                </div>
                            </div>

                            {{-- End Date --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label"><label>End Date</label></div>
                                    <input type="date" name="end_date" class="form-control">
                                </div>
                            </div>

                            {{-- Total Days --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label"><label>Total Days</label></div>
                                    <input type="number" name="total_days" class="form-control" min="1">
                                </div>
                            </div>

                            {{-- Applied Date --}}
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label"><label>Applied Date</label></div>
                                    <input type="date" name="applied_date" class="form-control">
                                </div>
                            </div>

                            {{-- Comments --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="input-label"><label>Comments</label></div>
                                    <textarea name="comments" class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                            {{-- Leave Type Data --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="input-label"><label>Leave Type Data</label></div>
                                    <textarea name="leave_type_data" class="form-control" rows="2"></textarea>
                                </div>
                            </div>

                            {{-- Work Shift Data --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="input-label"><label>Work Shift Data</label></div>
                                    <textarea name="work_shift_data" class="form-control" rows="2"></textarea>
                                </div>
                            </div>

                            {{-- Single Day Fields --}}
                            @foreach([
                                'single_duration' => 'Duration',
                                'single_shift' => 'Shift',
                                'single_hours_start' => 'Start Time',
                                'single_hours_end' => 'End Time',
                                'single_hours_duration' => 'Hours Duration'
                            ] as $name => $label)
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-label"><label>{{ $label }}</label></div>
                                        <input type="{{ strpos($name, 'hours_duration') ? 'number' : 'text' }}" name="{{ $name }}" class="form-control">
                                    </div>
                                </div>
                            @endforeach

                            {{-- Partial Days --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="input-label"><label>Partial Days</label></div>
                                    <input type="text" name="partial_days" class="form-control">
                                </div>
                            </div>

                            {{-- All Days Fields --}}
                            @foreach([
                                'all_days_duration' => 'All Days Duration',
                                'all_days_shift' => 'All Days Shift',
                                'all_days_hours_start' => 'All Days Hours Start',
                                'all_days_hours_end' => 'All Days Hours End',
                                'all_days_hours_duration' => 'All Days Hours Duration'
                            ] as $name => $label)
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-label"><label>{{ $label }}</label></div>
                                        <input type="{{ strpos($name, 'duration') ? 'number' : 'text' }}" name="{{ $name }}" class="form-control">
                                    </div>
                                </div>
                            @endforeach

                            {{-- Starting Fields --}}
                            @foreach([
                                'starting_duration' => 'Starting Duration',
                                'starting_shift' => 'Starting Shift',
                                'starting_hours_start' => 'Starting Hours Start',
                                'starting_hours_end' => 'Starting Hours End',
                                'starting_hours_duration' => 'Starting Hours Duration'
                            ] as $name => $label)
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-label"><label>{{ $label }}</label></div>
                                        <input type="{{ strpos($name, 'duration') ? 'number' : 'text' }}" name="{{ $name }}" class="form-control">
                                    </div>
                                </div>
                            @endforeach

                            {{-- Ending Fields --}}
                            @foreach([
                                'ending_duration' => 'Ending Duration',
                                'ending_shift' => 'Ending Shift',
                                'ending_hours_start' => 'Ending Hours Start',
                                'ending_hours_end' => 'Ending Hours End',
                                'ending_hours_duration' => 'Ending Hours Duration'
                            ] as $name => $label)
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-label"><label>{{ $label }}</label></div>
                                        <input type="{{ strpos($name, 'duration') ? 'number' : 'text' }}" name="{{ $name }}" class="form-control">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            <a href="{!! route('admin.hrm-leave-requests.index') !!}" class="btn btn-sm btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
