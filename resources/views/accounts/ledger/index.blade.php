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
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Ledgers</h4>
                    @if(Auth::user()->isAbleTo('create-ledger'))
                        <a href="{{ route('admin.ledger.create') }}" style="float:right;"
                           class="btn btn-success pull-right">Add New Ledgers</a>
                    @endif
                </div><!-- end card header -->

                <div class="card-body">
                    <form id="ledger-form">
                        {{ csrf_field()}}
                        @if(isset(auth()->user()->roles[0]))
                            @php
                                $company_session=  Session::get('company_session');
                                if(!$company_session) {
                                    $company_session=0;
                                }

                            $branch_session=  Session::get('branch_session');
                                if(!$branch_session){
                                     $branch_session=0;
                                }
                            @endphp
                            @if(auth()->user()->roles[0]->name=="administrator")
                                <select style="display: none;" name='company_id'
                                        class="form-control input-sm select2"
                                        id="company_id"
                                        onchange="myFunction()">
                                    <option value="">---Select Company---</option>
                                    @foreach($company as $singleCompany)
                                        @if($company_session==$singleCompany->id)
                                            <option selected
                                                    value="{{$singleCompany->id}}">{{$singleCompany->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select style="display: none;" name='branch_id'
                                        class="form-control input-sm select2"
                                        id="branch_id">
                                    @php
                                        $html='';
                                            if( $branch_session!=0){
                                           $branch= \App\Models\Branches::find($branch_session);
                                             $html='<option selected value="'.$branch->id.'"> '.$branch->name.'</option>';
                                            }
                                    @endphp
                                    {!! $html !!}
                                </select>
                            @else
                                @php
                                    $companies=\App\Models\Company::all();
                                    $branchs=\App\Models\Branches::where('company_id',$company_session)->get();
                                @endphp
                                <select style="display: none;" name='company_id'
                                        class="form-control input-sm select2"
                                        id="company_id"
                                        onchange="myFunction()">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        @if(Auth::user()->isAbleTo('Company_'.$company->id))
                                            <option @if($company_session==$company->id) selected
                                                    @endif value="{{$company->id}}">{{$company->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <select style="display: none;" name='branch_id'
                                        class="form-control input-sm select2"
                                        id="branch_id">
                                    <option value="">Select Branch</option>
                                    @foreach($branchs as $item)
                                        @if(Auth::user()->isAbleTo('Branch_'.$item->id))
                                            <option @if($branch_session==$item->id) selected
                                                    @endif  value="{!! $item->id !!}">{!! $item->name !!}</option>
                                        @endif
                                    @endforeach
                                </select>
                            @endif
                        @endif
                        <div class="col-md-12" style="float:left;padding:5px;">
                            <div class="form-group">
                                <label>Search By Name</label>
                                <input type="text" name="name" placeholder='Search By Name' class="form-control"/>

                            </div>
                        </div>
                        <div class="col-md-12" style="">
                            <div class="form-group">
                                <button type="button" class="btn btn-sm btn-primary"
                                        style="width: 100%;margin-top: 25px;font-size: 13px;margin-bottom: 25px;height: 40px;"
                                        onclick="fetch_ledger()">Search
                                </button>
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
                                <th style="text-align:center;">Code</th>
                                <th style="text-align:center;">Name</th>
                                <th style="text-align:center;">Opening Balance</th>
                                @if(Auth::user()->isAbleTo('edit-ledger'))
                                    <th style="text-align:center;">Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tr id="fetch_ob"></tr>
                            <tbody id="getData"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        function fetch_ledger() {

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route( 'admin.load-ledger' ) }}',
                data: $("#ledger-form").serialize(),
                beforeSend: function () {
                    showLoader();
                },
                success: function (data) {
                    var htmlData = "";
                    var k = 1;
                    for (i in data.data) {
                        var id = data.data[i].id;
                        var opening_balance = data.data[i].opening_balance;
                        if (opening_balance != 'undefined' && opening_balance != '' && opening_balance != null) {

                        } else {
                            opening_balance = 0;
                        }

                        htmlData += '<tr>';
                        htmlData += '<td>' + k + '</td>';
                        htmlData += '<td>' + data.data[i].number + '</td>';
                        htmlData += '<td>' + data.data[i].name + '</td>';
                        htmlData += '<td>' + numberWithCommas(opening_balance) + '</td><td>';

                        @if (Auth::user()->isAbleTo('edit-ledger'))
                            htmlData += '<a href="{{ url('admin/ledger') }}/' + id + '/edit" class="link-success fs-15"><i class="ri-edit-2-line"></i></a>';
                        @endif

                        htmlData += `<form style="display: inline-block;" method="POST" action="/admin/ledger/:id" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="link-danger fs-15" type="submit" style="border: none; background-color: transparent;">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                    </form>`;

                        htmlData = htmlData.replace(':id', id);

                        htmlData += '</td></tr>';
                        k++;

                    }

                    $("#getData").html(htmlData);
                    $('#fetch_ob').html(data.ob);
                },
                complete: function () {
                    hideLoader();
                }
            });
        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        }

        function myFunction() {
            var company_id = document.getElementById("company_id").value;

            $.ajax({
                url: '{{url('admin/load-branches-against-company')}}',
                type: 'get',
                data: {
                    "company_id": company_id
                },
                success: function (data) {
                    $("#branch_id").empty();

                    $("#branch_id").append("<option value = 'null'>---Select Branches---</option>");
                    for (i in data) {
                        $("#branch_id").append("<option value='" + data[i].id + "'>" + data[i].name + "</option>");
                    }

                }
            })
        }
    </script>
@endsection



