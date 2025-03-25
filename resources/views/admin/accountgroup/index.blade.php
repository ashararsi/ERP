@extends('admin.layout.main')

@section('title')
    Account Groups
@stop

@section('content')
    <div class="container-fluid">
        <div class="row w-100  mt-4 ">
            <h3 class="text-22 text-center text-bold w-100 mb-4">    Account Groups</h3>
        </div>
        <div class="row    mt-4 mb-4 ">
            <div class="col-12 " style="text-align: right">
                <a href="{!! route('admin.account_groups.create') !!}" class="btn btn-primary btn-sm ">Create     Account Group</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row w-100 ">
                    <div class="col-12">
                        <table class="table table-bordered table-striped {{ count($Groups) > 0 ? 'datatable' : '' }}">
                            <thead>
                            <tr>
                                <th>Sr.No</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Level</th>

                                    <th>Actions</th>

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

                                            <td>
                                                <div class="hstack gap-3 flex-wrap">
                                                    <a href="groups\{{$bank['id']}}\edit" class="link-success fs-15"><i
                                                            class="ri-edit-2-line"></i></a>
                                                </div>

                                            </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="5">Data Not Found</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
@stop
@section('css')

@endsection
@section('js')
    @include('admin.layout.datatable')
    <script type="text/javascript">
        {{--$(document).ready(function () {--}}
        {{--    $('#data-table').DataTable({--}}
        {{--        processing: true,--}}
        {{--        serverSide: true,--}}
        {{--        ajax: {--}}
        {{--            url: "{{ route('admin.account_groups.getdata') }}",--}}
        {{--            type: "POST",--}}
        {{--            data: {_token: "{{ csrf_token() }}"}--}}
        {{--        },--}}
        {{--        columns: [--}}
        {{--            {data: 'id', name: 'id'},--}}
        {{--            {data: 'name', name: 'name'},--}}
        {{--            {data: 'company', name: 'company'},--}}
        {{--            {data: 'branch_code', name: 'phonebranch_code'},--}}
        {{--            {data: 'phone', name: 'phone'},--}}
        {{--            {data: 'action', name: 'action', orderable: false, searchable: false}--}}
        {{--        ],--}}
        {{--        dom: 'Bfrtip', // Enable buttons at the top--}}
        {{--        buttons: [--}}
        {{--            {--}}
        {{--                extend: 'excelHtml5',--}}
        {{--                title: 'Roles Data',--}}
        {{--                exportOptions: {--}}
        {{--                    columns: [0, 1] // Export only ID and Name--}}
        {{--                }--}}
        {{--            },--}}
        {{--            {--}}
        {{--                extend: 'pdfHtml5',--}}
        {{--                title: 'Roles Data',--}}
        {{--                exportOptions: {--}}
        {{--                    columns: [0, 1]--}}
        {{--                }--}}
        {{--            },--}}
        {{--            {--}}
        {{--                extend: 'print',--}}
        {{--                title: 'Roles Data',--}}
        {{--                exportOptions: {--}}
        {{--                    columns: [0, 1]--}}
        {{--                }--}}
        {{--            }--}}
        {{--        ]--}}
        {{--    });--}}
        {{--});--}}

    </script>
@endsection
