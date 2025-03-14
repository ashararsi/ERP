@extends('layouts.app')

@inject('Ledger', '\App\Models\Ledger')
@section('stylesheet')
    <link rel="stylesheet"
          href="{{ url('public/adminlte') }}/bower_components/bootstrap-daterangepicker/daterangepicker.css">
@stop
@section('content')
    <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
        <!--div-->
        <div class="card">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <h3 style="float:left;">View {{ $EntryType->name }}: {{ $Entrie->number }}</h3>
                </div>

                <div class="box box-primary">
                    <div class="box-header with-border">

                        <a href="{{ route('admin.entries.index') }}" style="float:right;"
                           class="btn btn-success pull-right">Back</a>
                        @if(Auth::user()->isAbleTo('accounts-edit-voucher'))
                            <a href="{{ route('admin.gjv-edit',$Entrie->id) }}" style="float:right;"
                               class="btn btn-primary pull-right">Edit</a>
                        @endif
                        <a href="{{ route('admin.download',$Entrie->id) }}" target="_blank"
                           class="btn btn-warning pull-right" style="float:right;"> <u>P</u>df</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>Voucher #</th>
                                <td>{{ $Entrie->number }}</td>
                                <th>Voucher Date</th>
                                <td>{{ $Entrie->voucher_date }}</td>
                            </tr>
                            <tr>
                                <th>Company Name</th>
                                <td> {{$company->name ?? 'N/A'}}</td>
                                <th>Branch Name</th>
                                <td> {{$Branch->name ?? 'N/A'}}</td>
                            </tr>
                            <tr>
                                <th>Narration</th>
                                <td colspan="3">
                                    @if($Entrie->narration)
                                        {{ $Entrie->narration }}
                                    @else
                                        {{ 'N/A' }}
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <!-- Slip Area Started -->
                        <div class="nav-tabs-custom">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <table class="table table-bordered" id="entry_items">
                                        <thead>
                                        <tr>
                                            <th colspan="3" width="36%" style="text-align: center;">Account</th>
                                            <th width="12%" style="text-align: center;">Debit</th>
                                            <th width="12%" style="text-align: center;">Credit</th>
                                            @if($EntryType->id == 4 || $EntryType->id == 5)
                                                <th width="12%" style="text-align: center;">Instrument Number</th>
                                            @endif
                                            @if($EntryType->id == 1 || $EntryType->id == 3 || $EntryType->id == 5)
                                                <th width="12%" style="text-align: center;">Vendor</th>
                                            @endif
                                            <th width="36%" style="text-align: center;">Narration</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($Entry_items))
                                            @foreach($Entry_items as $Entry_item)
                                                <tr>
                                                    <td colspan="3">
                                                        <div class="form-group" style="margin-bottom: 0px !important;">
                                                            @if(isset($Ledgers) && !empty($Ledgers))
                                                                    <?php
                                                                    $prefix = $Ledger::getAllParent($Ledgers[$Entry_item->ledger_id]->group_id);
                                                                    if ($prefix == '0') {
                                                                        $text_ledger = '(' . $Ledgers[$Entry_item->ledger_id]->groups['name'] . ')';
                                                                    } else {
                                                                        $text_ledger = $prefix;
                                                                    }
                                                                    ?>
                                                                {{ $Ledgers[$Entry_item->ledger_id]->number . ' - ' . $Ledgers[$Entry_item->ledger_id]->name }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td align="right">
                                                        <div class="form-group" style="margin-bottom: 0px !important;">
                                                            @if($Entry_item->dc == 'd')
                                                                {{number_format($Entry_item->amount)}}
                                                            @else
                                                                0
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td align="right">
                                                        <div class="form-group" style="margin-bottom: 0px !important;">
                                                            @if($Entry_item->dc == 'c')
                                                                {{ number_format($Entry_item->amount) }}
                                                            @else
                                                                0
                                                            @endif
                                                        </div>
                                                    </td>
                                                    @if($EntryType->id == 4 || $EntryType->id == 5)
                                                        <td align="right">
                                                            <div class="form-group"
                                                                 style="margin-bottom: 0px !important;">
                                                                {{ $Entry_item->instrument_number }}
                                                            </div>
                                                        </td>
                                                    @endif
                                                    @if($EntryType->id == 1 || $EntryType->id == 3 || $EntryType->id == 5)
                                                        <td>
                                                            <div class="form-group"
                                                                 style="margin-bottom: 0px !important;">
                                                                {{ isset($Entry_item->vendor_data) ? $Entry_item->vendor_data->vendor_name : 'N/A' }}
                                                            </div>
                                                        </td>
                                                    @endif
                                                    <td>
                                                        <div class="form-group" style="margin-bottom: 0px !important;">
                                                            {{ $Entry_item->narration }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" align="center">No Entry Item found.</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td colspan="3" align="right" style="padding-top: 12px;"><b>Total</b></td>
                                            <td style="padding-top: 12px;" align="right">
                                                <b>{{ number_format($Entrie->dr_total) }}</b>
                                            </td>
                                            <td style="padding-top: 12px;" align="right">
                                                <b>{{ number_format($Entrie->cr_total) }}</b>
                                            </td>
                                            {{--                                            <td align="right" style="padding-top: 12px;"><b>Difference</b>--}}
                                            {{--                                            </td>--}}
                                            {{--                                            <td width="12%" style="padding-top: 12px;" align="right">--}}
                                            {{--                                                {{ number_format($Entrie->dr_total - $Entrie->cr_total) }}--}}
                                            {{--                                            </td>--}}
                                            @if($EntryType->id == 1 || $EntryType->id == 3)
                                                <td colspan="2"></td>
                                            @elseif($EntryType->id == 4 || $EntryType->id == 5)
                                                <td colspan="3"></td>
                                            @else
                                                <td></td>
                                            @endif
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    <table class="table table-bordered">
                                        <!--<tbody>-->
                                        <!--    <tr>-->
                                        <!--        <th width="10%">Cheque #</th>-->
                                        <!--        <td width="40%">@if($Entrie->cheque_no)
                                            {{ $Entrie->cheque_no }}
                                        @else
                                            N/A














                                        @endif</td>-->
                                        <!--        <th width="10%">Cheque Date</th>-->
                                        <!--        <td width="40%">@if($Entrie->cheque_date)
                                            {{ $Entrie->cheque_date }}
                                        @else
                                            N/A














                                        @endif</td>-->
                                        <!--    </tr>-->
                                        <!--    <tr>-->
                                        <!--        <th>Invoice #</th>-->
                                        <!--        <td>@if($Entrie->invoice_no)
                                            {{ $Entrie->invoice_no }}
                                        @else
                                            N/A














                                        @endif</td>-->
                                        <!--        <th>Invoice Date</th>-->
                                        <!--        <td>@if($Entrie->invoice_date)
                                            {{ $Entrie->invoice_date }}
                                        @else
                                            N/A














                                        @endif</td>-->
                                        <!--    </tr>-->
                                        <!--    <tr>-->
                                        <!--        <th>CDR #</th>-->
                                        <!--        <td>@if($Entrie->cdr_no)
                                            {{ $Entrie->cdr_no }}
                                        @else
                                            N/A














                                        @endif</td>-->
                                        <!--        <th>CDR Date</th>-->
                                        <!--        <td>@if($Entrie->cdr_date)
                                            {{ $Entrie->cdr_date }}
                                        @else
                                            N/A














                                        @endif</td>-->
                                        <!--    </tr>-->
                                        <!--    <tr>-->
                                        <!--        <th>BDR #</th>-->
                                        <!--        <td>@if($Entrie->bdr_no)
                                            {{ $Entrie->bdr_no }}
                                        @else
                                            N/A














                                        @endif</td>-->
                                        <!--        <th>CDR Date</th>-->
                                        <!--        <td>@if($Entrie->bdr_date)
                                            {{ $Entrie->bdr_date }}
                                        @else
                                            N/A














                                        @endif</td>-->
                                        <!--    </tr>-->
                                        <!--    <tr>-->
                                        <!--        <th>Bank Name</th>-->
                                        <!--        <td>@if($Entrie->bank_name)
                                            {{ $Entrie->bank_name }}
                                        @else
                                            N/A














                                        @endif</td>-->
                                        <!--        <th>Bank Branch</th>-->
                                        <!--        <td>@if($Entrie->bank_branch)
                                            {{ $Entrie->bank_branch }}
                                        @else
                                            N/A














                                        @endif</td>-->
                                        <!--    </tr>-->
                                        <!--    <tr>-->
                                        <!--        <th>Drawn Date</th>-->
                                        <!--        <td colspan="3">@if($Entrie->drawn_date)
                                            {{ $Entrie->drawn_date }}
                                        @else
                                            N/A














                                        @endif</td>-->
                                        <!--    </tr>-->
                                        <!--</tbody>-->
                                    </table>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div>

                    </div>

                    {{--Code added by shahryar for print start's from here--}}

                    {{--<div class="box-body" id='DivIdToPrint' style="display:none">--}}
                    {{--<table class="table table-bordered">--}}
                    {{--<tbody>--}}
                    {{--<tr>--}}
                    {{--<th width="10%">Voucher #</th>--}}
                    {{--<td>{{ $Entrie->number }}</td>--}}
                    {{--<th width="10%">Voucher Date</th>--}}
                    {{--<td>{{ $Entrie->voucher_date }}</td>--}}
                    {{--<th width="10%">Branch</th>--}}
                    {{--<td>{{ $Branch->name }}</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                    {{--<th>Department</th>--}}
                    {{--<td>@if($Department && isset($Department->name)){{ $Department->name }}@else N/A @endif</td>--}}
                    {{--<th>Employee</th>--}}
                    {{--<td>--}}
                    {{--@if($Employee == '')--}}
                    {{--Admin--}}
                    {{--@else--}}
                    {{--{{$Employee->first_name}}--}}
                    {{--@endif--}}

                    {{--</td>--}}
                    {{--<td colspan="2"></td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                    {{--<th>Narration</th>--}}
                    {{--<td colspan="4">@if($Entrie->narration){{ $Entrie->narration }}@else{{ 'N/A' }}@endif</td>--}}
                    {{--</tr>--}}
                    {{--</tbody>--}}
                    {{--</table>--}}

                    {{--<!-- Slip Area Started -->--}}
                    {{--<div class="nav-tabs-custom">--}}
                    {{--<div class="tab-content">--}}
                    {{--<div class="tab-pane active" id="tab_1">--}}
                    {{--<table class="table table-condensed" id="entry_items">--}}
                    {{--<thead>--}}
                    {{--<tr>--}}
                    {{--<th colspan="3">Account</th>--}}
                    {{--<th width="12%" style="text-align: right;">Debit</th>--}}
                    {{--<th width="12%" style="text-align: right;">Credit</th>--}}
                    {{--<th width="36%">Narration</th>--}}
                    {{--</tr>--}}
                    {{--</thead>--}}
                    {{--<tbody>--}}
                    {{--@if(count($Entry_items))--}}
                    {{--@foreach($Entry_items as $Entry_item)--}}
                    {{--<tr>--}}
                    {{--<td colspan="3">--}}
                    {{--<div class="form-group" style="margin-bottom: 0px !important;">--}}
                    {{--@if(isset($Ledgers) && !empty($Ledgers))--}}
                    {{--{{ $Ledgers[$Entry_item->ledger_id]->number }} - {{ $Ledgers[$Entry_item->ledger_id]->name }}--}}
                    {{--@else--}}
                    {{--N/A--}}
                    {{--@endif--}}
                    {{--</div>--}}
                    {{--</td>--}}
                    {{--<td align="right">--}}
                    {{--<div class="form-group" style="margin-bottom: 0px !important;">--}}
                    {{--@if($Entry_item->dc == 'd'){{ $DefaultCurrency->symbol . ' ' . $Currency::curreny_format($Entry_item->amount) }}@else--}}
                    {{--{{ $DefaultCurrency->symbol . ' ' . $Currency::curreny_format(0) }}--}}
                    {{--@endif--}}
                    {{--</div>--}}
                    {{--</td>--}}
                    {{--<td align="right">--}}
                    {{--<div class="form-group" style="margin-bottom: 0px !important;">--}}
                    {{--@if($Entry_item->dc == 'c'){{ $DefaultCurrency->symbol . ' ' . $Currency::curreny_format($Entry_item->amount) }}@else--}}
                    {{--{{ $DefaultCurrency->symbol . ' ' . $Currency::curreny_format(0) }}--}}
                    {{--@endif--}}
                    {{--</div>--}}
                    {{--</td>--}}
                    {{--<td>--}}
                    {{--<div class="form-group" style="margin-bottom: 0px !important;">--}}
                    {{--{{ $Entry_item->narration }}--}}
                    {{--</div>--}}
                    {{--</td>--}}
                    {{--</tr>--}}
                    {{--@endforeach--}}
                    {{--@else--}}
                    {{--<tr>--}}
                    {{--<td colspan="8" align="center">No Entry Item found.</td>--}}
                    {{--</tr>--}}
                    {{--@endif--}}
                    {{--<tr>--}}
                    {{--<td align="right" style="padding-top: 12px;" width="12%"><b>Difference</b></td>--}}
                    {{--<td width="12%" style="padding-top: 12px;" align="right">--}}
                    {{--{{ number_format($Entrie->dr_total - $Entrie->cr_total, 2) }}--}}
                    {{--</td>--}}
                    {{--<td align="right" style="padding-top: 12px;" width="12%"><b>Total</b></td>--}}
                    {{--<td style="padding-top: 12px;" align="right">--}}
                    {{--<b>{{ $Entrie->dr_total }}</b>--}}
                    {{--</td>--}}
                    {{--<td style="padding-top: 12px;" align="right">--}}
                    {{--<b>{{ $Entrie->cr_total }}</b>--}}
                    {{--</td>--}}
                    {{--<td colspan="2"></td>--}}
                    {{--</tr>--}}
                    {{--</tbody>--}}
                    {{--</table>--}}
                    {{--</div>--}}
                    {{--<!-- /.tab-pane -->--}}
                    {{--<div class="tab-pane" id="tab_2">--}}
                    {{--<table class="table table-bordered">--}}
                    {{--<tbody>--}}
                    {{--<tr>--}}
                    {{--<th width="10%">Cheque #</th>--}}
                    {{--<td width="40%">@if($Entrie->cheque_no){{ $Entrie->cheque_no }}@else N/A @endif</td>--}}
                    {{--<th width="10%">Cheque Date</th>--}}
                    {{--<td width="40%">@if($Entrie->cheque_date){{ $Entrie->cheque_date }}@else N/A @endif</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                    {{--<th>Invoice #</th>--}}
                    {{--<td>@if($Entrie->invoice_no){{ $Entrie->invoice_no }}@else N/A @endif</td>--}}
                    {{--<th>Invoice Date</th>--}}
                    {{--<td>@if($Entrie->invoice_date){{ $Entrie->invoice_date }}@else N/A @endif</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                    {{--<th>CDR #</th>--}}
                    {{--<td>@if($Entrie->cdr_no){{ $Entrie->cdr_no }}@else N/A @endif</td>--}}
                    {{--<th>CDR Date</th>--}}
                    {{--<td>@if($Entrie->cdr_date){{ $Entrie->cdr_date }}@else N/A @endif</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                    {{--<th>BDR #</th>--}}
                    {{--<td>@if($Entrie->bdr_no){{ $Entrie->bdr_no }}@else N/A @endif</td>--}}
                    {{--<th>CDR Date</th>--}}
                    {{--<td>@if($Entrie->bdr_date){{ $Entrie->bdr_date }}@else N/A @endif</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                    {{--<th>Bank Name</th>--}}
                    {{--<td>@if($Entrie->bank_name){{ $Entrie->bank_name }}@else N/A @endif</td>--}}
                    {{--<th>Bank Branch</th>--}}
                    {{--<td>@if($Entrie->bank_branch){{ $Entrie->bank_branch }}@else N/A @endif</td>--}}
                    {{--</tr>--}}
                    {{--<tr>--}}
                    {{--<th>Drawn Date</th>--}}
                    {{--<td colspan="3">@if($Entrie->drawn_date){{ $Entrie->drawn_date }}@else N/A @endif</td>--}}
                    {{--</tr>--}}
                    {{--</tbody>--}}
                    {{--</table>--}}
                    {{--</div>--}}
                    {{--<!-- /.tab-pane -->--}}
                    {{--</div>--}}
                    {{--<!-- /.tab-content -->--}}
                    {{--</div>--}}

                    {{--</div>--}}
                    {{--Code added by shahryar for print end's here--}}
                    <!-- /.box-body -->
                </div>
                @stop

                <script>
                    $("#downloadPdf").click(function () {
                        var inv_id = {{$Entrie->id}};
                        var payable = $('#payable_amount').html();
                        var credit_limit = parseInt($('#credit_limit').html());
                        var customer_credit = $('#customer_credit').html();
                        var payable = $('#payable_amount').html();
                        var newPayable = parseInt(payable) + parseInt(customer_credit);
                        if (newPayable > credit_limit) {
                            if (confirm('Customer invoice is exceeding the credit limit. Do You still want to generate invoice?')) {
                                window.open('downloadPDF/' + inv_id, '_blank');
                            } else {
                                return false
                            }

                        }

//if()
//
                    });
                    //    function printDiv()
                    //    {
                    //
                    //        var divToPrint=document.getElementById('DivIdToPrint');
                    //
                    //        var newWin=window.open('','Print-Window');
                    //
                    //        newWin.document.open();
                    //
                    //        newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
                    //
                    //        newWin.document.close();
                    //
                    //        setTimeout(function(){newWin.close();},10);
                    //
                    //    }
                </script>
