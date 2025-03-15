@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1" style="float:left;">View Voucher Template</h4>
                    <a href="{{ route('admin.entry_templates.index') }}" style="float:right;"
                       class="btn btn-success pull-right">Back</a>
                </div>
                <input value="{{ $entry_template->entry_type_id }}" id="entry_type_id" type="hidden">
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-4  @if($errors->has('entry_type_id')) has-error @endif">
                            {!! Form::label('entry_type_id', 'Entry Type', ['class' => 'control-label']) !!}
                            <input readonly value="{{ $entry_template->entry_type->name }}" class="form-control">
                        </div>
                        <div class="form-group col-md-4  @if($errors->has('company_id')) has-error @endif">
                            {!! Form::label('company_id', 'Company', ['class' => 'control-label']) !!}
                            <input readonly value="{{ $entry_template->company->name }}" class="form-control">
                        </div>
                        <div class="form-group col-md-4  @if($errors->has('branch_id')) has-error @endif">
                            {!! Form::label('branch_id', 'Branch', ['class' => 'control-label']) !!}
                            <input readonly value="{{ $entry_template->branch->name }}" class="form-control">
                        </div>

                        <div class="form-group col-md-12  @if($errors->has('narration')) has-error @endif">
                            {!! Form::label('narration', 'Narration', ['class' => 'control-label']) !!}
                            <input readonly value="{{ $entry_template->narration }}" class="form-control">
                        </div>
                    </div>

                    <div class="nav-tabs-custom">
                        <hr>
                        <div class="tab-content">
                            <div class="tab-pane active">
                                <table class="table table-condensed">
                                    @if(count($entry_template->entry_template_details) > 0)
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Ledger</th>
                                            <th class="vendor_div">Vendor</th>
                                            <th class="instrument_div">Instrument</th>
                                            <th>Narration</th>
                                        </tr>
                                        @php($i = 1)
                                        @foreach($entry_template->entry_template_details as $entry_template_detail)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $entry_template_detail->ledger->name }}</td>
                                                <td class="vendor_div">{{ isset($entry_template_detail->vendor) ? $entry_template_detail->vendor->vendor_name : 'N/A' }}</td>
                                                <td class="instrument_div">{{ $entry_template_detail->instrument_id }}</td>
                                                <td>{{ $entry_template_detail->narration }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        function hideDivByEntryType() {
            var entry_type_id = $('#entry_type_id').val();

            if (entry_type_id == 1) {

                $('.instrument_div').hide();
                $('.vendor_div').show();

            } else if (entry_type_id == 2) {

                $('.instrument_div').hide();
                $('.vendor_div').hide();

            } else if (entry_type_id == 3) {

                $('.instrument_div').hide();
                $('.vendor_div').show();

            } else if (entry_type_id == 4) {

                $('.instrument_div').show();
                $('.vendor_div').hide();

            } else if (entry_type_id == 5) {

                $('.instrument_div').show();
                $('.vendor_div').show();

            }
        }

        $(document).ready(function () {
            hideDivByEntryType();
        });
    </script>
@endsection
