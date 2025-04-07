@extends('admin.layout.main')

@section('css')
    <style>
        .col-md-6, .col-md-4, .col-md-12 {
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

        .panel {
            padding: 0 18px;
            display: block;
            background-color: white;
            overflow: hidden;
        }
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Create Shift</h3>
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

                    <form method="POST" action="{{ route('admin.work-shifts.store') }}">
                        @csrf
                        <div class="row">
                            <!-- Shift Name -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shift Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                </div>
                            </div>

                            <!-- Hours per Day -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hours per Day</label>
                                    <input type="number" step="0.01" class="form-control" name="hours_per_day" value="{{ old('hours_per_day') }}" required>
                                </div>
                            </div>

                            <!-- Shift Start Time -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shift Start Time</label>
                                    <input type="time" class="form-control" name="shift_start_time" value="{{ old('shift_start_time') }}" required>
                                </div>
                            </div>

                            <!-- Shift End Time -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shift End Time</label>
                                    <input type="time" class="form-control" name="shift_end_time" value="{{ old('shift_end_time') }}" required>
                                </div>
                            </div>

                            <!-- Working Hours per Day -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Working Hours per Day</label>
                                    <input type="number" step="0.01" class="form-control" name="working_hours_per_day" value="{{ old('working_hours_per_day') }}" required>
                                </div>
                            </div>

                            <!-- Break Start Time -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Break Start Time</label>
                                    <input type="time" class="form-control" name="break_start_time" value="{{ old('break_start_time') }}" required>
                                </div>
                            </div>

                            <!-- Break End Time -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Break End Time</label>
                                    <input type="time" class="form-control" name="break_end_time" value="{{ old('break_end_time') }}" required>
                                </div>
                            </div>

                            <!-- Break Hours per Day -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Break Hours per Day</label>
                                    <input type="number" step="0.01" class="form-control" name="break_hours_per_day" value="{{ old('break_hours_per_day') }}" required>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            <a href="{{ route('admin.work-shifts.index') }}" class="btn btn-sm btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    {{-- Optional JS if needed --}}
@stop
