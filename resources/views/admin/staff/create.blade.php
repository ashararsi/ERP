@extends('admin.layout.main')

@section('content')
    <div class="container">
        <h2>Create Staff Member</h2>
        <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Basic Info --}}
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Branch</label>
                    <input type="number" name="branch_id" class="form-control">
                </div>
                 
                <div class="col-md-4 mb-3">
                    <label>Staff Type</label>
                    <input type="text" name="staff_type" class="form-control" required>
                </div>
            </div>

            {{-- Personal Info --}}
            <div class="row">
                @foreach(['first_name', 'middle_name', 'last_name', 'father_name', 'mother_name'] as $field)
                    <div class="col-md-4 mb-3">
                        <label>{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                        <input type="text" name="{{ $field }}" class="form-control">
                    </div>
                @endforeach
            </div>

            {{-- Contact Info --}}
            <div class="row">
                @foreach(['email', 'pemail', 'home_phone', 'mobile_1', 'mobile_2'] as $field)
                    <div class="col-md-4 mb-3">
                        <label>{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                        <input type="text" name="{{ $field }}" class="form-control">
                    </div>
                @endforeach
            </div>

            {{-- Dates & Status --}}
            <div class="row">
                @foreach(['join_date', 'expiry_date', 'sos_date'] as $date)
                    <div class="col-md-4 mb-3">
                        <label>{{ ucfirst(str_replace('_', ' ', $date)) }}</label>
                        <input type="date" name="{{ $date }}" class="form-control">
                    </div>
                @endforeach
                <div class="col-md-4 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Active">Active</option>
                        <option value="InActive">InActive</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
            </div>

            {{-- Job Details --}}
            <div class="row">
                @foreach(['job_status', 'start_day_contract', 'end_day_contract', 'probation'] as $field)
                    <div class="col-md-3 mb-3">
                        <label>{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                        <input type="text" name="{{ $field }}" class="form-control">
                    </div>
                @endforeach
            </div>

            {{-- Enum Fields --}}
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label>Relation</label>
                    <select name="relation" class="form-control">
                        <option value="">Select</option>
                        <option value="father">Father</option>
                        <option value="husband">Husband</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Marital Status</label>
                    <select name="marital_status" class="form-control">
                        <option value="">Select</option>
                        <option value="married">Married</option>
                        <option value="unmarried">Unmarried</option>
                    </select>
                </div>
            </div>

            {{-- Address --}}
            <div class="row">
                @foreach(['address', 'temp_address', 'city', 'country'] as $field)
                    <div class="col-md-3 mb-3">
                        <label>{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                        <input type="text" name="{{ $field }}" class="form-control">
                    </div>
                @endforeach
            </div>

            {{-- Bank Info --}}
            <div class="row">
                @foreach(['bank_id', 'is_iban', 'bank_account', 'bank_branch', 'account_title', 'account_number'] as $field)
                    <div class="col-md-4 mb-3">
                        <label>{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                        <input type="text" name="{{ $field }}" class="form-control">
                    </div>
                @endforeach
            </div>

            {{-- Optional Details --}}
            <div class="row">
                @foreach([
                    'qualification', 'experience', 'other_info', 'skill', 'gender',
                    'blood_group', 'nationality', 'mother_tongue', 'cnic', 'ntn', 'password'
                ] as $field)
                    <div class="col-md-3 mb-3">
                        <label>{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                        <input type="{{ $field == 'password' ? 'password' : 'text' }}" name="{{ $field }}" class="form-control" {{ $field == 'password' ? 'required' : '' }}>
                    </div>
                @endforeach
            </div>

            {{-- Financials --}}
            <div class="row">
                @foreach([
                    'salary', 'salary_per_hour', 'basic_salary',
                    'house_rent', 'medical_allowances', 'conveyance',
                    'provident_fund', 'provident_amount', 'filer_type'
                ] as $field)
                    <div class="col-md-4 mb-3">
                        <label>{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                        <input type="text" name="{{ $field }}" class="form-control">
                    </div>
                @endforeach
            </div>

            {{-- Upload --}}
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Staff Image</label>
                    <input type="file" name="staff_image" class="form-control">
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-primary">Create Staff</button>
        </form>
    </div>
@endsection
