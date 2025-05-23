@extends('admin.layout.main')
@section('title')
    Leaves Status
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                <div class="card ">
                    <div class="card-body">
                        <h3 class="text-22 text-midnight text-bold mb-4">View Book </h3>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Title</label>
                                    </div>
                                    <input readonly type="text" required class="form-control" value="{!! $book->title !!}"
                                           name="title">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 mt-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="input-label">
                                        <label>Description</label>
                                    </div>
                                    <textarea readonly class="form-control"
                                              name="description">{!! $book->description !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
