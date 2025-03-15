<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$EntryType->code. '-'.$Entrie->number }}</title>

    <style>

        * {
            box-sizing: border-box;
        }

        /* Create four equal columns that floats next to each other */
        .column {
            float: left;
            width: 50%;

            /* Should be removed. Only for demonstration */
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

    </style>


</head>


<style>

    body {
        padding: 0 30px;
        line-height: 14px;
    }

    td, th, tr {
        padding: 10px !important;
    }
</style>

<body>

<!--header-->


<div class="box box-primary">
    <div class="box-header with-border">
        <!-- /.box-header -->
        <div class="header">
            <h6 style="border-bottom: 1px solid black; font-size: 30px; padding-bottom: 7px; margin-bottom: 20px !important; text-align:center">
                {{-- $BranchTitle->lagder_data->lagder_branch->name --}}
                {{$company->name}}
                <Span style="margin-left: 100px;"></Span>
            </h6>

        </div>
        <div class="box-body">
            <div>
                <table cellpadding="0" cellspacing="0" class="table table-condensed" id="entry_items"
                       style="border: 1px solid black; width: 100%; line-height:20px;" border="1">
                    <tbody>
                    <tr>
                        <th colspan="4" style="text-align: left !important; padding: 2px;">Voucher # <span
                                style="font-weight: normal;">{{$EntryType->code. '-'.$Entrie->number }}</span></th>
                        <th colspan="4" style="text-align: right !important; padding: 2px;">Voucher Date: <span
                                style="font-weight: normal;">{{ \Carbon\Carbon::parse($Entrie->voucher_date)->format('d-m-Y')}}</span>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="8" style="text-align: left !important; padding: 2px;">Narration:
                            <span style="font-weight: normal;">
                                @if($Entrie->narration)
                                    {{ $Entrie->narration }}
                                @else
                                    {{ 'N/A' }}
                                @endif
                            </span>
                        </th>
                    </tr>
                    </tbody>
                </table>
            </div>

            <!-- Slip Area Started -->
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <table cellpadding="0" cellspacing="0" class="table table-condensed" id="entry_items"
                               style="border: 1px solid black; width: 100%;" border="1">
                            <thead>
                            <tr>
                                <th colspan="2" style=" text-align: left !important; padding: 2px;">Code</th>
                                <th colspan="2" style=" text-align: left !important; padding: 2px;">Account</th>
                                <th colspan="2" style=" text-align: left !important; padding: 2px;">Narration</th>
                                @if($EntryType->id == 4 || $EntryType->id == 5)
                                    <th colspan="2" style=" text-align: left !important; padding: 2px;">
                                        Instrument No
                                    </th>
                                @endif
                                @if($EntryType->id == 1 || $EntryType->id == 3 || $EntryType->id == 5)
                                    <th style="text-align: left !important; padding: 2px;">Vendor</th>
                                @endif
                                <th style=" text-align: right !important; padding: 2px;">Debit</th>
                                <th style=" text-align: right !important; padding: 2px;">Credit</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($Entry_items))
                                @foreach($Entry_items as $Entry_item)
                                    <tr>
                                        <td colspan="2" style="padding: 2px;">
                                            <div class="form-group" style="margin-bottom: 0px !important;">
                                                @if(isset($Ledgers) && !empty($Ledgers))
                                                    {{ $Ledgers[$Entry_item->ledger_id]->number }}
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                        </td>
                                        <td colspan="2" style="padding: 2px;">
                                            <div class="form-group" style="margin-bottom: 0px !important;">
                                                @if(isset($Ledgers) && !empty($Ledgers))
                                                    @php
                                                        $split = null;
                                                        $split = explode("(",$Ledgers[$Entry_item->ledger_id]->name);
                                                        //print_r($Ledgers[$Entry_item->ledger_id]->name);
                                                    @endphp
                                                    @if($Ledgers[$Entry_item->ledger_id]->parent_type==NULL)
                                                        {{ $split[0] }}
                                                    @else
                                                        {{ str_replace(')','',$split[1]) }}
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                        </td>
                                        <td colspan="2" style="padding: 2px;">
                                            <div class="form-group"
                                                 style="margin-bottom: 0px !important; float:left">
                                                {{$Entry_item->narration}}
                                            </div>
                                        </td>
                                        @if($EntryType->id == 4 || $EntryType->id == 5)
                                            <td colspan="2" style="padding: 2px;">
                                                <div class="form-group"
                                                     style="margin-bottom: 0px !important; float:left">
                                                    {{$Entry_item->instrument_number}}
                                                </div>
                                            </td>
                                        @endif
                                        @if($EntryType->id == 1 || $EntryType->id == 3 || $EntryType->id == 5)
                                            <td style="padding: 2px;">
                                                <div class="form-group"
                                                     style="margin-bottom: 0px !important; float:left">
                                                    {{ isset($Entry_item->vendor_data) ? $Entry_item->vendor_data->vendor_name : 'N/A' }}
                                                </div>
                                            </td>
                                        @endif
                                        <td style="padding: 2px;">
                                            <div class="form-group"
                                                 style="margin-bottom: 0px !important; float:right">
                                                @if($Entry_item->dc == 'd')
                                                    {{ number_format($Entry_item->amount) }}
                                                @else
                                                    0
                                                @endif
                                            </div>
                                        </td>
                                        <td style="padding: 2px;">
                                            <div class="form-group"
                                                 style="margin-bottom: 0px !important; float:right">
                                                @if($Entry_item->dc == 'c')
                                                    {{number_format($Entry_item->amount)}}
                                                @else
                                                    0
                                                @endif
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                                <tr>
                                    @if($EntryType->id == 5)
                                        <td colspan="9" style="border:1px solid black;text-align: right">
                                            <b>Total:</b>
                                        </td>
                                    @elseif($EntryType->id == 4)
                                        <td colspan="8" style="border:1px solid black;text-align: right">
                                            <b>Total:</b>
                                        </td>
                                    @elseif($EntryType->id == 1 || $EntryType->id == 3)
                                        <td colspan="7" style="border:1px solid black;text-align: right">
                                            <b>Total:</b>
                                        </td>
                                    @else
                                        <td colspan="6" style="border:1px solid black;text-align: right">
                                            <b>Total:</b>
                                        </td>
                                    @endif
                                    <td style="text-align:right;">
                                        {{number_format($Entrie->dr_total) }}
                                    </td>
                                    <td style="text-align:right;">
                                        {{number_format($Entrie->cr_total) }}
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="8" align="center">No Entry Item found.</td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <!--<table class="table table-bordered" width="100%;">-->
                        <!--    <tbody>-->
                        <!--    <tr>-->
                        <!--        <th width="10%">Cheque #</th>-->
                        <!--        <td width="40%">@if($Entrie->cheque_no)
                            {{ $Entrie->cheque_no }}
                        @else
                            N/A












                        @endif</td>-->
                        <!--        <th width="15%">Cheque Date</th>-->
                        <!--        <td width="35%">@if($Entrie->cheque_date)
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
                        <!--    </tbody>-->
                        <!--</table>-->
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
        </div>

        <!--footer-->
        <!--<p id="remarks"><b>Remarks:</b></p>-->


        <div class="authorised-sig" style=" margin-top: 60px;">
            <table style="width:100%">
                <!--<tr>-->
                <!--    <td><p style="display: inline-block; margin-left: 70px; margin-bottom: -20px;">Admin</p></td>-->
                <!--</tr>-->
                <tr>
                    <td><p style="border-top: 1px solid black; display: inline-block; margin-left: 50px;">Prepared
                            By</p></td>
                    <td><p style="border-top: 1px solid black; display: inline-block; margin-right: 20px;">Checked
                            By</p></td>
                    <td><p style="border-top: 1px solid black; display: inline-block;">Approved By</p></td>
                </tr>
            </table>
        </div>
        <div class="authorised-sig" style=" margin-top: 60px;">
            <table style="width:100%">
                <tr>
                    <td><p style="display: inline-block; font-family: arial;font-weight:bold;">Recieved By
                            Name:-------------</p></td>
                    <td><p style="display: inline-block;font-family: arial;font-weight:bold;">
                            Signature:-------------</p></td>
                    <td>
                        <p style="display: inline-block;font-family: arial;font-weight:bold; text-align: right !important;">
                            Date:-------------</p></td>
                </tr>
            </table>
        </div>

    </div>
</div>
</body>
</html>
