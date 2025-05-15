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
    <x-import-form 
    route="admin.customers.importdata" 
    label="Upload Customer data" 
    cancelRoute="admin.customers.index" 
    sampleFile="sample-files/customer-sample.xlsx"
/>
@stop