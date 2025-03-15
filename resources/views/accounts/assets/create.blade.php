@extends('layouts.app')
@section('stylesheet')
<link rel="stylesheet"
    href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">


@stop
@section('breadcrumbs')
@section('content')
<style>
    #example_wrapper {
        margin-top: 70px !important;
    }

    .col-md-3 {
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
                <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Add New Assets</h4>
                <a href="{{ route('admin.assets.index') }}" style="float:right;" class="btn btn-success pull-right">Back</a>

            </div><!-- end card header -->

            <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route' => ['admin.assets.store'],'enctype' => 'multipart/form-data', 'id' => 'validation-form']) !!}
        <div class="panel panel-default">
            <div class="panel-body" >
                <div class="row">
                     <div class="col-md-12 form-group @if($errors->has('branch')) has-error @endif">
                        <div class="@if($errors->has('branch')) has-error @endif">
                            {!! Form::label('branch', 'Select Products*', ['class' => 'control-label']) !!}
                            <select id="product_id" name="product_id" class="form-control select2" data-placeholder="Select Branch" required>
                           <option value ="">Select Products</option>
                            @foreach($products as $product)
                            <option value = "{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                            </select>
                         
                        </div>
                    </div>

                    <div class=" form-group col-md-3 @if($errors->has('products_name')) has-error @endif">
                        {!! Form::label('products_name', 'Select Asset Category *', ['class' => 'control-label']) !!}
                        <select name="asset_id" id="asset_id" class="form-control" required>
                            <option value = "">Select Assets Category</option>
                            @foreach($assets_types as $assets_type)
                            <option value = "{{$assets_type->id}}">{{$assets_type->name}}</option>
                            @endforeach
                        </select>
                    </div>

                     <div class="form-group col-md-3 @if($errors->has('products_date')) has-error @endif">
                        {!! Form::label('products_date', 'Purchasing Date*', ['class' => 'control-label']) !!}
                        <input type="date" name="products_date" class="form-control" required maxlength="10">
                    </div>

                    <div class="form-group col-md-3 @if($errors->has('asset_type_id')) has-error @endif">
                       {!! Form::label('asset_type_id', 'Asset Type*', ['class' => 'control-label']) !!}
                       <select name="asset_type" id="asset_type" class="form-control" required>
                            <option value = "">Select Assets Type</option>
                            <option value = "old">OLD</option>
                            <option value = "new">New</option>
                        </select>
                       
                    </div> 

                    <div class="col-md-3 form-group @if($errors->has('branch')) has-error @endif">
                        <div class="@if($errors->has('branch')) has-error @endif">
                            {!! Form::label('branch', 'Branch*', ['class' => 'control-label']) !!}
                            <select id="branch_id" name="branch" class="form-control select2" data-placeholder="Select Branch" required onchange = "get_ledgers_against_branches()">
                           <option value ="">Select Branch</option>
                            @foreach($branches as $branch)
                            <option value = "{{$branch->id}}">{{$branch->name}}</option>
                            @endforeach
                            </select>
                         
                        </div>
                    </div>

                    <div class="col-md-3 form-group @if($errors->has('price')) has-error @endif">
                        {!! Form::label('price', 'Price*', ['class' => 'control-label']) !!}
                        <input type="number" onchange="priceCalled()" name="price" class="form-control" id="price">
                    </div>
                    <div class="col-md-3 form-group @if($errors->has('price')) has-error @endif">
                        {!! Form::label('price', 'Total Months Of Deduction*', ['class' => 'control-label']) !!}
                        <input type="number" onchange="priceCalled()" class="form-control" name="months" id="month">
                    </div>
                    <div class="col-md-3 form-group @if($errors->has('price')) has-error @endif">
                        {!! Form::label('price', 'Per Month Amount*', ['class' => 'control-label']) !!}
                        <input type="text" readonly="readonly" id="depriciated_amount" name="depriciated_amount" class="form-control">
                    </div>

                    <div class="col-md-3 form-group @if($errors->has('closing_stock')) has-error @endif">
                        {!! Form::label('closing_stock', 'Quantity*', ['class' => 'control-label']) !!}
                        <input type="number" name="quantity" class="form-control" id="quantity">
                    </div>
                </div>

                <div class="row">
         <div class="col-md-3 form-group @if($errors->has('closing_stock')) has-error @endif">
                        {!! Form::label('closing_stock', 'Select Department:*', ['class' => 'control-label']) !!}
                        <select class = "form-control" name = "department_id" required>
                            <option value = "">Select Department</option>
                            @foreach($department as $dept)
                            <option value = "{{$dept->id}}">{{$dept->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 form-group @if($errors->has('po_number')) has-error @endif">
                        {!! Form::label('po_number', 'Po Number*', ['class' => 'control-label']) !!}
                        {!! Form::number('po_number', old('po_number'), ['class' => 'form-control', 'placeholder' => '','required']) !!}
                        @if($errors->has('model'))
                            <span class="help-block">
                                    {{ $errors->first('po_number') }}
                                </span>
                        @endif
                    </div>
                    <div class="col-md-3 form-group @if($errors->has('serial_number')) has-error @endif">
                        {!! Form::label('serial_number', 'Serial No*', ['class' => 'control-label']) !!}
                        {!! Form::number('serial_number', old('serial_number'), ['class' => 'form-control', 'placeholder' => '','required']) !!}
                        @if($errors->has('model'))
                            <span class="help-block">
                                    {{ $errors->first('retail_price') }}
                                </span>
                        @endif
                    </div>
                    <div class="col-md-3 form-group @if($errors->has('warranty_expires')) has-error @endif">
                        {!! Form::label('warranty_expires', 'Warranty Expires*', ['class' => 'control-label']) !!}
                        {!! Form::text('warranty_expires', old('warranty_expires'), ['class' => 'form-control datepicker', 'placeholder' => '','required']) !!}
                        @if($errors->has('model'))
                            <span class="help-block">
                                    {{ $errors->first('warranty_expires') }}
                                </span>
                        @endif
                    </div>

                </div>
                <div class="row">
                                        <div class="col-md-3 form-group @if($errors->has('closing_stock')) has-error @endif">
                        {!! Form::label('closing_stock', 'Payment Method*', ['class' => 'control-label']) !!}
                        <select class = "form-control" name = "payment_method" required>
                            <option value = "">Select Payment Method</option>
                            <option value = "Bank">Bank</option>
                            <option value = "Cash">Cash</option>
                            
                        </select>
                    </div>
                                            <div class="col-md-3 form-group @if($errors->has('closing_stock')) has-error @endif">
                        {!! Form::label('closing_stock', 'Select Credit A/C:*', ['class' => 'control-label']) !!}
                        <select class = "form-control" name = "credit" required>
                            <option value = "">Select Credit A/C:</option>
                            @foreach($ledgers as $ledger)
                            <option value = "{{$ledger->id}}">{{$ledger->name}}</option>
                            @endforeach
                        </select>
                    </div>
                                       <div class="col-md-3 form-group @if($errors->has('closing_stock')) has-error @endif">
                        {!! Form::label('closing_stock', 'Select Debit A/C:*', ['class' => 'control-label']) !!}
                        <select class = "form-control" name = "debit" id = "branch_leders" required>
                           
                        </select>
                    </div>
                                       <div class="col-md-3 form-group @if($errors->has('closing_stock')) has-error @endif">
                        {!! Form::label('closing_stock', 'Select Vendor:*', ['class' => 'control-label']) !!}
                        <select class = "form-control" name = "vendor_id" required>
                            <option value = "">Select Vendor</option>
                            @foreach($vendor as $vend)
                            <option value = "{{$vend->vendor_id}}">{{$vend->vendor_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group @if($errors->has('remarks')) has-error @endif">
                        {!! Form::label('remarks', 'Remarks', ['class' => 'control-label']) !!}
                        {!! Form::textarea('remarks', old('remarks'), ['class' => 'form-control', 'placeholder' => '', 'rows' => 4, 'cols' => 10]) !!}

                        @if($errors->has('remarks'))
                                <span class="help-block">
                                    {{ $errors->first('remarks') }}
                                </span>
                        @endif
                    </div>
                    <div class="col-md-6 form-group @if($errors->has('products_desc')) has-error @endif">
                        {!! Form::label('products_desc', 'Description', ['class' => 'control-label']) !!}
                        {!! Form::textarea('products_desc', old('products_desc'), ['class' => 'form-control', 'placeholder' => '', 'rows' => 4, 'cols' => 10]) !!}

                        @if($errors->has('products_desc'))
                            <span class="help-block">
                                    {{ $errors->first('products_desc') }}
                                </span>
                        @endif
                    </div>
                </div>

                <div class="brands_row">
                    <div class="col-xs-6">
                        {!! Form::submit(trans('save'), ['class' => 'btn btn-primary globalSaveBtn','style'=>'width:100%;margin-top:10px;']) !!}
                    </div>
                </div>

             </div>
            </div>
        </div>
        {!! Form::close() !!}
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@stop

    <script type="text/javascript">
        function priceCalled()
        {
             var z =$("#price").val();
             var y =$("#month").val();
             if(y)
             {
              $("#depriciated_amount").val(z/y);  
             }
             else
             {
                $("#depriciated_amount").val(0);
             }
             
        }
        function get_ledgers_against_branches()
        {
              var branch_id = document.getElementById("branch_id").value;

  $.ajax({
      url: '{{url('admin/load-assets-against-branches')}}',
      type: 'get',
      data: {
          "branch_id": branch_id
      },
      success: function(data){
          $("#branch_leders").empty();
          
          $("#branch_leders").append("<option value = 'null'>---Select Debit A/C---</option>");
          for(i in data){
              $("#branch_leders").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>");
          }

      }
  })
        }
      
    </script>