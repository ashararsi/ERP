@extends('layouts.app')
@section('stylesheet')
<link rel="stylesheet"
    href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">


@stop
@section('content')
<style>
    #example_wrapper {
        margin-top: 70px !important;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Assets Types</h4>
                @if(Auth::user()->isAbleTo('create-assets-types'))
                <a href="{{route('admin.assets-types.create')}}" style="float:right;" class="btn btn-success pull-right">Add New
                 Banks</a>
                 @endif

            </div><!-- end card header -->

            <div class="card-body">
                <table class="table table-bordered table-striped {{ count($assets) > 0 ? 'datatable' : '' }}">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Assets Type</th>
                            @if(Auth::user()->isAbleTo('edit-assets-types'))
                            <th>Actions</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($assets) > 0)
                        <?php
                $i=0;
                ?>
                        @foreach ($assets as $bank)
                        <?php $i++; ?>
                        <tr data-entry-id="{{ $bank->id }}">
                            <td>
                                {{$i}}
                            </td>
                            <td>{{ $bank->name }}</td>
                            @if(Auth::user()->isAbleTo('edit-assets-types'))
                            <td>
                                <div class="hstack gap-3 flex-wrap">
                                    <a href="assets-types\{{$bank->id}}\edit" class="link-success fs-15"><i
                                            class="ri-edit-2-line"></i></a>
                                   
                                </div>

                            </td>
                            @endif


                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="3">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>

@stop

@section('javascript')

@endsection