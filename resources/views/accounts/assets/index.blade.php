@extends('layouts.app')
@section('stylesheet')
<link rel="stylesheet" href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">


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
                <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Fixed Assets</h4>
                @if(Auth::user()->isAbleTo('create-voucher'))
                <div class="btn-group pull-right" role="group" style="float:right;" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <a href="{{route('admin.assets.create')}}" style="float:right;" class="btn btn-success pull-right">Add New
               Fixed Assets</a>
                    </div>
                </div>
                @endif
            </div><!-- end card header -->

            <div class="card-body">
                <form id="ledger-form">
                    {{ csrf_field()}}



                    <div class="col-md-12" style="float:left;padding:5px;">
                        <div class="form-group">
                            <label>Select Branch</label>
                            <select name='branch_id' class="form-control input-sm select2" id="company_id" onchange="myFunction()">
                                <option value="null">---Select Branch---</option>
                                @foreach($branches as $companies)
                                <option value="{{$companies->id}}">{{$companies->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!--div class="col-md-6" style="float:left;padding:5px;">
                        <div class="form-group">
                            <label>Select Branch</label>
                            <select name='branch_id' class="form-control input-sm select2 branches" id="branch_id">
                                <option value="null">---Select Branches---</option>
                            </select>
                        </div>
                    </div -->
                    <div class="col-md-6" style="float:left;padding:5px;">
                        <div class="form-group">
                            <label>Select Assets Type</label>
                            <select name='assets_type' class="form-control input-sm select2 branches" id="branch_id">
                                <option value="null">---Select Assets Type---</option>
                                 @foreach($assets_types as $companies)
                                <option value="{{$companies->id}}">{{$companies->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                      <div class="col-md-6" style="float:left;padding:5px;">
                        <div class="form-group">
                            <label>Select Department</label>
                            <select name='department_id' class="form-control input-sm select2 branches" id="branch_id">
                                <option value="null">---Select Department---</option>
                                 @foreach($department as $companies)
                                <option value="{{$companies->id}}">{{$companies->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12" style="float:left;padding:5px;">
                        <div class="form-group">
                            <label>Search By Product Name</label>
                           <input type ="text" placeholder ="Search By Name" class = "form-control" name = "name"/>
                        </div>
                    </div>
                

                    <div class="col-md-12" style="">
                        <div class="form-group">
                            <button type="button" class="btn btn-sm btn-primary" style="width: 100%;margin-top: 25px;font-size: 13px;margin-bottom: 25px;height: 40px;" onclick="fetch_ledger()">Search</button>
                        </div>
                    </div>
                </form>
                <div class="clearfix"></div>
                <!-- /.box-header -->
                <div class="panel-body pad table-responsive">
                    <table class="table table-bordered" style="text-transform:none;">
                        <thead>
                            <tr style="text-align:center;">
                                <th style="text-align:center;">Sr.No</th>
                                <th style="text-align:center;">Product Name</th>
                                <th style="text-align:center;">Assets Type</th>
                                <th style="text-align:center;">Assets Category</th>
                                <th style="text-align:center;">Vendor</th>
                                <th style="text-align:center;">Department</th>
                                <th style="text-align:center;">Branch</th>
                                <th style="text-align:center;">Quantity</th>
                                <th style="text-align:center;">Total Price</th>
                                <th style="text-align:center;">No of Month Depreciation</th>
                                <th style="text-align:center;">Per Month Amount</th>
                              
                                @if(Auth::user()->isAbleTo('edit-voucher'))
                                <th style="text-align:center;">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tr id="fetch_ob"></tr>
                        <tbody id="getData"></tbody>
                    </table>
                </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


            <script>
                function fetch_ledger() {

                    $.ajax({
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ route('admin.load-fixed-assets') }}",
                        data: $("#ledger-form").serialize(),
                        success: function(data) {
                            var action_edit     = "";
                            var action_view     = "";
                            var action_pdf      = "";
                            var action_delete   = "";
                            var action_all      = "";
                            var htmlData = "";
                            var k = 1;
                            for (i in data.data) {
                                var id = data.data[i].id;

                                htmlData += '<tr>';
                                htmlData += '<td>' + k + '</td>';
                                htmlData += '<td>' + data.data[i].product_name + '</td>';
                                htmlData += '<td>' + data.data[i].asset_name +'</td>';
                                htmlData += '<td>' + data.data[i].asset_type + '</td>';
                                htmlData += '<td>' + data.data[i].vendor_name + '</td>';
                                htmlData += '<td>' + data.data[i].department_name + '</td>';
                                htmlData += '<td>' + data.data[i].branch_name + '</td>';
                                htmlData += '<td>' + data.data[i].quantity + '</td>';
                                htmlData += '<td>' + data.data[i].price + '</td>';
                                htmlData += '<td>' + data.data[i].month + '</td>';
                                htmlData += '<td>' + data.data[i].depriciated_amount + '</td>';
                                <?php
                                if(Auth::user()->isAbleTo('edit-voucher'))
                                {
                                    ?>
                                htmlData += '<td><a href="{{ route("admin.bpv-edit") }}/?id='+ id +'" class="link-success fs-15"><i class="ri-edit-2-line"></i></a></td>';
                                <?php
                                }
                                ?>



                                htmlData += '</tr>';
                                k++;


                            }

                            $("#getData").html(htmlData);
                            $('#fetch_ob').html(data.ob);
                        }
                    });
                }
                function numberWithCommas(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
}
                function myFunction() {
                 
                }
            </script>
            @stop