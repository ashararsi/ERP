@inject('request', 'Illuminate\Http\Request')
@inject('CoreAccounts', 'App\Helpers\CoreAccounts')
@if($request->get('medium_type') != 'web')
    @if($request->get('medium_type') == 'pdf')
        @include('partials.pdf_head')
    @else
        @include('partials.head')
    @endif
    @include('partials.print_head')
    <style type="text/css">
        @page {
            margin: 10px 20px;
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
        }
    </style>
@endif
@inject('CoreAccounts', '\App\Helpers\CoreAccounts')
<div class="panel-body pad table-responsive">
<table align="center">
        <tbody>
        <tr>
            <td><h3 align="center"><span style="border-bottom: double;">P & L Report</span></h3>
               
            </td>
        </tr>
        <tr>
            <td align="center"><span></span>
            </td>
        </tr>
        </tbody>
    </table>
    <div class = "col-md-12">
    <div class="col-md-12">
        <h4 style = "float:left;"> From {{ $start_date}}  to {{$end_date }}</h4>
  
        <h4 style = "float:right"> From {{ $previous_start_date}}  to {{$previous_end_date }}</h4>
    </div>
    @if($request->get('medium_type') == 'web')
        <div class="col-md-12">
            <div class="text-center pull-right">
                <button onclick="FormControls.printReport('excel');" type="button" class="btn bg-olive btn-flat"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</button>
                <button onclick="FormControls.printReport('pdf');" type="button" class="btn btn-danger btn-flat"><i class="fa fa-file-pdf-o"></i>&nbsp;PDF</button>
                <button onclick="FormControls.printReport('print');" type="button" class="btn btn-flat"><i class="fa fa-print"></i>&nbsp;Print</button>
            </div>
        </div>
    @endif
    <div class="clear clearfix"></div>
    <!-- Liabilities and Assets -->

    <div style = "float:left;" class="col-md-12">
        <!-- Assets -->

        <table class="table" style = "width:100%; float:left;">
            <thead>
                <tr>
                    <th class="th-style" width="30%">Incomes (Cr)</th>
                    <th class="th-style"  style="text-align: right;"> Current Month (Rs.)</th>
                    <th class="th-style"  style="text-align: right;"> Previous Amount (Rs.)</th>
                    <th class="th-style" style="text-align: right;"> Current Quater (Rs.)</th>
                    <th class="th-style"  style="text-align: right;"> Previous Quater (Rs.)</th>
                    <th class="th-style"  style="text-align: right;"> Current Year (Rs.)</th>
                    <th class="th-style"  style="text-align: right;"> Previous Year (Rs.)</th>
                </tr>
            </thead>
            <tbody>
             
                {!! $pandl['gross_incomes_data'] !!}
                @if ($CoreAccounts::calculate($pandl['gross_income_total'], 0, '>='))
                
                    <tr class="bold-text bg-filled">
                        <td>Gross Incomes</td>
                        <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">{{ $CoreAccounts::toCurrency('c', $pandl['gross_income_total']) }}</td>
                        <!--td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">{{ $CoreAccounts::toCurrency('d', $pandl['gross_income_total']) }}</td -->
                    </tr>
                @else
                    <tr class="dc-error bold-text bg-filled">
                        <td>Gross Incomes</td>
                        <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right" class="show-tooltip" data-toggle="tooltip" data-original-title="Expecting positive Dr Balance">{{ $CoreAccounts::toCurrency('c', $pandl['gross_income_total']) }}</td>
                    </tr>
                @endif
                <tr class="bold-text">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <!--table class="table" style = "width:49%; float:right;">
            <thead>
                <tr>
                    <th class="th-style">Incomes (Cr)</th>
                    <th class="th-style" width="20%" style="text-align: right;"> Previous Amount (Rs.)</th>
                </tr>
            </thead>
            <tbody>
             
                {!! $pandl['gross_incomes_previous_data'] !!}
                @if ($CoreAccounts::calculate($pandl['gross_income_previous_total'], 0, '>='))
                
                    <tr class="bold-text bg-filled">
                        <td>Gross Incomes</td>
                        <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">{{ $CoreAccounts::toCurrency('c', $pandl['gross_income_previous_total']) }}</td>
                        <!--td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">{{ $CoreAccounts::toCurrency('d', $pandl['gross_income_total']) }}</td -->
                    <!--/tr>
                @else
                    <tr class="dc-error bold-text bg-filled">
                        <td>Gross Incomes</td>
                        <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right" class="show-tooltip" data-toggle="tooltip" data-original-title="Expecting positive Dr Balance">{{ $CoreAccounts::toCurrency('c', $pandl['gross_income_previous_total']) }}</td>
                    </tr>
                @endif
                <tr class="bold-text">
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
            </tbody>
        </table-->
    </div>
    <div class = "col-md-12">
        <!-- Liabilities -->
        <table class="table" style = "width:100%; float:left;">
            <thead>
            <tr>
                <th class="th-style">Expenses (Dr)</th>
             <th class="th-style"  style="text-align: right;"> Current Amount (Rs.)</th>
                    <th class="th-style"  style="text-align: right;"> Previous Amount (Rs.)</th>
                    <th class="th-style" style="text-align: right;"> Current Quater (Rs.)</th>
                    <th class="th-style"  style="text-align: right;"> Previous Quater (Rs.)</th>
                    <th class="th-style"  style="text-align: right;"> Current Year (Rs.)</th>
                    <th class="th-style"  style="text-align: right;"> Previous Year (Rs.)</th>
            </tr>
            </thead>
            <tbody>
            {!! $pandl['gross_expenses_data'] !!}
            @if ($CoreAccounts::calculate($pandl['gross_expense_total'], 0, '>='))
                <tr class="bold-text bg-filled">
                    <td>Gross Expenses</td>
                    <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">{{ $CoreAccounts::toCurrency('d', $pandl['gross_expense_total']) }}</td>
              
                 </tr>
            @else
                <tr class="dc-error bold-text bg-filled">
                    <td>Gross Expenses</td>
                    <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right" class="show-tooltip bg-filled" data-toggle="tooltip" data-original-title="Expecting positive Cr balance">{{ $CoreAccounts::toCurrency('d', $pandl['gross_expense_total']) }}</td>
                  
                </tr>
            @endif
            <tr class="bold-text">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>

        <!-- Assets -->
    

        <!-- Liabilities -->
        <!--table class="table" style = "width:49%; float:right;">
            <thead>
            <tr>
                <th class="th-style">Expenses (Dr)</th>
                <th class="th-style" width="20%" style="text-align: right;">Previous Amount (Rs.)</th>
            </tr>
            </thead>
            <tbody>
            {!! $pandl['gross_expenses_previous_data'] !!}
            @if ($CoreAccounts::calculate($pandl['gross_expense_previous_total'], 0, '>='))
                <tr class="bold-text bg-filled">
                    <td>Gross Expenses</td>
                    <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">{{ $CoreAccounts::toCurrency('d', $pandl['gross_expense_previous_total']) }}</td>
              
                 </tr>
            @else
                <tr class="dc-error bold-text bg-filled">
                    <td>Gross Expenses</td>
                    <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right" class="show-tooltip bg-filled" data-toggle="tooltip" data-original-title="Expecting positive Cr balance">{{ $CoreAccounts::toCurrency('d', $pandl['gross_expense_previous_total']) }}</td>
                  
                </tr>
            @endif
            <tr class="bold-text">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table>
         <table class="table" style = "width:49%; float:left;">
          <tr class="bold-text bg-filled">
                    <td>Gross Profit / Loss:</td>
                     @if ($CoreAccounts::calculate($pandl['net_pl'], 0, '>='))
                     
                    <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">{{ $CoreAccounts::toCurrency('c', $pandl['net_pl']) }}</td>
                     @else
                     
                    <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">{{ $CoreAccounts::toCurrency('d', $pandl['net_pl']) }}</td>
                     @endif
              
                 </tr>
                
                </thead>
                </table>
                   <table class="table" style = "width:49%; float:right;">
          <tr class="bold-text bg-filled">
                      <td>Gross Profit / Loss:</td>
                          @if ($CoreAccounts::calculate($pandl['net_pl_previous'], 0, '>='))
                     
                    <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">{{ $CoreAccounts::toCurrency('c', $pandl['net_pl_previous']) }}</td>
                     @else
                     
                    <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">{{ $CoreAccounts::toCurrency('d', $pandl['net_pl_previous']) }}</td>
                     @endif
              
                 </tr>
                </table -->
</div>
    </div>
<!-- <script type="text/javascript">
    window.onload = function() {
        window.print();
        setTimeout(window.close, 0);

    }
</script> -->