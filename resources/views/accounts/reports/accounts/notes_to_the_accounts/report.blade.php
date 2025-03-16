@inject('request', 'Illuminate\Http\Request')


<style type="text/css">
    table {
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        padding: 8px;
    }

</style>
<div class="panel-body pad table-responsive">
    <!--header--->

    <!--end-header--->
    <table align="center">
        <tbody>
        <tr>
            <td><h3 align="center"><span style="border-bottom: double;">Balance Sheet Report</span></h3>
            </td>
        </tr>
        <tr>
            <td aliagn="center"><span>As on {{ $end_date }}</span>
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
                <th class="th-style">Assets (Cr)</th>
                <th class="th-style">Account Type</th>
                <th class="th-style" width="20%" style="text-align: right;">Amount (Pkr)</th>
            </tr>
            </thead>
            <tbody>
            {!! $Data !!}


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
                <th class="th-style">Liabilities (Dr)</th>
                <th class="th-style">Account Type</th>
                <th class="th-style" width="20%" style="text-align: right;">Amount (Pkr)</th>
            </tr>
            </thead>
            <tbody>{!! 0 !!}</tbody>
        </table>
    </div>
</div>
