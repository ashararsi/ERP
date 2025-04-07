@extends('admin.layout.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="text-22 text-midnight text-bold mb-4">Create Loan Plan</h3>
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

                    <form method="POST" action="{{ route('admin.loan-plans.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Loan Installment</label>
                                    <input type="text" name="loan_installment" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label>Tenure</label>
                                    <input type="text" name="tenure" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label>Extra Pay</label>
                                    <input type="text" name="extra_pay" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right mt-4">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            <a href="{{ route('admin.loan-plans.index') }}" class="btn btn-sm btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
