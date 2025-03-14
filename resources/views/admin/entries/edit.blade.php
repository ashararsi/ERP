@extends('admin.layout.main')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0" style="float:left;">Edit Ledger</h4>
                    <a href="{{ route('admin.ledger.index') }}" class="btn btn-success" style="float:right;">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ledger.update', $ledger->id) }}" method="POST" id="validation-form">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <label for="ledger_name" class="form-label">Name*</label>
                                <input type="text" id="ledger_name" name="name" value="{{ old('name', $ledger->name) }}" class="form-control" maxlength="250" placeholder="">
                                <ul id="results" class="list-group"></ul>
                            </div>
{{--                            <div class="col-md-6">--}}
{{--                                <label for="branch_id" class="form-label">Branches</label>--}}
{{--                                <select name="branch_id" id="branch_id" class="form-control">--}}
{{--                                    @foreach($branches as $branch)--}}
{{--                                        <option value="{{ $branch->id }}" {{ $ledger->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
                            <div class="col-md-4">
                                <label for="balance_type" class="form-label">Balance Type</label>
                                <select name="balance_type" id="balance_type" class="form-control" required>
                                    <option value="">Select Balance Type</option>
                                    <option value="d" {{ $ledger->balance_type == 'd' ? 'selected' : '' }}>Debit</option>
                                    <option value="c" {{ $ledger->balance_type == 'c' ? 'selected' : '' }}>Credit</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="opening_balance" class="form-label">Opening Balance</label>
                                <input type="text" id="opening_balance" name="opening_balance" value="{{ old('opening_balance', $ledger->opening_balance) }}" class="form-control" pattern="[0-9]+" maxlength="10">
                            </div>
                            <div class="col-md-4">
                                <label for="closing_balance" class="form-label">Closing Balance</label>
                                <input type="number" id="closing_balance" name="closing_balance" value="{{ old('closing_balance', $ledger->closing_balance) }}" class="form-control" readonly>
                            </div>


                            <div class="col-md-12">
                                <label for="group_id" class="form-label">Parent Group</label>
                                <select name="group_id" id="group_id" class="form-control">
                                    <option value="">Select a Parent Group</option>
                                    {!! $groups !!}
                                </select>
                            </div>
                        </div>
                        <button class="btn btn-success mt-3 w-100">Update Ledger</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
