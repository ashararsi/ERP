@extends('layouts.app')
@section('stylesheet')
    <link rel="stylesheet" href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
@stop
@section('breadcrumbs')

@section('content')
<div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
						<!--div-->
						<div class="card">
							<div class="card-body">
								<div class="main-content-label mg-b-5">
                                <h3 style = "float:left;">Create Journal Voucher</h3>
            <a href="{{ route('admin.entries.index') }}" class="btn btn-success pull-right">Back</a>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        {!! Form::open(['method' => 'POST', 'route' => ['admin.voucher.gjv_store'], 'id' => 'validation-form']) !!}
        <div class="box-body">
            @include('admin.entries.voucher.journal_voucher.fields')
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger globalSaveBtn']) !!}
        </div>
        {!! Form::close() !!}
        @include('admin.entries.voucher.journal_voucher.entries_template')
    </div>
@stop

@section('javascript')

    <script src="{{ url('public/js/admin/entries/voucher/journal_voucher/create_modify.js') }}" type="text/javascript"></script>
@endsection
<script>
function dr_validation(id)
{
    var id = '#entry_item-dr_amount-'+id;
    //console.log(id);
    //var value = $(id).val();
    $(id).keyup(function(event) {

    // skip for arrow keys
    if(event.which >= 37 && event.which <= 40) return;

   
    });
    //alert(value);
}

function cr_validation(id)
{
    var id = '#entry_item-cr_amount-'+id;
    console.log(id);
    var value = $(id).val();
    // alert(value);
}

    </script>

