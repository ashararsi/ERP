@extends('layouts.app')
@section('stylesheet')
    <style>
        td {
            border-bottom: none !important;
            padding-top: 2px !important;
            padding-bottom: 2px !important;
        }

        .first_row > td > div,
        .first_row > td > button {
            margin-top: 5px !important;
        }

        .last_row > td > div,
        .last_row > td > button {
            margin-bottom: 5px !important;
        }

        .last_row {
            border-bottom-width: 1px !important;
            border-color: darkgrey !important;
        }

        .select2-selection__rendered {
            line-height: 35px !important;
        }

        .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .select2-selection__arrow {
            height: 35px !important;
        }
    </style>
@stop
@section('content')
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <!--div-->
        <div class="card">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <h3 style="float:left;">Create Voucher Template</h3>
                    <a href="{{ route('admin.entry_templates.index') }}" style="float:right;"
                       class="btn btn-success pull-right">Back</a>
                </div>

                {!! Form::open(['method' => 'POST', 'route' => ['admin.entry_templates.store'], 'id' => 'validation-form']) !!}
                <div class="box-body" style="margin-top:40px;">
                    <div class="row">
                        <div class="form-group col-md-4  @if($errors->has('entry_type_id')) has-error @endif">
                            {!! Form::label('entry_type_id', 'Entry Type*', ['class' => 'control-label']) !!}
                            <select class="form-control" name="entry_type_id" id="entry_type_id" required>
                                <option value="">Select</option>
                                @foreach($entry_types as $item => $name)
                                    <option value="{{ $item }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4  @if($errors->has('company_id')) has-error @endif">
                            {!! Form::label('company_id', 'Companies*', ['class' => 'control-label']) !!}
                            <select class="form-control select2" name="company_id" id="company_id" required>
                                @foreach($companies as $item)
                                    @if($item->id == $companyId)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4  @if($errors->has('branch_id')) has-error @endif">
                            {!! Form::label('branch_id', 'Branches*', ['class' => 'control-label']) !!}
                            <select class="form-control select2" name="branch_id" id="branch_id" required>
                                @foreach($branches as $item)
                                    @if($item->id == $branchId)
                                        <option
                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12  @if($errors->has('narration')) has-error @endif">
                            {!! Form::label('narration', 'Narration*', ['class' => 'control-label']) !!}
                            {!! Form::text('narration', null, ['id' => 'narration', 'onkeydown' => 'updateNarration();', 'onkeyup' => 'updateNarration();', 'onblur' => 'updateNarration();', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="nav-tabs-custom">
                        <hr>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <button onclick="createEntryItem();" type="button"
                                        style="margin-bottom: 5px;"
                                        class="btn pull-right btn-sm btn-flat btn-primary"><i class="fa fa-plus"></i>&nbsp;Add
                                    <u>R</u>ow
                                </button>
                                <table class="table table-condensed" id="entry_items">
                                    <tr></tr>
                                </table>
                                <input type="hidden" id="entry_item-global_counter" value="1"/>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            {!! Form::submit(trans('Save'), ['class' => 'btn btn-success globalSaveBtn float-end ']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                    @include('accounts.entry_templates.include_entries_template', ['vendor'=>$vendor])
                </div>
            </div>
        </div>
    </div>
@stop
@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"
            type="text/javascript"></script>
    <script
        src="https://ivyacademic.org/public/theme/assets/plugins/select2/js/select2.min.js"></script>

    <script>
        function dr_validation(id) {
            var id = '#entry_item-dr_amount-' + id;
            //console.log(id);
            //var value = $(id).val();
            $(id).keyup(function (event) {

                // skip for arrow keys
                if (event.which >= 37 && event.which <= 40) return;


            });
            //alert(value);
        }

        function cr_validation(id) {
            var id = '#entry_item-cr_amount-' + id;
            console.log(id);
            var value = $(id).val();
            // alert(value);
        }

        function Select2AjaxObj() {

            return {
                allowClear: true,
                placeholder: "Account",
                minimumInputLength: 2,
                ajax: {
                    url: '/admin/gjv_search',
                    dataType: 'json',
                    delay: 500,
                    data: function (params) {
                        return {
                            item: params.term, company_id: $("#company_id").val(), branch_id: $("#branch_id").val(),
                        };
                    },
                    processResults: function (data) {
                        if (data.status == 1) {
                            return {
                                results: data.data
                            };
                        } else {
                            alert('Select Branch');
                        }

                    },
                }
            }
        }

        function createEntryItem() {
            var global_counter = parseInt($('#entry_item-global_counter').val()) + 1;
            var entry_item = $('#entry_item-container').html().replace(/########/g, '').replace(/######/g, global_counter);
            $('#entry_items tr:last').after(entry_item);
            $('#entry_item-ledger_id-' + global_counter).select2(Select2AjaxObj());
            $('#entry_item-vendor_id-' + global_counter).select2();
            $('#entry_item-global_counter').val(global_counter);
            updateNarration(global_counter);
        }

        function updateNarration(global_counter) {
            if (global_counter == undefined) {
                $('.entry_items-narration').each(function (index) {
                    if ($('#narration').val() != '') {
                        $(this).val($('#narration').val());
                    }
                });
            } else {
                $('#entry_item-narration-' + global_counter).val($('#narration').val());
            }
        }

        function checkInstrumentNo(global_counter) {
            var instrumentNo = $('#entry_item-instrument_number-' + global_counter).val();
            $.ajax({
                url: '/admin/check-instrument-no',
                type: "GET",
                data: {
                    'instrumentNo': instrumentNo,
                },
                success: function (status) {
                    if (status == 1) {
                        alert('Instrument number exists!');
                        // $('#entry_item-instrument_number-' + global_counter).val('');
                        // $('#entry_item-instrument_number-' + global_counter).focus();
                        // return false;
                    }
                },
                error: function (error) {
                    console.log('error ' + error);
                }
            });
        }

        function destroyEntryItem(itemId) {
            var r = confirm("Are you sure to delete Entry Item?");
            if (r == true) {
                $('#entry_item-ledger_id-' + itemId).select2(Select2AjaxObj());
                $('#entry_item-vendor_id-' + itemId).select2();
                $('.entry_item-' + itemId).remove();
            }
        }

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

        jQuery(document).ready(function () {
            $('#entry_item-ledger_id-1').select2(Select2AjaxObj());
            $('#entry_item-vendor_id-1').select2();

            $('.instrument_div').hide();
            $('.vendor_div').hide();

            $('#entry_type_id').change(function () {
                hideDivByEntryType();
            });

        });

    </script>
@endsection
