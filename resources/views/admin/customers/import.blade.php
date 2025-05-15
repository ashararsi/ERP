@extends('admin.layout.main')

@section('title')
    Customers Upload
@stop

@section('content')
    {{-- <x-import-form
        route="admin.packing-materials.importdata"
        label="Upload packing Materials"
        cancelRoute="admin.packing-materials.index"
    /> --}}
    {{--    <x-import-form--}}
    {{--    route="admin.customers.importdata"--}}
    {{--    label="Upload Customer data"--}}
    {{--    cancelRoute="admin.customers.index"--}}
    {{--    sampleFile="sample-files/customer-sample.xlsx"--}}
    {{--/>--}}

    <br/>
    <div class="card">
        <div class="card-header text-right">
            <div class="col-md-12 text-right" style="text-align: right">
                <a href="/sample-files/customer-sample.xlsx" class=" btn btn-link" download>
                    Download Sample File
                </a>
            </div>
        </div>
        <div class="card-body">
            <form action="{!! route('admin.customers.importdata') !!}" method="POST" enctype="multipart/form-data"
                  class="container  ">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <h3 class="mb-4">Upload Customer Data</h3>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label"> Sale  man </label>
                        <select class="form-control" name="sale_man">
                            <option>Select option</option>
                            @foreach($data as $item)
                                <option value="{!! $item->id !!}" > {!! $item->name !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="mb-3">
                    <label for="file" class="form-label">Choose Excel File</label>
                    <input class="form-control" type="file" name="file" id="file" accept=".xlsx,.xls" required>
                </div>


                <div class="col-md-12">
                    <div class="d-flex gap-2 text-right" style="text-align: right">
                        <button type="submit" class="btn btn-primary">Upload</button>
                        <a href="/admin/customers/index" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>

            </form>

        </div>
    </div>

@stop
