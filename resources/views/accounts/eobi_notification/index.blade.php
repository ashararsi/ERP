@extends('layouts.app')
@section('stylesheet')
<link rel="stylesheet" href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">


@stop
@section('content')
<style>
    #example_wrapper {
        margin-top: 70px !important;
    }

    .col-md-6 {
        padding: 10px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0 flex-grow-1" style="float:left;">EOBI Notification</h4>
                <a href="{{route('admin.eobi-notification.create')}}" style="float:right;" class="btn btn-success pull-right">Add New Notification</a>

            </div><!-- end card header -->
        
                <!-- /.box-header -->
                <div class="panel-body pad table-responsive">
            <table class="table table-bordered table-striped {{ count($eobin) > 0 ? 'datatable' : '' }}">
                <thead>

                    <tr>
                        <th>Sr.No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Company Share</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($eobin) > 0)
                    <?php
                        $i = 0;
                        ?>
                        @foreach ($eobin as $data)
                        <?php $i++; ?>
                        <tr data-entry-id="{{ $data->id }}">
                            <td>
                                {{$i}}
                            </td>
                                <td>{{ $data->name}}</td>
                                <td>{{ $data->description }}</td>
                                <td>{{ $data->date }}</td>
                                <td>{{ $data->amount }}</td>
                                <td>{{ $data->company_share }}</td>
                                <td>    
                                
                                    <a href="{{ route('admin.eobi-notification.edit',$data->id ) }}" class="btn btn-primary">Edit</a>
                                    

                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>


   




@stop

@section('javascript')

@endsection