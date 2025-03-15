@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">Voucher Templates</h4>
                    <a href="{{ route('admin.entry_templates.create') }}" style="float:right;"
                       class="btn btn-success pull-right">Create</a>
                </div>
                <div class="card-body">
                    <div class="panel-body pad table-responsive">
                        <table class="table table-bordered datatable" style="text-transform:none;">
                            <thead>
                            <tr style="text-align:center;">
                                <th style="text-align:center;">Sr.No</th>
                                <th style="text-align:center;">Entry Type</th>
                                <th style="text-align:center;">Company</th>
                                <th style="text-align:center;">Branch</th>
                                <th style="text-align:center;">Narration</th>
                                <th width="10%" style="text-align:center;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($entry_templates as $entry_template)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $entry_template->entry_type->name }}</td>
                                    <td>{{ $entry_template->company->name }}</td>
                                    <td>{{ $entry_template->branch->name }}</td>
                                    <td>{{ $entry_template->narration }}</td>
                                    <td>
                                        <div style="display:ruby;">
                                            <div>
                                                <a href="{{ route('admin.entry_templates.show',$entry_template->id) }}"
                                                   class="btn btn-primary btn-sm">View</a>
                                            </div>
                                            <div>
                                                <a href="{{ route('admin.entry_template.use',$entry_template->id) }}"
                                                   class="btn btn-warning btn-sm">Use</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
