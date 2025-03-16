@inject('request', 'Illuminate\Http\Request')


<style type="text/css">
    table {
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        padding: 8px;
    }

    tr:nth-child(even) {
    }
</style>
<div class="panel-body pad table-responsive">
    <!--header--->

    <!--end-header--->
    <table align="center">
        <tbody>
        <tr>
            <td align="center">
                <h3><span style="border-bottom: double;">{{ $company }}</span></h3>
            </td>
        </tr>
        @if($branch != null)
            <tr>
                <td align="center">
                    <h3><span style="border-bottom: double;">{{ $branch }}</span></h3>
                </td>
            </tr>
        @endif
        <tr>
            <td align="center">
                <h3><span style="border-bottom: double;">Profit & Loss Report</span></h3>
            </td>
        </tr>
        <tr>
            <td align="center">
                <h5>As on {{ $end_date }}</h5>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="clear clearfix"></div>
    <!-- Liabilities and Assets -->

    <div class="col-md-12">
        <!-- Assets -->
        <table class="table" style="width:100%;">
            <thead>
            <tr>
                <th class="th-style">Incomes (Cr)</th>
                <th class="th-style" width="20%" style="text-align: right;">Amount (Pkr)</th>
            </tr>
            </thead>
            <tbody>
            {!! $incomeData !!}


            <tr class="bold-text">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>

        <!-- Liabilities -->
        <table class="table" style="width:100%;">
            <thead>
            <tr>
                <th class="th-style">Expenses (Dr)</th>
                <th class="th-style" width="20%" style="text-align: right;">Amount (Pkr)</th>
            </tr>
            </thead>
            <tbody>{!! $expData !!}</tbody>
        </table>

        <table class="table" style="width:100%;">
            <tbody>
            {!! $totalTaxData1 !!}
            {!! $taxData !!}
            {!! $totalTaxData2 !!}
            </tbody>
        </table>

    </div>
</div>
