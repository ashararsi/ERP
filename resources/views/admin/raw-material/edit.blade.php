@extends('admin.layout.main')
@section('title')
    Role Edit
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card "><div class="card-header bg-light">
                        <h3 class="text-22 text-midnight text-bold mb-4"> Edit </h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{!! route('admin.roles.update',$role->id) !!}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <div class="input-label">
                                    <label>Name</label>
                                </div>
                                <input type="text" required class="form-control" value="{!! $role->name !!}"
                                       name="name">
                            </div>
                            <div class="container mt-4">
                                <div class="row">
                                    @foreach($permissions as $item)
                                        <div class="card mt-4 z-50" style="width: 18rem;">
                                            <div class="card-header">
                                                <h5 class="card-title">
                                                    <span>{!! $item->name !!}</span>
                                                    <span class="float-right mt-1">

                                                        <input type="checkbox" value="{!! $item->id !!}"
                                                               name="permisions[]" @if(isset($AllowedPermissions[$item->id])) checked="true" @endif> </span>
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-text">
                                                    <table class="table table-striped table-hover">
                                                        @if($item->child !=null)
                                                            @foreach($item->child as $item1 )
                                                                <tr>
                                                                    <td> {!! $item1 ->name !!} </td>
                                                                    <td> <span class="ml-4"> <input type="checkbox"
                                                                                                    value="{!! $item1->id !!}" @if(isset($AllowedPermissions[$item1->id])) checked="true" @endif
                                                                                                    name="permisions[]"> </span>
                                                                    </td>
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
                            <div class="row">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                    <a href="{!! route('admin.roles.index') !!}"
                                       class=" btn btn-sm btn-danger">Cancel </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
@endsection
