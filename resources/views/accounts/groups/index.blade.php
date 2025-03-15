@extends('layouts.app')
@section('stylesheet')
<link rel="stylesheet"
    href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<style>
    #example_wrapper {
        margin-top: 70px !important;
    }
</style>
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Groups</h4>
                @if(Auth::user()->isAbleTo('create-groups'))
                <a href="{{route('admin.groups.create')}}" style="float:right;" class="btn btn-success pull-right">Add New
                 Groups</a>
                 @endif

            </div><!-- end card header -->

            <div class="card-body">
                <table class="table table-bordered table-striped {{ count($Groups) > 0 ? 'datatable' : '' }}">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Level</th>
                            @if(Auth::user()->isAbleTo('edit-groups'))
                            <th>Actions</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($Groups) > 0)
                        <?php
                $i=0;
                ?>
                        @foreach ($Groups as $bank)
                        <?php $i++; ?>
                        <tr data-entry-id="{{ $bank['id'] }}">
                            <td>
                                {{$i}}
                            </td>
                            <td>{{ $bank['number'] }}</td>
                            <td>{{ $bank['name'] }}</td>
                            <td>{{ $bank['level'] }}</td>
                            @if(Auth::user()->isAbleTo('create-banks'))
                            <td>
                                <div class="hstack gap-3 flex-wrap">
                                    <a href="groups\{{$bank['id']}}\edit" class="link-success fs-15"><i
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
