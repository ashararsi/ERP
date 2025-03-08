@extends('admin.layout.main')

@section('content')
    <style>
        #example_wrapper {
            margin-top: 70px !important;
        }

        .col-md-4 {
            padding: 10px;
        }

        .col-md-6 {
            padding: 10px;
        }

        .col-md-12 {
            padding: 10px;
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Add New Ledger</h4>
                    <a href="{{ route('admin.ledger.index') }}" style="float:right;" class="btn btn-success pull-right">Back</a>
                </div>

                <div class="card-body">
                    <form method="Post" enctype="multipart/form-data"
                          action="{!!  route('admin.ledger.store') !!}">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-6  "
                                 style="float:left;">
                                <label for="ledger_name">Name*</label>
                                <input type="text" value="" name="name" id="ledger_name" class="form-control"
                                       maxlength="250">
                            </div>

                            <div class="col-md-6 form-group" style=" float:left;">
                                <label for="branch">Branches</label>
                                <select name='branch_id'
                                        class="form-control input-sm select2"
                                        id="branch_id">
                                    <option value="">Select Branches</option>
                                    @foreach($branches as $key=>$value)
                                        <option value="{!! $value->id !!}">{!! $value->name !!}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class=" col-md-4 form-group "
                                 style="float:left;">
                                <label for="balance_type">Balance Type</label>
                                <select name="balance_type" class="form-control" required>
                                    <option value="">Select Balance Type</option>
                                    <option value="d">Debit</option>
                                    <option value="c">Credit</option>
                                </select>
                            </div>
                            <div class=" col-md-4 form-group  " style="float:left;">
                                <label for="opening_balance">Opening Balance</label>
                                <input type="number" value="" maxlength="10" name="opening_balance" id="opening_balance"
                                       class="form-control"/>

                            </div>
                            <div class=" col-md-4 form-group"
                                 style="float:left;">
                                <label for="closing_balance">Closing Balance</label>
                                <input type="number" value="" maxlength="10" name="closing_balance" id="closing_balance"
                                       class="form-control"/>

                            </div>
                            <div class="col-xs-12 form-group">
                                <label for="parent_id">Parent Group</label>
                                <select name="group_id" id="group_id" class="form-control groups" style="width: 100%;">
                                    <option value=""> Select a Parent Group</option>
                                    {!! $groups !!}
                                </select>

                            </div>
                        </div>

                        <!-- /.box-body -->
                        <button type="submit" id="btn" class="btn btn-success col-md-12" style="margin-top:20px;">Add New Ledger
                        </button>

                    </div>

                    </form>

                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    </div>
@endsection
@section('javascript')

    <script>
        $(document).ready(function () {

            $('#ledger_name').on('input', function () {
                let query = $(this).val();

                $.ajax({
                    url: "{{ route('admin.ledger.already_created') }}",
                    method: "GET",
                    data: {query: query},
                    success: function (data) {
                        console.log(data);
                        $('#results').html(data);
                    }
                });

            });

        });
    </script>
@endsection
