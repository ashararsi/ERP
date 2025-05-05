@extends('admin.layout.main')

@section('title')
    Product Material Upload
@stop

@section('content')
    {{-- <x-import-form 
        route="admin.packing-materials.importdata" 
        label="Upload packing Materials" 
        cancelRoute="admin.packing-materials.index" 
    /> --}}
    <x-import-form 
    route="admin.packing-materials.importdata" 
    label="Upload Packing Materials" 
    cancelRoute="admin.packing-materials.index" 
    sampleFile="sample-files/packing-materials-sample.xlsx"
/>
@stop
