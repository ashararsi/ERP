@extends('admin.layout.main')

@section('title')
    Edit Category
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4">Edit Category</h3>
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

                        <form method="post" action="{{ route('admin.categories.update', $category->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Name -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Category Name</label>
                                        <input type="text" required class="form-control" name="name" value="{{ old('name', $category->name) }}">
                                    </div>
                                </div>

                        
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
