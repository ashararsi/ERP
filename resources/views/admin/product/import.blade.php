@extends('admin.layout.main')
@section('title')
    Product Upload
@stop


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">upload Product Data </h3>
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
                        <form method="post" action="{!! route('admin.products.import.data') !!}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>File</label>
                                        </div>
                                        <input  type="file" required class="form-control" value=" " name="excel_file">
                                    </div>
                                </div>


                            </div>


                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                <a href="{!! route('admin.products.index') !!}"
                                   class=" btn btn-sm btn-danger">Cancel </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(document).ready(function () {
            // Select/Deselect all checkboxes
            $('#select-all').on('change', function () {
                $('input[type="checkbox"][name="permisions[]"]').prop('checked', this.checked);
            });

            // If any checkbox is unchecked, uncheck the "Select All" checkbox
            $('input[type="checkbox"][name="permisions[]"]').on('change', function () {
                if (!this.checked) {
                    $('#select-all').prop('checked', false);
                }

                // If all checkboxes are checked, check the "Select All" checkbox
                if ($('input[type="checkbox"][name="permisions[]"]:checked').length === $('input[type="checkbox"][name="permisions[]"]').length) {
                    $('#select-all').prop('checked', true);
                }
            });
        });
    </script>
@endsection
