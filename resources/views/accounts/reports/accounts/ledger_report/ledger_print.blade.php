@inject('request', 'Illuminate\Http\Request')
<style type="text/css">
    @page {
        margin: 10px 20px;
    }

    table {
        text-align: center;
    }

    @media print {
        table {
            font-size: 12px;
        }

        .tr-root-group {
            background-color: #F3F3F3;
            color: rgba(0, 0, 0, 0.98);
            font-weight: bold;
        }

        .tr-group {
            font-weight: bold;
        }

        .bold-text {
            font-weight: bold;
        }

        .error-text {
            font-weight: bold;
            color: #FF0000;
        }

        .ok-text {
            color: #006400;
        }

        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
            padding: 2px !important;
        }

    }

    .table th {
        text-align: center;
    }

    .last-th th {
        border-bottom: 1px solid
    }

    .noBorder {
        border: none !important;
    }

</style>
<div class="panel-body pad table-responsive">
    <table align="center">
        <tbody>
        <tr>
            <td>
                <h3 align="center"><span style="border-bottom: double;">Ledger Report</span></h3>
                <h5>{!! $company_name !!} <br> ({!! date('d-m-Y',strtotime($start_date)) !!}
                    To {!! date('d-m-Y', strtotime($end_date)) !!})</h5>
            </td>
        </tr>
        <tr>
            <td align="center"><span>{{ isset($vendor_name) ? $vendor_name : null }}</span>
            </td>
        </tr>
        </tbody>
    </table>
    <table cellpadding="0" cellspacing="0" class="table table-condensed" id="entry_items"
           style="border: 1px solid black; width: 100%;" border="1" bordercolor="#dadada">
        <thead>
        <tr style="border: 0.2em solid #4d4d4d;">
            <th width="13%" align="center">Date</th>
            <th width="7%" align="center">Voucher Number</th>
            <th width="5%" align="center">Voucher Type</th>
            <th width="40%">Descriptions</th>
            <th width="10%" style="text-align: right;">Debit</th>
            <th width="10%" style="text-align: right;">Credit</th>
            <th width="15%" style="text-align: right;">Opening Balance</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $ledger)
            <tr>
                <th style="text-align: left" colspan="6">{!! $ledger['ledger_name'] !!}</th>
                {!! $ledger['ob'] !!}
            </tr>
            @foreach($ledger['data'] as $data1)
                <tr>
                    <td>{{ $data1['voucher_date'] }}</td>
                    <td>{{ $data1['number'] }}</td>
                    <td>{{ $data1['vt'] }}</td>
                    <td style="text-align: left">{{ $data1['narration'] }}</td>
                    <td style="text-align: right;">{{ $data1['dr_amount'] }}</td>
                    <td style="text-align: right">{{ $data1['cr_amount'] }}</td>
                    <td style="text-align: right">{{ $data1['balance'] }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="8"><br></th>
            </tr>
            <tr style="border-bottom: none;">
                <td style="text-align: right" colspan="4"><b>Total</b></td>
                <th style="text-align: right">{{ $ledger['total_dr'] }}</th>
                <th style="text-align: right">{{ $ledger['total_cr'] }}</th>
                <th style="text-align: right">{{ $ledger['balance'] }}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script type="text/javascript">
    window.onload = function () {
        window.print();
        setTimeout(window.close, 0);
    }
</script>
