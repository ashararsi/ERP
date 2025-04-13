@extends('admin.layout.main')
@section('title')
     Attendance
@endsection
@section('css')

@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Edit Attendance</h3>
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
                    <form method="post" action="{!! route('admin.attendance.update', $Attendance->id) !!}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- User ID -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>User</label>
                                    </div>
                                    <select name="user_id" class="form-control" required>
                                        <option value="" disabled selected>Select User</option>
                                        @foreach($data_create['Staff'] as $user)
                                            <option @if($Attendance->user_id==$user->id) selected
                                                    @endif value="{{ $user->id }}">{{ $user->first_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Date -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Date</label>
                                    </div>
                                    @php
                                        $currentDate = \Carbon\Carbon::now()->toDateString(); // e.g., 2025-04-13
                                    @endphp
                                    <input type="date" value="{!! $Attendance->date !!}" name="date"
                                           class="form-control" required>
                                </div>
                            </div>

                            <!-- Time In -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Time In</label>
                                    </div>
                                    @php
                                        $currentTime = \Carbon\Carbon::now()->format('H:i'); // e.g., 14:35
                                    @endphp

                                    <input type="time" name="time_in" value="{!! $Attendance->time_in !!}"
                                           class="form-control">
                                </div>
                            </div>

                            <!-- Time Out -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Time Out</label>
                                    </div>
                                    <input type="time" name="time_out" value="{!! $Attendance->time_out!!}"
                                           class="form-control">
                                </div>
                            </div>

                            <!-- Branch ID -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Branch</label>
                                    </div>
                                    <select name="branch_id" class="form-control">
                                        <option value="" disabled selected>Select Branch</option>
                                        @foreach($data_create['branches']  as $branch)
                                            <option @if($Attendance->user_id==$branch->id) selected
                                                    @endif   value="{{ $branch->id }}">{{ $branch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Status</label>
                                    </div>
                                    <select name="status" class="form-control" required>
                                        <option value="Present">Present</option>
                                        <option value="Absent">Absent</option>
                                        <option value="Leave">Leave</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Remarks -->
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Remarks</label>
                                    </div>
                                    <input type="text" name="remarks" class="form-control" placeholder="Optional">
                                </div>
                            </div>

                            @php
                                $currentMonth = \Carbon\Carbon::now()->format('F'); // e.g., April
                            @endphp

                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Month</label>
                                    </div>
                                    <input type="text" name="month" class="form-control" value="{{ $currentMonth }}"
                                           readonly>
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
