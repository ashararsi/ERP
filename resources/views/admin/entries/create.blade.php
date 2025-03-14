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
