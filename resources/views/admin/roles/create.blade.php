@extends('admin.layout.main')
@section('title')
    Role  Create
@stop


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card "><div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Create Role </h3>
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
                        <form method="post" action="{!! route('admin.roles.store') !!}"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="input-label">
                                            <label>Name</label>
                                        </div>
                                        <input type="text" required class="form-control" value=" " name="name">
                                    </div>
                                </div>
                            </div>   <div class="form-group">
                                <input type="checkbox" id="select-all"> <label for="select-all">Select All</label>
                            </div>

                            <div class="container mt-4">
                            <div class="row">
                                @foreach($permissions as $item)
                                    <div class="card col-md-3 mt-4   " style="margin-left: 15px; margin-right: 15px"  >
                                        <div class="card-header">
                                            <h5 class="card-title w-100 row">
                                              <span class="col-10">{!! $item->name !!}</span>
                                            <span class="col-2 float-right mt-1" style="margin-right: 10px margin-left: 10px">
                                                <input type="checkbox" value="{!! $item->id !!}"
                                                         name="permisions[]">   </span></h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-text">
                                                <table class="table table-striped table-hover">
                                                    @if($item->child !=null)
                                                        @foreach($item->child as $item1 )
                                                            <tr>
                                                                <td > {!! $item1 ->name !!} </td>
                                                                <td> <span class="ml-4"> <input type="checkbox" value="{!! $item1->id !!}"
                                                                                   name="permisions[]"> </span> </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </table>
                                            </div>

                                        </div>
                                        <div class="card-footer text-muted">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                           </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                <a href="{!! route('admin.roles.index') !!}"
                                   class=" btn btn-sm btn-danger">Cancel </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js') <script>
    $(document).ready(function() {
        // Select/Deselect all checkboxes
        $('#select-all').on('change', function() {
            $('input[type="checkbox"][name="permisions[]"]').prop('checked', this.checked);
        });

        // If any checkbox is unchecked, uncheck the "Select All" checkbox
        $('input[type="checkbox"][name="permisions[]"]').on('change', function() {
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
