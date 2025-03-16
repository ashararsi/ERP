<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AccountsHelper;
use App\Helpers\AccountsList;
use App\Helpers\AccountsListOther;
use App\Helpers\CoreAccounts;
use App\Helpers\LedgersTree;
use App\Helpers\PermissionCheck;
use App\Http\Controllers\Controller;
use App\Models\ActiveSession;
use App\Models\Board;
use App\Models\Branches;
use App\Models\City;
use App\Models\Classes;
use App\Models\Company;
use App\Models\CourseType;
use App\Models\Entries;
use App\Models\EntryItems;
use App\Models\EntryTypes;
use App\Models\ErpFeeHead;
use App\Models\FeeCollection;
use App\Models\FeeCollectionDetail;
use App\Models\FeeHead;
use App\Models\FeeMasterBasic;
use App\Models\Groups;
use App\Models\Intake;
use App\Models\Ledger;
use App\Models\Months;
use App\Models\ParentDetail;
use App\Models\Program;
use App\Models\Section;
use App\Models\Session;
use App\Models\Session as school_session;
use App\Models\Staff;
use App\Models\StaffSalaries;
use App\Models\Students;
use App\Models\SubjectFeeMaster;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use Yajra\DataTables\DataTables;

class ReportsController extends Controller
{
    protected $sheet;
    // Variable to hold Excel Loop counter
    protected static $excel_iterator;

    public function __construct(AccountsHelper $accountsHelper)
    {
        $this->accountsHelper = $accountsHelper;
    }

    public function salary_tax_monthly_report(Request $request)
    {
        $branches = Branches::get();
        $months = Months::orderBy('id', 'asc')->get();
        return view('reports.salary.monthly_salary_tax_report.index', compact('branches', 'months'));
    }

    public function salary_tax_monthly_report_print(Request $request)
    {
        $array = array();
        $staff = Staff::join('staff_branches', 'staff_branches.staff_id', '=', 'staff.id')
            ->where('staff_branches.branch_id', $request->branch_id)->where('gross_salary_amount', '>', 0)->get();

        foreach ($staff as $staffs) {

            $name = "";
            $july = 0;
            $july_tax = 0;
            $august = 0;
            $august_tax = 0;
            $sept = 0;
            $sept_tax = 0;
            $october = 0;
            $oct_tax = 0;
            $november = 0;
            $november_tax = 0;
            $december = 0;
            $december_tax = 0;
            $january = 0;
            $january_tax = 0;
            $febraury = 0;
            $febraury_tax = 0;
            $march = 0;
            $march_tax = 0;

            $april = 0;
            $april_tax = 0;
            $may = 0;
            $may_tax = 0;
            $june = 0;
            $june_tax = 0;
            $total = 0;
            $total_tax = 0;


            $get_staff_salaries = StaffSalaries::where('branch_id', $request->branch_id)->where('staff_id', $staffs->staff_id)
                ->where('year_id', '>=', $request->from_year)->where('year_id', '<=', $request->to_year)
                ->orderby('month_id', 'asc')
                ->orderBy('year_id', 'asc')
                ->where('pay_status', 'Yes')
                ->get();

            foreach ($get_staff_salaries as $salaries) {

                if ($salaries->month_id == 7 && $request->from_year == $salaries->year_id) {
                    $july = $salaries->gross_before_adj;
                    $july_tax = $salaries->tax_amount;
                    $total = $total + $salaries->gross_before_adj;
                    $total_tax = $total_tax + $salaries->tax_amount;
                }
                if ($salaries->month_id == 8 && $request->from_year == $salaries->year_id) {
                    $august = $salaries->gross_before_adj;
                    $august_tax = $salaries->tax_amount;
                    $total = $total + $salaries->gross_before_adj;
                    $total_tax = $total_tax + $salaries->tax_amount;
                }
                if ($salaries->month_id == 9 && $request->from_year == $salaries->year_id) {
                    $sept = $salaries->gross_before_adj;
                    $sept_tax = $salaries->tax_amount;
                    $total = $total + $salaries->gross_before_adj;
                    $total_tax = $total_tax + $salaries->tax_amount;
                }
                if ($salaries->month_id == 10 && $request->from_year == $salaries->year_id) {
                    $october = $salaries->gross_before_adj;
                    $oct_tax = $salaries->tax_amount;
                    $total = $total + $salaries->gross_before_adj;
                    $total_tax = $total_tax + $salaries->tax_amount;
                }
                if ($salaries->month_id == 11 && $request->from_year == $salaries->year_id) {
                    $november = $salaries->gross_before_adj;
                    $november_tax = $salaries->tax_amount;
                    $total = $total + $salaries->gross_before_adj;
                    $total_tax = $total_tax + $salaries->tax_amount;
                }
                if ($salaries->month_id == 12 && $request->from_year == $salaries->year_id) {
                    $december = $salaries->gross_before_adj;
                    $december_tax = $salaries->tax_amount;
                    $total = $total + $salaries->gross_before_adj;
                    $total_tax = $total_tax + $salaries->tax_amount;
                }
                if ($salaries->month_id == 1 && $request->to_year == $salaries->year_id) {
                    $january = $salaries->gross_before_adj;
                    $january_tax = $salaries->tax_amount;
                    $total = $total + $salaries->gross_before_adj;
                    $total_tax = $total_tax + $salaries->tax_amount;
                }
                if ($salaries->month_id == 2 && $request->to_year == $salaries->year_id) {
                    $febraury = $salaries->gross_before_adj;
                    $febraury_tax = $salaries->tax_amount;
                    $total = $total + $salaries->gross_before_adj;
                    $total_tax = $total_tax + $salaries->tax_amount;
                }
                if ($salaries->month_id == 3 && $request->to_year == $salaries->year_id) {
                    $march = $salaries->gross_before_adj;
                    $march_tax = $salaries->tax_amount;
                    $total = $total + $salaries->gross_before_adj;
                    $total_tax = $total_tax + $salaries->tax_amount;
                }
                if ($salaries->month_id == 4 && $request->to_year == $salaries->year_id) {
                    $april = $salaries->gross_before_adj;
                    $april_tax = $salaries->tax_amount;
                    $total = $total + $salaries->gross_before_adj;
                    $total_tax = $total_tax + $salaries->tax_amount;
                }
                if ($salaries->month_id == 5 && $request->to_year == $salaries->year_id) {
                    $may = $salaries->gross_before_adj;
                    $may_tax = $salaries->tax_amount;
                    $total = $total + $salaries->gross_before_adj;
                    $total_tax = $total_tax + $salaries->tax_amount;
                }
                if ($salaries->month_id == 6 && $request->to_year == $salaries->year_id) {
                    $june = $salaries->gross_before_adj;
                    $june_tax = $salaries->tax_amount;
                    $total = $total + $salaries->gross_before_adj;
                    $total_tax = $total_tax + $salaries->tax_amount;
                }
                $name = $salaries->name;

            }

            $array[] = array('id' => $staffs->staff_id, 'reg_no' => $staffs->reg_no, 'name' => $name, 'cnic' => $staffs->cnic, 'total' => $total, 'total_tax' => $total_tax, 'april' => $april, 'april_tax' => $april_tax, 'may' => $may, 'may_tax' => $may_tax, 'june' => $june, 'june_tax' => $june_tax, 'march' => $march, 'march_tax' => $march_tax, 'febraury' => $febraury, 'febraury_tax' => $febraury_tax, 'january' => $january, 'january_tax' => $january_tax, 'december' => $december, 'december_tax' => $december_tax, 'november' => $november, 'november_tax' => $november_tax, 'october' => $october, 'oct_tax' => $oct_tax, 'sept' => $sept, 'sept_tax' => $sept_tax, 'july' => $july, 'july_tax' => $july_tax, 'august' => $august, 'august_tax' => $august_tax);
        }
        return response()->json(['data' => $array]);


    }

    public function ledger_report($ledger_id = 0, $start_date = 0, $end_date = 0)
    {
        $companies = Company::get();

        if ($ledger_id != 0 && $start_date != 0 && $end_date != 0) {

            $date_format = 'Y-m-d';
            $start_date_obj = DateTime::createFromFormat($date_format, $start_date);
            $end_date_obj = DateTime::createFromFormat($date_format, $end_date);

            $start_date = $start_date_obj->format('d/m/Y');
            $end_date = $end_date_obj->format('d/m/Y');

            $date_range = $start_date . '-' . $end_date;

            $ledger = Ledger::where('id', $ledger_id)->first();
            $branch = Branches::where('id', $ledger->branch_id)->first();
            $company = Company::where('id', $ledger->company_id)->first();

        } else {

            $ledger = null;
            $date_range = null;
            $branch = null;
            $company = null;
        }

        return view('reports.accounts.ledger_report.ledger', compact('companies', 'company', 'branch', 'ledger', 'start_date', 'end_date'));

    }

    public function ledger_print(Request $request)
    {
        $count = 0;
        $company_name = null;

        $date_range = explode(' - ', $request->get('date_range'));

        $date_format = 'd/m/Y';

        $start_date_obj = DateTime::createFromFormat($date_format, $date_range[0]);
        $end_date_obj = DateTime::createFromFormat($date_format, $date_range[1]);

        $start_date = $start_date_obj->format('Y-m-d');
        $end_date = $end_date_obj->format('Y-m-d');

        $ledgerIDs = $request->leadger_idd;

        if ($ledgerIDs[0] == 0) {
            if (isset($request->company_id)) {

                if (!isset($request->branch_id)) {
                    $request['branch_id'] = 0;
                }

                $parentGroups = new LedgersTree();
                $parentGroups->current_id = -1;
                $parentGroups->filter = $request->all();
                $parentGroups->build(0);
                $parentGroups->toList($parentGroups, -1);
                $Ledgers = $parentGroups->ledgerList;

                foreach ($Ledgers as $id => $singleLedger) {
                    if ($id < 0) {
                        $only_group[] = $singleLedger;
                    } else {
                        if ($id != 0)
                            $only_ledger[] = $id;
                    }
                }
                $ledgerIDs = $only_ledger;
            }
        }

        $date = date_create($start_date);
        date_sub($date, date_interval_create_from_date_string("1 days"));
        $new = date_format($date, "Y-m-d");
        $data = [];

        foreach ($ledgerIDs as $ledgerID) {
            $balance = 0.00;
            $tdr = 0;
            $tcr = 0;

            $company_details = Ledger::join('erp_branches', 'erp_branches.id', '=', 'erp_ledgers.branch_id')->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')->where('erp_ledgers.id', $ledgerID)->where('parent_type', null)->pluck('erp_companies.name');
            $ledger_opening_balance = Ledger::where('erp_ledgers.id', $ledgerID)->first();

            if (isset($company_details[0])) {
                $company_name = $company_details[0];
            } else {
                $company_detailsget = Ledger::join('erp_branches', 'erp_branches.id', '=', 'erp_ledgers.branch_id')->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')->where('erp_ledgers.id', $ledgerID)->pluck('erp_companies.name');

                $company_name = $company_detailsget[0];
            }

            $array = array();

            $Entrie = EntryItems::join('erp_ledgers', 'erp_ledgers.id', '=', 'erp_entry_items.ledger_id')
                ->where('erp_ledgers.id', '=', $ledgerID)->whereBetween('voucher_date', [$start_date, $end_date])
                ->orderBy('erp_entry_items.voucher_date', 'asc')->orderBy('erp_entry_items.entry_id', 'asc')->get();

            $Entries = EntryItems::join('erp_ledgers', 'erp_ledgers.id', '=', 'erp_entry_items.ledger_id')
                ->where('erp_entry_items.ledger_id', $ledgerID)->whereDate('voucher_date', '<', $start_date)->get();


            $dr = 0;
            $cr = 0;
            $ob = 0;

            foreach ($Entries as $Ent) {
                if ($Ent->dc == 'd') {
                    $dr += $Ent['amount'];
                }
                if ($Ent->dc == 'c') {
                    $cr += $Ent['amount'];
                }
            }
            $opening_balance = ($ledger_opening_balance->opening_balance) + ($dr) - ($cr);
            $ob_str = '<th style="text-align: right">' . CoreAccounts::dr_cr_balance($opening_balance) . ' </th>';

            foreach ($Entrie as $Ent) {

                $dr = 0.00;
                $cr = 0.00;
                $vn = Entries::where('id', $Ent->entry_id)->pluck('number');
                $vt = EntryTypes::where('id', $Ent->entry_type_id)->pluck('code');
                if ($Ent->dc == 'd') {
                    $dr = $Ent->amount;
                } else {
                    $cr = floatval($Ent->amount);

                }
                $ob += ($dr) - ($cr);
                $balance = $opening_balance + $ob;
                $balance = number_format($balance, 2, '.', '');
                $array[] = array('voucher_id' => $Ent->entry_id, 'voucher_date' => date('d-m-Y', strtotime($Ent->voucher_date)), 'number' => $vn[0],
                    'vt' => $vt[0], 'narration' => $Ent->narration . '-' . $Ent->instrument_number, 'dr_amount' => number_format($dr, 2), 'cr_amount' => number_format($cr, 2), 'balance' => CoreAccounts::dr_cr_balance($balance, 2));
                $tdr += $dr;
                $tcr += $cr;
            }

            // }
            $prBalance = CoreAccounts::dr_cr_balance($opening_balance);

            $data[$count]['data'] = $array;
            $data[$count]['ledger_name'] = Ledger::find($ledgerID)->number . ' - ' . Ledger::find($ledgerID)->name;
            $data[$count]['ob'] = $ob_str;
            $data[$count]['total_dr'] = number_format($tdr, 2);
            $data[$count]['total_cr'] = number_format($tcr, 2);
            $data[$count]['balance'] = CoreAccounts::dr_cr_balance($balance, 2);
//            return response()->json(['data' => $array, 'ob' => $ob_str, 'total_dr' => number_format($tdr, 2), 'total_cr' => number_format($tcr, 2), 'balance' => CoreAccounts::dr_cr_balance($balance, 2)]);
            ++$count;
        }

        if (isset($request->type) && $request->type == 'excel') {
            return self::excel_ledger($data, $start_date, $end_date, $company_name);
        } else if ($request->type == 'print') {
            return view('reports.accounts.ledger_report.ledger_print', compact('data', 'start_date', 'end_date', 'company_name'));
        }

        return response()->json(['data' => $data]);

    }

    public function excel_ledger($array, $start_date, $end_date, $company_name, $vendor_name = null)
    {
        header('Content-Type: application/vnd.ms-excel charset=UTF-8');
        header('Content-disposition: attachment; filename=LedgerReport.xls');
        $data = '';
        $string = "";

        $start_date = date("d-m-Y", strtotime($start_date));
        $end_date = date("d-m-Y", strtotime($end_date));

        $tdr = 0;
        $tcr = 0;
        $data .= '<table align="center">
        <tbody>
        <tr>
            <td>
                <h3 align="center"><span style="border-bottom: double;">Ledger Report</span></h3>
                <h5>' . $company_name . '<br>' . $start_date . ' To ' . $end_date . ' )</h5>
            </td>
        </tr>
        <tr>
            <td align="center">
            <span>' . $vendor_name . '</span>
            </td>
        </tr>
        </tbody>
    </table>';

        $data .= '<table cellpadding="0" cellspacing="0" class="table table-condensed" id="entry_items"
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
        <tbody style="border: 0.1pt solid #ccc">';

        foreach ($array as $ledger) {
            $data .= '<style>
                table{width: 100%;}
                td,th {
                    border: 0.1pt solid #ccc;
                }
                </style>';
            $data .= '<tr></tr>';
            $data .= '<tr>
                <th style="text-align: left" colspan="6">&#160;' . $ledger['ledger_name'] . '</th>' .
                $ledger['ob'] .
                '</tr>';
            foreach ($ledger['data'] as $data1) {
                $voucher_date = date("d-m-Y", strtotime($data1['voucher_date']));
                $data .= '<tr>
                    <td>' . $voucher_date . '</td>
                    <td> ' . $data1['number'] . '</td>
                    <td> ' . $data1['vt'] . '</td>
                    <td style = "text-align: left"> ' . $data1['narration'] . '</td>
                    <td style = "text-align: right;"> ' . $data1['dr_amount'] . '</td>
                    <td style = "text-align: right"> ' . $data1['cr_amount'] . '</td>
                    <td style = "text-align: right"> ' . $data1['balance'] . '</td>
                </tr> ';
            }
        }

        $data .= '</tbody>
    </table>';

        echo $data;
    }

    public function vendor_wise_ledger_report()
    {
        $vendors = Vendor::get();

        return view('reports.accounts.vendor_wise_ledger_report.ledger', compact('vendors'));

    }

    public function vendor_wise_ledger_print(Request $request)
    {
        $count = 0;
        $company_name = null;
        $vendor_name = null;

        $date_range = explode(' - ', $request->get('date_range'));

        $date_format = 'd/m/Y';

        $start_date_obj = DateTime::createFromFormat($date_format, $date_range[0]);
        $end_date_obj = DateTime::createFromFormat($date_format, $date_range[1]);

        $start_date = $start_date_obj->format('Y-m-d');
        $end_date = $end_date_obj->format('Y-m-d');

        $data = [];
        $vendor_id = $request->get('vendor_id');

        if ($vendor_id != null) {
            $vendor_name = Vendor::where('vendor_id', $vendor_id)->value('vendor_name');
            $ledgerIDs = EntryItems::whereHas('entry', function ($query) use ($request) {
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('branch_id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('branch_id', $branch_ids);
                }
            })->where('vendor_id', $vendor_id)->distinct()->pluck('ledger_id');

            $date = date_create($start_date);
            date_sub($date, date_interval_create_from_date_string("1 days"));
            $new = date_format($date, "Y-m-d");

            foreach ($ledgerIDs as $ledgerID) {
                $balance = 0.00;
                $tdr = 0;
                $tcr = 0;

                $company_details = Ledger::join('erp_branches', 'erp_branches.id', '=', 'erp_ledgers.branch_id')->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')->where('erp_ledgers.id', $ledgerID)->where('parent_type', null)->pluck('erp_companies.name');
                $ledger_opening_balance = Ledger::where('erp_ledgers.id', $ledgerID)->first();

                if (isset($company_details[0])) {
                    $company_name = $company_details[0];
                } else {
                    $company_detailsget = Ledger::join('erp_branches', 'erp_branches.id', '=', 'erp_ledgers.branch_id')->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')->where('erp_ledgers.id', $ledgerID)->pluck('erp_companies.name');

                    $company_name = $company_detailsget[0];
                }

                $array = array();

                $Entrie = EntryItems::join('erp_ledgers', 'erp_ledgers.id', '=', 'erp_entry_items.ledger_id')
                    ->where('erp_ledgers.id', '=', $ledgerID)->whereBetween('voucher_date', [$start_date, $end_date])
                    ->where('vendor_id', $vendor_id)->orderBy('erp_entry_items.voucher_date', 'asc')
                    ->orderBy('erp_entry_items.entry_id', 'asc')->get();

                $Entries = EntryItems::join('erp_ledgers', 'erp_ledgers.id', '=', 'erp_entry_items.ledger_id')
                    ->where('erp_entry_items.ledger_id', $ledgerID)->whereDate('voucher_date', '<', $start_date)->get();


                $dr = 0;
                $cr = 0;
                $ob = 0;

                foreach ($Entries as $Ent) {
                    if ($Ent->dc == 'd') {
                        $dr += $Ent['amount'];
                    }
                    if ($Ent->dc == 'c') {
                        $cr += $Ent['amount'];
                    }
                }
                $opening_balance = ($ledger_opening_balance->opening_balance) + ($dr) - ($cr);
                $ob_str = '<th style="text-align: right">' . CoreAccounts::dr_cr_balance($opening_balance) . ' </th>';

                foreach ($Entrie as $Ent) {

                    $dr = 0.00;
                    $cr = 0.00;
                    $vn = Entries::where('id', $Ent->entry_id)->pluck('number');
                    $vt = EntryTypes::where('id', $Ent->entry_type_id)->pluck('code');
                    if ($Ent->dc == 'd') {
                        $dr = $Ent->amount;
                    } else {
                        $cr = floatval($Ent->amount);

                    }
                    $ob += ($dr) - ($cr);
                    $balance = $opening_balance + $ob;
                    $balance = number_format($balance, 2, '.', '');
                    $array[] = array('voucher_id' => $Ent->entry_id, 'voucher_date' => date('d-m-Y', strtotime($Ent->voucher_date)), 'number' => $vn[0],
                        'vt' => $vt[0], 'narration' => $Ent->narration . '-' . $Ent->instrument_number, 'dr_amount' => number_format($dr, 2), 'cr_amount' => number_format($cr, 2), 'balance' => CoreAccounts::dr_cr_balance($balance, 2));
                    $tdr += $dr;
                    $tcr += $cr;
                }

                // }
                $prBalance = CoreAccounts::dr_cr_balance($opening_balance);

                $data[$count]['data'] = $array;
                $data[$count]['ledger_name'] = Ledger::find($ledgerID)->number . ' - ' . Ledger::find($ledgerID)->name;
                $data[$count]['ob'] = $ob_str;
                $data[$count]['total_dr'] = number_format($tdr, 2);
                $data[$count]['total_cr'] = number_format($tcr, 2);
                $data[$count]['balance'] = CoreAccounts::dr_cr_balance($balance, 2);
//            return response()->json(['data' => $array, 'ob' => $ob_str, 'total_dr' => number_format($tdr, 2), 'total_cr' => number_format($tcr, 2), 'balance' => CoreAccounts::dr_cr_balance($balance, 2)]);
                ++$count;
            }
        }

        if (isset($request->type) && $request->type == 'excel') {
            return self::excel_ledger($data, $start_date, $end_date, $company_name, $vendor_name);
        } else if ($request->type == 'print') {
            return view('reports.accounts.ledger_report.ledger_print', compact('data', 'start_date', 'end_date', 'company_name', 'vendor_name'));
        }

        return response()->json(['data' => $data]);

    }

    public function profit_loss(Request $request)
    {
        $companies = Company::get();

        return view('reports.accounts.profit_loss.index', compact('companies'));
    }

    public function profit_loss_print(Request $request)
    {
        $type = $request->type ?? $request->medium_type;
        $texp_balance = 0;
        $incomeData = '';
        $expData = '';
        $taxData = '';
        $totalTaxData1 = '';
        $totalTaxData2 = '';
        $tincome_balance = 0;
        $level = 2;

        if ($request->get('date_range')) {
            $date_range = explode(' - ', $request->get('date_range'));

            $start_date = $date_range[0];
            $start_date = str_replace('/', '-', $start_date);
            $start_date = Carbon::createFromFormat('d-m-Y', $start_date);
            $start_date = $start_date->format('Y-m-d');

            $end_date = $date_range[1];
            $end_date = str_replace('/', '-', $end_date);
            $end_date = Carbon::createFromFormat('d-m-Y', $end_date);
            $end_date = $end_date->format('Y-m-d');

        } else {
            $start_date = null;
            $end_date = null;
        }

        if (!$request->company_id) {
            $request['company_id'] = 0;
        }
        if (!$request->branch_id) {
            $request['branch_id'] = 0;
        }

        $tinc_balance = 0;

        $GroupIncome = Groups::where('account_type_id', 4)->where('level', 2)->orderBy('number')->get();

        foreach ($GroupIncome as $Exp) {

            $topGroups = $this->accountsHelper->getGroupChild($Exp->id);
            $trialHash = [];
            $array = $this->accountsHelper->buildTrialBalance($topGroups, $trialHash, $start_date, $end_date, $request['company_id'], $request['branch_id']);
            $data = $this->accountsHelper->calculateSums($array);
            $total = $this->accountsHelper->calculateTotals($data);

            $groupBalance = abs($total['closing_dr'] - $total['closing_cr']);

            if ($Exp->level == 2) {
                $b_start = '<b>';
                $b_end = '</b>';
            } else {
                $b_start = '';
                $b_end = '';
            }

            $incomeData .= '<tr style = "background-color:#dad5d5;">';

            $incomeData .= '<td   data-bs-toggle="collapse" href="#id-' . $Exp->id . '" role="button" aria-expanded="false" aria-controls="collapseExample" ';

            $incomeData .= ' ><span style="margin-left:0;color:black;">' . $b_start . $Exp->number . ' - ' . $Exp->name . $b_end . '</span>';
            if ($type == 'web') {
                $incomeData .= '<div class="collapse" id="id-' . $Exp->id . '"> <hr/>  <div style="width:100% " > <table style="width:100% ">      ' . $this->childgroup($Exp->id, $request, 3, $Exp->level) . '</table>  </div> </div></td>';
            }

            $incomeData .= '<td><b style="float: right !important;">' . number_format($groupBalance) . '</b></td>';
            $incomeData .= '</tr>';

            $tinc_balance += $groupBalance;

        }
        $incomeData .= '
                    <tr class="bold-text bg-filled">
                        <td>Gross Incomes</td>
                        <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">' . CoreAccounts::dr_cr_balance_inverse($tinc_balance, 2) . '</td>
                    </tr>';

        $texp_balance = 0;
        $tax_balance = 0;

        $GroupExp = Groups::where('account_type_id', 3)->where('level', 2)->orderBy('number')->get();

        foreach ($GroupExp as $Exp) {

            $topGroups = $this->accountsHelper->getGroupChild($Exp->id);
            $trialHash = [];
            $array = $this->accountsHelper->buildTrialBalance($topGroups, $trialHash, $start_date, $end_date, $request['company_id'], $request['branch_id']);
            $data = $this->accountsHelper->calculateSums($array);
            $total = $this->accountsHelper->calculateTotals($data);

            $groupBalance = abs($total['closing_dr'] - $total['closing_cr']);

            if ($Exp->level == 2) {
                $b_start = '<b>';
                $b_end = '</b>';
            } else {
                $b_start = '';
                $b_end = '';
            }

            if ($Exp->name == 'Taxation') {

                $taxData .= '<tr style = "background-color:#dad5d5;">';

                $taxData .= '<td   data-bs-toggle="collapse" href="#id-' . $Exp->id . '" role="button" aria-expanded="false" aria-controls="collapseExample" ';


                $taxData .= ' ><span style="margin-left:0;color:black;">' . $b_start . $Exp->number . ' - ' . $Exp->name . $b_end . '</span>';
                if ($type == 'web') {
                    $taxData .= '<div class="collapse" id="id-' . $Exp->id . '"> <hr/>  <div style="width:100% " > <table style="width:100% ">      ' . $this->childgroup($Exp->id, $request, 4, $Exp->level) . '</table>  </div> </div></td>';
                }

                $taxData .= '<td><b style="float: right !important;">' . number_format($groupBalance) . '</b></td>';
                $taxData .= '</tr>';

                $tax_balance += $groupBalance;

            } else {

                $expData .= '<tr style = "background-color:#dad5d5;">';

                $expData .= '<td   data-bs-toggle="collapse" href="#id-' . $Exp->id . '" role="button" aria-expanded="false" aria-controls="collapseExample" ';


                $expData .= ' ><span style="margin-left:0;color:black;">' . $b_start . $Exp->number . ' - ' . $Exp->name . $b_end . '</span>';
                if ($type == 'web') {
                    $expData .= '<div class="collapse" id="id-' . $Exp->id . '"> <hr/>  <div style="width:100% " > <table style="width:100% ">      ' . $this->childgroup($Exp->id, $request, 1, $Exp->level) . '</table>  </div> </div></td>';
                }

                $expData .= '<td><b style="float: right !important;">' . number_format($groupBalance) . '</b></td>';
                $expData .= '</tr>';

                $texp_balance += $groupBalance;
            }
        }

        $expData .= '
                <tr class="bold-text bg-filled">
                    <td>Gross Expenses</td>
                    <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">' . CoreAccounts::dr_cr_balance($texp_balance, 2) . '</td>
                </tr>';

        $net = ($tinc_balance) - ($texp_balance);
        $net1 = ($net) + ($tax_balance);

        $totalTaxData1 .= '<tr class="bold-text">
                    <th>Profit Before Taxation</th>
                    <td width="20%" align="right" style="border-bottom: 1px solid black;">' . CoreAccounts::dr_cr_balance_inverse($net, 2) . '</td>
                </tr>';
        $totalTaxData2 .= '<tr class="bold-text">
                    <th>Profit After Taxation</th>
                    <td width="20%" align="right" style="border-bottom: 1px solid black;">' . CoreAccounts::dr_cr_balance_inverse($net1, 2) . '</td>
                </tr>';

        $company = Company::where('id', $request->company_id)->value('name');

        if ($request->branch_id) {
            $branch = Branches::where('id', $request->branch_id)->value('name');
        } else {
            $branch = null;
        }

        if ($type == 'excel') {
            return self::excel_report($incomeData, $expData, $taxData, $totalTaxData1, $totalTaxData2, $start_date, $end_date, $company, $branch);
        } elseif ($type == 'print') {
            $content = View::make('reports.accounts.profit_loss.report', compact('incomeData', 'expData', 'taxData', 'totalTaxData1', 'totalTaxData2', 'start_date', 'end_date', 'company', 'branch'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('ProfitAndLossReport.pdf', 'D');
        } else {
            return view('reports.accounts.profit_loss.report', compact('incomeData', 'expData', 'taxData', 'totalTaxData1', 'totalTaxData2', 'start_date', 'end_date', 'company', 'branch'));
        }
    }

    public function profit_loss_print_new($request)
    {
        $type = $request->type ?? $request->medium_type;
        $texp_balance = 0;
        $incomeData = '';
        $expData = '';
        $taxData = '';
        $totalTaxData1 = '';
        $totalTaxData2 = '';
        $tincome_balance = 0;
        $level = 2;

        if ($request->get('date_range')) {
            $date_range = explode(' - ', $request->get('date_range'));

            $start_date = $date_range[0];
            $start_date = str_replace('/', '-', $start_date);
            $start_date = Carbon::createFromFormat('d-m-Y', $start_date);
            $start_date = $start_date->format('Y-m-d');

            $end_date = $date_range[1];
            $end_date = str_replace('/', '-', $end_date);
            $end_date = Carbon::createFromFormat('d-m-Y', $end_date);
            $end_date = $end_date->format('Y-m-d');

        } else {
            $start_date = null;
            $end_date = null;
        }

        if (!$request->company_id) {
            $request['company_id'] = 0;
        }
        if (!$request->branch_id) {
            $request['branch_id'] = 0;
        }

        $tinc_balance = 0;

        $GroupIncome = Groups::where('account_type_id', 4)->where('level', 2)->orderBy('number')->get();

        foreach ($GroupIncome as $Exp) {

            $topGroups = $this->accountsHelper->getGroupChild($Exp->id);
            $trialHash = [];
            $array = $this->accountsHelper->buildTrialBalance($topGroups, $trialHash, $start_date, $end_date, $request['company_id'], $request['branch_id']);
            $data = $this->accountsHelper->calculateSums($array);
            $total = $this->accountsHelper->calculateTotals($data);

            $groupBalance = abs($total['closing_dr'] - $total['closing_cr']);

            if ($Exp->level == 2) {
                $b_start = '<b>';
                $b_end = '</b>';
            } else {
                $b_start = '';
                $b_end = '';
            }

            $incomeData .= '<tr style = "background-color:#dad5d5;">';

            $incomeData .= '<td   data-bs-toggle="collapse" href="#id-' . $Exp->id . '" role="button" aria-expanded="false" aria-controls="collapseExample" ';


            $incomeData .= ' ><span style="margin-left:0;color:black;">' . $b_start . $Exp->number . ' - ' . $Exp->name . $b_end . '</span>';
            if ($type == 'web') {
                $incomeData .= '<div class="collapse" id="id-' . $Exp->id . '"> <hr/>  <div style="width:100% " > <table style="width:100% ">      ' . $this->childgroup($Exp->id, $request, 3, $Exp->level) . '</table>  </div> </div></td>';
            }

            $incomeData .= '<td><b style="float: right !important;">' . number_format($groupBalance) . '</b></td>';
            $incomeData .= '</tr>';

            $tinc_balance += $groupBalance;
        }
        $incomeData .= '
                    <tr class="bold-text bg-filled">
                        <td>Gross Incomes</td>
                        <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">' . CoreAccounts::dr_cr_balance_inverse($tinc_balance, 2) . '</td>
                    </tr>';

        $texp_balance = 0;
        $tax_balance = 0;

        $GroupExp = Groups::where('account_type_id', 3)->where('level', 2)->orderBy('number')->get();

        foreach ($GroupExp as $Exp) {

            $topGroups = $this->accountsHelper->getGroupChild($Exp->id);
            $trialHash = [];
            $array = $this->accountsHelper->buildTrialBalance($topGroups, $trialHash, $start_date, $end_date, $request['company_id'], $request['branch_id']);
            $data = $this->accountsHelper->calculateSums($array);
            $total = $this->accountsHelper->calculateTotals($data);

            $groupBalance = abs($total['closing_dr'] - $total['closing_cr']);

            if ($Exp->level == 2) {
                $b_start = '<b>';
                $b_end = '</b>';
            } else {
                $b_start = '';
                $b_end = '';
            }

            if ($Exp->name == 'Taxation') {

                $taxData .= '<tr style = "background-color:#dad5d5;">';

                $taxData .= '<td   data-bs-toggle="collapse" href="#id-' . $Exp->id . '" role="button" aria-expanded="false" aria-controls="collapseExample" ';


                $taxData .= ' ><span style="margin-left:0;color:black;">' . $b_start . $Exp->number . ' - ' . $Exp->name . $b_end . '</span>';
                if ($type == 'web') {
                    $taxData .= '<div class="collapse" id="id-' . $Exp->id . '"> <hr/>  <div style="width:100% " > <table style="width:100% ">      ' . $this->childgroup($Exp->id, $request, 4, $Exp->level) . '</table>  </div> </div></td>';
                }

                $taxData .= '<td><b style="float: right !important;">' . number_format($groupBalance) . '</b></td>';
                $taxData .= '</tr>';

                $tax_balance += $groupBalance;

            } else {

                $expData .= '<tr style = "background-color:#dad5d5;">';

                $expData .= '<td   data-bs-toggle="collapse" href="#id-' . $Exp->id . '" role="button" aria-expanded="false" aria-controls="collapseExample" ';


                $expData .= ' ><span style="margin-left:0;color:black;">' . $b_start . $Exp->number . ' - ' . $Exp->name . $b_end . '</span>';
                if ($type == 'web') {
                    $expData .= '<div class="collapse" id="id-' . $Exp->id . '"> <hr/>  <div style="width:100% " > <table style="width:100% ">      ' . $this->childgroup($Exp->id, $request, 1, $Exp->level) . '</table>  </div> </div></td>';
                }

                $expData .= '<td><b style="float: right !important;">' . number_format($groupBalance) . '</b></td>';
                $expData .= '</tr>';

                $texp_balance += $groupBalance;
            }
        }

        $expData .= '
                <tr class="bold-text bg-filled">
                    <td>Gross Expenses</td>
                    <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">' . CoreAccounts::dr_cr_balance($texp_balance, 2) . '</td>
                </tr>';

        $net = ($tinc_balance) - ($texp_balance);
        $net1 = ($net) + ($tax_balance);

        $totalTaxData1 .= '<tr class="bold-text">
                    <th>Profit Before Taxation</th>
                    <td width="20%" align="right" style="border-bottom: 1px solid black;">' . CoreAccounts::dr_cr_balance_inverse($net, 2) . '</td>
                </tr>';
        $totalTaxData2 .= '<table> <tr class="bold-text" style="width: 100%">
                    <th>Profit & Loss Net Balance</th>
                    <td width="24.5%" align="right" style="border-bottom: 1px solid black;">' . CoreAccounts::dr_cr_balance_inverse($net1, 2) . '</td>
                </tr></table>';

        return $totalTaxData2;
    }


    public function excel_report($incomeData, $expData, $taxData, $totalTaxData1, $totalTaxData2, $start_date, $end_date, $company, $branch)
    {
        header('Content-Type: application/vnd.ms-excel charset=UTF-8');
        header('Content-disposition: attachment; filename=P&LReport.xls');
        $data = '';

        $start_date = date("d-m-Y", strtotime($start_date));
        $end_date = date("d-m-Y", strtotime($end_date));

        $data .= '<style>
                table{width: 100%;}
                td,th {
                    border: 0.1pt solid #ccc;
                }
                </style>';

        $data .= '<div class="panel-body pad table-responsive">
                    <table align="center">
                        <tbody>
                        <tr>
                            <td align="center">
                                <h3><span style="border-bottom: double;">' . $company . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <h3><span style="border-bottom: double;">' . $branch . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <h3><span style="border-bottom: double;">Profit & Loss Report</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <h5>As on ' . $end_date . '</h5>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="clear clearfix"></div>
                    <div class="col-md-12">
                        <table class="table" style="width:100%;">
                            <thead>
                            <tr>
                                <th class="th-style">Incomes (Cr)</th>
                                <th class="th-style" width="20%" style="text-align: right;">Amount (Pkr)</th>
                            </tr>
                            </thead>
                            <tbody>' .
            $incomeData
            . '<tr class="bold-text">
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table" style="width:100%;">
                            <thead>
                            <tr>
                                <th class="th-style">Expenses (Dr)</th>
                                <th class="th-style" width="20%" style="text-align: right;">Amount (Pkr)</th>
                            </tr>
                            </thead>
                            <tbody>' .
            $expData
            . '</tbody>
                        </table>

                        <table class="table" style="width:100%;">
                            <tbody>' .
            $totalTaxData1 .
            $taxData .
            $totalTaxData2
            . '</tbody>
                        </table>

                    </div>
                </div>';

        echo $data;
    }

    public function excel_bs_report($incomeData, $expData, $start_date, $end_date, $company, $branch)
    {
        header('Content-Type: application/vnd.ms-excel charset=UTF-8');
        header('Content-disposition: attachment; filename=B&SReport.xls');
        $data = '';

        $start_date = date("d-m-Y", strtotime($start_date));
        $end_date = date("d-m-Y", strtotime($end_date));

        $data .= '<style>
                table{width: 100%;}
                td,th {
                    border: 0.1pt solid #ccc;
                }
                </style>';

        $data .= '<div class="panel-body pad table-responsive">
                    <table align="center">
                        <tbody>
                        <tr>
                            <td align="center">
                                <h3><span style="border-bottom: double;">' . $company . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <h3><span style="border-bottom: double;">' . $branch . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <h3><span style="border-bottom: double;">Balance Sheet Report</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <h5>As on ' . $end_date . '</h5>
                            </td>
                        </tr>
                        </tbody>
                    </table>';

        $data .= '<div class="col-md-12">
                    <table class="table" style="width:100%;">
                        <thead>
                        <tr>
                            <th class="th-style">Assets (Cr)</th>
                            <th class="th-style" style="text-align: right;">Amount (Pkr)</th>
                        </tr>
                        </thead>
                        <tbody>' . $incomeData . '
                        <tr class="bold-text">
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table" style="width:100%;">
                        <thead>
                        <tr>
                            <th class="th-style">Liabilities (Dr)</th>
                            <th class="th-style" style="text-align: right;">Amount (Pkr)</th>
                        </tr>
                        </thead>
                        <tbody>' . $expData . '</tbody>
                    </table>
                </div>
            </div>';

        echo $data;
    }

    public function cmp_profit_loss(Request $request)
    {
        $company = Company::get();
        return view('reports.accounts.cmp_profit_loss.index', compact('company'));
    }

    public function cmp_profit_loss_print(Request $request)
    {

        if ($request->get('date_range')) {
            $date_range = explode(' - ', $request->get('date_range'));
            $start_date = date('Y-m-d', strtotime($date_range[0]));
            $end_date = date('Y-m-d', strtotime($date_range[1]));
        } else {
            $start_date = null;
            $end_date = null;
        }
        if ($request->get('date_range_1')) {
            $date_range = explode(' - ', $request->get('date_range_1'));
            $previous_start_date = date('Y-m-d', strtotime($date_range[0]));
            $previous_end_date = date('Y-m-d', strtotime($date_range[1]));
        } else {
            $previous_start_date = null;
            $previous_end_date = null;
        }
        if ($request->get('date_range_2')) {
            $date_range = explode(' - ', $request->get('date_range_2'));
            $current_quater_start_date = date('Y-m-d', strtotime($date_range[0]));
            $current_quater_end_date = date('Y-m-d', strtotime($date_range[1]));
        } else {
            $current_quater_start_date = null;
            $current_quater_end_date = null;
        }
        if ($request->get('date_range_3')) {
            $date_range = explode(' - ', $request->get('date_range_3'));
            $previous_quater_start_date = date('Y-m-d', strtotime($date_range[0]));
            $previous_quater_end_date = date('Y-m-d', strtotime($date_range[1]));
        } else {
            $previous_quater_start_date = null;
            $previous_quater_end_date = null;
        }
        if ($request->get('date_range_4')) {
            $date_range = explode(' - ', $request->get('date_range_4'));
            $current_year_start_date = date('Y-m-d', strtotime($date_range[0]));
            $current_year_end_date = date('Y-m-d', strtotime($date_range[1]));
        } else {
            $current_year_start_date = null;
            $current_year_end_date = null;
        }
        if ($request->get('date_range_5')) {
            $date_range = explode(' - ', $request->get('date_range_5'));
            $previous_year_start_date = date('Y-m-d', strtotime($date_range[0]));
            $previous_year_end_date = date('Y-m-d', strtotime($date_range[1]));
        } else {
            $previous_year_start_date = null;
            $previous_year_end_date = null;
        }

        /*   /**********************************************************************/
        /*********************** GROSS CALCULATIONS ***************************/
        /**********************************************************************/

        /* Gross P/L : Expenses */
        $gross_expenses = new AccountsListOther();
        $gross_expenses->only_opening = false;
        $gross_expenses->start_date = $start_date;
        $gross_expenses->end_date = $end_date;
        $gross_expenses->previous_month_start_date = $previous_start_date;
        $gross_expenses->previous_month_end_date = $previous_end_date;
        $gross_expenses->previous_quater_start_date = $previous_quater_start_date;
        $gross_expenses->previous_quater_end_date = $previous_quater_end_date;
        $gross_expenses->current_quater_start_date = $current_quater_start_date;
        $gross_expenses->current_quater_end_date = $current_quater_end_date;
        $gross_expenses->c_year_start = $current_year_start_date;
        $gross_expenses->c_year_end = $current_year_end_date;
        $gross_expenses->p_year_start = $previous_year_start_date;
        $gross_expenses->p_year_end = $previous_year_end_date;
        $gross_expenses->affects_gross = 1;
        $gross_expenses->filter = $request->all();
        $gross_expenses->start(4);

        $pandl['gross_expenses'] = $gross_expenses;
        $pandl['gross_expenses_data'] = $gross_expenses->generateSheet($gross_expenses, -1, 'd');

        $pandl['gross_expense_total'] = 0;
        if ($gross_expenses->cl_total_dc == 'd') {
            $pandl['gross_expense_total'] = $gross_expenses->cl_total;
        } else {
            $pandl['gross_expense_total'] = CoreAccounts::calculate($gross_expenses->cl_total, 0, 'n');
        }

        /* Gross P/L : Incomes */
        $gross_incomes = new AccountsListOther();
        $gross_incomes->only_opening = false;
        $gross_incomes->start_date = $start_date;
        $gross_incomes->end_date = $end_date;
        //previous
        $gross_incomes->previous_month_start_date = $previous_start_date;
        $gross_incomes->previous_month_end_date = $previous_end_date;
        $gross_incomes->previous_quater_start_date = $previous_quater_start_date;
        $gross_incomes->previous_quater_end_date = $previous_quater_end_date;
        $gross_incomes->current_quater_start_date = $current_quater_start_date;
        $gross_incomes->current_quater_end_date = $current_quater_end_date;
        $gross_incomes->c_year_start = $current_year_start_date;
        $gross_incomes->c_year_end = $current_year_end_date;
        $gross_incomes->p_year_start = $previous_year_start_date;
        $gross_incomes->p_year_end = $previous_year_end_date;

        $gross_incomes->affects_gross = 1;
        $gross_incomes->filter = $request->all();
        $gross_incomes->start(3);


        $pandl['gross_incomes'] = $gross_incomes;
        // dd($gross_incomes);
        $pandl['gross_incomes_data'] = $gross_incomes->generateSheet($gross_incomes, -1, 'c');
        $pandl['gross_income_total'] = 0;
        if ($gross_incomes->cl_total_dc == 'c') {
            $pandl['gross_income_total'] = $gross_incomes->cl_total;
        } else {
            $pandl['gross_income_total'] = CoreAccounts::calculate($gross_incomes->cl_total, 0, 'n');
        }

        /* Calculating Gross P/L */
        $pandl['gross_pl'] = CoreAccounts::calculate($pandl['gross_income_total'], $pandl['gross_expense_total'], '-');

        /**********************************************************************/
        /************************* NET CALCULATIONS ***************************/
        /**********************************************************************/

        /* Net P/L : Expenses */
        $net_expenses = new AccountsListOther();
        $gross_expenses->start_date = $start_date;
        $gross_expenses->end_date = $end_date;
        $gross_expenses->affects_gross = 0;
        $gross_expenses->filter = $request->all();
        $gross_expenses->start(4);

        $pandl['net_expenses'] = $net_expenses;
        $pandl['net_expenses_data'] = $gross_expenses->generateSheet($gross_expenses, -1, 'd');

        $pandl['net_expense_total'] = 0;
        if ($net_expenses->cl_total_dc == 'd') {
            $pandl['net_expense_total'] = $net_expenses->cl_total;
        } else {
            $pandl['net_expense_total'] = CoreAccounts::calculate($net_expenses->cl_total, 0, 'n');
        }

        /* Net P/L : Incomes */
        $net_incomes = new AccountsListOther();
        $gross_incomes->start_date = $start_date;
        $gross_incomes->end_date = $end_date;
        $gross_incomes->affects_gross = 0;
        $gross_incomes->filter = $request->all();
        $gross_incomes->start(3);

        $pandl['net_incomes'] = $net_incomes;
        $pandl['net_incomes_data'] = $gross_incomes->generateSheet($gross_incomes, -1, 'c');

        $pandl['net_income_total'] = 0;
        if ($net_incomes->cl_total_dc == 'c') {
            $pandl['net_income_total'] = $net_incomes->cl_total;
        } else {
            $pandl['net_income_total'] = CoreAccounts::calculate($net_incomes->cl_total, 0, 'n');
        }

        /* Calculating Net P/L */
        $pandl['net_pl'] = CoreAccounts::calculate($pandl['net_income_total'], $pandl['net_expense_total'], '-');
        $pandl['net_pl'] = CoreAccounts::calculate($pandl['net_pl'], $pandl['gross_pl'], '+');

        /**********************************************************************/
        /*********************** GROSS PREVIOUS CALCULATIONS  ***************************/
        /**********************************************************************/

        /* Gross P/L : Expenses */
        $gross_expenses_previous = new AccountsListOther();
        $gross_expenses_previous->only_opening = false;
        $gross_expenses_previous->start_date = $previous_start_date;
        $gross_expenses_previous->end_date = $previous_end_date;
        $gross_expenses_previous->affects_gross = 1;
        $gross_expenses_previous->filter = $request->all();
        $gross_expenses_previous->start(4);

        $pandl['gross_expenses_previous'] = $gross_expenses_previous;
        $pandl['gross_expenses_previous_data'] = $gross_expenses_previous->generateSheet($gross_expenses_previous, -1, 'd');

        $pandl['gross_expense_previous_total'] = 0;
        if ($gross_expenses_previous->cl_total_dc == 'd') {
            $pandl['gross_expense_previous_total'] = $gross_expenses_previous->cl_total;
        } else {
            $pandl['gross_expense_previous_total'] = CoreAccounts::calculate($gross_expenses_previous->cl_total, 0, 'n');
        }

        /* Gross P/L : Incomes */
        $gross_incomes_previous = new AccountsListOther();
        $gross_incomes_previous->only_opening = false;
        $gross_incomes_previous->start_date = $previous_start_date;
        $gross_incomes_previous->end_date = $previous_end_date;
        $gross_incomes_previous->affects_gross = 1;
        $gross_incomes_previous->filter = $request->all();
        $gross_incomes_previous->start(3);
        //print_r($gross_incomes);
        $pandl['gross_incomes_previous'] = $gross_incomes_previous;
        $pandl['gross_incomes_previous_data'] = $gross_incomes_previous->generateSheet($gross_incomes_previous, -1, 'c');

        $pandl['gross_income_previous_total'] = 0;
        if ($gross_incomes_previous->cl_total_dc == 'c') {
            $pandl['gross_income_previous_total'] = $gross_incomes_previous->cl_total;
        } else {
            $pandl['gross_income_previous_total'] = CoreAccounts::calculate($gross_incomes_previous->cl_total, 0, 'n');
        }

        /* Calculating Gross P/L */
        $pandl['gross_pl_previous'] = CoreAccounts::calculate($pandl['gross_income_previous_total'], $pandl['gross_expense_previous_total'], '-');

        /**********************************************************************/
        /************************* NET CALCULATIONS ***************************/
        /**********************************************************************/

        /* Net P/L : Expenses */
        $net_expenses_previous = new AccountsListOther();
        $gross_expenses_previous->start_date = $previous_start_date;
        $gross_expenses_previous->end_date = $previous_end_date;
        $gross_expenses_previous->affects_gross = 0;
        $gross_expenses_previous->filter = $request->all();
        $gross_expenses_previous->start(4);

        $pandl['net_expenses_previous'] = $net_expenses_previous;
        $pandl['net_expenses_previous_data'] = $gross_expenses_previous->generateSheet($gross_expenses_previous, -1, 'd');

        $pandl['net_expense_previous_total'] = 0;
        if ($net_expenses_previous->cl_total_dc == 'd') {
            $pandl['net_expense_previous_total'] = $net_expenses_previous->cl_total;
        } else {
            $pandl['net_expense_previous_total'] = CoreAccounts::calculate($net_expenses_previous->cl_total, 0, 'n');
        }

        /* Net P/L : Incomes */
        $net_incomes_previous = new AccountsListOther();
        $gross_incomes_previous->start_date = $start_date;
        $gross_incomes_previous->end_date = $end_date;
        $gross_incomes_previous->affects_gross = 0;
        $gross_incomes_previous->filter = $request->all();
        $gross_incomes_previous->start(3);

        $pandl['net_incomes_previous'] = $net_incomes_previous;
        $pandl['net_incomes_previous_data'] = $gross_incomes_previous->generateSheet($gross_incomes_previous, -1, 'c');

        $pandl['net_income_previous_total'] = 0;
        if ($net_incomes_previous->cl_total_dc == 'c') {
            $pandl['net_income_previous_total'] = $net_incomes_previous->cl_total;
        } else {
            $pandl['net_income_previous_total'] = CoreAccounts::calculate($net_incomes_previous->cl_total, 0, 'n');
        }

        /* Calculating Net P/L */
        $pandl['net_pl_previous'] = CoreAccounts::calculate($pandl['net_income_previous_total'], $pandl['net_expense_previous_total'], '-');
        $pandl['net_pl_previous'] = CoreAccounts::calculate($pandl['net_pl_previous'], $pandl['gross_pl_previous'], '+');


        return view('reports.accounts.cmp_profit_loss.report', compact('pandl', 'start_date', 'end_date', 'previous_start_date', 'previous_end_date'));


        /*   switch($request->get('medium_type')) {
            case 'web':
                return view('admin.account_reports.profit_loss.comp_report', compact('pandl', 'start_date', 'end_date','previous_start_date', 'previous_end_date', 'DefaultCurrency'));
                break;
            case 'print':
                return view('admin.account_reports.profit_loss.comp_report', compact('pandl', 'start_date', 'end_date','previous_start_date', 'previous_end_date', 'DefaultCurrency'));
                break;
            case 'excel':
                $this->profitLossExcelcomp($pandl, $DefaultCurrency, $start_date, $end_date, $previous_start_date,$previous_end_date);
                break;
            case 'pdf':
               $content = View::make('admin.account_reports.profit_loss.comp_report', compact('pandl', 'start_date', 'end_date','previous_start_date', 'previous_end_date', 'DefaultCurrency'))->render();
                // Create an instance of the class:
                $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
                // Write some HTML code:
                $mpdf->WriteHTML($content);
                // Output a PDF file directly to the browser
                $mpdf->Output('ProfitNLossReport.pdf','D');

                break;
            default:
                return view('admin.account_reports.profit_loss.comp_report', compact('pandl', 'start_date', 'end_date','previous_start_date', 'previous_end_date', 'DefaultCurrency'));
                break;

         }*/
    }

    public function student_section_wise_strength(Request $request)
    {
        $company = Company::get();
        $session = school_session::get();
        return view('reports.academics.student_section_wise.index', compact('company', 'session'));
    }

    public function student_section_wise_strength_report(Request $request)
    {

    }

    public function student_tier_wise_strength(Request $request)
    {

    }

    public function student_tier_wise_strength_report(Request $request)
    {

    }

    public function yearly_class_comparison_report(Request $request)
    {

    }

    public function yearly_class_comparison_report_print(Request $request)
    {

    }

    public function yearly_strength_comparison_report(Request $request)
    {

    }

    public function yearly_strength_comparison_report_print(Request $request)
    {

    }


    public function sos_detail_report(Request $request)
    {
        $company = Company::get();
        $session = school_session::get();
        return view('reports.branch_performance.sos_report.index', compact('company', 'session'));
    }

    public function sos_detail_report_print(Request $request)
    {
        $from = $request['from'];
        $to = $request['to'];

        $user = Auth::user();

        $student = DB::table('students')
            ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
            ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
            ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
            ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->join('sections', 'sections.id', '=', 'active_session_sections.section_id')
            ->where('students.sos_status', 'InActive')
            ->where('students.admission_status', 'Regular')
            ->where('active_session_students.status', 0)
            ->where('active_sessions.session_id', $request->session_id)
            ->whereBetween('students.sos_date', [$from, $to])
            ->where(function ($query) use ($request) {
                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('boards.id', $request['boards']);
                }
                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('programs.id', $request['programs']);
                }
                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('classes.id', $request['classes']);
                }


            })
            ->select('guardian_details.guardian_first_name', 'guardian_details.guardian_last_name', 'guardian_details.guardian_mobile_1', 'students.home_phone', 'students.mobile_1', 'students.reg_no', 'students.reg_no as s_id', 'students.reg_date', 'students.home_phone', 'erp_branches.name as branch_name', 'students.sos_date', 'students.sos_comment', 'boards.name as board_name', 'programs.name as program_name', 'classes.name as class_name', 'intake.name as intake_name', 'students.first_name as first_name', 'students.last_name as last_name', 'students.date_of_birth', 'students.reg_date', 'students.mobile_1', 'students.first_due_date')
            ->get();
        return response()->json(['data' => $student]);
    }

    public function sos_summary_report(Request $request)
    {
        $company = Company::get();
        $session = school_session::get();
        return view('reports.branch_performance.branch_wise_summary_sos_report.index', compact('company', 'session'));
    }

    public function sos_summary_report_print(Request $request)
    {
        $from = $request['from'];
        $to = $request['to'];

        $user = Auth::user();

        $student = DB::table('students')
            ->join('erp_branches', 'erp_branches.id', '=', 'students.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('boards', 'boards.id', '=', 'students.board_id')
            ->join('programs', 'programs.id', '=', 'students.program_id')
            ->join('classes', 'classes.id', '=', 'students.class_id')
            ->where('students.sos_status', 'InActive')
            ->where('admission_status', 'Regular')
            ->where('students.session_id', $request->session_id)
            ->whereBetween('students.sos_date', [$from, $to])
            ->where(function ($query) use ($request) {
                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('boards.id', $request['boards']);
                }
                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('programs.id', $request['programs']);
                }
                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('classes.id', $request['classes']);
                }


            })
            ->groupBy('students.branch_id')
            ->groupby('erp_branches.name')
            ->select('erp_branches.name as branch_name', DB::Raw('count(students.branch_id) as strength'))
            ->get();
        return response()->json(['data' => $student]);
    }

    public function regular_student_report(Request $request)
    {
        $company = Company::get();
        $session = school_session::get();
        $branches = Branches::where('id', Auth::user()->branch_id)->get();

        return view('reports.branch_performance.regular_report.index', compact('company', 'session', 'branches'));
    }

    public function regular_student_report_print(Request $request)
    {
        $to = $request['to'];
        $from = $request['from'];

        $student = DB::table('students')
            ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
            ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
            ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
            ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->join('sections', 'sections.id', '=', 'active_session_sections.section_id')
            ->whereBetween('students.first_paid_date', [$from, $to])
            ->where('students.status', 'Active')
            ->where('students.academic_status', 'New Admission')
            ->where('students.admission_status', 'Regular')
            ->where('active_session_students.status', 1)
            //->where('students.registered_session',2)
            ->where('active_sessions.session_id', $request->session_id)
            ->where(function ($query) use ($request) {
                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('boards.id', $request['boards']);
                }
                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('programs.id', $request['programs']);
                }
                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('classes.id', $request['classes']);
                }
                if ($request['intake'] != null && $request['intake'] != "null") {
                    $query->where('intake.id', $request['intake']);
                }


            })
            ->select('guardian_details.guardian_first_name', 'guardian_details.guardian_last_name', 'students.first_paid_date', 'students.reg_date', 'students.home_phone', 'erp_branches.name as branch_name', 'boards.name as board_name', 'programs.name as program_name', 'classes.name as class_name', 'students.first_name as first_name', 'students.last_name as last_name', 'students.date_of_birth', 'students.reg_date', 'students.mobile_1', 'classes.name as class_name', 'students.reg_no as s_id', 'intake.name as intake_name')
            ->orderBy('classes.id', 'asc')
            ->get();
        return response()->json(['data' => $student]);

    }

    public function walkin_report(Request $request)
    {
        $company = Company::get();
        $session = school_session::get();
        $branches = Branches::where('id', Auth::user()->branch_id)->get();

        return view('reports.branch_performance.walkin_report.index', compact('company', 'session', 'branches'));
    }

    public function walkin_report_print(Request $request)
    {
        $from = $request['from'];
        $to = $request['to'];

        $user = Auth::user();

        $student = DB::table('students')
            ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
            ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
            ->join('erp_branches', 'erp_branches.id', '=', 'students.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('boards', 'boards.id', '=', 'students.board_id')
            ->join('programs', 'programs.id', '=', 'students.program_id')
            ->join('classes', 'classes.id', '=', 'students.class_id')
            ->join('intake', 'intake.id', '=', 'students.intake_id')
            ->where('students.status', 'Active')
            ->where('admission_status', 'Walkin')
            ->where('students.first_paid_date', '=', null)
            ->where('students.session_id', $request->session_id)
            ->whereBetween('students.first_due_date', [$from, $to])
            ->where(function ($query) use ($request) {
                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('boards.id', $request['boards']);
                }
                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('programs.id', $request['programs']);
                }
                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('classes.id', $request['classes']);
                }
                if ($request['intake'] != null && $request['intake'] != "null") {
                    $query->where('intake.id', $request['intake']);
                }


            })
            ->select('guardian_details.guardian_first_name', 'guardian_details.guardian_last_name', 'guardian_details.guardian_mobile_1', 'students.home_phone', 'students.mobile_1', 'students.reg_no', 'students.walkin_reg_no', 'students.reg_date', 'students.home_phone', 'erp_branches.name as branch_name', 'boards.name as board_name', 'programs.name as program_name', 'classes.name as class_name', 'students.first_name as first_name', 'students.last_name as last_name', 'students.date_of_birth', 'students.reg_date', 'students.mobile_1', 'students.first_due_date', 'intake.name as intake_name')
            ->get();
        return response()->json(['data' => $student]);

    }

    //Acadmic Reports
    public function student_contact_list(Request $request)
    {
        $company = Company::get();
        $session = school_session::get();
        return view('reports.academics.student_reports.student_contact_list.index', compact('company', 'session'));
    }

    public function student_contact_list_report(Request $request)
    {
        $student = Students::join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
            ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
            ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
            ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->join('addressinfos', 'addressinfos.students_id', '=', 'students.id')
            ->where('students.admission_status', 'Regular')
            ->where('active_sessions.session_id', $request->session_id)
            ->where('active_session_students.status', '=', 1)
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }

                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('boards.id', $request['boards']);
                }
                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('programs.id', $request['programs']);
                }
                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('classes.id', $request['classes']);
                }
                if ($request['intake'] != null && $request['intake'] != "null") {
                    $query->where('intake.id', $request['intake']);
                }
                if ($request['sections'] != null && $request['sections'] != "null") {
                    $query->where('sections.id', $request['sections']);
                }
            })
            ->orderby('erp_branches.id', 'asc')
            ->orderby('classes.id', 'asc')
            ->orderby('students.registered_session', 'desc')
            ->select('addressinfos.address', 'addressinfos.home_phone', 'addressinfos.mobile_1 as mob1', 'guardian_details.guardian_first_name', 'guardian_details.guardian_last_name', 'students.reg_no', 'students.registered_session', 'students.reg_date', 'students.extra_info', 'students.home_phone', 'erp_branches.name as branch_name', 'boards.name as board_name', 'programs.name as program_name', 'classes.name as class_name', 'students.first_name as first_name', 'students.gender as std_gender', 'students.middle_name as middle_name', 'students.last_name as last_name', 'students.date_of_birth', 'students.reg_date', 'students.mobile_1', 'intake.name as intake_name', 'guardian_details.guardian_mobile_1')
            ->get();


        return response()->json(['data' => $student]);
    }

    public function student_address_list(Request $request)
    {
        $company = Company::get();
        $session = school_session::get();
        return view('reports.academics.student_reports.student_address_list.index', compact('company', 'session'));
    }

    public function student_address_list_report(Request $request)
    {
        $student = Students::join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
            ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
            ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
            ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->join('addressinfos', 'addressinfos.students_id', '=', 'students.id')
            ->where('students.admission_status', 'Regular')
            ->where('active_sessions.session_id', $request->session_id)
            ->where('active_session_students.status', '=', 1)
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['city_id'] != null && $request['city_id'] != "null") {
                    $query->where('erp_branches.city_id', $request['city_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('boards.id', $request['boards']);
                }
                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('programs.id', $request['programs']);
                }
                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('classes.id', $request['classes']);
                }
                if ($request['intake'] != null && $request['intake'] != "null") {
                    $query->where('intake.id', $request['intake']);
                }
                if ($request['sections'] != null && $request['sections'] != "null") {
                    $query->where('sections.id', $request['sections']);
                }
            })
            ->orderby('erp_branches.id', 'asc')
            ->orderby('classes.id', 'asc')
            ->orderby('students.registered_session', 'desc')
            ->select('addressinfos.address', 'addressinfos.home_phone', 'addressinfos.mobile_1 as mob1', 'guardian_details.guardian_first_name', 'guardian_details.guardian_last_name', 'students.reg_no', 'students.registered_session', 'students.reg_date', 'students.extra_info', 'students.home_phone', 'erp_branches.name as branch_name', 'boards.name as board_name', 'programs.name as program_name', 'classes.name as class_name', 'students.first_name as first_name', 'students.gender as std_gender', 'students.middle_name as middle_name', 'students.last_name as last_name', 'students.date_of_birth', 'students.reg_date', 'students.mobile_1', 'intake.name as intake_name', 'guardian_details.guardian_mobile_1')
            ->get();


        return response()->json(['data' => $student]);
    }

    public function admitted_students_report(Request $request)
    {
        $company = Company::get();
        $branches = Branches::get();

        return view('reports.academics.student_reports.admitted_student.index', compact('company', 'branches'));
    }

    public function admitted_students_report_print(Request $request)
    {
        $student = Students::join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
            ->where('students.admission_status', 'Regular')
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }

                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }

                if ($request['start_date'] != null && $request['end_date'] != null) {
                    $query->whereBetween('students.reg_date', [$request['start_date'], $request['end_date']]);
                }
            })->select('erp_branches.name as branch_name', DB::raw('COUNT(students.id) as student_count'))
            ->groupBy('erp_branches.id')
            ->orderBy('erp_branches.id', 'asc')
            ->get();

        $branch = null;
        $date_range = null;

        if ($request['branch_id'] != null && $request['branch_id'] != '---Select---') {
            $branch = Branches::where('id', $request['branch_id'])->value('name');
        }

        if ($request['start_date'] != null && $request['end_date'] != null) {
            $date_range = $request['start_date'] . ' - ' . $request['end_date'];
        }

        $dataArray = [
            'date_range' => $date_range,
        ];

        if ($request->type == 'print') {
            $content = View::make('reports.academics.student_reports.admitted_student.pdf', compact('student', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('AdmittedStudentReport.pdf', 'D');
        } else {
            return response()->json(['data' => $student]);
        }

    }

    public function walk_in_students_report(Request $request)
    {
        $company = Company::get();
        $branches = Branches::get();

        return view('reports.academics.student_reports.walk_in_student.index', compact('company', 'branches'));
    }

    public function walk_in_students_report_print(Request $request)
    {
        $student = Students::join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
            ->where('students.status', 'Active')
            ->where('students.admission_status', 'Walkin')
            ->where('students.first_paid_date', '=', null)
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }

                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }

                if ($request['start_date'] != null && $request['end_date'] != null) {
                    $query->whereBetween('students.first_due_date', [$request['start_date'], $request['end_date']]);
                }
            })->select('erp_branches.name as branch_name', DB::raw('COUNT(students.id) as student_count'))
            ->groupBy('erp_branches.id')
            ->orderBy('erp_branches.id', 'asc')
            ->get();

        $branch = null;
        $date_range = null;

        if ($request['branch_id'] != null && $request['branch_id'] != '---Select---') {
            $branch = Branches::where('id', $request['branch_id'])->value('name');
        }

        if ($request['start_date'] != null && $request['end_date'] != null) {
            $date_range = $request['start_date'] . ' - ' . $request['end_date'];
        }

        $dataArray = [
            'date_range' => $date_range,
        ];

        if ($request->type == 'print') {
            $content = View::make('reports.academics.student_reports.walk_in_student.pdf', compact('student', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('AdmittedStudentReport.pdf', 'D');
        } else {
            return response()->json(['data' => $student]);
        }

    }


    public function nominal_report(Request $request)
    {
        $company = Company::get();
        $session = school_session::get();
        $branches = Branches::get();

        return view('reports.academics.student_reports.nominal.index', compact('company', 'session', 'branches'));
    }

    public function nominal_report_print(Request $request)
    {
        $student = Students::join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
            ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->where('students.admission_status', 'Regular')
            ->where('active_sessions.session_id', $request->session_id)
            ->where('active_session_students.status', '=', 1)
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['city_id'] != null && $request['city_id'] != "null") {
                    $query->where('erp_branches.city_id', $request['city_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('boards.id', $request['boards']);
                }
                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('programs.id', $request['programs']);
                }
                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('classes.id', $request['classes']);
                }
                if ($request['intake'] != null && $request['intake'] != "null") {
                    $query->where('intake.id', $request['intake']);
                }
                if ($request['sections'] != null && $request['sections'] != "null") {
                    $query->where('sections.id', $request['sections']);
                }
            })
            ->orderby('erp_branches.id', 'asc')
            ->orderby('classes.id', 'asc')
            ->orderby('students.registered_session', 'desc')
            ->select('students.reg_no', 'students.registered_session', 'students.reg_date', 'students.extra_info',
                'students.home_phone', 'erp_branches.name as branch_name', 'boards.name as board_name', 'programs.name as program_name',
                'classes.name as class_name', 'students.first_name as first_name', 'students.gender as std_gender',
                'students.middle_name as middle_name', 'students.last_name as last_name', 'students.date_of_birth', 'students.reg_date',
                'students.mobile_1', 'intake.name as intake_name', 'students.staff_ref as student_staff_ref')
            ->get();

        $branch = null;
        $board = null;
        $session = null;
        $program = null;
        $class = null;
        $company = null;
        $intake = null;

        if ($request['branch_id'] != null && $request['branch_id'] != '---Select---') {
            $branch = Branches::where('id', $request['branch_id'])->value('name');
        }

        if ($request['boards'] != null && $request['boards'] != "null") {
            $board = Board::where('id', $request['boards'])->value('name');
        }

        if ($request['company_id'] != null && $request['company_id'] != "null") {
            $company = Company::where('id', $request['company_id'])->value('name');
        }

        if ($request['programs'] != null && $request['programs'] != "null") {
            $program = Program::where('id', $request['programs'])->value('name');
        }

        if ($request['classes'] != null && $request['classes'] != "null") {
            $class = Classes::where('id', $request['classes'])->value('name');
        }

        if ($request['session_id'] != null && $request['session_id'] != "null") {
            $session = Session::where('id', $request['session_id'])->value('title');
        }

        if ($request['intake'] != null && $request['intake'] != "null") {
            $intake = InTake::where('id', $request['intake'])->value('name');
        }

        $dataArray = [
            'session' => $session,
            'company' => $company,
            'branch' => $branch,
            'board' => $board,
            'program' => $program,
            'class' => $class,
            'intake' => $intake,
        ];

        if ($request->type == 'print') {
            $content = View::make('reports.academics.student_reports.nominal.pdf', compact('student', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('NominalReport.pdf', 'D');
        } else {
            return response()->json(['data' => $student]);
        }

    }

    public function monthly_revenue_receivable_report(Request $request)
    {
        $session = school_session::get();
        $company = Company::get();
        $branches = Branches::get();
        $intake = Intake::get();
        return view('reports.fee.regular_fee.monthly_revenue.index', compact('branches', 'company', 'session', 'intake'));
    }

    public function monthly_revenue_receivable_report_print(Request $request)
    {
        $company_id = $request->company_id;
        $session_id = $request->session_id;
        $array = array();
        $balance = 0;

        $session_record = school_session::where('id', $session_id)->first();

        $query = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts , sum(previous_session_default_amount) as previous_default, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas_amount) as arreas,sum(total_amount) as revenue, sum(paid_amount) as recovered, erp_branches.name as branch_name')
            ->join('students', 'students.id', '=', 'fee_collections.students_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->where('fee_collections.session_id', '=', $session_id)
            ->where('fee_collections.due_date', '>=', $request->from)
            ->where('fee_collections.due_date', '<=', $request->to)
            ->where('cancel_voucher', 'No')
            ->where('admission_status', 'Regular')
            ->where(function ($query) use ($request) {
                if ($request->branch_id != null) {
                    foreach ($request->branch_id as $branch_list) {
                        $query->whereNotIn('erp_branches.id', [$branch_list]);
                    }
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->company_id != null) {
                    foreach ($request->company_id as $branch_list) {
                        $query->whereNotIn('company_id', [$branch_list]);
                    }
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->intake_id != 0) {
                    $query->where('fee_collections.intake_id', $request->intake_id);
                }
            })
            ->orderBy('erp_branches.company_id', 'ASC')
            ->groupBy('fee_collections.branch_id')
            ->groupBy('erp_companies.name')
            ->groupBy('erp_branches.name')
            ->get();
        // }

        $i = 0;

        foreach ($query as $key => $records) {


            $i++;

            $revenue = $records->revenue + $records->fines + $records->arreas + $records->previous_default;
            $recovered_amount = $records->recovered - $records->tax_amounts - $records->other_taxes;

            $default_amount = $revenue - $recovered_amount;
            $recoverd = $recovered_amount / $revenue;
            $recoverd = $recoverd * 100;
            $default_per = $default_amount / $revenue;
            $default_per = $default_per * 100;
            $array[] = array('previous_default' => number_format(ceil($records->previous_default), 0), 'company_name' => $records->company_name, 'default_per' => $default_per, 'id' => $i, 'branch' => $records->branch_name, 'revenue' => number_format(ceil($revenue), 0), 'recovered' => number_format(ceil($recovered_amount), 0), 'default_amount' => number_format(ceil($default_amount), 0), 'recovered_per' => $recoverd);
        }
        return response()->json(['data' => $array]);
    }

    public function strength_wise_annual_revenue_receivable_report(Request $request)
    {
        $session = school_session::get();
        $company = Company::get();
        $branches = Branches::get();
        $intake = Intake::get();
        return view('reports.fee.regular_fee.strength_wise_revenue_annual_receivable.index', compact('branches', 'company', 'session', 'intake'));
    }

    public function strength_wise_annual_revenue_receivable_report_print(Request $request)
    {
        $company_id = $request->company_id;
        $session_id = $request->session_id;
        $array = array();
        $balance = 0;

        $session_record = school_session::where('id', $session_id)->first();

        $query = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts , sum(previous_session_default_amount) as previous_default, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas_amount) as arreas,sum(total_amount) as revenue, sum(paid_amount) as recovered, erp_branches.name as branch_name,erp_branches.id as branch_id')
            ->join('students', 'students.id', '=', 'fee_collections.students_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->where('fee_collections.session_id', '=', $session_id)
            ->where('fee_collections.due_date', '>=', $session_record->start_year)
            ->where('fee_collections.due_date', '<=', $session_record->end_year)
            ->where('cancel_voucher', 'No')
            ->where('admission_status', 'Regular')
            ->where(function ($query) use ($request) {
                if ($request->branch_id != null) {
                    foreach ($request->branch_id as $branch_list) {
                        $query->whereNotIn('erp_branches.id', [$branch_list]);
                    }
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->company_id != null) {
                    foreach ($request->company_id as $branch_list) {
                        $query->whereNotIn('company_id', [$branch_list]);
                    }
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->intake_id != 0) {
                    $query->where('fee_collections.intake_id', $request->intake_id);
                }
            })
            ->orderBy('erp_branches.company_id', 'ASC')
            ->groupBy('fee_collections.branch_id')
            ->groupBy('erp_companies.name')
            ->groupBy('erp_branches.id')
            ->groupBy('erp_branches.name')
            ->get();
        // }

        $i = 0;

        foreach ($query as $key => $records) {

            $student = Students::join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                ->where('active_sessions.session_id', $session_id)
                ->where('students.admission_status', 'Regular')
                ->where('active_sessions.branch_id', $records->branch_id)
                ->where('active_session_students.status', 1)
                ->count();

            $i++;

            $revenue = $records->revenue + $records->fines + $records->arreas + $records->previous_default;
            $recovered_amount = $records->recovered - $records->tax_amounts - $records->other_taxes;

            $default_amount = $revenue - $recovered_amount;
            $recoverd = $recovered_amount / $revenue;
            $recoverd = $recoverd * 100;
            $default_per = $default_amount / $revenue;
            $default_per = $default_per * 100;
            $array[] = array('strength' => $student, 'previous_default' => number_format(ceil($records->previous_default), 0), 'company_name' => $records->company_name, 'default_per' => $default_per, 'id' => $i, 'branch' => $records->branch_name, 'revenue' => number_format(ceil($revenue), 0), 'recovered' => number_format(ceil($recovered_amount), 0), 'default_amount' => number_format(ceil($default_amount), 0), 'recovered_per' => $recoverd);
        }
        return response()->json(['data' => $array]);
    }

    public function annual_revenue_receivable_report(Request $request)
    {
        $session = school_session::get();
        $company = Company::get();
        $branches = Branches::get();
        $intake = Intake::get();
        return view('reports.fee.regular_fee.annual_revenue.index', compact('branches', 'company', 'session', 'intake'));

    }

    public function annual_revenue_receivable_report_print(Request $request)
    {
        $company_id = $request->company_id;
        $session_id = $request->session_id;
        $array = array();
        $balance = 0;

        $session_record = school_session::where('id', $session_id)->first();

        $query = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts , sum(previous_session_default_amount) as previous_default, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas_amount) as arreas,sum(total_amount) as revenue, sum(paid_amount) as recovered, erp_branches.name as branch_name')
            ->join('students', 'students.id', '=', 'fee_collections.students_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->where('fee_collections.session_id', '=', $session_id)
            ->where('fee_collections.due_date', '>=', $session_record->start_year)
            ->where('fee_collections.due_date', '<=', $session_record->end_year)
            ->where('cancel_voucher', 'No')
            ->where('admission_status', 'Regular')
            ->where(function ($query) use ($request) {
                if ($request->branch_id != null) {
                    foreach ($request->branch_id as $branch_list) {
                        $query->whereNotIn('erp_branches.id', [$branch_list]);
                    }
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->company_id != null) {
                    foreach ($request->company_id as $branch_list) {
                        $query->whereNotIn('company_id', [$branch_list]);
                    }
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->intake_id != 0) {
                    $query->where('fee_collections.intake_id', $request->intake_id);
                }
            })
            ->orderBy('erp_branches.company_id', 'ASC')
            ->groupBy('fee_collections.branch_id')
            ->groupBy('erp_companies.name')
            ->groupBy('erp_branches.name')
            ->get();
        // }

        $i = 0;

        foreach ($query as $key => $records) {


            $i++;

            $revenue = $records->revenue + $records->fines + $records->arreas + $records->previous_default;
            $recovered_amount = $records->recovered - $records->tax_amounts - $records->other_taxes;

            $default_amount = $revenue - $recovered_amount;
            $recoverd = $recovered_amount / $revenue;
            $recoverd = $recoverd * 100;
            $default_per = $default_amount / $revenue;
            $default_per = $default_per * 100;
            $array[] = array('previous_default' => number_format(ceil($records->previous_default), 0), 'company_name' => $records->company_name, 'default_per' => $default_per, 'id' => $i, 'branch' => $records->branch_name, 'revenue' => number_format(ceil($revenue), 0), 'recovered' => number_format(ceil($recovered_amount), 0), 'default_amount' => number_format(ceil($default_amount), 0), 'recovered_per' => $recoverd);
        }
        return response()->json(['data' => $array]);
    }

    public function staff_gross_salary_report(Request $request)
    {
        $branches = Branches::get();
        return view('reports.hr.salary.current_salary_report.index', compact('branches'));
    }

    public function staff_gross_salary_report_print(Request $request)
    {
        $data = Staff::join('staff_branches', 'staff_branches.staff_id', '=', 'staff.id')
            ->leftjoin('staff_type', 'staff_type.id', '=', 'staff.staff_type_id')
            ->where('gross_salary_amount', '>', 0)
            ->where('staff_branches.branch_id', $request->branch_id)
            ->where('staff.branch_id', $request->branch_id)
            ->where('status', 'Active')
            ->get();

        return response()->json(['data' => $data]);
    }

    public function salary_comparison_report(Request $request)
    {
        $branches = Branches::get();
        return view('reports.hr.salary.salary_increment_comparison.index', compact('branches'));
    }

    public function salary_comparison_report_print(Request $request)
    {

        $month = explode("-", $request->previous_month);
        $month_id = ltrim($month[1], "0");
        $year_id = ltrim($month[0], "0");
        $month_current = explode("-", $request->current_month);
        $month_id_current = ltrim($month_current[1], "0");
        $year_id_current = $month_current[0];
        $data = StaffSalaries::join('staff', 'staff.id', '=', 'erp_staff_salaries.staff_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'erp_staff_salaries.branch_id')
            ->where('erp_staff_salaries.branch_id', $request->branch_id)
            ->where('month_id', $month_id)
            ->where('year_id', $year_id)
            ->select('erp_staff_salaries.*', 'staff.first_name', 'staff.last_name', 'erp_branches.name')
            ->get();
        $array = array();

        foreach ($data as $dt) {

            $current = StaffSalaries::join('staff', 'staff.id', '=', 'erp_staff_salaries.staff_id')
                ->where('month_id', $month_id_current)
                ->where('year_id', $year_id_current)
                ->where('erp_staff_salaries.branch_id', $request->branch_id)
                ->where('erp_staff_salaries.staff_id', $dt->staff_id)
                ->first();
            if ($current != null) {
                if ($current->gross_salary == $dt->gross_salary) {

                } else {
                    $array[] = array('name' => $dt->name, 'staff_name' => $dt->first_name . ' ' . $dt->last_name, 'previous_salary' => $dt->gross_salary, 'current_salary' => $current->gross_salary);
                }
            }
        }

        return response()->json(['data' => $array]);
    }

    public function subject_wise_bill_detail_report(Request $request)
    {
        $session = school_session::get();
        $branches = Branches::get();
        $coursetype = CourseType::get();
        return view('reports.fee.cambridge_fee.subject_wise_bill_detail.index', compact('branches', 'session', 'coursetype'));

    }

    public function subject_wise_bill_detail_report_print(Request $request)
    {

        $subject = SubjectFeeMaster::join('subject_fee_details', 'subject_fee_details.subject_fee_master_id', '=', 'subject_fee_master.subject_fee_id')
            ->join('students', 'students.id', '=', 'subject_fee_master.student_id')
            ->join('course_types', 'course_types.id', 'subject_fee_master.type')
            ->join('erp_branches', 'erp_branches.id', '=', 'subject_fee_master.branch_id')
            ->join('courses', 'courses.id', '=', 'subject_fee_details.subject_id')
            ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->where('subject_fee_master.session_id', $request->session_id)
            ->where('active_sessions.session_id', $request->session_id)
            ->where('active_session_students.status', 1)
            ->where('subject_fee_master.status', 'Paid')
            ->whereBetween('due_date', [$request->from, $request->to])
            ->where(function ($query) use ($request) {
                if ($request->branch_id != null) {
                    foreach ($request->branch_id as $branch_list) {
                        $query->whereNotIn('erp_branches.id', [$branch_list]);
                    }
                }
                if ($request->exam_session != null && $request->exam_session != "null") {

                    $query->where('subject_fee_master.session_details', $request->exam_session);

                }
            })
            ->select('students.*', 'courses.*', 'subject_fee_master.*', 'subject_fee_details.*', 'classes.name as class_name')
            ->get();
        return response()->json(['data' => $subject]);
    }

    public function revenue_separation_report(Request $request)
    {
        $sessions = Session::SessionList();
//        $companies = Company::CompanyList();
        $fee_heads = ErpFeeHead::get();
        $company = Company::get();

        return view('reports.revenue_report.index', compact('fee_heads', 'company', 'sessions'));
    }

    public function revenue_separation_report_print(Request $request)
    {
        $session_record = Session::where('id', $request->session_id)->first();
        $company_id = $request->company_id;
        $session_id = $request->session_id;
        $array = array();
        $branch_name;
        $balance = 0;

        if ($request->fee_head == 0) {
            $query = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts ,classes.id as class_id,classes.name as class_name, tier.id as tier_list_id,tier.name as tier_name, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas_amount) as arreas,sum(total_amount) as revenue, sum(paid_amount) as recovered, fee_collections.*, erp_branches.name as branch_name,programs.name as program_name,programs.id as program_id')
                ->join('students', 'students.id', '=', 'fee_collections.students_id')
                ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
                ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                ->join('programs', 'programs.id', '=', 'fee_collections.program_id')
                ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
                ->join('tier', 'tier.id', '=', 'programs.tier_id')
                ->where('fee_collections.session_id', '=', $session_id)
                ->where('erp_branches.company_id', $company_id)
                ->where('erp_branches.id', $request->branch_id)
                ->where('due_date', '>=', $session_record->start_year)
                ->where('due_date', '<=', $session_record->end_year)
                ->where('cancel_voucher', 'No')
                ->where(function ($query) use ($request) {


                    if ($request['fee_status'] != 0 && $request['fee_status'] != "0") {
                        $query->where('fee_collections.fee_status', $request['fee_status']);
                    }
                })
                // ->groupBy('tier.id')

                ->where('admission_status', 'Regular')
                ->orderBy('tier.id', 'ASC')
                ->groupBy('tier.id')
                ->groupBy('classes.id')
                ->get();
            //  dd($query);
            $i = 0;

            foreach ($query as $key => $records) {

                $total_strength = DB::table('students')
                    ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                    ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                    ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                    ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                    ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                    ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                    ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                    ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                    ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('students.status', 'Active')
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('active_sessions.class_id', $records->class_id)
                    ->where('students.admission_status', 'Regular')
                    ->where('students.sos_status', '!=', 'InActive')
                    ->groupBy('tier.id')
                    ->where('active_sessions.session_id', $session_id)
                    ->where('active_session_students.status', 1)
                    ->count();

                $new_admission_count = DB::table('students')
                    ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                    ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                    ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                    ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                    ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                    ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                    ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                    ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                    ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('students.status', 'Active')
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('active_sessions.class_id', $records->class_id)
                    ->where('students.admission_status', 'Regular')
                    ->where('students.sos_status', '!=', 'InActive')
                    ->groupBy('tier.id')
                    ->where('active_sessions.session_id', $session_id)
                    ->where('active_session_students.status', 1)
                    ->where('registered_session', 2)
                    ->count();
                $staff_reference = DB::table('students')
                    ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                    ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                    ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                    ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                    ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                    ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                    ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                    ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                    ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('students.status', 'Active')
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('active_sessions.class_id', $records->class_id)
                    ->where('students.admission_status', 'Regular')
                    ->where('students.sos_status', '!=', 'InActive')
                    ->where('staff_ref', '=', 'Yes')
                    ->groupBy('tier.id')
                    ->where('active_sessions.session_id', $session_id)
                    ->where('active_session_students.status', 1)
                    //    ->where('registered_session',1)
                    ->count();
                $staff_reference_amount = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts ,classes.id as class_id,classes.name as class_name, tier.id as tier_list_id,tier.name as tier_name, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas_amount) as arreas,sum(total_amount) as revenue, sum(paid_amount) as recovered, fee_collections.*, erp_branches.name as branch_name,programs.name as program_name,programs.id as program_id')
                    ->join('students', 'students.id', '=', 'fee_collections.students_id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('programs', 'programs.id', '=', 'fee_collections.program_id')
                    ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('fee_collections.session_id', '=', $session_id)
                    ->where('erp_branches.company_id', $company_id)
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('due_date', '>=', $session_record->start_year)
                    ->where('due_date', '<=', $session_record->end_year)
                    ->where('fee_collections.class_id', $records->class_id)
                    ->where('cancel_voucher', 'No')
                    ->where(function ($query) use ($request) {


                        if ($request['fee_status'] != 0 && $request['fee_status'] != "0") {
                            $query->where('fee_collections.fee_status', $request['fee_status']);
                        }
                    })
                    // ->groupBy('tier.id')
                    ->where('students.sos_status', '!=', 'InActive')
                    ->where('staff_ref', '=', 'Yes')
                    ->where('admission_status', 'Regular')
                    ->orderBy('tier.id', 'ASC')
                    // ->where('registered_session',1)
                    ->groupBy('tier.id')
                    ->groupBy('classes.id')
                    ->get();
                $staff_reference_amountss = 0;
                foreach ($staff_reference_amount as $staff_reference_amounts) {
                    $staff_reference_amountss = $staff_reference_amounts->revenue + $staff_reference_amounts->fines + $staff_reference_amounts->arreas;
                }


                $new_admission_amount = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts ,classes.id as class_id,classes.name as class_name, tier.id as tier_list_id,tier.name as tier_name, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas_amount) as arreas,sum(total_amount) as revenue, sum(paid_amount) as recovered, fee_collections.*, erp_branches.name as branch_name,programs.name as program_name,programs.id as program_id')
                    ->join('students', 'students.id', '=', 'fee_collections.students_id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('programs', 'programs.id', '=', 'fee_collections.program_id')
                    ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('fee_collections.session_id', '=', $session_id)
                    ->where('erp_branches.company_id', $company_id)
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('due_date', '>=', $session_record->start_year)
                    ->where('due_date', '<=', $session_record->end_year)
                    ->where('fee_collections.class_id', $records->class_id)
                    ->where('cancel_voucher', 'No')
                    // ->groupBy('tier.id')
                    ->where('students.sos_status', '!=', 'InActive')
                    ->where('admission_status', 'Regular')
                    ->orderBy('tier.id', 'ASC')
                    ->where(function ($query) use ($request) {


                        if ($request['fee_status'] != 0 && $request['fee_status'] != "0") {
                            $query->where('fee_collections.fee_status', $request['fee_status']);
                        }
                    })
                    ->where('registered_session', 2)
                    ->groupBy('tier.id')
                    ->groupBy('classes.id')
                    ->get();
                $new_admission_amountss = 0;
                foreach ($new_admission_amount as $new_admission_amounts) {
                    $new_admission_amountss = $new_admission_amounts->revenue + $new_admission_amounts->fines + $new_admission_amounts->arreas;
                }


                $total_strength_sos = DB::table('students')
                    ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                    ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                    ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                    ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                    ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                    ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                    ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                    ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                    ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('students.status', 'Active')
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('active_sessions.class_id', $records->class_id)
                    ->where('students.admission_status', 'Regular')
                    ->where('students.sos_status', '=', 'InActive')
                    ->groupBy('tier.id')
                    ->where('active_sessions.session_id', $session_id)
                    ->where('active_session_students.status', 0)
                    ->count();


                $query_sos_amount = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts ,classes.id as class_id,classes.name as class_name, tier.id as tier_list_id,tier.name as tier_name, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas_amount) as arreas,sum(total_amount) as revenue, sum(paid_amount) as recovered, fee_collections.*, erp_branches.name as branch_name,programs.name as program_name,programs.id as program_id')
                    ->join('students', 'students.id', '=', 'fee_collections.students_id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('programs', 'programs.id', '=', 'fee_collections.program_id')
                    ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('fee_collections.session_id', '=', $session_id)
                    ->where('erp_branches.company_id', $company_id)
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('due_date', '>=', $session_record->start_year)
                    ->where('due_date', '<=', $session_record->end_year)
                    ->where('fee_collections.class_id', $records->class_id)
                    ->where('cancel_voucher', 'No')
                    // ->groupBy('tier.id')
                    ->where(function ($query) use ($request) {


                        if ($request['fee_status'] != 0 && $request['fee_status'] != "0") {
                            $query->where('fee_collections.fee_status', $request['fee_status']);
                        }
                    })
                    ->where('students.sos_status', '=', 'InActive')
                    ->where('admission_status', 'Regular')
                    ->orderBy('tier.id', 'ASC')
                    ->groupBy('tier.id')
                    ->groupBy('classes.id')
                    ->get();
                //   dd($query_sos_amount);
                $revenue1 = 0;
                foreach ($query_sos_amount as $query_sos) {
                    $revenue1 = $query_sos->revenue + $query_sos->fines + $query_sos->arreas;
                }
                $pass_out = 0;
                $passout_amount = 0;
                if ($records->class_id == 24 || $records->class_id == 26 || $records->class_id == 32 || $records->class_id == 36 || $records->class_id == 38 || $records->class_id == 130 || $records->class_id == 104 || $records->class_id == 105 || $records->class_id == 106 || $records->class_id == 107 || $records->class_id == 108 || $records->class_id == 111 || $records->class_id == 115 || $records->class_id == 116 || $records->class_id == 117 || $records->class_id == 120 || $records->class_id == 123 || $records->class_id == 102 || $records->class_id == 101 || $records->class_id == 100 || $records->class_id == 99 || $records->class_id == 96 || $records->class_id == 97 || $records->class_id == 98 || $records->class_id == 95 || $records->class_id == 92 || $records->class_id == 81 || $records->class_id == 79 || $records->class_id == 78 || $records->class_id == 75 || $records->class_id == 72 || $records->class_id == 69 || $records->class_id == 66 || $records->class_id == 63 || $records->class_id == 60 || $records->class_id == 56 || $records->class_id == 54 || $records->class_id == 55 || $records->class_id == 47 || $records->class_id == 50 || $records->class_id == 51 || $records->class_id == 41 || $records->class_id == 44) {

                    $pass_out = DB::table('students')
                        ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                        ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                        ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                        ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                        ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                        ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                        ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                        ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                        ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                        ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                        ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                        ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                        ->join('tier', 'tier.id', '=', 'programs.tier_id')
                        ->where('students.status', 'Active')
                        ->where('erp_branches.id', $request->branch_id)
                        ->where('tier.id', $records->tier_list_id)
                        ->where('active_sessions.class_id', $records->class_id)
                        ->where('students.admission_status', 'Regular')
                        ->where('students.sos_status', '!=', 'InActive')
                        ->groupBy('tier.id')
                        ->where('active_sessions.session_id', $session_id)
                        ->where('active_session_students.status', 1)
                        ->where('registered_session', 1)
                        ->count();
                    $pass_out_total_amount = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts ,classes.id as class_id,classes.name as class_name, tier.id as tier_list_id,tier.name as tier_name, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas_amount) as arreas,sum(total_amount) as revenue, sum(paid_amount) as recovered, fee_collections.*, erp_branches.name as branch_name,programs.name as program_name,programs.id as program_id')
                        ->join('students', 'students.id', '=', 'fee_collections.students_id')
                        ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
                        ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                        ->join('programs', 'programs.id', '=', 'fee_collections.program_id')
                        ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
                        ->join('tier', 'tier.id', '=', 'programs.tier_id')
                        ->where('fee_collections.session_id', '=', $session_id)
                        ->where('erp_branches.company_id', $company_id)
                        ->where('erp_branches.id', $request->branch_id)
                        ->where('tier.id', $records->tier_list_id)
                        ->where('due_date', '>=', $session_record->start_year)
                        ->where('due_date', '<=', $session_record->end_year)
                        ->where('fee_collections.class_id', $records->class_id)
                        ->where('cancel_voucher', 'No')
                        // ->groupBy('tier.id')
                        ->where(function ($query) use ($request) {


                            if ($request['fee_status'] != 0 && $request['fee_status'] != "0") {
                                $query->where('fee_collections.fee_status', $request['fee_status']);
                            }
                        })
                        ->where('students.sos_status', '!=', 'InActive')
                        ->where('admission_status', 'Regular')
                        ->orderBy('tier.id', 'ASC')
                        ->groupBy('tier.id')
                        ->where('registered_session', 1)
                        ->groupBy('classes.id')
                        ->get();
                    //   dd($query_sos_amount);
                    foreach ($pass_out_total_amount as $query_soss) {
                        $passout_amount = $query_soss->revenue + $query_soss->fines + $query_soss->arreas;
                    }
                }


                $i++;

                $revenue = $records->revenue + $records->fines + $records->arreas;
                $recovered_amount = 0;
                $default_amount = $revenue - $recovered_amount;
                $recoverd = $recovered_amount / $revenue;
                $recoverd = $recoverd * 100;
                $default_per = $default_amount / $revenue;
                $default_per = $default_per * 100;
                $array[] = array('staff_reference_amount' => $staff_reference_amountss, 'staff_reference' => $staff_reference, 'new_admission_amount' => $new_admission_amountss, 'new_admission' => $new_admission_count, 'pass_out' => $pass_out, 'passout_amount' => $passout_amount, 'sos_amount' => $revenue1, 'total_strength_sos' => $total_strength_sos, 'class_name' => $records->class_name, 'program_id' => $records->tier_list_id, 'total' => $total_strength, 'program_name' => $records->tier_name, 'company_name' => $records->company_name, 'default_per' => $default_per, 'id' => $i, 'branch' => $records->branch_name, 'revenue' => $revenue, 'recovered' => number_format(ceil($recovered_amount), 0), 'default_amount' => number_format(ceil($default_amount), 0), 'recovered_per' => $recoverd);
            }
        } else {
            $query = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts ,classes.id as class_id,classes.name as class_name, tier.id as tier_list_id,tier.name as tier_name, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas) as arreas,sum(amount) as revenue, sum(paid_amount) as recovered, erp_branches.name as branch_name,programs.name as program_name,programs.id as program_id')
                ->join('students', 'students.id', '=', 'fee_collections.students_id')
                ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
                ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                ->join('programs', 'programs.id', '=', 'fee_collections.program_id')
                ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
                ->join('tier', 'tier.id', '=', 'programs.tier_id')
                ->join('fee_collection_detail', 'fee_collection_detail.fc_id', '=', 'fee_collections.id')
                ->where('fee_collections.session_id', '=', $session_id)
                ->where('erp_branches.company_id', $company_id)
                ->where(function ($query) use ($request) {


                    if ($request['fee_status'] != 0 && $request['fee_status'] != "0") {
                        $query->where('fee_collections.fee_status', $request['fee_status']);
                    }
                })
                ->where('erp_branches.id', $request->branch_id)
                ->where('fee_collection_detail.erp_fee_head_id_direct', $request->fee_head)
                ->where('due_date', '>=', $session_record->start_year)
                ->where('due_date', '<=', $session_record->end_year)
                ->where('cancel_voucher', 'No')
                // ->groupBy('tier.id')

                ->where('admission_status', 'Regular')
                ->orderBy('tier.id', 'ASC')
                ->groupBy('tier.id')
                ->groupBy('classes.id')
                ->get();

            $i = 0;

            foreach ($query as $key => $records) {

                $total_strength = DB::table('students')
                    ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                    ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                    ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                    ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                    ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                    ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                    ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                    ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                    ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('students.status', 'Active')
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('active_sessions.class_id', $records->class_id)
                    ->where('students.admission_status', 'Regular')
                    ->where('students.sos_status', '!=', 'InActive')
                    ->groupBy('tier.id')
                    ->where('active_sessions.session_id', $session_id)
                    ->where('active_session_students.status', 1)
                    ->count();

                $new_admission_count = DB::table('students')
                    ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                    ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                    ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                    ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                    ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                    ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                    ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                    ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                    ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('students.status', 'Active')
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('active_sessions.class_id', $records->class_id)
                    ->where('students.admission_status', 'Regular')
                    ->where('students.sos_status', '!=', 'InActive')
                    ->groupBy('tier.id')
                    ->where('active_sessions.session_id', $session_id)
                    ->where('active_session_students.status', 1)
                    ->where('registered_session', 2)
                    ->count();
                $staff_reference = DB::table('students')
                    ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                    ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                    ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                    ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                    ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                    ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                    ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                    ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                    ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('students.status', 'Active')
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('active_sessions.class_id', $records->class_id)
                    ->where('students.admission_status', 'Regular')
                    ->where('students.sos_status', '!=', 'InActive')
                    ->where('staff_ref', '=', 'Yes')
                    ->groupBy('tier.id')
                    ->where('active_sessions.session_id', $session_id)
                    ->where('active_session_students.status', 1)
                    //    ->where('registered_session',1)
                    ->count();
                $staff_reference_amount = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts ,classes.id as class_id,classes.name as class_name, tier.id as tier_list_id,tier.name as tier_name, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas) as arreas,sum(amount) as revenue, sum(paid_amount) as recovered, erp_branches.name as branch_name,programs.name as program_name,programs.id as program_id')
                    ->join('students', 'students.id', '=', 'fee_collections.students_id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('programs', 'programs.id', '=', 'fee_collections.program_id')
                    ->join('fee_collection_detail', 'fee_collection_detail.fc_id', '=', 'fee_collections.id')
                    ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('fee_collections.session_id', '=', $session_id)
                    ->where('erp_branches.company_id', $company_id)
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where(function ($query) use ($request) {


                        if ($request['fee_status'] != 0 && $request['fee_status'] != "0") {
                            $query->where('fee_collections.fee_status', $request['fee_status']);
                        }
                    })
                    ->where('due_date', '>=', $session_record->start_year)
                    ->where('due_date', '<=', $session_record->end_year)
                    ->where('fee_collections.class_id', $records->class_id)
                    ->where('fee_collection_detail.erp_fee_head_id_direct', $request->fee_head)
                    ->where('cancel_voucher', 'No')
                    // ->groupBy('tier.id')
                    ->where('students.sos_status', '!=', 'InActive')
                    ->where('staff_ref', '=', 'Yes')
                    ->where('admission_status', 'Regular')
                    ->orderBy('tier.id', 'ASC')
                    // ->where('registered_session',1)
                    ->groupBy('tier.id')
                    ->groupBy('classes.id')
                    ->get();
                $staff_reference_amountss = 0;
                foreach ($staff_reference_amount as $staff_reference_amounts) {
                    $staff_reference_amountss = $staff_reference_amounts->revenue + $staff_reference_amounts->fines + $staff_reference_amounts->arreas;
                }


                $new_admission_amount = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts ,classes.id as class_id,classes.name as class_name, tier.id as tier_list_id,tier.name as tier_name, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas) as arreas,sum(amount) as revenue, sum(paid_amount) as recovered, erp_branches.name as branch_name,programs.name as program_name,programs.id as program_id')
                    ->join('students', 'students.id', '=', 'fee_collections.students_id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('programs', 'programs.id', '=', 'fee_collections.program_id')
                    ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
                    ->join('fee_collection_detail', 'fee_collection_detail.fc_id', '=', 'fee_collections.id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('fee_collections.session_id', '=', $session_id)
                    ->where('erp_branches.company_id', $company_id)
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('due_date', '>=', $session_record->start_year)
                    ->where('due_date', '<=', $session_record->end_year)
                    ->where('fee_collections.class_id', $records->class_id)
                    ->where('fee_collection_detail.erp_fee_head_id_direct', $request->fee_head)
                    ->where('cancel_voucher', 'No')
                    ->where(function ($query) use ($request) {


                        if ($request['fee_status'] != 0 && $request['fee_status'] != "0") {
                            $query->where('fee_collections.fee_status', $request['fee_status']);
                        }
                    })
                    // ->groupBy('tier.id')
                    ->where('students.sos_status', '!=', 'InActive')
                    ->where('admission_status', 'Regular')
                    ->orderBy('tier.id', 'ASC')
                    ->where('registered_session', 2)
                    ->groupBy('tier.id')
                    ->groupBy('classes.id')
                    ->get();
                $new_admission_amountss = 0;
                foreach ($new_admission_amount as $new_admission_amounts) {
                    $new_admission_amountss = $new_admission_amounts->revenue + $new_admission_amounts->fines + $new_admission_amounts->arreas;
                }


                $total_strength_sos = DB::table('students')
                    ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                    ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                    ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                    ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                    ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                    ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                    ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                    ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                    ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('students.status', 'Active')
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('active_sessions.class_id', $records->class_id)
                    ->where('students.admission_status', 'Regular')
                    ->where('students.sos_status', '=', 'InActive')
                    ->groupBy('tier.id')
                    ->where('active_sessions.session_id', $session_id)
                    ->where('active_session_students.status', 1)
                    ->count();


                $query_sos_amount = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts ,classes.id as class_id,classes.name as class_name, tier.id as tier_list_id,tier.name as tier_name, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas) as arreas,sum(amount) as revenue, sum(paid_amount) as recovered, erp_branches.name as branch_name,programs.name as program_name,programs.id as program_id')
                    ->join('students', 'students.id', '=', 'fee_collections.students_id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('programs', 'programs.id', '=', 'fee_collections.program_id')
                    ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->join('fee_collection_detail', 'fee_collection_detail.fc_id', '=', 'fee_collections.id')
                    ->where('fee_collections.session_id', '=', $session_id)
                    ->where('erp_branches.company_id', $company_id)
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('due_date', '>=', $session_record->start_year)
                    ->where('due_date', '<=', $session_record->end_year)
                    ->where('fee_collections.class_id', $records->class_id)
                    ->where('fee_collection_detail.erp_fee_head_id_direct', $request->fee_head)
                    ->where('cancel_voucher', 'No')
                    ->where(function ($query) use ($request) {


                        if ($request['fee_status'] != 0 && $request['fee_status'] != "0") {
                            $query->where('fee_collections.fee_status', $request['fee_status']);
                        }
                    })
                    // ->groupBy('tier.id')
                    ->where('students.sos_status', '=', 'InActive')
                    ->where('admission_status', 'Regular')
                    ->orderBy('tier.id', 'ASC')
                    ->groupBy('tier.id')
                    ->groupBy('classes.id')
                    ->get();
                //   dd($query_sos_amount);
                $revenue1 = 0;
                foreach ($query_sos_amount as $query_sos) {
                    $revenue1 = $query_sos->revenue + $query_sos->fines + $query_sos->arreas;
                }
                $pass_out = 0;
                $passout_amount = 0;
                if ($records->class_id == 24 || $records->class_id == 26 || $records->class_id == 32 || $records->class_id == 36 || $records->class_id == 38 || $records->class_id == 130 || $records->class_id == 104 || $records->class_id == 105 || $records->class_id == 106 || $records->class_id == 107 || $records->class_id == 108 || $records->class_id == 111 || $records->class_id == 115 || $records->class_id == 116 || $records->class_id == 117 || $records->class_id == 120 || $records->class_id == 123 || $records->class_id == 102 || $records->class_id == 101 || $records->class_id == 100 || $records->class_id == 99 || $records->class_id == 96 || $records->class_id == 97 || $records->class_id == 98 || $records->class_id == 95 || $records->class_id == 92 || $records->class_id == 81 || $records->class_id == 79 || $records->class_id == 78 || $records->class_id == 75 || $records->class_id == 72 || $records->class_id == 69 || $records->class_id == 66 || $records->class_id == 63 || $records->class_id == 60 || $records->class_id == 56 || $records->class_id == 54 || $records->class_id == 55 || $records->class_id == 47 || $records->class_id == 50 || $records->class_id == 51 || $records->class_id == 41 || $records->class_id == 44) {
                    $pass_out = DB::table('students')
                        ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                        ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                        ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                        ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                        ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                        ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                        ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                        ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                        ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                        ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                        ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                        ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                        ->join('tier', 'tier.id', '=', 'programs.tier_id')
                        ->where('students.status', 'Active')
                        ->where('erp_branches.id', $request->branch_id)
                        ->where('tier.id', $records->tier_list_id)
                        ->where('active_sessions.class_id', $records->class_id)
                        ->where('students.admission_status', 'Regular')
                        ->where('students.sos_status', '!=', 'InActive')
                        ->groupBy('tier.id')
                        ->where('active_sessions.session_id', $session_id)
                        ->where('active_session_students.status', 1)
                        ->where('registered_session', 1)
                        ->count();
                    $pass_out_total_amount = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts ,classes.id as class_id,classes.name as class_name, tier.id as tier_list_id,tier.name as tier_name, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas) as arreas,sum(amount) as revenue, sum(paid_amount) as recovered, erp_branches.name as branch_name,programs.name as program_name,programs.id as program_id')
                        ->join('students', 'students.id', '=', 'fee_collections.students_id')
                        ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
                        ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                        ->join('programs', 'programs.id', '=', 'fee_collections.program_id')
                        ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
                        ->join('tier', 'tier.id', '=', 'programs.tier_id')
                        ->join('fee_collection_detail', 'fee_collection_detail.fc_id', '=', 'fee_collections.id')
                        ->where('fee_collections.session_id', '=', $session_id)
                        ->where('fee_collection_detail.erp_fee_head_id_direct', $request->fee_head)
                        ->where('erp_branches.company_id', $company_id)
                        ->where('erp_branches.id', $request->branch_id)
                        ->where('tier.id', $records->tier_list_id)
                        ->where('due_date', '>=', $session_record->start_year)
                        ->where('due_date', '<=', $session_record->end_year)
                        ->where('fee_collections.class_id', $records->class_id)
                        ->where('cancel_voucher', 'No')
                        // ->groupBy('tier.id')
                        ->where(function ($query) use ($request) {


                            if ($request['fee_status'] != 0 && $request['fee_status'] != "0") {
                                $query->where('fee_collections.fee_status', $request['fee_status']);
                            }
                        })
                        ->where('students.sos_status', '!=', 'InActive')
                        ->where('admission_status', 'Regular')
                        ->orderBy('tier.id', 'ASC')
                        ->groupBy('tier.id')
                        ->where('registered_session', 1)
                        ->groupBy('classes.id')
                        ->get();
                    //   dd($query_sos_amount);
                    foreach ($pass_out_total_amount as $query_soss) {
                        $passout_amount = $query_soss->revenue + $query_soss->fines + $query_soss->arreas;
                    }
                }


                $i++;

                $revenue = $records->revenue + $records->fines + $records->arreas;
                $recovered_amount = 0;
                if ($revenue == 0) {
                    $revenue = 1;
                }
                $default_amount = $revenue - $recovered_amount;
                $recoverd = $recovered_amount / $revenue;
                $recoverd = $recoverd * 100;
                $default_per = $default_amount / $revenue;
                $default_per = $default_per * 100;
                $array[] = array('staff_reference_amount' => $staff_reference_amountss, 'staff_reference' => $staff_reference, 'new_admission_amount' => $new_admission_amountss, 'new_admission' => $new_admission_count, 'pass_out' => $pass_out, 'passout_amount' => $passout_amount, 'sos_amount' => $revenue1, 'total_strength_sos' => $total_strength_sos, 'class_name' => $records->class_name, 'program_id' => $records->tier_list_id, 'total' => $total_strength, 'program_name' => $records->tier_name, 'company_name' => $records->company_name, 'default_per' => $default_per, 'id' => $i, 'branch' => $records->branch_name, 'revenue' => $revenue, 'recovered' => number_format(ceil($recovered_amount), 0), 'default_amount' => number_format(ceil($default_amount), 0), 'recovered_per' => $recoverd);
            }


        }

        $session = Session::where('id', $request->session_id)->value('title');
        $company = Company::where('id', $request->company_id)->value('name');
        $branch = Branches::where('id', $request->branch_id)->value('name');

        if ($request->fee_head != 0) {
            $fee_head = FeeHead::where('id', $request->fee_head)->value('fee_head_title');
        } else {
            $fee_head = null;
        }

        if ($request->fee_status == 0) {
            $status = null;
        } elseif ($request->fee_status == 3) {
            $status = 'Paid';
        } elseif ($request->fee_status == 1) {
            $status = 'Unpaid';
        }

        $dataArray = [
            'session' => $session,
            'company' => $company,
            'branch' => $branch,
            'fee_head' => $fee_head,
            'status' => $status,
        ];

        if ($request->type == 'print') {
//            return view('reports.revenue_report.pdf', compact('array', 'dataArray'));
            $content = View::make('reports.revenue_report.pdf', compact('array', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('RevenueSeparationReport.pdf', 'D');
        } elseif ($request->type == 'excel') {
            return self::revenue_separation_report_excel($array, $dataArray);
        } else {
            return response()->json(['data' => $array]);
        }
    }

    public function revenue_separation_report_excel($array, $dataArray)
    {
        header('Content-Type: application/vnd.ms-excel charset=UTF-8');
        header('Content-disposition: attachment; filename=RevenueSeparationReport.xls');
        $data = '';

        $data .= '<style>
                table{width: 100%;}
                td,th {
                    border: 0.1pt solid #ccc;
                }
                </style>';
        $data .= '<div class="panel-body pad table-responsive">
                    <table align="center">
                        <tbody>
                        <tr>
                            <td colspan="17" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['session'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="17" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['company'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="17" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['branch'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="17" align="center">
                                <h3><span style="border-bottom: double;">Revenue Separation Report</span></h3>
                            </td>
                        </tr>';

        if ($dataArray['fee_head'] != null) {
            $data .= '<tr>
                            <td colspan="17" align="center"><h5><span style="border-bottom: double;">Fee Head: ' . $dataArray['fee_head'] . '</span></h5></td>
                        </tr>';
        }

        if ($dataArray['status'] != null) {
            $data .= '<tr>
                            <td colspan="17" align="center"><h5><span style="border-bottom: double;">Status: ' . $dataArray['status'] . '</span></h5></td>
                        </tr>';
        }

        $data .= '        </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="col-md-12">
        <table class="table" style="width:100%;">
            <thead>
            <tr>
                <th>Sr.No</th>
                <th>Tier Name</th>
                <th>Class Name</th>
                <th>Total Strength</th>
                <th>Gross Revenue(Annual)</th>
                <th>SOS Mid Session Strength</th>
                <th>SOS Mid Session Amount</th>
                <th>Staff Child</th>
                <th>Staff Child Amount</th>
                <th>New Admission</th>
                <th>New Admission Amount</th>
                <th>Remaining Strength</th>
                <th>Remaining Amount</th>
                <th>Average Annually</th>
                <th>Average Monthly</th>
                <th>Pass Out Strength</th>
                <th>Pass Out Session Amount</th>
            </tr>
            </thead>
            <tbody>';

        $i = 1;
        $total_strength_branch = 0;
        $total_revenue = 0;
        $sos_total = 0;
        $sos_total_amount = 0;
        $staff_ref_total = 0;
        $staff_reference_amount = 0;
        $new_admission = 0;
        $new_admission_amount = 0;
        $difference_revenue = 0;
        $difference_revenue_amount = 0;
        $pass_out = 0;
        $pass_out_amount = 0;

        foreach ($array as $single) {
            $data .= '<tr style="text-align:center;">
                    <td>' . $i++ . '</td>
                    <td>' . $single['program_name'] . '</td>
                    <td>' . $single['class_name'] . '</td>';

            $total_strength = $single['total_strength_sos'] + $single['total'];

            $data .= '<td>' . number_format($total_strength) . '</td>
                    <td>' . number_format($single['revenue']) . '</td>
                    <td>' . number_format($single['total_strength_sos']) . '</td>
                    <td>' . number_format($single['sos_amount']) . '</td>
                    <td>' . number_format($single['staff_reference']) . '</td>
                    <td>' . number_format($single['staff_reference_amount']) . '</td>
                    <td>' . number_format($single['new_admission']) . '</td>
                    <td>' . number_format($single['new_admission_amount']) . '</td>';

            $remaining_strenth_after = $single['total'] - $single['new_admission'] - $single['staff_reference'];

            $data .= '<td>' . number_format($remaining_strenth_after) . '</td>';
            $difference_revenue += $remaining_strenth_after;
            $total_amount = $single['revenue'] - $single['sos_amount'] - $single['new_admission_amount'] - $single['staff_reference_amount'];

            $data .= '<td>' . number_format($total_amount) . '</td>';

            $average = $total_amount / $remaining_strenth_after;

            $data .= '<td>' . number_format(round($average)) . '</td>';

            $average = $average / 12;

            $data .= '<td>' . number_format(round($average)) . '</td>
                        <td>' . number_format($single['pass_out']) . '</td>
                        <td>' . number_format($single['passout_amount']) . '</td>';

            $total_strength_branch += $total_strength;
            $sos_total += $single['total_strength_sos'];
            $sos_total_amount += $single['sos_amount'];
            $total_revenue += $single['revenue'];
            $difference_revenue_amount += $total_amount;
            $pass_out += $single['pass_out'];
            $pass_out_amount += $single['passout_amount'];
            $new_admission += $single['new_admission'];
            $staff_ref_total += $single['staff_reference'];
            $staff_reference_amount += $single['staff_reference_amount'];
            $new_admission_amount += $single['new_admission_amount'];

        }

        $data .= '        <tr style="text-align:center;">
                            <th colspan="3">Total:</th>
                            <th>' . number_format($total_strength_branch) . '</th>
                            <th>' . number_format($total_revenue) . '</th>
                            <th>' . number_format($sos_total) . '</th>
                            <th>' . number_format($sos_total_amount) . '</th>
                            <th>' . number_format($staff_ref_total) . '</th>
                            <th>' . number_format($staff_reference_amount) . '</th>
                            <th>' . number_format($new_admission) . '</th>
                            <th>' . number_format($new_admission_amount) . '</th>
                            <th>' . number_format($difference_revenue) . '</th>
                            <th>' . number_format($difference_revenue_amount) . '</th>
                            <th>-</th>
                            <th>-</th>
                            <th>' . number_format($pass_out) . '</th>
                            <th>' . number_format($pass_out_amount) . '</th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>';

        echo $data;

    }

    public function revenue_projection_report(Request $request)
    {
        $sessions = Session::SessionList();
//        $companies = Company::CompanyList();
        $company = Company::get();
        $fee_heads = ErpFeeHead::get();

        return view('reports.revenue_projection.index', compact('fee_heads', 'company', 'sessions'));
    }

    public function revenue_projection_report_print(Request $request)
    {
        $session_record = Session::where('id', $request->session_id)->first();
        $company_id = $request->company_id;
        $session_id = $request->session_id;
        $array = array();
        $branch_name;
        $balance = 0;
        if ($request->fee_head == 0) {
            $query = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts ,sum(previous_session_default_amount) as previous_session,tier.id as tier_list_id,tier.name as tier_name, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas_amount) as arreas,sum(total_amount) as revenue, sum(paid_amount) as recovered, fee_collections.*, erp_branches.name as branch_name,programs.name as program_name,programs.id as program_id')
                ->join('students', 'students.id', '=', 'fee_collections.students_id')
                ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
                ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                ->join('programs', 'programs.id', '=', 'fee_collections.program_id')
                ->join('tier', 'tier.id', '=', 'programs.tier_id')
                ->where('fee_collections.session_id', '=', $session_id)
                ->where('erp_branches.company_id', $company_id)
                ->where('erp_branches.id', $request->branch_id)
                ->where('due_date', '>=', $session_record->start_year)
                ->where('due_date', '<=', $session_record->end_year)
                ->where('cancel_voucher', 'No')
                // ->groupBy('tier.id')
                ->where('admission_status', 'Regular')
                ->orderBy('tier.id', 'ASC')
                ->groupBy('tier.id')
                ->get();
            $i = 0;

            foreach ($query as $key => $records) {

                $total_strength = DB::table('students')
                    ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                    ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                    ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                    ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                    ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                    ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                    ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                    ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                    ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                    //->leftjoin('sections','sections.id','=','active_session_sections.section_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('students.status', 'Active')
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('students.admission_status', 'Regular')
                    ->where('students.sos_status', '!=', 'InActive')
                    ->groupBy('tier.id')
                    ->where('active_sessions.session_id', $session_id)
                    ->where('active_session_students.status', 1)
                    ->count();
                //   $total_strength = FeeMasterBasic::join('students','students.id','=','fee_master_basics.student_id')->where('students.admission_status','Regular')->where('sos_status','Active')->where('fee_master_basics.branch_id',$records->branch_id)->where('fee_master_basics.program_id',$records->program_id)->count();

                $i++;

                $revenue = $records->revenue + $records->fines + $records->arreas + $records->previous_session;
                $recovered_amount = $records->recovered - $records->tax_amounts - $records->other_taxes;

                $default_amount = $revenue - $recovered_amount;
                $recoverd = $recovered_amount / $revenue;
                $recoverd = $recoverd * 100;
                $default_per = $default_amount / $revenue;
                $default_per = $default_per * 100;
                $array[] = array('program_id' => $records->tier_list_id, 'total' => $total_strength, 'program_name' => $records->tier_name, 'company_name' => $records->company_name, 'default_per' => $default_per, 'id' => $i, 'branch' => $records->branch_name, 'revenue' => $revenue, 'recovered' => number_format(ceil($recovered_amount), 0), 'default_amount' => number_format(ceil($default_amount), 0), 'recovered_per' => $recoverd);
            }
        } else {
            $query = FeeCollectionDetail::selectRaw('sum(amount) as total_head_amount ,tier.id as tier_list_id,tier.name as tier_name,sum(arreas) as arreas_head_amount,erp_branches.name as branch_name,programs.name as program_name,programs.id as program_id')
                ->join('fee_collections', 'fee_collections.id', '=', 'fee_collection_detail.fc_id')
                ->join('students', 'students.id', '=', 'fee_collections.students_id')
                ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
                ->join('programs', 'programs.id', '=', 'fee_collections.program_id')
                ->join('tier', 'tier.id', '=', 'programs.tier_id')
                ->where('erp_fee_head_id_direct', $request->fee_head)
                ->where('fee_collections.session_id', '=', $session_id)
                ->where('erp_branches.company_id', $company_id)
                ->where('erp_branches.id', $request->branch_id)
                ->where('due_date', '>=', $session_record->start_year)
                ->where('due_date', '<=', $session_record->end_year)
                //   ->where('tier.id',19)
                ->where('cancel_voucher', 'No')
                //    ->where('fee_collection_detail.amount','>',0)
                // ->groupBy('tier.id')
                ->where('admission_status', 'Regular')
                ->orderBy('tier.id', 'ASC')
                ->groupBy('tier.id')
                ->get();
            // dd($query);
            $i = 0;

            foreach ($query as $key => $records) {

                $total_strength = DB::table('students')
                    ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                    ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                    ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                    ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                    ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                    ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                    ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                    ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                    ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                    ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                    ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                    //  ->join('sections','sections.id','=','active_session_sections.section_id')
                    ->join('tier', 'tier.id', '=', 'programs.tier_id')
                    ->where('students.status', 'Active')
                    ->where('erp_branches.id', $request->branch_id)
                    ->where('tier.id', $records->tier_list_id)
                    ->where('students.admission_status', 'Regular')
                    ->where('students.sos_status', '!=', 'InActive')
                    ->groupBy('tier.id')
                    ->where('active_session_students.status', 1)
                    ->where('active_sessions.session_id', $session_id)
                    ->count();
                //   $total_strength = FeeMasterBasic::join('students','students.id','=','fee_master_basics.student_id')->where('students.admission_status','Regular')->where('sos_status','Active')->where('fee_master_basics.branch_id',$records->branch_id)->where('fee_master_basics.program_id',$records->program_id)->count();

                $i++;

                $revenue = $records->total_head_amount + $records->arreas_head_amount;

                $array[] = array('program_id' => $records->tier_list_id, 'total' => $total_strength, 'program_name' => $records->tier_name, 'id' => $i, 'branch' => $records->branch_name, 'revenue' => $revenue);
            }
        }

        $session = Session::where('id', $request->session_id)->value('title');
        $company = Company::where('id', $request->company_id)->value('name');
        $branch = Branches::where('id', $request->branch_id)->value('name');

        if ($request->fee_head != 0) {
            $fee_head = FeeHead::where('id', $request->fee_head)->value('fee_head_title');
        } else {
            $fee_head = null;
        }

        $dataArray = [
            'session' => $session,
            'company' => $company,
            'branch' => $branch,
            'fee_head' => $fee_head,
        ];

        if ($request->type == 'print') {
//            return view('reports.revenue_projection.pdf', compact('array', 'dataArray'));
            $content = View::make('reports.revenue_projection.pdf', compact('array', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('RevenueSeparationReport.pdf', 'D');
        } elseif ($request->type == 'excel') {
            return self::revenue_projection_report_excel($array, $dataArray);
        } else {
            return response()->json(['data' => $array]);
        }
    }

    public function revenue_projection_report_excel($array, $dataArray)
    {
        header('Content-Type: application/vnd.ms-excel charset=UTF-8');
        header('Content-disposition: attachment; filename=RevenueProjectionReport.xls');
        $data = '';

        $data .= '<style>
                table{width: 100%;}
                td,th {
                    border: 0.1pt solid #ccc;
                }
                </style>';
        $data .= '<div class="panel-body pad table-responsive">
                    <table align="center">
                        <tbody>
                        <tr>
                            <td colspan="12" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['session'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="12" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['company'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="12" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['branch'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="12" align="center">
                                <h3><span style="border-bottom: double;">Revenue Projection Report</span></h3>
                            </td>
                        </tr>';

        if ($dataArray['fee_head'] != null) {
            $data .= '<tr>
                            <td colspan="12" align="center"><h5><span style="border-bottom: double;">Fee Head: ' . $dataArray['fee_head'] . '</span></h5></td>
                        </tr>';
        }

        $data .= '        </td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="col-md-12">
        <table class="table" style="width:100%;">
            <thead>
            <tr>
                <th>Sr.No</th>
                <th>Program Name</th>
                <th>No Of Students</th>
                <th>Current Gross Revenue(Annual)</th>
                <th>Current Gross Revenue(Monthly)</th>
                <th>Avg Fee Per Student(Annual)</th>
                <th>Avg Fee Per Student(Monthly)</th>
                <th>Enter Amount</th>
                <th>Projected Gross Revenue(Annual)</th>
                <th>Projected Gross Revenue(Monthly)</th>
                <th>Projected Fee Per Student(Annual)</th>
                <th>Projected Fee Per Student(Monthly)</th>
            </tr>
            </thead>
            <tbody>';

        $i = 1;
        $c_s_total = 0;
        $c_total_revenue = 0;
        $c_annual_total = 0;
        $c_monthly_total = 0;

        foreach ($array as $single) {
            $data .= '<tr style="text-align:center;">
                    <td>' . $i++ . '</td>
                    <td>' . $single['program_name'] . '</td>
                    <td>' . $single['total'] . '</td>
                    <td>' . $single['revenue'] . '</td>';

            $total_revenue = $single['revenue'] / $single['total'];
            $current_month = $single['revenue'] / 12;

            $data .= '<td>' . number_format($current_month) . '</td>
                    <td>' . number_format($total_revenue) . '</td>';

            $monthly = $total_revenue / 12;

            $data .= '<td>' . number_format($monthly) . '</td>
                    <td>0</td>
                    <td>' . number_format($single['revenue']) . '</td>
                    <td>' . number_format($current_month) . '</td>
                    <td>' . number_format($total_revenue) . '</td>
                    <td>' . number_format($monthly) . '</td>';

            $c_s_total += $single['total'];
            $c_total_revenue += $single['revenue'];
            $c_annual_total += $total_revenue;
            $c_monthly_total += $monthly;

        }

        $total_overall = $c_total_revenue / $c_s_total;
        $month = $c_total_revenue / 12;
        $overall = $total_overall / 12;

        $data .= '        <tr style="text-align:center;">
                            <td colspan="2">Total Revenue:</td>
                            <th>' . number_format($c_s_total) . '</th>
                            <th>' . number_format($c_total_revenue) . '</th>
                            <th>' . number_format($month) . '</th>
                            <th>' . number_format($total_overall) . '</th>
                            <th>' . number_format($overall) . '</th>
                            <th></th>
                            <th>' . number_format($c_total_revenue) . '</th>
                            <th>' . number_format($month) . '</th>
                            <th>' . number_format($total_overall) . '</th>
                            <th>' . number_format($overall) . '</th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>';

        echo $data;

    }

    public
    function cie_paid_report(Request $request)
    {
        $session = school_session::get();
        $company = Company::get();
        $coursetype = CourseType::get();
        return view('reports.fee.cambridge_fee.cam_paid_fee.index', compact('company', 'session', 'coursetype'));

    }

    public
    function cie_paid_report_print(Request $request)
    {
        $type = $request['course_type'];
        $session_details = $request['session_details'];
        $data = Students::join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
            ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
            ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->join('subject_fee_master', 'subject_fee_master.student_id', '=', 'students.id')
            ->where('active_sessions.session_id', $request->session_id)
            ->where('subject_fee_master.status', 'Paid')
            ->where('active_session_students.status', 1)
            ->where('active_sessions.session_id', $request->session_id)
            ->whereBetween('paid_date', [$request->from, $request->to])
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['city_id'] != null && $request['city_id'] != "null") {
                    $query->where('erp_branches.city_id', $request['city_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('boards.id', $request['boards']);
                }
                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('programs.id', $request['programs']);
                }
                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('classes.id', $request['classes']);
                }
                if ($request['intake'] != null && $request['intake'] != "null") {
                    $query->where('intake.id', $request['intake']);
                }
                if ($request['session_details'] != 0) {
                    $query->where('subject_fee_master.session_details', $request['session_details']);
                }
                if ($request['course_type'] != 0) {
                    $query->where('type', $request['course_type']);
                }
            })
            ->get();


        return response()->json(['data' => $data]);

    }

    public
    function cie_unpaid_report(Request $request)
    {
        $session = school_session::get();
        $company = Company::get();
        $coursetype = CourseType::get();
        return view('reports.fee.cambridge_fee.cam_unpaid_fee.index', compact('company', 'session', 'coursetype'));

    }

    public
    function cie_unpaid_report_print(Request $request)
    {
        $type = $request['course_type'];
        $session_details = $request['session_details'];
        $data = Students::join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
            ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
            ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->join('subject_fee_master', 'subject_fee_master.student_id', '=', 'students.id')
            ->where('active_sessions.session_id', $request->session_id)
            ->where('subject_fee_master.status', 'Unpaid')
            ->where('active_session_students.status', 1)
            ->where('active_sessions.session_id', $request->session_id)
            ->whereBetween('due_date', [$request->from, $request->to])
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['city_id'] != null && $request['city_id'] != "null") {
                    $query->where('erp_branches.city_id', $request['city_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('boards.id', $request['boards']);
                }
                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('programs.id', $request['programs']);
                }
                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('classes.id', $request['classes']);
                }
                if ($request['intake'] != null && $request['intake'] != "null") {
                    $query->where('intake.id', $request['intake']);
                }
                if ($request['session_details'] != 0) {
                    $query->where('subject_fee_master.session_details', $request['session_details']);
                }
                if ($request['course_type'] != 0) {
                    $query->where('type', $request['course_type']);
                }
            })
            ->get();


        return response()->json(['data' => $data]);

    }

    public
    function actual_summary_report(Request $request)
    {
        if (Auth::user()->isAbleTo('actual-summary-report')) {

            $session = school_session::get();
            $company = Company::get();
            $coursetype = CourseType::get();
            return view('reports.fee.cambridge_fee.actual_summary_report.index', compact('company', 'session', 'coursetype'));
        } else {
            return abort(401);
        }
    }

    public
    function actual_summary_report_print(Request $request)
    {
        if (Auth::user()->isAbleTo('actual-summary-report')) {
            $data = DB::table('students')
                ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                ->join('sections', 'sections.id', '=', 'active_session_sections.section_id')
                ->join('subject_fee_master', 'subject_fee_master.student_id', '=', 'students.id')
                ->join('subject_fee_details', 'subject_fee_details.subject_fee_master_id', '=', 'subject_fee_master.subject_fee_id')
                ->join('courses', 'courses.id', '=', 'subject_fee_details.subject_id')
                ->where('courses.program_id', '!=', 1000)
                ->whereBetween('paid_date', [$request->from, $request->to])
                ->where('subject_fee_master.session_id', $request->session_id)
                ->where('subject_fee_master.status', 'Paid')
                ->where('active_sessions.session_id', $request->session_id)
                ->where(function ($query) use ($request) {

                    if ($request['company_id'] != null && $request['company_id'] != "null") {
                        $query->where('erp_branches.company_id', $request['company_id']);
                    }
                    if ($request['city_id'] != null && $request['city_id'] != "null") {
                        $query->where('erp_branches.city_id', $request['city_id']);
                    }
                    if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                        $query->where('erp_branches.id', $request['branch_id']);
                    } else {
                        $branch_ids = PermissionCheck::check_branch();
                        $query->whereIn('erp_branches.id', $branch_ids);
                    }
                    if ($request['boards'] != null && $request['boards'] != "null") {
                        $query->where('boards.id', $request['boards']);
                    }
                    if ($request['programs'] != null && $request['programs'] != "null") {
                        $query->where('programs.id', $request['programs']);
                    }
                    if ($request['classes'] != null && $request['classes'] != "null") {
                        $query->where('classes.id', $request['classes']);
                    }
                    if ($request['intake'] != null && $request['intake'] != "null") {
                        $query->where('intake.id', $request['intake']);
                    }
                    if ($request['sections'] != null && $request['sections'] != "null") {
                        $query->where('sections.id', $request['sections']);
                    }
                    if ($request['session_details'] != 0) {
                        $query->where('subject_fee_master.session_details', $request['session_details']);
                    }
                    if ($request['course_type'] != 0) {
                        $query->where('subject_fee_master.type', $request['course_type']);
                    }
                })
                ->select('classes.name as class_name', 'courses.subject_code', 'courses.subject_optional_code', 'courses.id as course_id', 'erp_branches.name as branch_name', 'erp_branches.id as branches_id', 'subject_fee_details.actual_fees', 'classes.id as class_id', 'courses.name as course_name')
                ->groupBy('classes.id')
                ->groupBy('erp_branches.id')
                ->groupBy('courses.id')
                ->groupBy('classes.name')
                ->groupBy('subject_code')
                ->groupBy('subject_optional_code')
                ->groupBy('erp_branches.name')
                ->groupBy('courses.name')
                ->groupBy('subject_fee_details.actual_fees')
                ->get();
            $array = array();
            foreach ($data as $dat) {
                $student_issued_bills = DB::table('students')
                    ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                    ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                    ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                    ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                    ->join('subject_fee_master', 'subject_fee_master.student_id', '=', 'students.id')
                    ->join('subject_fee_details', 'subject_fee_details.subject_fee_master_id', '=', 'subject_fee_master.subject_fee_id')
                    ->where('subject_fee_master.session_id', $request->session_id)
                    ->whereBetween('paid_date', [$request->from, $request->to])
                    ->where('subject_id', $dat->course_id)
                    ->where('active_sessions.class_id', $dat->class_id)
                    ->where('erp_branches.id', $dat->branches_id)
                    ->where('active_sessions.session_id', $request->session_id)
                    ->where('subject_fee_master.status', 'Paid')
                    ->where(function ($query) use ($request) {
                        if ($request['session_details'] != 0) {
                            $query->where('subject_fee_master.session_details', $request['session_details']);
                        }
                        if ($request['course_type'] != 0) {
                            $query->where('type', $request['course_type']);
                        }
                    })
                    ->select(DB::Raw('count(subject_fee_master.subject_fee_id) as issued_bill'), 'subject_fee_details.actual_fees')
                    ->groupby('subject_fee_id')
                    ->groupby('actual_fees')
                    ->get();

                $issued_bill = 0;
                $actual_fee = 0;
                foreach ($student_issued_bills as $issued) {
                    $issued_bill = $issued_bill + $issued->issued_bill;
                    $actual_fee = $issued->actual_fees;
                }

                $total = $issued_bill * $actual_fee;
                $array[] = array('class_name' => $dat->class_name, 'course_name' => $dat->course_name . '-' . $dat->subject_code . '-' . $dat->subject_optional_code, 'strength' => $issued_bill, 'actual_fee' => $actual_fee, 'total' => $total);
            }


            return response()->json(['data' => $array]);
        } else {
            return abort(401);
        }

    }

    public
    function cambridge_topup_report(Request $request)
    {
        $session = school_session::get();
        $company = Company::get();
        $coursetype = CourseType::get();
        return view('reports.fee.cambridge_fee.cambridge_topup.index', compact('company', 'session', 'coursetype'));
    }

    public
    function cambridge_topup_report_print(Request $request)
    {
        $type = $request['course_type'];
        $session_details = $request['session_details'];
        $array = array();

        $student = DB::table('students')
            ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
            ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->where('active_session_students.status', 1)
            ->whereIn('active_sessions.program_id', [3, 4])
            ->whereIn('active_sessions.board_id', [2, 3])
            ->whereIn('active_sessions.class_id', [21, 22, 23, 24])
            ->where('admission_status', 'Regular')
            ->where('active_sessions.session_id', $request->session_id)
            ->where(function ($query) use ($request) {
                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['city_id'] != null && $request['city_id'] != "null") {
                    $query->where('erp_branches.city_id', $request['city_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['session_details'] != 0) {
                    $query->where('subject_fee_master.session_details', $request['session_details']);
                }

            })
            ->orderby('erp_branches.id', 'asc')
            ->groupBy('classes.id')
            ->groupBy('erp_branches.id')
            ->groupBy('erp_branches.name')
            ->groupBy('classes.name')
            ->select(DB::raw('COUNT(students.id) as student_strength'), 'erp_branches.id as branch_id', 'classes.id as class_id', 'erp_branches.name as branch_name', 'classes.name')
            ->get();

        foreach ($student as $key => $std) {
            $strength = $std->student_strength;
            $branch_name = 0;
            $issued_bill = 0;
            $paid_bill = 0;
            $student_issued_bills = SubjectFeeMaster::join('students', 'students.id', '=', 'subject_fee_master.student_id')
                ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                ->where('subject_fee_master.session_id', $request->session_id)
                ->where('active_sessions.session_id', $request->session_id)
                ->whereIn('active_sessions.program_id', [3, 4])
                ->whereIn('active_sessions.board_id', [2, 3])
                ->where('admission_status', 'Regular')
                ->where('active_session_students.status', 1)
                ->where('active_sessions.class_id', $std->class_id)
                ->where('active_sessions.branch_id', $std->branch_id)
                ->whereBetween('paid_date', [$request->from, $request->to])
                ->where('subject_fee_master.status', 'Paid')
                ->where(function ($query) use ($request) {
                    if ($request['session_details'] != 0) {
                        $query->where('subject_fee_master.session_details', $request['session_details']);
                    }
                    if ($request['course_type'] != 0) {
                        $query->where('type', $request['course_type']);
                    }
                })
                ->groupBy('subject_fee_id')
                ->select(DB::raw('COUNT(subject_fee_master.subject_fee_id) as issued_bill'))
                ->get();

            foreach ($student_issued_bills as $issued) {
                $issued_bill = $issued_bill + $issued->issued_bill;
            }

            $subject_details_actual = SubjectFeeMaster::join('students', 'students.id', '=', 'subject_fee_master.student_id')
                ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                ->join('subject_fee_details', 'subject_fee_details.subject_fee_master_id', '=', 'subject_fee_master.subject_fee_id')
                ->join('courses', 'courses.id', '=', 'subject_fee_details.subject_id')
                ->where('subject_fee_master.session_id', $request->session_id)
                ->where('active_sessions.session_id', $request->session_id)
                ->whereIn('active_sessions.program_id', [3, 4])
                ->whereIn('active_sessions.board_id', [2, 3])
                ->where('active_sessions.class_id', $std->class_id)
                ->where('active_sessions.branch_id', $std->branch_id)
                ->where('courses.program_id', '!=', 1000)
                ->where('admission_status', 'Regular')
                ->where('active_session_students.status', 1)
                ->where('active_sessions.status', 1)
                ->whereBetween('paid_date', [$request->from, $request->to])
                ->where('subject_fee_master.status', 'Paid')
                ->where(function ($query) use ($request) {
                    if ($request['session_details'] != 0) {
                        $query->where('subject_fee_master.session_details', $request['session_details']);
                    }
                    if ($request['course_type'] != 0) {
                        $query->where('subject_fee_master.type', $request['course_type']);
                    }
                })
                ->sum('actual_fee');
            $subject_details_subject = SubjectFeeMaster::join('students', 'students.id', '=', 'subject_fee_master.student_id')
                ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                ->join('subject_fee_details', 'subject_fee_details.subject_fee_master_id', '=', 'subject_fee_master.subject_fee_id')
                ->join('courses', 'courses.id', '=', 'subject_fee_details.subject_id')
                ->where('subject_fee_master.session_id', $request->session_id)
                ->where('active_sessions.session_id', $request->session_id)
                ->where('active_session_students.status', 1)
                ->whereIn('active_sessions.program_id', [3, 4])
                ->whereIn('active_sessions.board_id', [2, 3])
                ->where('active_sessions.class_id', $std->class_id)
                ->where('active_sessions.branch_id', $std->branch_id)
                ->where('courses.program_id', '!=', 1000)
                ->where('admission_status', 'Regular')
                ->whereBetween('paid_date', [$request->from, $request->to])
                ->where('subject_fee_master.status', 'Paid')
                ->where(function ($query) use ($request) {
                    if ($request['session_details'] != 0) {
                        $query->where('subject_fee_master.session_details', $request['session_details']);
                    }
                    if ($request['course_type'] != 0) {
                        $query->where('subject_fee_master.type', $request['course_type']);
                    }
                })
                //->get();
                ->sum('subject_fee');
            $actual = 0;
            $subject = 0;
            $topup = 0;
            /*   foreach( $subject_details as $issued)
          {
            if($issued ->actual_fees_total !=null)
            {
            $actual = $issued ->actual_fees_total;
            }
            if($issued->subject_amount != null)
            {
            $subject = $issued->subject_amount;
            }
            $topup = $subject-$actual;
          }
          */
            $subject = $subject_details_subject;
            $actual = $subject_details_actual;
            $topup = $subject - $actual;
            //    dd($std->class_id);
            $registration = SubjectFeeMaster::join('students', 'students.id', '=', 'subject_fee_master.student_id')
                ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                ->join('subject_fee_details', 'subject_fee_details.subject_fee_master_id', '=', 'subject_fee_master.subject_fee_id')
                ->join('courses', 'courses.id', '=', 'subject_fee_details.subject_id')
                ->where('active_session_students.status', 1)
                ->where('subject_fee_master.session_id', $request->session_id)
                ->where('active_sessions.class_id', $std->class_id)
                ->where('active_sessions.branch_id', $std->branch_id)
                ->where('courses.program_id', '=', 1000)
                ->where('admission_status', 'Regular')
                ->where('active_sessions.session_id', $request->session_id)
                ->whereBetween('paid_date', [$request->from, $request->to])
                ->where('subject_fee_master.status', 'Paid')
                ->where(function ($query) use ($request) {
                    if ($request['session_details'] != 0) {
                        $query->where('subject_fee_master.session_details', $request['session_details']);
                    }
                    if ($request['course_type'] != 0) {
                        $query->where('subject_fee_master.type', $request['course_type']);
                    }
                })
                //          ->select(DB::raw('sum(subject_amount) as subject_amount'))
                //        ->groupby('subject_amount')
                ->sum('subject_fee');
            //   dd($registration);
            $registration_total = 0;
            if ($registration) {
                $registration_total = $registration;
            }


            $total = $registration_total + $subject;
            $top_up = $registration_total + $topup;
            $array[] = array('gross_topup' => $top_up, 'total' => $total, 'topup' => $topup, 'reg' => $registration_total, 'actual' => $actual, 'subject' => $subject, 'id' => $std->branch_id, 'name' => $std->branch_name, 'class_name' => $std->name, 'strength' => $strength, 'issued' => $issued_bill);

        }

        $data = $array;


        return response()->json(['data' => $data]);

    }

    public
    function draft_amount_report(Request $request)
    {
        $session = school_session::get();
        $company = Company::get();
        $coursetype = CourseType::get();
        return view('reports.fee.cambridge_fee.draft_amount.index', compact('company', 'session', 'coursetype'));
    }

    public
    function draft_amount_report_print(Request $request)
    {
        $type = $request['course_type'];
        $session_details = $request['session_details'];
        $array = array();
        $student = DB::table('students')
            ->leftjoin('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->leftjoin('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->leftjoin('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->leftjoin('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
            ->leftjoin('exam_center_draft_amount', 'exam_center_draft_amount.id', '=', 'erp_branches.exam_center_no')
            ->leftjoin('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
            ->leftjoin('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->leftjoin('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->leftjoin('intake', 'intake.id', '=', 'active_sessions.intake_id')
            ->leftjoin('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->leftjoin('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->leftjoin('sections', 'sections.id', '=', 'active_session_sections.section_id')
            //    ->leftjoin('subject_fee_master','students.id','=','subject_fee_master.student_id')
            //  ->where('students.status','Active')
            ->whereIn('active_sessions.program_id', [3, 4])
            ->whereIn('active_sessions.board_id', [2, 3])
            ->whereIn('active_sessions.class_id', [21, 22, 23, 24])
            ->where('active_sessions.session_id', $request->session_id)
            //   ->where('subject_fee_master.session_id',$request->session_id)
            ->where('admission_status', 'Regular')
            ->where('active_sessions.status', 1)
            ->where('exam_center_draft_amount.id', $request->exam_center_no)
            ->where(function ($query) use ($request) {
                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['city_id'] != null && $request['city_id'] != "null") {
                    $query->where('erp_branches.city_id', $request['city_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['session_details'] != 0) {
                    $query->where('subject_fee_master.session_details', $request['session_details']);
                }
                if ($request['course_type'] != 0) {
                    $query->where('type', $request['course_type']);
                }
            })
            ->orderby('erp_branches.id', 'asc')
            ->groupBy('classes.id')
            ->groupBy('erp_branches.id')
            ->groupBy('classes.name')
            ->groupBy('erp_branches.name')
            ->groupBy('draft_amount')
            ->select(DB::raw('COUNT(students.id) as student_strength'), 'erp_branches.id as branch_id', 'classes.id as class_id', 'erp_branches.name as branch_name', 'classes.name', 'exam_center_draft_amount.draft_amount as draft_amount')
            ->get();
        foreach ($student as $key => $std) {
            $strength = $std->student_strength;
            $draft_amount = $std->draft_amount;
            $branch_name = 0;
            $issued_bill = 0;
            $paid_bill = 0;
            $student_issued_bills = SubjectFeeMaster::join('students', 'students.id', '=', 'subject_fee_master.student_id')
                ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                ->join('sections', 'sections.id', '=', 'active_session_sections.section_id')
                ->where('subject_fee_master.session_id', $request->session_id)
                ->whereIn('active_sessions.program_id', [3, 4])
                ->whereIn('active_sessions.board_id', [2, 3])
                ->where('active_sessions.class_id', $std->class_id)
                ->where('active_sessions.branch_id', $std->branch_id)
                ->where('subject_fee_master.status', 'Paid')
                ->where(function ($query) use ($request) {
                    if ($request['session_details'] != 0) {
                        $query->where('subject_fee_master.session_details', $request['session_details']);
                    }
                    if ($request['course_type'] != 0) {
                        $query->where('type', $request['course_type']);
                    }
                })
                ->orderby('erp_branches.id', 'asc')
                ->groupBy('classes.id')
                ->groupBy('erp_branches.id')
                ->groupby('subject_fee_id')
                ->select(DB::raw('COUNT(subject_fee_master.subject_fee_id) as issued_bill'))
                ->get();

            foreach ($student_issued_bills as $issued) {
                $issued_bill = $issued->issued_bill;
            }
            //get amounts
            $subject_details = SubjectFeeMaster::join('students', 'students.id', '=', 'subject_fee_master.student_id')
                ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                ->join('sections', 'sections.id', '=', 'active_session_sections.section_id')
                ->join('subject_fee_details', 'subject_fee_details.subject_fee_master_id', '=', 'subject_fee_master.subject_fee_id')
                ->join('courses', 'courses.id', '=', 'subject_fee_details.subject_id')
                ->where('subject_fee_master.session_id', $request->session_id)
                ->whereIn('active_sessions.program_id', [3, 4])
                ->whereIn('active_sessions.board_id', [2, 3])
                ->where('active_sessions.class_id', $std->class_id)
                ->where('active_sessions.branch_id', $std->branch_id)
                ->where('courses.program_id', '!=', 1000)
                ->where('subject_fee_master.status', 'Paid')
                ->where(function ($query) use ($request) {
                    if ($request['session_details'] != 0) {
                        $query->where('subject_fee_master.session_details', $request['session_details']);
                    }
                    if ($request['course_type'] != 0) {
                        $query->where('subject_fee_master.type', $request['course_type']);
                    }
                })
                ->orderby('erp_branches.id', 'asc')
                ->groupby('subject_fee_id')
                ->groupby('actual_fees')
                ->groupby('subject_amount')
                ->select(DB::raw('COUNT(subject_fee_master.subject_fee_id) as issued_bill, sum(actual_fees) as actual_fees_total,sum(subject_amount) as subject_amount'))
                ->get();
            $actual = 0;
            $subject = 0;
            $topup = 0;
            foreach ($subject_details as $issued) {
                if ($issued->actual_fees_total != null) {
                    $actual = $issued->actual_fees_total;
                }
                if ($issued->subject_amount != null) {
                    $subject = $issued->subject_amount;
                }
                $topup = $subject - $actual;
            }
            $registration = SubjectFeeMaster::join('students', 'students.id', '=', 'subject_fee_master.student_id')
                ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
                ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
                ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
                ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
                ->join('sections', 'sections.id', '=', 'active_session_sections.section_id')
                ->join('subject_fee_details', 'subject_fee_details.subject_fee_master_id', '=', 'subject_fee_master.subject_fee_id')
                ->join('courses', 'courses.id', '=', 'subject_fee_details.subject_id')
                ->where('subject_fee_master.session_id', $request->session_id)
                ->where('active_sessions.class_id', $std->class_id)
                ->where('active_sessions.branch_id', $std->branch_id)
                ->where('courses.program_id', '=', 1000)
                ->where('subject_fee_master.status', 'Paid')
                ->where(function ($query) use ($request) {
                    if ($request['session_details'] != 0) {
                        $query->where('subject_fee_master.session_details', $request['session_details']);
                    }
                    if ($request['course_type'] != 0) {
                        $query->where('subject_fee_master.type', $request['course_type']);
                    }
                })
                ->orderby('erp_branches.id', 'asc')
                ->groupby('subject_amount')
                ->select(DB::raw('sum(subject_amount) as subject_amount'))
                ->get();
            $registration_total = 0;
            foreach ($registration as $reg) {
                if ($reg->subject_amount != null) {
                    $registration_total = $reg->subject_amount;
                } else {
                    $registration_total = 0;
                }
            }
            $total = $registration_total + $subject;
            $top_up = $registration_total + $topup;
            $array[] = array('gross_topup' => $top_up, 'total' => $total, 'topup' => $topup, 'reg' => $registration_total, 'actual' => $actual, 'subject' => $subject, 'id' => $std->branch_id, 'name' => $std->branch_name, 'class_name' => $std->name, 'strength' => $strength, 'issued' => $issued_bill, 'draft_amount' => $draft_amount);

        }

        $data = $array;


        return response()->json(['data' => $data]);

    }

    public
    function fee_collection_search_index(Request $request)
    {
        $branch = PermissionCheck::check_branch_search();
        $data = "";

//        if ($branch == 4) {
//            if ($request->filter_type == 'bill_no' && $request->value != null) {
//                $data = Students::select(DB::raw('sum(fee_collections.total_amount) as grand_total, sum(fee_collections.paid_amount) as      total_paid_amount'), 'students.id', 'students.reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
//                    'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'students.board_id', 'students.class_id', 'fee_collections.bill_no', 'boards.name as b_name', 'classes.name as c_name', 'programs.name as p_name',
//                    'sessions.title as session_id', 'students.father_cnic', 'students.mother_cnic', 'pd.father_first_name', 'pd.father_last_name')
//                    ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
//                    ->join('boards', 'boards.id', '=', 'students.board_id')
//                    ->join('programs', 'programs.id', '=', 'students.program_id')
//                    ->join('classes', 'classes.id', '=', 'students.class_id')
//                    ->leftjoin('parent_details as pd', 'pd.students_id', '=', 'students.id')
//                    ->leftjoin('guardian_details as gd', 'gd.id', '=', 'students.id')
//                    ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
//                    ->join('sessions', 'sessions.id', '=', 'students.session_id')
//                    ->where('fee_collections.bill_no', $request->value)
//                    ->orderBy('students.branch_id')
//                    ->orderBy('students.program_id')
//                    ->orderBy('students.first_name')
//                    ->get();
//            } elseif ($request->filter_type == 'reg_no' && $request->value != null) {
//
//
//                $data = Students::select('students.id', 'students.reg_no', 'students.walkin_reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
//                    'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'erp_branches.id as branch_id', 'students.board_id', 'students.class_id', 'boards.name as b_name', 'classes.name as c_name', 'programs.name as p_name')
//                    ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
//                    ->join('boards', 'boards.id', '=', 'students.board_id')
//                    ->join('programs', 'programs.id', '=', 'students.program_id')
//                    ->join('classes', 'classes.id', '=', 'students.class_id')
//                    ->join('sessions', 'sessions.id', '=', 'students.session_id')
//                    ->groupBy('students.id')
//                    ->where('students.reg_no', $request->value)
//                    ->orderBy('students.branch_id')
//                    ->orderBy('students.program_id')
//                    ->orderBy('students.first_name')
//                    ->get();
//
//            } elseif ($request->filter_type == 'first_name' && $request->value != null) {
//                $data = Students::select('students.id', 'students.reg_no', 'students.walkin_reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
//                    'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'students.board_id', 'students.class_id', 'boards.name as b_name', 'classes.name as c_name', 'programs.name as p_name')
//                    ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
//                    ->join('boards', 'boards.id', '=', 'students.board_id')
//                    ->join('programs', 'programs.id', '=', 'students.program_id')
//                    ->join('classes', 'classes.id', '=', 'students.class_id')
//                    ->join('sessions', 'sessions.id', '=', 'students.session_id')
//                    ->groupBy('students.id')
//                    ->where('students.first_name', 'like', '%' . $request->value . '%')
//                    ->orderBy('students.branch_id')
//                    ->orderBy('students.program_id')
//                    ->orderBy('students.first_name')
//                    ->get();
//
//
//            } elseif ($request->filter_type == 'last_name' && $request->value != null) {
//
//
//                $data = Students::select('students.id', 'students.reg_no', 'students.walkin_reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
//                    'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'students.board_id', 'students.class_id', 'boards.name as b_name', 'classes.name as c_name', 'programs.name as p_name')
//                    ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
//                    ->join('boards', 'boards.id', '=', 'students.board_id')
//                    ->join('programs', 'programs.id', '=', 'students.program_id')
//                    ->join('classes', 'classes.id', '=', 'students.class_id')
//                    ->join('sessions', 'sessions.id', '=', 'students.session_id')
//                    ->groupBy('students.id')
//                    ->where('students.last_name', 'like', '%' . $request->value . '%')
//                    ->orderBy('students.branch_id')
//                    ->orderBy('students.program_id')
//                    ->orderBy('students.last_name')
//                    ->get();
//
//            } elseif ($request->filter_type == 'full_name' && $request->value != null) {
//
//                $fullName = $request->value;
//
//                $query = Students::select('students.id', 'students.reg_no', 'students.walkin_reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
//                    'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'students.board_id', 'students.class_id', 'boards.name as b_name', 'classes.name as c_name', 'programs.name as p_name')
//                    ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
//                    ->join('boards', 'boards.id', '=', 'students.board_id')
//                    ->join('programs', 'programs.id', '=', 'students.program_id')
//                    ->join('classes', 'classes.id', '=', 'students.class_id')
//                    ->join('sessions', 'sessions.id', '=', 'students.session_id')
//                    ->groupBy('students.id')
//                    ->orderBy('students.branch_id')
//                    ->orderBy('students.program_id')
//                    ->orderBy('students.first_name')
//                    ->orderBy('students.last_name');
//
//                if ($fullName) {
//                    $query->searchFullName($fullName);
//                }
//
//                $data = $query->get();
//
//            } elseif ($request->filter_type == 'father_name' && $request->value != null) {
//
//
//                $data = Students::select('students.id', 'students.reg_no', 'students.walkin_reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
//                    'parent_details.father_first_name as father_first_name', 'parent_details.father_middle_name as father_middle_name', 'parent_details.father_last_name as father_last_name',
//                    'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status',
//                    'erp_branches.name as branch_name', 'students.board_id', 'students.class_id', 'boards.name as b_name', 'classes.name as c_name',
//                    'programs.name as p_name')
//                    ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
//                    ->join('boards', 'boards.id', '=', 'students.board_id')
//                    ->join('programs', 'programs.id', '=', 'students.program_id')
//                    ->join('classes', 'classes.id', '=', 'students.class_id')
//                    ->join('sessions', 'sessions.id', '=', 'students.session_id')
//                    ->join('parent_details', 'parent_details.students_id', '=', 'students.id')
//                    ->groupBy('students.id')
//                    ->whereRaw("CONCAT(parent_details.father_first_name) LIKE ?", ['%' . $request->value . '%'])
//                    ->orWhereRaw("CONCAT(parent_details.father_first_name, ' ', parent_details.father_last_name) LIKE ?", ['%' . $request->value . '%'])
//                    ->orWhereRaw("CONCAT(parent_details.father_first_name, ' ', parent_details.father_middle_name, ' ', parent_details.father_last_name) LIKE ?", ['%' . $request->value . '%'])
//                    ->orderBy('students.branch_id')
//                    ->orderBy('students.program_id')
//                    ->orderBy('students.last_name')
//                    ->get();
//
//            } elseif ($request->filter_type == 'total_amount' && $request->value != null) {
//
//                $data = Students::select(DB::raw('sum(fee_collections.total_amount) as grand_total,sum(fee_collections.total_amount+fee_collections.arreas_amount+fee_collections.fine+fee_collections.other_tax+fee_collections.tax_amount) as overall_total_amount, sum(fee_collections.paid_amount) as      total_paid_amount'), 'students.id', 'students.reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
//                    'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'students.board_id', 'students.class_id', 'fee_collections.bill_no', 'boards.name as b_name', 'classes.name as c_name', 'programs.name as p_name')
//                    ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
//                    ->join('boards', 'boards.id', '=', 'students.board_id')
//                    ->join('programs', 'programs.id', '=', 'students.program_id')
//                    ->join('classes', 'classes.id', '=', 'students.class_id')
//                    ->join('sessions', 'sessions.id', '=', 'students.session_id')
//                    ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
//                    ->groupBy('fee_collections.bill_no')
//                    ->having('overall_total_amount', '=', $request->value)
//                    ->where('fee_status', 1)
//                    ->orderBy('students.branch_id')
//                    ->orderBy('students.program_id')
//                    ->orderBy('students.last_name')
//                    ->get();
//
//            } elseif ($request->filter_type == 'walkin' && $request->value != null) {
//                $data = Students::select(DB::raw('sum(fee_collections.total_amount) as grand_total, sum(fee_collections.paid_amount) as      total_paid_amount'), 'students.id', 'students.reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
//                    'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'erp_branches.id as branch_id', 'students.board_id', 'students.class_id', 'fee_collections.bill_no', 'boards.name as b_name', 'classes.name as c_name', 'programs.name as p_name')
//                    ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
//                    ->join('boards', 'boards.id', '=', 'students.board_id')
//                    ->join('programs', 'programs.id', '=', 'students.program_id')
//                    ->join('classes', 'classes.id', '=', 'students.class_id')
//                    ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
//                    ->join('sessions', 'sessions.id', '=', 'students.session_id')
//                    ->groupBy('students.id')
//                    ->where('students.walkin_reg_no', $request->value)
//                    ->orderBy('students.branch_id')
//                    ->orderBy('students.program_id')
//                    ->orderBy('students.first_name')
//                    ->get();
//            }
//        } elseif ($branch != 4) {
        if ($request->filter_type == 'bill_no' && $request->value != null) {
            $data = Students::select(DB::raw('sum(fee_collections.total_amount) as grand_total, sum(fee_collections.paid_amount) as      total_paid_amount'), 'students.id', 'students.reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
                'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'students.board_id', 'students.class_id', 'fee_collections.bill_no', 'boards.name as b_name', 'classes.name as c_name', 'intake.name as intake_name', 'programs.name as p_name')
                ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
                ->join('boards', 'boards.id', '=', 'students.board_id')
                ->join('programs', 'programs.id', '=', 'students.program_id')
                ->join('classes', 'classes.id', '=', 'students.class_id')
                ->join('intake', 'intake.id', '=', 'students.intake_id')
                ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
                ->join('sessions', 'sessions.id', '=', 'students.session_id')
                ->groupBy('students.id')
                ->where('fee_collections.bill_no', $request->value)
                ->whereIn('students.branch_id', $branch)
                ->orderBy('students.branch_id')
                ->orderBy('students.program_id')
                ->orderBy('students.first_name')
                ->get();
        } elseif ($request->filter_type == 'reg_no' && $request->value != null) {
            $data = Students::select('students.id', 'students.reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
                'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'students.board_id', 'students.class_id', 'boards.name as b_name', 'classes.name as c_name', 'intake.name as intake_name', 'programs.name as p_name')
                ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
                ->join('boards', 'boards.id', '=', 'students.board_id')
                ->join('programs', 'programs.id', '=', 'students.program_id')
                ->join('classes', 'classes.id', '=', 'students.class_id')
                ->join('intake', 'intake.id', '=', 'students.intake_id')
                ->join('sessions', 'sessions.id', '=', 'students.session_id')
                ->groupBy('students.id')
                ->whereIn('students.branch_id', $branch)
                ->where('students.reg_no', $request->value)
                ->orderBy('students.branch_id')
                ->orderBy('students.program_id')
                ->orderBy('students.first_name')
                ->get();

        } elseif ($request->filter_type == 'first_name' && $request->value != null) {
            $data = Students::select('students.id', 'students.reg_no', 'students.walkin_reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
                'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'students.board_id', 'students.class_id', 'boards.name as b_name', 'classes.name as c_name', 'intake.name as intake_name', 'programs.name as p_name')
                ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
                ->join('boards', 'boards.id', '=', 'students.board_id')
                ->join('programs', 'programs.id', '=', 'students.program_id')
                ->join('classes', 'classes.id', '=', 'students.class_id')
                ->join('intake', 'intake.id', '=', 'students.intake_id')
                ->join('sessions', 'sessions.id', '=', 'students.session_id')
                ->groupBy('students.id')
                ->whereIn('students.branch_id', $branch)
                ->where('students.first_name', 'like', '%' . $request->value . '%')
                ->orderBy('students.branch_id')
                ->orderBy('students.program_id')
                ->orderBy('students.first_name')
                ->get();

        } elseif ($request->filter_type == 'last_name' && $request->value != null) {
            $data = Students::select('students.id', 'students.reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
                'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'students.board_id', 'students.class_id', 'boards.name as b_name', 'classes.name as c_name', 'intake.name as intake_name', 'programs.name as p_name')
                ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
                ->join('boards', 'boards.id', '=', 'students.board_id')
                ->join('programs', 'programs.id', '=', 'students.program_id')
                ->join('classes', 'classes.id', '=', 'students.class_id')
                ->join('intake', 'intake.id', '=', 'students.intake_id')
                ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
                ->join('sessions', 'sessions.id', '=', 'students.session_id')
                ->groupBy('students.id')
                ->whereIn('students.branch_id', $branch)
                ->where('students.last_name', 'like', '%' . $request->value . '%')
                ->orderBy('students.branch_id')
                ->orderBy('students.program_id')
                ->orderBy('students.last_name')
                ->get();

        } elseif ($request->filter_type == 'total_amount' && $request->value != null) {
            $data = Students::select(DB::raw('sum(fee_collections.total_amount) as grand_total,sum(fee_collections.total_amount+fee_collections.arreas_amount+fee_collections.fine+fee_collections.other_tax+fee_collections.tax_amount) as overall_total_amount, sum(fee_collections.paid_amount) as      total_paid_amount'), 'students.id', 'students.reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
                'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'students.board_id', 'students.class_id', 'fee_collections.bill_no', 'boards.name as b_name', 'classes.name as c_name', 'intake.name as intake_name', 'programs.name as p_name')
                ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
                ->join('boards', 'boards.id', '=', 'students.board_id')
                ->join('programs', 'programs.id', '=', 'students.program_id')
                ->join('classes', 'classes.id', '=', 'students.class_id')
                ->join('intake', 'intake.id', '=', 'students.intake_id')
                ->join('parent_details as pd', 'pd.students_id', '=', 'students.id')
                ->join('addressinfos as ai', 'ai.students_id', '=', 'students.id')
                ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
                ->join('sessions', 'sessions.id', '=', 'students.session_id')
                ->groupBy('students.id')
                ->whereIn('students.branch_id', $branch)
                ->where('fee_status', 1)
                ->having('overall_total_amount', $request->value)
                ->orderBy('students.branch_id')
                ->orderBy('students.program_id')
                ->orderBy('students.last_name')
                ->get();

        } elseif ($request->filter_type == 'walkin' && $request->value != null) {
            $data = Students::select('students.id', 'students.reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
                'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'students.board_id',
                'students.class_id', 'boards.name as b_name', 'classes.name as c_name', 'intake.name as intake_name', 'programs.name as p_name')
                ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
                ->join('boards', 'boards.id', '=', 'students.board_id')
                ->join('programs', 'programs.id', '=', 'students.program_id')
                ->join('classes', 'classes.id', '=', 'students.class_id')
                ->join('intake', 'intake.id', '=', 'students.intake_id')
                ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
                ->join('sessions', 'sessions.id', '=', 'students.session_id')
                ->groupBy('students.id')
                ->whereIn('students.branch_id', $branch)
                ->where('students.walkin_reg_no', $request->value)
                ->orderBy('students.branch_id')
                ->orderBy('students.program_id')
                ->orderBy('students.first_name')
                ->get();
        } elseif ($request->filter_type == 'full_name' && $request->value != null) {

            $fullName = $request->value;

            $query = Students::select('students.id', 'students.reg_no', 'students.walkin_reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
                'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status', 'erp_branches.name as branch_name', 'students.board_id', 'students.class_id', 'boards.name as b_name', 'classes.name as c_name', 'intake.name as intake_name', 'programs.name as p_name')
                ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
                ->join('boards', 'boards.id', '=', 'students.board_id')
                ->join('programs', 'programs.id', '=', 'students.program_id')
                ->join('classes', 'classes.id', '=', 'students.class_id')
                ->join('intake', 'intake.id', '=', 'students.intake_id')
                ->join('sessions', 'sessions.id', '=', 'students.session_id')
                ->whereIn('students.branch_id', $branch)
                ->groupBy('students.id')
                ->orderBy('students.branch_id')
                ->orderBy('students.program_id')
                ->orderBy('students.first_name')
                ->orderBy('students.last_name');

            if ($fullName) {
                $query->searchFullName($fullName);
            }

            $data = $query->get();

        } elseif ($request->filter_type == 'father_name' && $request->value != null) {


            $data = Students::select('students.id', 'students.reg_no', 'students.walkin_reg_no', 'students.program_id', 'students.term_id', 'students.reg_date', 'students.first_name',
                'parent_details.father_first_name as father_first_name', 'parent_details.father_middle_name as father_middle_name', 'parent_details.father_last_name as father_last_name',
                'sessions.title as session_id', 'students.middle_name', 'students.sos_status', 'students.last_name', 'students.status',
                'erp_branches.name as branch_name', 'students.board_id', 'students.class_id', 'boards.name as b_name', 'classes.name as c_name', 'intake.name as intake_name',
                'programs.name as p_name')
                ->join('erp_branches', 'students.branch_id', '=', 'erp_branches.id')
                ->join('boards', 'boards.id', '=', 'students.board_id')
                ->join('programs', 'programs.id', '=', 'students.program_id')
                ->join('classes', 'classes.id', '=', 'students.class_id')
                ->join('intake', 'intake.id', '=', 'students.intake_id')
                ->join('sessions', 'sessions.id', '=', 'students.session_id')
                ->join('parent_details', 'parent_details.students_id', '=', 'students.id')
                ->whereIn('students.branch_id', $branch)
                ->groupBy('students.id')
                ->whereRaw("CONCAT(parent_details.father_first_name) LIKE ?", ['%' . $request->value . '%'])
                ->orWhereRaw("CONCAT(parent_details.father_first_name, ' ', parent_details.father_last_name) LIKE ?", ['%' . $request->value . '%'])
                ->orWhereRaw("CONCAT(parent_details.father_first_name, ' ', parent_details.father_middle_name, ' ', parent_details.father_last_name) LIKE ?", ['%' . $request->value . '%'])
                ->orderBy('students.branch_id')
                ->orderBy('students.program_id')
                ->orderBy('students.last_name')
                ->get();

        }
//        }

        return response()->json(['data' => $data]);
    }

    public
    function default_student_report(Request $request)
    {
//        if (Auth::user()->branch_id == 4) {
        $session = Session::get();
        $company = Company::get();
        $branches = Branches::get();
//        } else {
//
//            $session = Session::where('active_status', 1)->get();
//            $company = Company::get();
//            $branches = Branches::where('id', Auth::user()->branch_id)->get();
//        }
        $tier_one = Auth::user()->program_id_one;
        $tier_two = Auth::user()->program_id_two;
        if ($tier_one != 0) {
            $tier = DB::table('tier')
                ->whereIn('id', [$tier_one, $tier_two])
                ->get();
        } else {
            $tier = DB::table('tier')
                ->get();
        }

        return view('reports.fee.defaulter_report.index', compact('session', 'company', 'branches', 'tier', 'tier_one', 'tier_two'));
    }

    public
    function default_student_report_print(Request $request)
    {

        $input = $request->all();

        $student = DB::table('students')
            ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
            ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
            ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
            ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->join('sections', 'sections.id', '=', 'active_session_sections.section_id')
            ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
            ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
            ->where('students.sos_status', '!=', 'InActive')
            ->where('admission_status', 'Regular')
            ->where('fee_collections.session_id', $request->session_id)
            ->where('active_sessions.session_id', $request->session_id)
            ->where('cancel_voucher', 'No')
            ->where('fee_status', '1')
            // ->where('registered_session','!=',2)
            ->where('active_session_students.status', '=', 1)
            ->whereBetween('fee_collections.due_date', [$request->from, $request->to])
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null" && $request['branch_id'] != '---Select---') {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['boards'] != null && $request['boards'] != "null" && $request['boards'] != '---Select---') {
                    $query->where('boards.id', $request['boards']);
                }
                if ($request['programs'] != null && $request['programs'] != "null" && $request['programs'] != '---Select---') {
                    $query->where('programs.id', $request['programs']);
                }
                if ($request['classes'] != null && $request['classes'] != "null" && $request['classes'] != '---Select---') {
                    $query->where('classes.id', $request['classes']);
                }
                if ($request['sections'] != null && $request['sections'] != "null" && $request['sections'] != '---Select---') {
                    $query->where('sections.id', $request['sections']);
                }
                if ($request['intake'] != null && $request['intake'] != "null" && $request['intake'] != '---Select---') {
                    $query->where('intake.id', $request['intake']);
                }
            })
            ->select('guardian_details.guardian_mobile_1 as mobile_num', 'students.mobile_1 as student_num', 'students.reg_no',
                'fee_collections.*', 'erp_branches.name as branch_name', 'erp_branches.id as branch_table_id', 'boards.name as board_name', 'intake.name as intake_name',
                'programs.name as program_name', 'classes.name as class_name', 'classes.id as class_table_id', 'classes.name as class_name', 'sections.name as section_name',
                'students.first_name as first_name', 'students.last_name as last_name', 'students.middle_name as middle_name',
                'students.date_of_birth', 'students.reg_date', 'students.address', 'students.staff_ref as student_staff_ref')
            // ->orderBy('fee_collections.students_id', 'ASC')
            ->orderBy('erp_branches.id', 'ASC')
            ->orderBy('fee_collections.class_id', 'ASC')
            ->orderBy('students.reg_no', 'ASC')
            //  ->orderBy('fee_collections.fee_term_id', 'ASC')
            ->get();

        $array = array();
        $existing = "";
        $customize_string = "";
        $customize_bill = "";
        $new_id = "";
        $student_name = "";
        $exisitng_studnet = "";
        $branch_id = "";
        $class_id = "";

        $class_id = "";
        $branch_name = "";
        $class_name = "";
        $intake_name = "";
        $mobile_num = "";
        $student_num = "";
        $student_staff_ref = "";

        $students = $student->sortBy(['branch_id', 'class_id']);

        foreach ($student as $students) {
            $new_id = $students->reg_no;
            $branch_name = $students->branch_name;

            $student_name = $students->first_name . " " . $students->middle_name . " " . $students->last_name;

            if ($new_id == $existing) {
                $branch_id = $students->branch_table_id;
                $class_id = $students->class_table_id;

                $customize_string = $customize_string . ", " . $students->fee_term_id . "- Installment(" . $students->due_date . ")";
                $customize_bill = $customize_bill . " -  " . $students->bill_no;
                $student_name = $students->first_name . " " . $students->middle_name . " " . $students->last_name;
                $class_name = $students->class_name;
                $intake_name = $students->intake_name;
                $mobile_num = $students->mobile_num;
                $student_num = $students->student_num;
                $student_staff_ref = $students->student_staff_ref;
            } else {
                if ($existing != "") {
                    $array[] = array('branch_id' => $branch_id, 'class_id' => $class_id, 'reg_no' => $existing, 'name' => $exisitng_studnet, 'term' => $customize_string, 'bill_no' => $customize_bill, 'branch_name' => $branch_name, 'class_name' => $class_name, 'intake_name' => $intake_name, 'mobile_num' => $mobile_num, 'student_num' => $student_num, 'student_staff_ref' => $student_staff_ref);
                }
                $exisitng_studnet = $students->first_name . " " . $students->middle_name . " " . $students->last_name;
                $existing = $students->reg_no;
                $customize_string = $students->fee_term_id . "- Installment(" . $students->due_date . ")";
                $customize_bill = $students->bill_no;
                $branch_id = $students->branch_table_id;
                $class_id = $students->class_table_id;
                $class_name = $students->class_name;
                $intake_name = $students->intake_name;
                $mobile_num = $students->mobile_num;
                $student_num = $students->student_num;
                $student_staff_ref = $students->student_staff_ref;

            }

        }

        $array[] = array('branch_id' => $branch_id, 'class_id' => $class_id, 'reg_no' => $new_id, 'name' => $student_name, 'term' => $customize_string, 'bill_no' => $customize_bill, 'branch_name' => $branch_name, 'class_name' => $class_name, 'intake_name' => $intake_name, 'mobile_num' => $mobile_num, 'student_num' => $student_num, 'student_staff_ref' => $student_staff_ref);

        $student = $array;
//        arsort($student);

        usort($student, function ($a, $b) {
            if ($a['branch_id'] === $b['branch_id']) {
                return $a['class_id'] <=> $b['class_id'];
            }
            return $a['branch_id'] <=> $b['branch_id'];
        });

        $array_list = array();
        foreach ($student as $std) {
            $array_list[] = array(
                'branch_id' => $std['branch_id'],
                'class_id' => $std['class_id'],
                'reg_no' => $std['reg_no'],
                'name' => $std['name'],
                'term' => $std['term'],
                'bill_no' => $std['bill_no'],
                'branch_name' => $std['branch_name'],
                'class_name' => $std['class_name'],
                'intake_name' => $std['intake_name'],
                'mobile_num' => $std['mobile_num'],
                'student_num' => $std['student_num'],
                'student_staff_ref' => $std['student_staff_ref']
            );

        }

        $dateRange = null;
        $branch = null;
        $board = null;
        $session = null;
        $program = null;
        $class = null;
        $section = null;
        $company = null;
        $intake = null;


        if ($request->from != null && $request->from != "null" || $request->to != null && $request->to != "null") {
            $dateRange = $request->from . ' - ' . $request->to;
        }

        if ($request['branch_id'] != null && $request['branch_id'] != '---Select---') {
            $branch = Branches::where('id', $request['branch_id'])->value('name');
        }

        if ($request['boards'] != null && $request['boards'] != "null") {
            $board = Board::where('id', $request['boards'])->value('name');
        }

        if ($request['company_id'] != null && $request['company_id'] != "null") {
            $company = Company::where('id', $request['company_id'])->value('name');
        }

        if ($request['programs'] != null && $request['programs'] != "null") {
            $program = Program::where('id', $request['programs'])->value('name');
        }

        if ($request['classes'] != null && $request['classes'] != "null") {
            $class = Classes::where('id', $request['classes'])->value('name');
        }

        if ($request['session_id'] != null && $request['session_id'] != "null") {
            $session = Session::where('id', $request['session_id'])->value('title');
        }

        if ($request['intake'] != null && $request['intake'] != "null") {
            $intake = InTake::where('id', $request['intake'])->value('name');
        }

        $dataArray = [
            'dateRange' => $dateRange,
            'session' => $session,
            'company' => $company,
            'branch' => $branch,
            'board' => $board,
            'program' => $program,
            'class' => $class,
            'intake' => $intake,
        ];

        if ($request->type == 'print') {
//            $pdf = PDF::loadView('reports.student_defaulters.print', compact('company', 'student', 'branch', 'board', 'program', 'class', 'section', 'session'));
//            return $pdf->stream('student_defaulters.pdf');
//            return view('reports.student_defaulters.print', compact('dataArray', 'array_list'));
            $content = View::make('reports.student_defaulters.print', compact('dataArray', 'array_list'))->render();
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
            $mpdf->WriteHTML($content);
            $mpdf->Output('DefaulterStudentReport.pdf', 'D');

        } else {
            return response()->json(['data' => $array_list]);
        }
    }

    public
    function defaulter_amt_report(Request $request)
    {
        if (Auth::user()->branch_id == 4) {
            $session = Session::get();
            $company = Company::get();
            $branches = Branches::get();
        } else {

//            $session = Session::where('active_status', 1)->get();
            $session = Session::get();
            $company = Company::get();
            $branches = Branches::where('id', Auth::user()->branch_id)->get();
        }
        $tier_one = Auth::user()->program_id_one;
        $tier_two = Auth::user()->program_id_two;
        if ($tier_one != 0) {
            $tier = DB::table('tier')
                ->whereIn('id', [$tier_one, $tier_two])
                ->get();
        } else {
            $tier = DB::table('tier')
                ->get();
        }

        return view('reports.fee.defaulter_report_with_amount.index', compact('session', 'company', 'branches', 'tier', 'tier_one', 'tier_two'));
    }

    public
    function default_amt_report_print(Request $request)
    {


        $input = $request->all();

        $student = DB::table('students')
            ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
            ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
            ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
            ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
            ->where('students.sos_status', '!=', 'InActive')
            ->where('admission_status', 'Regular')
            ->where('fee_collections.session_id', $request->session_id)
            ->where('active_sessions.session_id', $request->session_id)
            ->where('cancel_voucher', 'No')
            ->where('fee_status', '1')
            // ->where('registered_session','!=',2)
            ->where('active_session_students.status', '=', 1)
            ->whereBetween('fee_collections.due_date', [$request->from, $request->to])
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['city_id'] != null && $request['city_id'] != "null" && $request['city_id'] != '---Select---') {
                    $query->where('erp_branches.city_id', $request['city_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null" && $request['branch_id'] != '---Select---') {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['boards'] != null && $request['boards'] != "null" && $request['boards'] != '---Select---') {
                    $query->where('boards.id', $request['boards']);
                }
                if ($request['programs'] != null && $request['programs'] != "null" && $request['programs'] != '---Select---') {
                    $query->where('programs.id', $request['programs']);
                }
                if ($request['classes'] != null && $request['classes'] != "null" && $request['classes'] != '---Select---') {
                    $query->where('classes.id', $request['classes']);
                }
                if ($request['sections'] != null && $request['sections'] != "null" && $request['sections'] != '---Select---') {
                    $query->where('sections.id', $request['sections']);
                }
                if ($request['intake'] != null && $request['intake'] != "null" && $request['intake'] != '---Select---') {
                    $query->where('intake.id', $request['intake']);
                }
            })
            ->select('students.reg_no', 'fee_collections.*', 'erp_branches.name as branch_name', 'boards.name as board_name', 'intake.name as intake_name', 'programs.name as program_name', 'classes.name as class_name', 'students.first_name as first_name', 'students.last_name as last_name', 'students.middle_name as middle_name', 'students.date_of_birth', 'students.reg_date', 'students.address')
            ->orderBy('fee_collections.students_id', 'ASC')
            // ->orderBy('erp_branches.id','ASC')
            ->orderBy('classes.id', 'ASC')
            ->orderBy('fee_collections.fee_term_id', 'ASC')
            ->get();
        $array = array();
        $existing = "";
        $customize_string = "";
        $new_id = "";
        $student_name = "";
        $exisitng_studnet = "";
        $branch_id = "";
        $class_id = "";

        $class_id = "";
        $branch_name = "";
        $class_name = "";
        $amount = 0;
        $customize_bill = "";
        foreach ($student as $students) {
            $new_id = $students->reg_no;
            $branch_name = $students->branch_name;

            $student_name = $students->first_name . " " . $students->middle_name . " " . $students->last_name;

            if ($new_id == $existing) {
                $branch_id = $students->branch_id;
                $class_id = $students->class_id;
                $customize_string = $customize_string . ", " . $students->fee_term_id . "- Installment";
                $customize_bill = $customize_bill . " -  " . $students->bill_no;
                $student_name = $students->first_name . " " . $students->middle_name . " " . $students->last_name;
                $class_name = $students->class_name;
                $amount = $amount + $students->total_amount + $students->arreas_amount + $students->fine;
            } else {
                if ($existing != "") {
                    $array[] = array('branch_id' => $branch_id, 'class_id' => $class_id, 'reg_no' => $existing, 'name' => $exisitng_studnet, 'term' => $customize_string, 'branch_name' => $branch_name, 'class_name' => $class_name, 'amount' => $amount, 'bill_no' => $customize_bill);
                }
                $exisitng_studnet = $students->first_name . " " . $students->middle_name . " " . $students->last_name;
                $existing = $students->reg_no;
                $customize_string = $students->fee_term_id . "- Installment";
                $customize_bill = $students->bill_no;
                $branch_id = $students->branch_id;
                $class_id = $students->class_id;
                $class_name = $students->class_name;
                $amount = $students->total_amount + $students->arreas_amount + $students->fine;

            }

        }

        $array[] = array('branch_id' => $branch_id, 'class_id' => $class_id, 'reg_no' => $new_id, 'name' => $student_name, 'term' => $customize_string, 'branch_name' => $branch_name, 'class_name' => $class_name, 'amount' => $amount, 'bill_no' => $customize_bill);

        $student = $array;
        arsort($student);
        $array_list = array();
        foreach ($student as $std) {
            $array_list[] = array('branch_id' => $std['branch_id'], 'class_id' => $std['class_id'], 'reg_no' => $std['reg_no'], 'name' => $std['name'], 'term' => $std['term'], 'branch_name' => $std['branch_name'], 'class_name' => $std['class_name'], 'amount' => $std['amount'], 'bill_no' => $std['bill_no'],);

        }


        $branch = null;
        $board = null;
        $session = null;
        $program = null;
        $class = null;
        $section = null;
        $company = null;
        if ($request['branch_id'] != null && $request['branch_id'] != '---Select---') {
            $branch = Branches::where('id', $request['branch_id'])->get();

        }
        if ($request['boards'] != null && $request['boards'] != "null") {

            $board = Board::where('id', $request['boards'])->value('name');


        }
        if ($request['company_id'] != null && $request['company_id'] != "null") {
            $company = Company::where('id', $request['company_id'])->value('name');
        }
        if ($request['programs'] != null && $request['programs'] != "null") {
            $program = Program::where('id', $request['programs'])->value('name');
        }
        if ($request['classes'] != null && $request['classes'] != "null") {
            $class = Classes::where('id', $request['classes'])->value('name');
        }
        if ($request['sections'] != null && $request['sections'] != "null") {
            $section = Section::where('id', $request['sections'])->value('name');
        }
        if ($request['session_id'] != null && $request['session_id'] != "null") {
            $session = Session::where('id', $request['session_id'])->value('title');
        }
        if ($request['intake'] != null && $request['intake'] != "null") {
            $intake = InTake::where('id', $request['intake'])->value('name');
        }
        if ($request->type == 'print') {

            return view('reports.defaulter_amt_report.print', compact('student', 'branch', 'board', 'program', 'class', 'section', 'session'));
        } else {
            return response()->json(['data' => $student]);
        }

    }

    public
    function defaulter_company_report(Request $request)
    {

    }

    public
    function default_company_report_print(Request $request)
    {
        $input = $request->all();

        $student = DB::table('students')
            ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('erp_branches', 'active_sessions.branch_id', '=', 'erp_branches.id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
            ->where('students.sos_status', 'Active')
            ->where('admission_status', 'Regular')
            ->where('active_sessions.session_id', $request->session_id)
            ->where('active_session_students.status', 1)
            ->where('fee_collections.session_id', $request->session_id)
            ->where('fee_status', '1')
            //   ->where('due_date','<=',date('y-m-d'))
            ->whereBetween('due_date', [$request->from, $request->to])
            ->where('cancel_voucher', 'No')
            ->where(function ($query) use ($request) {

                $query->where('erp_branches.company_id', $request['company_id']);


            })
            ->select(DB::raw('sum(fee_collections.total_amount) as total, sum(fee_collections.previous_session_default_amount) as previous, sum(fee_collections.fine) as fine, sum(fee_collections.arreas_amount) as arreas,COUNT(fee_collections.students_id) as students_count'), 'erp_companies.id as company_id', 'erp_companies.name as company_name', 'erp_branches.id as branch_id', 'erp_branches.name as branch_name')
            //   ->orderBy('fee_collections.students_id', 'ASC')
            //   ->orderBy('erp_branches.id','ASC')
            //   ->orderBy('classes.id','ASC')
            // ->orderBy('fee_collections.fee_term_id', 'ASC')
            ->groupBy('erp_branches.id')
            ->get();


        $branch = null;

        $section = null;
        if ($request['company_id'] != null && $request['company_id'] != '---Select---') {
            $branch = Company::where('id', $request['company_id'])->get();

        }

        if ($request['session_id'] != null && $request['session_id'] != "null") {
            $session = Session::where('id', $request['session_id'])->value('title');
        }
        if ($request->type == 'print') {

            return view('reports.defaulter_summary_company.print', compact('student', 'branch', 'session'));
        } else {
            return response()->json(['data' => $student]);
        }
    }

    public
    function trial_balance()
    {
        $companies = Company::get();

        return view('reports.accounts.trial_balance.index', compact('companies'));

    }

    public
    function trial_balance_group($group_id = 0, $start_date = 0, $end_date = 0, $company_id = 0, $branch_id = 0)
    {
        $group = Groups::find($group_id);
        $group_name = $group->number . ' <b>' . $group->name . '</b>';
        if ($group->level == 4) {
            $topGroups = Groups::where('id', $group_id)->select('id', 'number', 'name', 'level', 'parent_id')->get()->toArray();
        } else {
            $topGroups = $this->accountsHelper->getGroupChild($group_id);
        }

        $trialHash = [];
        $array = $this->accountsHelper->buildTrialBalance($topGroups, $trialHash, $start_date, $end_date, $company_id, $branch_id);
        $data = $this->accountsHelper->calculateSums($array);
        $ReportData = $this->accountsHelper->generateHtml($data, $start_date, $end_date, 0, $group->level);

        return view('reports.accounts.trial_balance.groupDetail', compact('ReportData', 'start_date', 'end_date', 'group_name'));
    }

    public
    function trial_balance_report(Request $request)
    {
        if ($request->get('date_range')) {
            $date_range = explode(' - ', $request->get('date_range'));

            $date_format = 'd/m/Y';

            $start_date_obj = DateTime::createFromFormat($date_format, $date_range[0]);
            $end_date_obj = DateTime::createFromFormat($date_format, $date_range[1]);

            $start_date = $start_date_obj->format('Y-m-d');
            $end_date = $end_date_obj->format('Y-m-d');

        } else {
            $start_date = null;
            $end_date = null;
        }

        $view_as = $request->get('view_as');

        $company_id = $request->company_id;
        $branch_id = $request->branch_id;

        $group_id = 0;
        $topGroups = $this->accountsHelper->getGroupChild($group_id);
        $trialHash = [];
        $array = $this->accountsHelper->buildTrialBalance($topGroups, $trialHash, $start_date, $end_date, $company_id, $branch_id);
        $data = $this->accountsHelper->calculateSums($array);

        $company = Company::where('id', $request->company_id)->value('name');
        if ($request->branch_id) {
            $branch = Branches::where('id', $request->branch_id)->value('name');
        } else {
            $branch = null;
        }

        $medium_type = $request->get('medium_type');
        if ($medium_type == 'excel') {
            $this->accountsHelper->generateExcel($data, $start_date, $end_date, $company, $branch, $view_as);
        } else {
            $ReportData = $this->accountsHelper->generateHtml($data, $start_date, $end_date, $view_as);
        }

        switch ($medium_type) {
            case 'web':
                return view('reports.accounts.trial_balance.print', compact('company', 'branch', 'ReportData', 'start_date', 'end_date', 'medium_type'));
                break;
            case 'print':
                return view('reports.accounts.trial_balance.print', compact('company', 'branch', 'ReportData', 'start_date', 'end_date', 'medium_type'));
                break;
            case 'pdf':
                $content = View::make('reports.accounts.trial_balance.print', compact('company', 'branch', 'ReportData', 'start_date', 'end_date', 'medium_type'))->render();
                $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
                $mpdf->WriteHTML($content);
                $mpdf->Output('TrialBalanceReport.pdf', 'D');
                break;
            default:
                return view('reports.accounts.trial_balance.print', compact('company', 'branch', 'ReportData', 'start_date', 'end_date'));
                break;
        }
    }


    private
    function loopTrialBalanceExcel($account, $c = 0, $view_as)
    {
        $counter = $c;

        /* Print groups */
        if ($account->id != 0) {

            $c_opening = CoreAccounts::toCurrency('c', $account->op_total);
            $d_opening = CoreAccounts::toCurrency('d', $account->op_total);
            $c_period = CoreAccounts::toCurrency('c', $account->cr_total);
            $d_period = CoreAccounts::toCurrency('d', $account->dr_total);
            $c_closing = CoreAccounts::toCurrency('c', $account->cl_total);
            $d_closing = CoreAccounts::toCurrency('d', $account->cl_total);

            if ($c_closing > 0 || $d_closing > 0 || $c_period > 0 || $d_period > 0 || $c_opening > 0 || $d_opening > 0) {
                if ($view_as == 0 || $account->g_parent_id == 0) {
                    $this->sheet->setCellValue('A' . self::$excel_iterator, html_entity_decode(AccountsList::printSpace($counter)) . AccountsList::toCodeWithName($account->code, $account->name));
                    $this->sheet->setCellValue('B' . self::$excel_iterator, 'Group');

                    if ($account->op_total_dc == 'd') {
                        $this->sheet->setCellValue('C' . self::$excel_iterator, $d_opening);
                        $this->sheet->setCellValue('D' . self::$excel_iterator, '');
                    } else {
                        $this->sheet->setCellValue('C' . self::$excel_iterator, '');
                        $this->sheet->setCellValue('D' . self::$excel_iterator, $c_opening);
                    }

                    $this->sheet->setCellValue('E' . self::$excel_iterator, $d_period);
                    $this->sheet->setCellValue('F' . self::$excel_iterator, $c_period);

                    if ($account->cl_total_dc == 'd') {
                        $this->sheet->setCellValue('G' . self::$excel_iterator, $d_closing);
                        $this->sheet->setCellValue('H' . self::$excel_iterator, '');
                    } else {
                        $this->sheet->setCellValue('G' . self::$excel_iterator, '');
                        $this->sheet->setCellValue('H' . self::$excel_iterator, $c_closing);
                    }

                    self::$excel_iterator++;
                }
            }
        }

        /* Print child ledgers */
        if (count($account->children_ledgers) > 0) {
            $counter++;
            foreach ($account->children_ledgers as $id => $data) {

                $c_opening_ledgers = CoreAccounts::toCurrency('c', $data['op_total']);
                $d_opening_ledgers = CoreAccounts::toCurrency('d', $data['op_total']);
                $c_period_ledgers = CoreAccounts::toCurrency('c', $data['cr_total']);
                $d_period_ledgers = CoreAccounts::toCurrency('d', $data['dr_total']);
                $c_closing_ledgers = CoreAccounts::toCurrency('c', $data['cl_total']);
                $d_closing_ledgers = CoreAccounts::toCurrency('d', $data['cl_total']);

                if ($c_opening_ledgers > 0 || $d_opening_ledgers > 0 || $c_period_ledgers > 0 || $d_period_ledgers > 0 || $c_closing_ledgers > 0 || $d_closing_ledgers > 0) {

                    $this->sheet->setCellValue('A' . self::$excel_iterator, html_entity_decode(AccountsList::printSpace($counter)) . AccountsList::toCodeWithName($data['code'], $data['name']));
                    $this->sheet->setCellValue('B' . self::$excel_iterator, 'Ledger');

                    if ($data['op_total_dc'] == 'd') {
                        $this->sheet->setCellValue('C' . self::$excel_iterator, $d_opening_ledgers);
                        $this->sheet->setCellValue('D' . self::$excel_iterator, '');
                    } else {
                        $this->sheet->setCellValue('C' . self::$excel_iterator, '');
                        $this->sheet->setCellValue('D' . self::$excel_iterator, $c_opening_ledgers);
                    }

                    $this->sheet->setCellValue('E' . self::$excel_iterator, $d_period_ledgers);
                    $this->sheet->setCellValue('F' . self::$excel_iterator, $c_period_ledgers);

                    if ($data['cl_total_dc'] == 'd') {
                        $this->sheet->setCellValue('G' . self::$excel_iterator, $d_closing_ledgers);
                        $this->sheet->setCellValue('H' . self::$excel_iterator, '');
                    } else {
                        $this->sheet->setCellValue('G' . self::$excel_iterator, '');
                        $this->sheet->setCellValue('H' . self::$excel_iterator, $c_closing_ledgers);
                    }

                    self::$excel_iterator++;
                }
            }
            $counter--;
        }

        /* Print child groups recursively */
        foreach ($account->children_groups as $id => $data) {
            $counter++;
            $this->loopTrialBalanceExcel($data, $counter, $view_as);
            $counter--;
        }
    }


    public
    function balance_sheet(Request $request)
    {
        $companies = Company::get();

        return view('reports.accounts.balance_sheet.index', compact('companies'));
    }

    public
    function test($g_id)
    {
//        dd($g_id);
        $start_date = '2023-07-01';
        $end_date = '2024-06-30';
        $total = 0;
        $GroupIncome = Groups::where('id', $g_id)->orderBy('number')->get();
        $Ledgers = Ledger::where('group_id', $g_id)->where('company_id', 1)->get();

        $ledger_sum = null;
        foreach ($Ledgers as $Ledger) {
            $ledger_total = CoreAccounts::opening_balance($start_date, $end_date, $Ledger->id);
            $ledger_sum[$Ledger->id] = $ledger_total;
            $total = $total + $ledger_total;
        }
        dd($GroupIncome, $total, $ledger_sum);

    }

    public
    function groupIdChangeOfLedgers($old, $new)
    {
        return Ledger::where('group_id', $old)->update(['group_id' => $new]);
    }

    public
    function parentIdChangeOfGroups($old, $new)
    {
        return Groups::where('parent_id', $old)->update(['parent_id' => $new]);
    }

    public
    function balance_sheet_report(Request $request)
    {
        $level = 3;
        $type = $request->type ?? $request->medium_type;
        $incomeData = '';
        $expData = '';
        if ($request->get('date_range')) {
            $date_range = explode(' - ', $request->get('date_range'));

            $date_format = 'd/m/Y';

            $start_date_obj = DateTime::createFromFormat($date_format, $date_range[0]);
            $end_date_obj = DateTime::createFromFormat($date_format, $date_range[1]);

            $start_date = $start_date_obj->format('Y-m-d');
            $end_date = $end_date_obj->format('Y-m-d');
        } else {
            $start_date = null;
            $end_date = null;
        }

        if (!$request->company_id) {
            $request['company_id'] = 0;
        }
        if (!$request->branch_id) {
            $request['branch_id'] = 0;
        }

        $tinc_balance = 0;

        $GroupIncome = Groups::where('account_type_id', 1)->orderBy('number')->get();

        foreach ($GroupIncome as $income) {

            if ($level >= $income->level && $income->id != 1) {

                if ($level == $income->level) {

                    $topGroups = $this->accountsHelper->getGroupChild($income->id);
                    $trialHash = [];
                    $array = $this->accountsHelper->buildTrialBalance($topGroups, $trialHash, $start_date, $end_date, $request['company_id'], $request['branch_id']);
                    $data = $this->accountsHelper->calculateSums($array);
                    $total = $this->accountsHelper->calculateTotals($data);

                    $groupBalance = abs($total['closing_dr'] - $total['closing_cr']);

                } else {
                    $groupBalance = 0;
                }

                if ($income->level == 2) {
                    $b_start = '<b>';
                    $b_end = '</b>';
                } else {
                    $b_start = '';
                    $b_end = '';
                }

                $incomeData .= '<tr style = "background-color:#dad5d5;">';

//                if ($type == 'print') {
                $incomeData .= '<td   data-bs-toggle="collapse" href="#id-' . $income->id . '" role="button" aria-expanded="false" aria-controls="collapseExample" ';


                $incomeData .= ' ><span style="margin-left:0;color:black;">' . $b_start . $income->number . ' - ' . $income->name . $b_end . '</span>';
                if ($type == 'web') {
                    if ($level == $income->level) {
                        $incomeData .= '<div class="collapse" id="id-' . $income->id . '"> <hr/>  <div style="width:100% " > <table style="width:100% ">      ' . $this->childgroup($income->id, $request, 1, $income->level) . '</table>  </div> </div></td>';
                    }
                }
                //                } else {
//                    $incomeData .= '<td colspan="2"><a href="' . route("admin.notes-to-the-accounts", [$start_date, $end_date, $income->id, $request->company_id ?? 0]) . '"><span style="margin-left:0px;color:black;">' . $income->number . ' - ' . $income->name . '</span></a></td>';
//                }

                if ($level == $income->level) {
                    $incomeData .= '<td><b style="float: right !important;">' . number_format($groupBalance) . '</b></td>';
                } else {
                    $incomeData .= '<td></td>';
                }


                $incomeData .= '</tr>';
                $tinc_balance += $groupBalance;
            }
        }
        $incomeData .= '
                    <tr class="bold-text bg-filled">
                        <th>Gross Assets</th>
                        <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">' . CoreAccounts::dr_cr_balance($tinc_balance, 2) . '</td>
                    </tr>';

        $texp_balance = 0;

        $GroupExp = Groups::where('account_type_id', 5)->orderBy('number')->get();

        foreach ($GroupExp as $Exp) {

            if ($level >= $Exp->level && $Exp->id != 2) {

                if ($level == $Exp->level) {

                    $topGroups = $this->accountsHelper->getGroupChild($Exp->id);
                    $trialHash = [];
                    $array = $this->accountsHelper->buildTrialBalance($topGroups, $trialHash, $start_date, $end_date, $request['company_id'], $request['branch_id']);
                    $data = $this->accountsHelper->calculateSums($array);
                    $total = $this->accountsHelper->calculateTotals($data);

                    $groupBalance = abs($total['closing_dr'] - $total['closing_cr']);

                } else {
                    $groupBalance = 0;
                }

                if ($Exp->level == 2) {
                    $b_start = '<b>';
                    $b_end = '</b>';
                } else {
                    $b_start = '';
                    $b_end = '';
                }

                $expData .= '<tr style = "background-color:#dad5d5;">';

//                if ($type == 'print') {
                $expData .= '<td   data-bs-toggle="collapse" href="#id-' . $Exp->id . '" role="button" aria-expanded="false" aria-controls="collapseExample" >';
                $expData .= '  <span style="margin-left:0;color:black;">' . $b_start . $Exp->number . ' - ' . $Exp->name . $b_end . '</span>';


                if ($type == 'web') {
                    if ($level == $Exp->level) {
                        $expData .= '<div class="collapse" id="id-' . $Exp->id . '"> <hr/>  <div style="width:100% " > <table style="width:100% ">      ' . $this->childgroup($Exp->id, $request, 2, $Exp->level) . '</table>  </div> </div></td>';
                    }
                }

                $expData .= '</td>';


//                } else {
//                    $expData .= '<td colspan="2"><a href="' . route("admin.notes-to-the-accounts", [$start_date, $end_date, $Exp->id, $request->company_id ?? 0]) . '"><span style="margin-left:0px;color:black;">' . $Exp->number . ' - ' . $Exp->name . '</span></a></td>';
//                }

                if ($level == $Exp->level) {
                    $expData .= '<td><b style="float: right !important;">' . number_format($groupBalance) . '</b></td>';
                } else {
                    $expData .= '<td></td>';
                }

                $expData .= '</tr>';
                $texp_balance += $groupBalance;
            }
        }
        $expData .= '
                <tr class="bold-text bg-filled">
                    <th>Gross Liabilities</th>
                    <td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">' . CoreAccounts::dr_cr_balance_inverse($texp_balance, 2) . '</td>
                </tr>';
        $net = ($tinc_balance) - ($texp_balance);
        $expData .= '<tr class="bold-text">
                    <th>Balance</th>
                    <td align="right" style="border-top:double; border-bottom: double">' . CoreAccounts::dr_cr_balance($net, 2) . '</td>
                </tr>';

        $company = Company::where('id', $request->company_id)->value('name');

        if ($request->branch_id) {
            $branch = Branches::where('id', $request->branch_id)->value('name');
        } else {
            $branch = null;
        }

        $totalTaxData2 = $this->profit_loss_print_new($request);

        if ($type == 'excel') {
            return self::excel_bs_report($incomeData, $expData, $start_date, $end_date, $company, $branch);
        } elseif ($type == 'print') {
            $content = View::make('reports.accounts.balance_sheet.report', compact('incomeData', 'expData', 'start_date', 'end_date', 'company', 'branch'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('BalanceSheetReport.pdf', 'D');
        } else {
            return view('reports.accounts.balance_sheet.report', compact('incomeData', 'expData', 'start_date', 'end_date', 'company', 'branch', 'totalTaxData2'));
        }
        return 0;
    }

    public
    function childgroup($id, $request, $group_type, $child_level)
    {
        $incomeData = '';

        if ($request->get('date_range')) {
            $date_range = explode(' - ', $request->get('date_range'));

            $start_date = $date_range[0];
            $start_date = str_replace('/', '-', $start_date);
            $start_date = Carbon::createFromFormat('d-m-Y', $start_date);
            $start_date = $start_date->format('Y-m-d');

            $end_date = $date_range[1];
            $end_date = str_replace('/', '-', $end_date);
            $end_date = Carbon::createFromFormat('d-m-Y', $end_date);
            $end_date = $end_date->format('Y-m-d');

        } else {
            $start_date = null;
            $end_date = null;
        }

        if (!$request->company_id) {
            $request['company_id'] = 0;
        }
        if (!$request->branch_id) {
            $request['branch_id'] = 0;
        }

        $tinc_balance = 0;

        $GroupIncome = Groups::where('parent_id', $id)->orderBy('number')->get();

        foreach ($GroupIncome as $Exp) {

            if ($child_level <= $Exp->level) {

                $trialHash = [];

                if ($Exp->level == 4) {
                    $array = $this->accountsHelper->buildTrialBalanceForLevelFour($Exp, $trialHash, $start_date, $end_date, $request['company_id'], $request['branch_id']);
                } else {
                    $topGroups = $this->accountsHelper->getGroupChild($Exp->id);
                    $array = $this->accountsHelper->buildTrialBalance($topGroups, $trialHash, $start_date, $end_date, $request['company_id'], $request['branch_id']);
                }

                $data = $this->accountsHelper->calculateSums($array);
                $total = $this->accountsHelper->calculateTotals($data);

                $groupBalance = $total['closing_dr'] - $total['closing_cr'];

//                if ($group_type == 2 || $group_type == 3) {
//                    if ($groupBalance > 0) {
//                        $groupBalance = -($groupBalance);
//                    }
//                }

                $incomeData .= '<tr style = "background-color:#dad5d5;">';
                $incomeData .= '<td data-bs-toggle="collapse" href="#id-' . $Exp->id . '" role="button" aria-expanded="false" aria-controls="collapseExample" >';

                if ($Exp->level == 4) {
                    $incomeData .= '<a target="_blank" style="color: black" href="' .
                        route('admin.trial-balance-group', [
                            'group_id' => $Exp->id,
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'company_id' => $request['company_id'],
                            'branch_id' => $request['branch_id']
                        ]) . '"><span style="margin-left:0;color:black;">' . $Exp->number . ' - ' . $Exp->name . '</span>
                        </a>';
                } else {
                    $incomeData .= '<span style="margin-left:0;color:black;">' . $Exp->number . ' - ' . $Exp->name . '</span>';
                }

                if ($child_level < $Exp->level && $child_level != 4) {
                    $incomeData .= '<div class="collapse" id="id-' . $Exp->id . '"> <hr/>  <div style="width:100% " > <table style="width:100% "> ' . $this->childgroup($Exp->id, $request, $group_type, $Exp->level) . '</table>  </div> </div>';
                }

                $incomeData .= '</td> <td><b style="float: right !important;">' . number_format($groupBalance) . '</b></td>';
                $incomeData .= '</tr>';

                $tinc_balance += $groupBalance;
            }
        }
        $incomeData .= '<tr class="bold-text bg-filled">
                        <th style="border-top: 1px solid black; border-bottom: 1px solid black;">Total</th>';
        if ($group_type == 1 || $group_type == 4) {
            $incomeData .= '<td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">' . CoreAccounts::dr_cr_balance($tinc_balance, 2) . '</td>';
        } else {
            $incomeData .= '<td style="text-align: right; border-top: 1px solid black; border-bottom: 1px solid black;" align="right">' . CoreAccounts::dr_cr_balance_inverse($tinc_balance, 2) . '</td>';
        }
        $incomeData .= '</tr>';

        return $incomeData;

    }

    public
    function notes_to_the_accounts($start_date, $end_date, $groupId, $company_id)
    {
        $Data = self::notes_to_the_accounts_called($start_date, $end_date, $groupId, $company_id);

        return view('reports.accounts.notes_to_the_accounts.report', compact('Data', 'start_date', 'end_date'));
    }

    public
    function notes_to_the_accounts_called($start_date, $end_date, $groupId, $company_id)
    {
        $Data = '';
        $total_bl = 0;
        $Groups = Groups::where('parent_id', $groupId)->orderBy('number')->get();
        if ($Groups->count() > 0) {
            foreach ($Groups as $Group) {
                $Data .= '<tr style = "background-color:#dad5d5;">';
                $Data .= '<td colspan="3"><span style="margin-left:0px;color:black;">' . $Group->number . ' - ' . $Group->name . '<b style="float: right">' . $total_bl . '</b></span></td>';
                $Data .= '</tr>';
                $nestedGroups = Groups::where('parent_id', $Group->id)->orderBy('number')->get();
                if ($nestedGroups->count() > 0) {
                    $Data .= self::notes_to_the_accounts_called($start_date, $end_date, $Group->id, $company_id);
                } else {
                    if ($company_id == 0) {
                        $ledgers = Ledger::where('group_id', $groupId)->orderBy('number')->get();
                    } else {
                        $ledgers = Ledger::where('group_id', $groupId)->where('company_id', $company_id)->orderBy('number')->get();
                    }
                    foreach ($ledgers as $ledger) {
                        $total_bl += CoreAccounts::opening_balance($start_date, $end_date, $ledger->id);
                        $Data .= '<tr style="text-align: center">';
                        $Data .= '<td align="left"> ' . $ledger->number . ' - ' . ucfirst($ledger->name) . '</td>';
                        $Data .= '<td>Ledger</td>';
                        $Data .= '<td align="right">' . CoreAccounts::dr_cr_balance($total_bl, 2) . '</td>';
                        $Data .= '</tr>';
                    }
                }
            }
        } else {
            $total_bl = 0;
            $ledgers = Ledger::where('group_id', $groupId)->where('company_id', $company_id)->orderBy('number')->get();
            foreach ($ledgers as $ledger) {
                $total_bl += CoreAccounts::opening_balance($start_date, $end_date, $ledger->id);
                $Data .= '<tr style="text-align: center">';
                $Data .= '<td align="left"> ' . $ledger->number . ' - ' . ucfirst($ledger->name) . '</td>';
                $Data .= '<td>Ledger</td>';
                $Data .= '<td align="right">' . CoreAccounts::dr_cr_balance($total_bl, 2) . '</td>';
                $Data .= '</tr>';
            }
        }

        return $Data;
    }

    public
    function testBalance()
    {
        $count = 0;
        $entries = Entries::where('company_id', 2)
            ->pluck('id');

        $entry_item = EntryItems::whereIn('entry_id', $entries)->pluck('ledger_id');

        dd($entry_item);
    }

    public function summary_reconciliation()
    {
        $sessions = Session::SessionList();
//        $companies = Company::CompanyList();
        $company = Company::get();

        $banks = Ledger::where('parent_type', '!=', null)->get();

        return view('reports.summary_reconciliation.index', compact('banks', 'company', 'sessions'));
    }

    public function summary_reconciliation_print(Request $request)
    {
        $array = FeeCollection::join('erp_ledgers', 'erp_ledgers.id', '=', 'fee_collections.bank_ledger_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->where('fee_status', '3')
            ->groupby('paid_date')
            ->groupby('bank_ledger_id')
            ->whereBetween('paid_date', [$request->from, $request->To])
            // ->where('fee_collections.session_id',$request->session_id)
            ->where(function ($query) use ($request) {
                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }

                if ($request['bank_id'] != null && $request['bank_id'] != "null") {
                    $query->where('erp_ledgers.id', $request['bank_id']);
                }

            })
            ->select(DB::raw('sum(paid_amount) as total_amount'), 'fee_collections.paid_date', 'erp_ledgers.name')
            ->get();

        $session = Session::where('id', $request->session_id)->value('title');
        $company = Company::where('id', $request->company_id)->value('name');
        $branch = Branches::where('id', $request->branch_id)->value('name');

        if ($request->bank_id != 0) {
            $bank = Ledger::where('id', $request->bank_id)->value('name');
        } else {
            $bank = null;
        }

        $dataArray = [
            'session' => $session,
            'company' => $company,
            'branch' => $branch,
            'bank' => $bank,
        ];

        if ($request->type == 'print') {
//            return view('reports.summary_reconciliation.pdf', compact('array', 'dataArray'));
            $content = View::make('reports.summary_reconciliation.pdf', compact('array', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('SummaryReconciliationReport.pdf', 'D');
        } else {
            return response()->json(['data' => $array]);
        }
    }

    public function fee_bill_issued_paid_report()
    {
        $sessions = Session::SessionList();
//        $companies = Company::CompanyList();
        $company = Company::get();
        return view('reports.fee_bill_issued_paid_report.index', compact('company', 'sessions'));
    }

    public function fee_bill_issued_paid_report_print(Request $request)
    {
        $array = DB::table('fee_collections')->select(DB::raw('count(fee_collections.id) as `issued`'), DB::raw("DATE_FORMAT(fee_collections.starting_date, '%m-%Y') new_date"), DB::raw('YEAR(fee_collections.due_date) year, MONTH(fee_collections.due_date) month'), DB::raw('count(fee_collections.paid_date) as `paid`'), 'starting_date')
            ->groupby('year', 'month')
            ->join('active_session_students', 'active_session_students.student_id', '=', 'fee_collections.students_id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
            ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->where('cancel_voucher', 'No')
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('boards.id', $request['boards']);
                }
                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('programs.id', $request['programs']);
                }
                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('classes.id', $request['classes']);
                }
                if ($request['intake'] != null && $request['intake'] != "null") {
                    $query->where('intake.id', $request['intake']);
                }

            })
            ->get();

        $branch = null;
        $board = null;
        $session = null;
        $company = null;
        $program = null;
        $class = null;
        $intake = null;

        if ($request['session_id'] != null && $request['session_id'] != "null") {
            $session = Session::where('id', $request['session_id'])->value('title');
        }

        if ($request['company_id'] != null && $request['company_id'] != '---Select---') {
            $company = Company::where('id', $request['company_id'])->value('name');
        }

        if ($request['branch_id'] != null && $request['branch_id'] != '---Select---') {
            $branch = Branches::where('id', $request['branch_id'])->value('name');
        }

        if ($request['boards'] != null && $request['boards'] != "null") {
            $board = Board::where('id', $request['boards'])->value('name');
        }

        if ($request['programs'] != null && $request['programs'] != "null") {
            $program = Program::where('id', $request['programs'])->value('name');
        }

        if ($request['classes'] != null && $request['classes'] != "null") {
            $class = Classes::where('id', $request['classes'])->value('name');
        }

        if ($request['intake'] != null && $request['intake'] != "null") {
            $intake = InTake::where('id', $request['intake'])->value('name');
        }

        $dataArray = [
            'session' => $session,
            'company' => $company,
            'branch' => $branch,
            'board' => $board,
            'program' => $program,
            'class' => $class,
            'intake' => $intake,
        ];

        if ($request->type == 'print') {
//            return view('reports.fee_bill_issued_paid_report.pdf', compact('array', 'dataArray'));
            $content = View::make('reports.fee_bill_issued_paid_report.pdf', compact('array', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('FeeBillIssuedPaidReport.pdf', 'D');
        } elseif ($request->type == 'excel') {
            return self::excel_fee_bill_issued_paid_report($array, $dataArray);
        } else {
            return response()->json(['data' => $array]);
        }

    }

    public function excel_fee_bill_issued_paid_report($array, $dataArray)
    {
        header('Content-Type: application/vnd.ms-excel charset=UTF-8');
        header('Content-disposition: attachment; filename=FeeBillIssuedPaidReport.xls');
        $data = '';

        $data .= '<style>
                table{width: 100%;}
                td,th {
                    border: 0.1pt solid #ccc;
                }
                </style>';
        $data .= '<div class="panel-body pad table-responsive">
                    <table align="center">
                        <tbody>
                        <tr>
                            <td colspan="4" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['session'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['company'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['branch'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <h3><span style="border-bottom: double;">Fee Bill Issued Paid Report</span></h3>
                            </td>
                        </tr>';

        $data .= '<tr>
            <td colspan="4" align="center">
                <span style="border-bottom: dot-dash;">';

        if ($dataArray['board'] != null) {
            $data .= '<span style="font-weight: bold">Board: </span>' . $dataArray['board'];
        }
        if ($dataArray['program'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Program: </span>' . $dataArray['program'];
        }
        if ($dataArray['class'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Class: </span>' . $dataArray['class'];
        }
        if ($dataArray['intake'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Intake: </span>' . $dataArray['intake'];
        }

        $data .= '</span>
            </td>
        </tr>
        </tbody>
    </table>';

        $data .= '<table class="table" style="width:100%;">
            <thead>
            <tr>
                <th>Sr.#</th>
                <th>Month - Year</th>
                <th>Issued</th>
                <th>Paid</th>
            </tr>
            </thead>';
        $i = 1;

        foreach ($array as $single) {
            $date = $single->starting_date;
            $date = date('F', strtotime($date));

            $data .= '<tr class="tr" style="text-align: center !important;">
                    <td>' . $i++ . '</td>
                    <td>' . $date . ' - ' . $single->year . '</td>
                    <td>' . $single->issued . '</td>
                    <td>' . $single->paid . '</td>
                </tr>';

        }

        $data .= '</tbody>
        </table>
    </div>';

        echo $data;
    }

    public function student_head_wise_received_fee_report()
    {
        $sessions = Session::SessionList();
//        $companies = Company::CompanyList();
        $company = Company::get();
        $banks = Ledger::where('parent_type', '!=', null)->get();
        $erp_fee_heads = ErpFeeHead::orderBy('id', 'asc')->get();

        return view('reports.student_head_wise_received_fee_report.index', compact('sessions', 'company', 'erp_fee_heads', 'banks'));
    }

    public function student_head_wise_received_fee_report_print(Request $request)
    {
        $students = DB::table('students')->whereNull('students.deleted_at')
            ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
            ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('parent_details', 'parent_details.students_id', '=', 'students.id')
            ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
            ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
            ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
            ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
            ->join('sections', 'sections.id', '=', 'active_session_sections.section_id')
            ->join('erp_ledgers', 'erp_ledgers.id', '=', 'fee_collections.bank_ledger_id')
            ->where('admission_status', 'Regular')
            ->where('fee_collections.fee_status', 3)
            ->whereBetween('paid_date', [$request->from, $request->To])
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }

                if ($request['branch_id'] != null && $request['branch_id'] != "null" && $request['branch_id'] != "---Select---") {
                    $query->where('fee_collections.branch_id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('fee_collections.branch_id', $branch_ids);
                }

                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('boards.id', $request['boards']);
                }

                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('programs.id', $request['programs']);
                }

                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('classes.id', $request['classes']);
                }

                if ($request['intake'] != null && $request['intake'] != "null") {
                    $query->where('intake.id', $request['intake']);
                }

                if ($request['sections'] != null && $request['sections'] != "null" && $request['sections'] != '---Select---') {
                    $query->where('sections.id', $request['sections']);
                }

                if ($request['bank_id'] != null && $request['bank_id'] != "null") {
                    $query->where('erp_ledgers.id', $request['bank_id']);
                }

            })
            ->select('erp_ledgers.name as ledger_name', 'guardian_details.cnic', 'students.registered_session', 'classes.name as class_name', 'guardian_details.guardian_first_name', 'guardian_details.guardian_last_name', 'fee_collections.id as fee_collection_id', 'fee_collections.*', 'students.id as student_id', 'students.reg_no', 'students.reg_date', 'students.home_phone', 'students.first_name as first_name', 'students.last_name as last_name', 'students.date_of_birth', 'students.reg_date', 'students.mobile_1')
            ->distinct()
            ->orderby('fee_collections.paid_date', 'asc')
            ->limit(800)
            ->get();

        $array = array();
        foreach ($students as $std) {
            $query = DB::table('fee_collection_detail')->join('fee_heads', 'fee_heads.id', '=', 'fee_collection_detail.fee_head_id')->rightjoin('erp_fee_head', 'erp_fee_head.id', '=', 'fee_heads.erp_fees_head_id')->where('fc_id', $std->fee_collection_id)->orderby('erp_fee_head.id', 'asc')->groupBy('erp_fee_head.id')->select('erp_fee_head.id', DB::raw('SUM(fee_collection_detail.amount) as amount'), DB::raw('SUM(fee_collection_detail.arreas) as arreas'))->get();
            $tax = $std->paid_amount - $std->arreas_amount - $std->fine - $std->total_amount;
            $array[] = array('bank' => $std->ledger_name, 'class_name' => $std->class_name, 'tax' => $tax, 'reg_no' => $std->reg_no, 'fee' => $query, 'name' => $std->first_name . ' ' . $std->last_name, 'father' => $std->guardian_first_name . ' ' . $std->guardian_last_name, 'cnic' => $std->cnic, 'bill_no' => $std->bill_no, 'paid_date' => $std->paid_date, 'term' => $std->fee_term_id, 'arreas_amount' => $std->arreas_amount, 'fine' => $std->fine, 'total' => $std->paid_amount, 'starting_date' => $std->starting_date, 'ending_date' => $std->ending_date, 'session_id' => $std->registered_session, 'fc_id' => $std->id);
        }

        $dateRange = null;
        $branch = null;
        $board = null;
        $session = null;
        $company = null;
        $program = null;
        $class = null;
        $intake = null;
        $section = null;
        $bank = null;

        if ($request->from != null && $request->from != "null" || $request->To != null && $request->To != "null") {
            $dateRange = $request->from . ' - ' . $request->To;
        }

        if ($request['session_id'] != null && $request['session_id'] != "null") {
            $session = Session::where('id', $request['session_id'])->value('title');
        }

        if ($request['company_id'] != null && $request['company_id'] != '---Select---') {
            $company = Company::where('id', $request['company_id'])->value('name');
        }

        if ($request['branch_id'] != null && $request['branch_id'] != '---Select---') {
            $branch = Branches::where('id', $request['branch_id'])->value('name');
        }

        if ($request['boards'] != null && $request['boards'] != "null") {
            $board = Board::where('id', $request['boards'])->value('name');
        }

        if ($request['programs'] != null && $request['programs'] != "null") {
            $program = Program::where('id', $request['programs'])->value('name');
        }

        if ($request['classes'] != null && $request['classes'] != "null") {
            $class = Classes::where('id', $request['classes'])->value('name');
        }

        if ($request['intake'] != null && $request['intake'] != "null") {
            $intake = InTake::where('id', $request['intake'])->value('name');
        }

        if ($request['sections'] != null && $request['sections'] != "null") {
            $section = Section::where('id', $request['sections'])->value('name');
        }

        if ($request['bank_id'] != null && $request['bank_id'] != "null") {
            $bank = Ledger::where('id', $request['bank_id'])->value('name');
        }

        $dataArray = [
            'dateRange' => $dateRange,
            'session' => $session,
            'company' => $company,
            'branch' => $branch,
            'board' => $board,
            'program' => $program,
            'class' => $class,
            'intake' => $intake,
            'section' => $section,
            'bank' => $bank,
            'erp_fee_heads' => ErpFeeHead::orderBy('id', 'asc')->get(),
        ];

        if ($request->type == 'print') {
            $content = View::make('reports.student_head_wise_received_fee_report.pdf', compact('array', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('StudentHeadWiseReceivedFeeReport.pdf', 'D');
        } elseif ($request->type == 'excel') {
            return self::excel_student_head_wise_fee_report($array, $dataArray);
        } else {
            return response()->json(['data' => $array]);
        }
    }

    public function student_head_wise_receivable_fee_report()
    {
        $sessions = Session::SessionList();
//        $companies = Company::CompanyList();
//        $banks = Ledger::where('parent_type', '!=', null)->get();
        $erp_fee_heads = ErpFeeHead::orderBy('id', 'asc')->get();
        $company = Company::get();

        return view('reports.student_head_wise_receivable_fee_report.index', compact('sessions', 'company', 'erp_fee_heads'));
    }

    public function student_head_wise_receivable_fee_report_print(Request $request)
    {
        $students = DB::table('students')->whereNull('students.deleted_at')
            ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
            ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('parent_details', 'parent_details.students_id', '=', 'students.id')
            ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
            ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
            ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->join('sections', 'sections.id', '=', 'active_session_sections.section_id')
            ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
            ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
//            ->join('erp_ledgers', 'erp_ledgers.id', '=', 'fee_collections.bank_ledger_id')
            ->where('admission_status', 'Regular')
            ->whereIn('fee_collections.fee_status', [1, 3])
            ->whereBetween('fee_collections.due_date', [$request->from, $request->To])
            ->where('fee_collections.cancel_voucher', 'No')
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }

                if ($request['branch_id'] != null && $request['branch_id'] != "null" && $request['branch_id'] != "---Select---") {
                    $query->where('fee_collections.branch_id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('fee_collections.branch_id', $branch_ids);
                }

                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('boards.id', $request['boards']);
                }

                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('programs.id', $request['programs']);
                }

                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('classes.id', $request['classes']);
                }

                if ($request['intake'] != null && $request['intake'] != "null") {
                    $query->where('intake.id', $request['intake']);
                }

                if ($request['sections'] != null && $request['sections'] != "null" && $request['sections'] != '---Select---') {
                    $query->where('sections.id', $request['sections']);
                }

//                if ($request['bank_id'] != null && $request['bank_id'] != "null") {
//                    $query->where('erp_ledgers.id', $request['bank_id']);
//                }

            })
            ->select('students.reg_no as ledger_name', 'guardian_details.cnic', 'students.registered_session', 'classes.name as class_name', 'guardian_details.guardian_first_name', 'guardian_details.guardian_last_name', 'fee_collections.id as fee_collection_id', 'fee_collections.*', 'students.id as student_id', 'students.reg_no', 'students.reg_date', 'students.home_phone', 'students.first_name as first_name', 'students.last_name as last_name', 'students.date_of_birth', 'students.reg_date', 'students.mobile_1')
            ->distinct()
            ->orderby('fee_collections.due_date', 'asc')
            ->limit(800)
            ->get();

        $array = array();
        foreach ($students as $std) {
            $query = DB::table('fee_collection_detail')->join('fee_heads', 'fee_heads.id', '=', 'fee_collection_detail.fee_head_id')->rightjoin('erp_fee_head', 'erp_fee_head.id', '=', 'fee_heads.erp_fees_head_id')->where('fc_id', $std->fee_collection_id)->orderby('erp_fee_head.id', 'asc')->groupBy('erp_fee_head.id')->select('erp_fee_head.id', DB::raw('SUM(fee_collection_detail.amount) as amount'), DB::raw('SUM(fee_collection_detail.arreas) as arreas'))->get();
            $tax = $std->paid_amount - $std->arreas_amount - $std->fine - $std->total_amount;
            $array[] = array('class_name' => $std->class_name, 'tax' => $tax, 'reg_no' => $std->reg_no, 'fee' => $query, 'name' => $std->first_name . ' ' . $std->last_name, 'father' => $std->guardian_first_name . ' ' . $std->guardian_last_name, 'cnic' => $std->cnic, 'bill_no' => $std->bill_no, 'paid_date' => $std->paid_date, 'due_date' => $std->due_date, 'term' => $std->fee_term_id, 'arreas_amount' => $std->arreas_amount, 'fine' => $std->fine, 'total' => $std->paid_amount, 'starting_date' => $std->starting_date, 'ending_date' => $std->ending_date, 'session_id' => $std->registered_session, 'fc_id' => $std->id);
        }

        $dateRange = null;
        $branch = null;
        $board = null;
        $session = null;
        $company = null;
        $program = null;
        $class = null;
        $intake = null;
        $section = null;
        $bank = null;

        if ($request->from != null && $request->from != "null" || $request->To != null && $request->To != "null") {
            $dateRange = $request->from . ' - ' . $request->To;
        }

        if ($request['session_id'] != null && $request['session_id'] != "null") {
            $session = Session::where('id', $request['session_id'])->value('title');
        }

        if ($request['company_id'] != null && $request['company_id'] != '---Select---') {
            $company = Company::where('id', $request['company_id'])->value('name');
        }

        if ($request['branch_id'] != null && $request['branch_id'] != '---Select---') {
            $branch = Branches::where('id', $request['branch_id'])->value('name');
        }

        if ($request['boards'] != null && $request['boards'] != "null") {
            $board = Board::where('id', $request['boards'])->value('name');
        }

        if ($request['programs'] != null && $request['programs'] != "null") {
            $program = Program::where('id', $request['programs'])->value('name');
        }

        if ($request['classes'] != null && $request['classes'] != "null") {
            $class = Classes::where('id', $request['classes'])->value('name');
        }

        if ($request['intake'] != null && $request['intake'] != "null") {
            $intake = InTake::where('id', $request['intake'])->value('name');
        }

        if ($request['sections'] != null && $request['sections'] != "null") {
            $section = Section::where('id', $request['sections'])->value('name');
        }

        $dataArray = [
            'dateRange' => $dateRange,
            'session' => $session,
            'company' => $company,
            'branch' => $branch,
            'board' => $board,
            'program' => $program,
            'class' => $class,
            'intake' => $intake,
            'section' => $section,
            'erp_fee_heads' => ErpFeeHead::orderBy('id', 'asc')->get(),
        ];

        if ($request->type == 'print') {
            $content = View::make('reports.student_head_wise_receivable_fee_report.pdf', compact('array', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('StudentHeadWiseReceivableFeeReport.pdf', 'D');
        } elseif ($request->type == 'excel') {
            return self::excel_student_head_wise_fee_report($array, $dataArray);
        } else {
            return response()->json(['data' => $array]);
        }
    }

    public function excel_student_head_wise_fee_report($array, $dataArray)
    {
        header('Content-Type: application/vnd.ms-excel charset=UTF-8');
        header('Content-disposition: attachment; filename=StudentHeadWiseFeeReport.xls');
        $data = '';

        $data .= '<style>
                table{width: 100%;}
                td,th {
                    border: 0.1pt solid #ccc;
                }
                </style>';
        $data .= '<div class="panel-body pad table-responsive">
                    <table align="center">
                        <tbody>
                        <tr>
                            <td colspan="4" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['dateRange'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['company'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['branch'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <h3><span style="border-bottom: double;">Student Head Wise Fee Report</span></h3>
                            </td>
                        </tr>';

        $data .= '<tr>
            <td colspan="4" align="center">
                <span style="border-bottom: dot-dash;">';

        if ($dataArray['board'] != null) {
            $data .= '<span style="font-weight: bold">Board: </span>' . $dataArray['board'];
        }
        if ($dataArray['program'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Program: </span>' . $dataArray['program'];
        }
        if ($dataArray['class'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Class: </span>' . $dataArray['class'];
        }
        if ($dataArray['intake'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Intake: </span>' . $dataArray['intake'];
        }
        if ($dataArray['section'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Section: </span>' . $dataArray['section'];
        }

        $data .= '</span>
            </td>
        </tr>
        </tbody>
    </table>';

        $data .= "<table class='table' style='width:100 %;'>
            <thead>
            <tr>
                <th>Sr.#</th>
                <th>Admission No</th>
                <th>Student Name</th>
                <th>Father's Name</th>
                <th>CNIC</th>
                <th>Class Name</th>
                <th>Bill No</th>
                <th>Due Date</th>
                <th>Paid Date</th>
                <th>Installment</th>";

        foreach ($dataArray['erp_fee_heads'] as $fee) {
            $data .= '<th>' . $fee->title . '</th>';
        }

        $data .= '<th>Arrears</th>
                <th>Fine</th>
                <th>Tax</th>
                <th>Total</th>
                <th>Account No</th>
            </tr>
            </thead>';

        $i = 1;

        foreach ($array as $single) {
            $data .= '<tr class="tr" style="text-align: center !important;">
                    <td>' . $i++ . '</td>
                    <td>' . $single['reg_no'] . '</td>
                    <td>' . $single['name'] . '</td>
                    <td>' . $single['father'] . '</td>
                    <td>' . $single['cnic'] . '</td>
                    <td>' . $single['class_name'] . '</td>
                    <td>' . $single['bill_no'] . '</td>
                    <td>' . $single['due_date'] . '</td>
                    <td>' . $single['paid_date'] . '</td>
                    <td>' . $single['term'] . ' Installment</td>';

            $previous_data = $single['fee'];

            foreach ($dataArray['erp_fee_heads'] as $fee) {
                $validation = 0;
                for ($loop = 0; $loop < count($previous_data); $loop++) {
                    if ($single["fee"][$loop]->id == $fee->id) {
                        $data .= '<td>' . $single["fee"][$loop]->amount . '</td>';
                        $validation++;
                    }
                }
                if ($validation == 0) {
                    $data .= '<td>-</td>';
                }
            }

            $data .= '<td>' . $single['arreas_amount'] . '</td>
                    <td>' . $single['fine'] . '</td>
                    <td>' . $single['tax'] . '</td>
                    <td>' . $single['total'] . '</td>
                    <td>' . $single['bank'] . '</td>
                </tr>';

        }

        $data .= '</tbody>
        </table>
    </div>';

        echo $data;

    }

    public function get_student_board_program_class_session_intake(Request $request)
    {
        $board_id = $request->board_id;
        $branch_id = $request->branch_id;
        $program_id = $request->program_id;
        $class_id = $request->class_id;
        $session_id = $request->session_id;
        $intake_id = $request->intake_id;

        return ActiveSession::join('active_session_sections', 'active_session_sections.active_session_id', '=', 'active_sessions.id')
            ->join('sections', 'sections.id', '=', 'active_session_sections.section_id')
            ->where('branch_id', $branch_id)
            ->where('board_id', $board_id)
            ->where('program_id', $program_id)
            ->where('class_id', $class_id)
            ->where('session_id', $session_id)
            ->where('intake_id', $intake_id)
            ->groupBy('active_session_sections.section_id')
            ->get();

    }

    public function chronic_report()
    {
        $sessions = Session::SessionList();
//        $companies = Company::CompanyList();
        $company = Company::get();
        return view('reports.chronic_report.index', compact('sessions', 'company'));

    }

    public function chronic_report_print(Request $request)
    {
        $student = DB::table('students')->whereNull('students.deleted_at')
            ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
            ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
            ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
            ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
            ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'active_sessions.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
            ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
            ->join('classes', 'classes.id', '=', 'active_sessions.class_id')
            ->join('sections', 'sections.id', '=', 'active_session_sections.section_id')
            ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
            ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
            ->where('students.sos_status', '!=', 'InActive')
            ->where('admission_status', 'Regular')
            ->where('active_sessions.session_id', $request->session_id)
            ->where('cancel_voucher', 'No')
            ->where('fee_status', '1')
            ->where('fee_collections.due_date', '<', date('Y-m-d'))
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['branch_id'] != null && $request['branch_id'] != "null" && $request['branch_id'] != '---Select---') {
                    $query->where('erp_branches.id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('erp_branches.id', $branch_ids);
                }
                if ($request['boards'] != null && $request['boards'] != "null" && $request['boards'] != '---Select---') {
                    $query->where('boards.id', $request['boards']);
                }
                if ($request['programs'] != null && $request['programs'] != "null" && $request['programs'] != '---Select---') {
                    $query->where('programs.id', $request['programs']);
                }
                if ($request['classes'] != null && $request['classes'] != "null" && $request['classes'] != '---Select---') {
                    $query->where('classes.id', $request['classes']);
                }
                if ($request['sections'] != null && $request['sections'] != "null" && $request['sections'] != '---Select---') {
                    $query->where('sections.id', $request['sections']);
                }
                if ($request['intake'] != null && $request['intake'] != "null" && $request['intake'] != '---Select---') {
                    $query->where('intake.id', $request['intake']);
                }
            })
            ->select('students.reg_no', 'fee_collections.*', 'students.id as student_list_id', 'erp_branches.name as branch_name', 'boards.name as board_name', 'programs.name as program_name', 'classes.name as class_name', 'sections.name as section_name', 'students.first_name as first_name', 'students.last_name as last_name', 'students.middle_name as middle_name', 'students.date_of_birth', 'students.reg_date', 'students.address')
            ->orderBy('fee_collections.students_id', 'ASC')
            ->orderBy('erp_branches.id', 'ASC')
            ->orderBy('classes.id', 'ASC')
            ->orderBy('fee_collections.fee_term_id', 'ASC')
            ->get();

        $array = array();
        $existing = "";
        $customize_string = "";
        $new_id = "";
        $student_name = "";
        $exisitng_studnet = "";
        $branch_id = "";
        $class_id = "";

        $class_id = "";
        $student_id = 0;
        $branch_name = "";
        $class_name = "";
        foreach ($student as $students) {
            $new_id = $students->reg_no;
            $branch_name = $students->branch_name;

            $student_name = $students->first_name . " " . $students->middle_name . " " . $students->last_name;

            if ($new_id == $existing) {
                $branch_id = $students->branch_id;
                $class_id = $students->class_id;
                $student_id = $students->student_list_id;
                $customize_string = $customize_string . ", " . $students->fee_term_id . "- Installment";
                $student_name = $students->first_name . " " . $students->middle_name . " " . $students->last_name;
                $class_name = $students->class_name;
            } else {
                if ($existing != "") {
                    $array[] = array('branch_id' => $branch_id, 'class_id' => $class_id, 'reg_no' => $existing, 'name' => $exisitng_studnet, 'term' => $customize_string, 'branch_name' => $branch_name, 'class_name' => $class_name, 'student_id' => $student_id);
                }
                $exisitng_studnet = $students->first_name . " " . $students->middle_name . " " . $students->last_name;
                $existing = $students->reg_no;
                $customize_string = $students->fee_term_id . "- Installment";
                $branch_id = $students->branch_id;
                $class_id = $students->class_id;
                $student_id = $students->student_list_id;
                $class_name = $students->class_name;

            }

        }

        $array[] = array('branch_id' => $branch_id, 'class_id' => $class_id, 'reg_no' => $new_id, 'name' => $student_name, 'term' => $customize_string, 'branch_name' => $branch_name, 'class_name' => $class_name, 'student_id' => $student_id);
        $student = $array;
        arsort($student);
        $array_list = array();

        foreach ($student as $std) {

            $get = FeeCollection::where('students_id', $std['student_id'])->where('fee_status', 3)->where('session_id', $request->session_id)->orderBy('id', 'DESC')->Limit('1')->value('id');

            $get_list = FeeCollection::where('students_id', $std['student_id'])->where('session_id', $request->session_id)->where('id', '>', (int)$get)->where('due_date', '<', date('y-m-d'))->skip(1)->take(12)->orderBy('fee_collections.id', 'DESC')->get();
            $custome = '';
            foreach ($get_list as $list) {
                $custome = $custome . ',' . $list->fee_term_id . '- Installment';
            }
            $array_list[] = array('branch_id' => $std['branch_id'], 'class_id' => $std['class_id'], 'reg_no' => $std['reg_no'], 'name' => $std['name'], 'term' => $std['term'], 'branch_name' => $std['branch_name'], 'class_name' => $std['class_name'], 'shift' => $custome);

        }

        $branch = null;
        $board = null;
        $session = null;
        $program = null;
        $class = null;
        $section = null;
        $company = null;
        $intake = null;

        if ($request['branch_id'] != null && $request['branch_id'] != '---Select---') {
            $branch = Branches::where('id', $request['branch_id'])->value('name');
        }

        if ($request['boards'] != null && $request['boards'] != "null") {
            $board = Board::where('id', $request['boards'])->value('name');
        }

        if ($request['company_id'] != null && $request['company_id'] != "null") {
            $company = Company::where('id', $request['company_id'])->value('name');
        }

        if ($request['programs'] != null && $request['programs'] != "null") {
            $program = Program::where('id', $request['programs'])->value('name');
        }

        if ($request['classes'] != null && $request['classes'] != "null") {
            $class = Classes::where('id', $request['classes'])->value('name');
        }

        if ($request['sections'] != null && $request['sections'] != "null") {
            $section = Section::where('id', $request['sections'])->value('name');
        }

        if ($request['session_id'] != null && $request['session_id'] != "null") {
            $session = Session::where('id', $request['session_id'])->value('title');
        }

        if ($request['intake'] != null && $request['intake'] != "null") {
            $intake = InTake::where('id', $request['intake'])->value('name');
        }

        $dataArray = [
            'session' => $session,
            'company' => $company,
            'branch' => $branch,
            'board' => $board,
            'program' => $program,
            'class' => $class,
            'intake' => $intake,
            'section' => $section,
        ];

        if ($request->type == 'print') {
            $content = View::make('reports.chronic_report.pdf', compact('array_list', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('ChronicReport.pdf', 'D');
        } elseif ($request->type == 'excel') {
            return self::excel_chronic_report($array_list, $dataArray);
        } else {
            return response()->json(['data' => $array_list]);
        }

    }

    public function excel_chronic_report($array, $dataArray)
    {
        header('Content-Type: application/vnd.ms-excel charset=UTF-8');
        header('Content-disposition: attachment; filename=StudentHeadWiseFeeReport.xls');
        $data = '';

        $data .= '<style>
                table{width: 100%;}
                td,th {
                    border: 0.1pt solid #ccc;
                }
                </style>';
        $data .= '<div class="panel-body pad table-responsive">
                    <table align="center">
                        <tbody>
                        <tr>
                            <td colspan="4" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['session'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['company'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['branch'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="center">
                                <h3><span style="border-bottom: double;">Chronic Report</span></h3>
                            </td>
                        </tr>';

        $data .= '<tr>
            <td colspan="4" align="center">
                <span style="border-bottom: dot-dash;">';

        if ($dataArray['board'] != null) {
            $data .= '<span style="font-weight: bold">Board: </span>' . $dataArray['board'];
        }
        if ($dataArray['program'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Program: </span>' . $dataArray['program'];
        }
        if ($dataArray['class'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Class: </span>' . $dataArray['class'];
        }
        if ($dataArray['intake'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Intake: </span>' . $dataArray['intake'];
        }
        if ($dataArray['section'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Section: </span>' . $dataArray['section'];
        }

        $data .= '</span>
            </td>
        </tr>
        </tbody>
    </table>';

        $data .= "<table class='table' style='width:100 %;'>
            <thead>
            <tr>
                <th>Admission No</th>
                <th>Student Name</th>
                <th>Current Month Defaulter</th>
                <th>Previous Defaulter</th>
            </tr>
            </thead>";

        $k = 1;
        $data .= '<tbody>';

        $total_students = 0; // Initialize the variable to store total students
        $existing_branch_name = ''; // Initialize the variable to store existing branch name
        $existing_class = ''; // Initialize the variable to store existing class name

        foreach ($array as $item) {
            $branch_name = $item['branch_name'];
            if ($existing_branch_name == $branch_name) {
                $new_class = $item['class_name'];
                if ($existing_class == $new_class) {
                    $total_students++;

                    $data .= "<tr>
                <td>" . $item['reg_no'] . "</td>
                <td>" . $item['name'] . "</td>
                <td style='color:white;background-color:#ef4545;'>" . $item['term'] . "</td>
                <td style='color:white;background-color:#ef4545;'>" . $item['shift'] . "</td>
            </tr>";
                    $k++;
                } else {
                    $data .= '<tr style="text-align: center;background-color: #bbb1b1;color: black;font-weight: 700;">
                <td>Total Students:</td>
                <td colspan="4">' . $total_students . '</td>
            </tr>';

                    $total_students = 0;
                    $total_students++;
                    $existing_class = $item['class_name'];

                    $data .= '<tr style="background: #9506e2;color: black;text-align: left;font-weight: 700;">
                <td colspan="4">' . $item['class_name'] . '</td>
            </tr>
            <tr>
                <td>' . $item['reg_no'] . '</td>
                <td>' . $item['name'] . '</td>
                <td style="color:white;background-color:#ef4545;">' . $item['term'] . '</td>
                <td style="color:white;background-color:#ef4545;">' . $item['shift'] . '</td>
            </tr>';

                    $k++;
                }
            } else {
                if ($k > 1) {

                    $data .= ' <tr style="text-align: center;background-color: #bbb1b1;color: black;font-weight: 700;">
                <td>Total Students:</td>
                <td colspan="4">' . $total_students . '</td>
            </tr>';

                    $total_students = 0;
                    $total_students++;
                }

                $existing_branch_name = $item['branch_name'];
                $existing_class = $item['class_name'];

                $data .= '<tr style="background: #9506e2;color: black;text-align: left;font-weight: 700;">
                <td colspan="4">' . $item['branch_name'] . '</td>
            </tr>

            <tr style="background: #9506e2;color: black;text-align: left;font-weight: 700;">
                <td colspan="4">' . $item['class_name'] . '</td>
            </tr>

            <tr>
                <td>' . $item['reg_no'] . '</td>
                <td>' . $item['name'] . '</td>
                <td style="color:white;background-color:#ef4545;">' . $item['term'] . '</td>
                <td style="color:white;background-color:#ef4545;">' . $item['shift'] . '</td>
            </tr>';

                $k++;
            }
        }

        $data .= '<tr style="text-align: center;background-color: #bbb1b1;color: black;font-weight: 700;">
                <td>Total Students:</td>
                <td colspan="3">' . $total_students . '</td>
            </tr>';

        echo $data;

    }

    public function student_head_wise_fee_merge_report()
    {
        $sessions = Session::SessionList();
//        $companies = Company::CompanyList();
        $company = Company::get();
        $erp_fee_heads = ErpFeeHead::orderBy('id', 'asc')->get();

        return view('reports.student_head_wise_fee_merge_report.index', compact('sessions', 'company', 'erp_fee_heads'));
    }

    public function student_head_wise_fee_merge_report_print(Request $request)
    {
        $students = DB::table('students')->whereNull('students.deleted_at')
            ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
            ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
            ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
            ->join('intake', 'intake.id', '=', 'fee_collections.intake_id')
            ->where('students.sos_status', '!=', 'InActive')
            ->where('admission_status', 'Regular')
            ->where('cancel_voucher', 'No')
            ->whereBetween('fee_collections.due_date', [$request->from, $request->To])
            ->where(function ($query) use ($request) {

                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }

                if ($request['branch_id'] != null && $request['branch_id'] != "null" && $request['branch_id'] != "---Select---") {
                    $query->where('fee_collections.branch_id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('fee_collections.branch_id', $branch_ids);
                }

                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('fee_collections.board_id', $request['boards']);
                }

                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('fee_collections.program_id', $request['programs']);
                }

                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('classes.id', $request['classes']);
                }

                if ($request['intake'] != null && $request['intake'] != "null") {
                    $query->where('intake.id', $request['intake']);
                }

            })
            ->select(DB::raw('sum(total_amount) as paid_amount_overall'), DB::raw('count(*) as count'), DB::raw('sum(arreas_amount) as arreas_bills_amount'), 'intake.name as intake_name', 'students.sos_status', 'students.staff_ref', 'classes.name as class_name', 'students.first_paid_date', 'fee_collections.id as fee_collection_id', 'students.id as students_id', 'students.reg_no', 'students.reg_date', 'students.home_phone', 'students.first_name as first_name', 'fee_collections.*', 'students.last_name as last_name', 'students.date_of_birth', 'students.reg_date', 'students.mobile_1')
            ->groupby('fee_collections.students_id')
            ->orderby('fee_collections.class_id', 'asc')
            ->get();

        $array = array();
        foreach ($students as $std) {
            $student_wise_total = $std->paid_amount_overall + $std->arreas_bills_amount;
            $query = DB::table('fee_collection_detail')->join('fee_collections', 'fee_collections.id', '=', 'fee_collection_detail.fc_id')->join('fee_heads', 'fee_heads.id', '=', 'fee_collection_detail.fee_head_id')->rightjoin('erp_fee_head', 'erp_fee_head.id', '=', 'fee_heads.erp_fees_head_id')->where('fee_collections.students_id', $std->students_id)->where('fee_collections.branch_id', $request->branch_id)
                ->where('fee_collections.session_id', $request->session_id)->orderby('erp_fee_head.id', 'asc')->groupBy('erp_fee_head.id')->where('cancel_voucher', 'No')->select('erp_fee_head.id', DB::raw('SUM(fee_collection_detail.amount) as amount'), DB::raw('SUM(fee_collection_detail.arreas) as arreas', DB::raw('first_paid_date as paid_date')))->get();

            $tax = 0;
            $date1 = $std->first_paid_date;
            $end_date = date('Y-m-d');
            $date2 = $end_date;
            $diff = abs(strtotime($date2) - strtotime($date1));

            $years = floor($diff / (365 * 60 * 60 * 24));

            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $array[] = array('count' => $std->count, 'first_due_date' => $std->first_paid_date, 'month' => $months, 'intake' => $std->intake_name, 'class_name' => $std->class_name, 'tax' => $tax, 'paid_amount_overall' => $student_wise_total, 'sos_status' => $std->sos_status, 'staff_ref' => $std->staff_ref, 'reg_no' => '/' . $std->reg_no, 'fee' => $query, 'name' => $std->first_name . ' ' . $std->last_name, 'father' => null, 'students_ids' => $std->students_id, 'cnic' => null, 'bill_no' => $std->bill_no, 'paid_date' => $std->paid_date, 'term' => $std->fee_term_id, 'arreas_amount' => $std->arreas_amount, 'fine' => $std->fine, 'total' => $std->paid_amount, 'starting_date' => $std->starting_date, 'ending_date' => $std->ending_date, 'session_id' => $std->session_id, 'fc_id' => $std->id);
        }

        $dateRange = null;
        $branch = null;
        $board = null;
        $session = null;
        $company = null;
        $program = null;
        $class = null;
        $intake = null;
        $section = null;

        if ($request->from != null && $request->from != "null" || $request->To != null && $request->To != "null") {
            $dateRange = $request->from . ' - ' . $request->To;
        }

        if ($request['session_id'] != null && $request['session_id'] != "null") {
            $session = Session::where('id', $request['session_id'])->value('title');
        }

        if ($request['company_id'] != null && $request['company_id'] != '---Select---') {
            $company = Company::where('id', $request['company_id'])->value('name');
        }

        if ($request['branch_id'] != null && $request['branch_id'] != '---Select---') {
            $branch = Branches::where('id', $request['branch_id'])->value('name');
        }

        if ($request['boards'] != null && $request['boards'] != "null") {
            $board = Board::where('id', $request['boards'])->value('name');
        }

        if ($request['programs'] != null && $request['programs'] != "null") {
            $program = Program::where('id', $request['programs'])->value('name');
        }

        if ($request['classes'] != null && $request['classes'] != "null") {
            $class = Classes::where('id', $request['classes'])->value('name');
        }

        if ($request['intake'] != null && $request['intake'] != "null") {
            $intake = InTake::where('id', $request['intake'])->value('name');
        }

        if ($request['sections'] != null && $request['sections'] != "null") {
            $section = Section::where('id', $request['sections'])->value('name');
        }

        $dataArray = [
            'dateRange' => $dateRange,
            'session' => $session,
            'company' => $company,
            'branch' => $branch,
            'board' => $board,
            'program' => $program,
            'class' => $class,
            'intake' => $intake,
            'section' => $section,
            'erp_fee_heads' => ErpFeeHead::orderBy('id', 'asc')->get(),
        ];

        if ($request->type == 'print') {
//            return view('reports.student_head_wise_fee_merge_report.pdf', compact('array', 'dataArray'));
            $content = View::make('reports.student_head_wise_fee_merge_report.pdf', compact('array', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('StudentHeadWiseMergeFeeReport.pdf', 'D');
        } elseif ($request->type == 'excel') {
            return self::excel_student_head_wise_fee_merge_report($array, $dataArray);
        } else {
            return response()->json(['data' => $array]);
        }
    }

    public function excel_student_head_wise_fee_merge_report($array, $dataArray)
    {
        header('Content-Type: application/vnd.ms-excel charset=UTF-8');
        header('Content-disposition: attachment; filename=StudentHeadWiseMergeFeeReport.xls');
        $data = '';

        $data .= '<style>
                table{width: 100%;}
                td,th {
                    border: 0.1pt solid #ccc;
                }
                </style>';
        $data .= '<div class="panel-body pad table-responsive">
                    <table align="center">
                        <tbody>
                        <tr>
                            <td colspan="9" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['dateRange'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['company'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['branch'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" align="center">
                                <h3><span style="border-bottom: double;">Student Head Wise Merge Fee Report</span></h3>
                            </td>
                        </tr>';

        $data .= '<tr>
            <td colspan="9" align="center">
                <span style="border-bottom: dot-dash;">';

        if ($dataArray['board'] != null) {
            $data .= '<span style="font-weight: bold">Board: </span>' . $dataArray['board'];
        }
        if ($dataArray['program'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Program: </span>' . $dataArray['program'];
        }
        if ($dataArray['class'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Class: </span>' . $dataArray['class'];
        }
        if ($dataArray['intake'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Intake: </span>' . $dataArray['intake'];
        }
        if ($dataArray['section'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Section: </span>' . $dataArray['section'];
        }

        $data .= '</span>
            </td>
        </tr>
        </tbody>
    </table>';

        $data .= "<table class='table' style='width:100 %;'>
            <thead>
            <tr>
                <th>Sr.#</th>
                <th>Student ID</th>
                <th>Admission No</th>
                <th>Admission Date</th>
                <th>Student Name</th>
                <th>Staff Reference</th>
                <th>SOS Status</th>
                <th>Class Name</th>
                <th>Installments</th>";

        $colCount = 9;
        $i = 1;
        $k = 1;
        $total = 0;
        $head_total = 0;
        $head_total1 = 0;
        $tuition_fee = 0;

        foreach ($dataArray['erp_fee_heads'] as $fee) {
            $data .= '<th>' . $fee->title . '</th>';
            ++$colCount;
        }

        $data .= "<th>Total</th>
                <th>Months</th>
                <th>Monthly Fee</th>
                <th>Monthly Increase</th>
                <th>After Increase</th>
                </tr>
            </thead>";

        foreach ($array as $single) {
            $data .= '<tr class="tr" style="text-align: center !important;">
                    <td>' . $i++ . '</td>
                    <td>' . $single['intake'] . '</td>
                    <td>' . $single['reg_no'] . '</td>
                    <td>' . $single['first_due_date'] . '</td>
                    <td>' . $single['name'] . '</td>
                    <td>' . $single['staff_ref'] . '</td>
                    <td>' . $single['sos_status'] . '</td>
                    <td>' . $single['class_name'] . '</td>
                    <td>' . $single['count'] . ' Installment</td>';

            $previous_data = $single['fee'];

            foreach ($dataArray['erp_fee_heads'] as $fee) {
                $validation = 0;
                if ($previous_data != null) {
                    for ($loop = 0; $loop < count($previous_data); $loop++) {
                        if ($single["fee"][$loop]->id == $fee->id) {
                            if ($single["fee"][$loop]->id == 5) {
                                $amount1 = $single["fee"][$loop]->amount;
                                $amount1 += $single["fee"][$loop]->arreas;
                                $tuition_fee = $tuition_fee + $amount1;
                            }
                            $amount = $single["fee"][$loop]->amount;
                            $amount = $amount + $single["fee"][$loop]->arreas;
                            $data .= '<td>' . number_format($amount) . '</td>';

                            $head_total = $head_total + $amount;
                            $validation++;
                        }
                    }
                }
                if ($validation == 0) {
                    $data .= '<td>-</td>';
                }
            }

            $total = $total + $single["paid_amount_overall"];
            if ($single["paid_amount_overall"] == $head_total) {
                $data .= '<td style="background-color:lightgreen">' . number_format($single["paid_amount_overall"]) . '</td>';
            } else {
                $data .= '<td>' . number_format($single["paid_amount_overall"]) . '</td>';
            }

            $data .= '<td>' . $single["month"] . '</td>';

            $monthly_fee = $tuition_fee / $single["month"];
            $new_increased = $monthly_fee + 3000;

            $data .= '<td>' . number_format($monthly_fee) . '</td>
                    <td>3,000</td>
                    <td>' . number_format($new_increased) . '</td>
                </tr>';

            $tuition_fee = 0;
            $k++;

        }

        $data .= '<tr>
                <th style="text-align: right !important;" colspan="' . $colCount . '">Total</th>
                <th colspan="5" style="text-align: left !important;">' . number_format($total) . '</th>
            </tr>
            </tbody>
        </table>';

        echo $data;

    }

    public function student_head_wise_advance_fee_report()
    {
        $sessions = Session::SessionList();
//        $companies = Company::CompanyList();
        $company = Company::get();
        $banks = Ledger::where('parent_type', '!=', null)->get();
        $erp_fee_heads = ErpFeeHead::orderBy('id', 'asc')->get();

        return view('reports.student_head_wise_advance_fee_report.index', compact('sessions', 'company', 'banks', 'erp_fee_heads'));
    }

    public function student_head_wise_advance_fee_report_print(Request $request)
    {
        $students = DB::table('students')->whereNull('students.deleted_at')
            ->join('student_guardians', 'student_guardians.students_id', '=', 'students.id')
            ->join('guardian_details', 'student_guardians.guardians_id', '=', 'guardian_details.id')
            ->join('parent_details', 'parent_details.students_id', '=', 'students.id')
            ->join('fee_collections', 'fee_collections.students_id', '=', 'students.id')
            ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
            ->join('classes', 'classes.id', '=', 'fee_collections.class_id')
            ->join('erp_ledgers', 'erp_ledgers.id', '=', 'fee_collections.bank_ledger_id')
            ->where('students.status', 'Active')
            ->where('admission_status', 'Regular')
            ->where('fee_collections.fee_status', 3)
            ->where('fee_collections.cancel_voucher', 'No')
            ->whereBetween('paid_date', [$request->from, $request->To])
            ->where('fee_collections.session_id', $request->session_id)
            ->where(function ($query) use ($request) {
                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }

                if ($request['branch_id'] != null && $request['branch_id'] != "null" && $request['branch_id'] != "---Select---") {
                    $query->where('fee_collections.branch_id', $request['branch_id']);
                } else {
                    $branch_ids = PermissionCheck::check_branch();
                    $query->whereIn('fee_collections.branch_id', $branch_ids);
                }

                if ($request['boards'] != null && $request['boards'] != "null") {
                    $query->where('fee_collections.board_id', $request['boards']);
                }

                if ($request['programs'] != null && $request['programs'] != "null") {
                    $query->where('fee_collections.program_id', $request['programs']);
                }

                if ($request['classes'] != null && $request['classes'] != "null") {
                    $query->where('fee_collections.class_id', $request['classes']);
                }

                if ($request['intake'] != null && $request['intake'] != "null") {
                    $query->where('fee_collections.intake_id', $request['intake']);
                }

                if ($request['bank_id'] != null && $request['bank_id'] != "null") {
                    $query->where('erp_ledgers.id', $request['bank_id']);
                }

            })
            ->select('erp_branches.name as branch_name', 'erp_ledgers.name as ledger_name', 'guardian_details.cnic', 'students.registered_session', 'classes.name as class_name', 'guardian_details.guardian_first_name', 'guardian_details.guardian_last_name', 'fee_collections.id as fee_collection_id', 'fee_collections.*', 'students.id as student_id', 'students.reg_no', 'students.reg_date', 'students.home_phone', 'students.first_name as first_name', 'students.last_name as last_name', 'students.date_of_birth', 'students.reg_date', 'students.mobile_1')
            ->orderby('fee_collections.due_date', 'asc')
            ->get();

        $array = array();
        foreach ($students as $std) {
            $query = DB::table('fee_collection_detail')->rightjoin('erp_fee_head', 'erp_fee_head.id', '=', 'fee_collection_detail.erp_fee_head_id_direct')->where('fc_id', $std->fee_collection_id)->orderby('erp_fee_head.id', 'asc')->groupBy('erp_fee_head.id')->select('erp_fee_head.id', DB::raw('SUM(fee_collection_detail.amount) as amount'), DB::raw('SUM(fee_collection_detail.arreas) as arreas'))->get();
            $tax = $std->paid_amount - $std->arreas_amount - $std->fine - $std->total_amount;

            $array[] = array('bank' => $std->ledger_name, 'class_name' => $std->class_name, 'tax' => $tax, 'reg_no' => $std->reg_no, 'fee' => $query, 'name' => $std->first_name . ' ' . $std->last_name, 'father' => $std->guardian_first_name . ' ' . $std->guardian_last_name, 'cnic' => $std->cnic, 'bill_no' => $std->bill_no, 'paid_date' => $std->paid_date, 'term' => $std->fee_term_id, 'arreas_amount' => $std->arreas_amount, 'fine' => $std->fine, 'total' => $std->paid_amount, 'starting_date' => $std->starting_date, 'ending_date' => $std->ending_date, 'session_id' => $std->registered_session, 'fc_id' => $std->id, 'paid_amount' => $std->paid_amount);
        }

        $dateRange = null;
        $branch = null;
        $board = null;
        $session = null;
        $session_end_date = null;
        $company = null;
        $program = null;
        $class = null;
        $intake = null;
        $section = null;
        $bank = null;

        if ($request->from != null && $request->from != "null" || $request->To != null && $request->To != "null") {
            $dateRange = $request->from . ' - ' . $request->To;
        }

        if ($request['session_id'] != null && $request['session_id'] != "null") {
            $session = Session::where('id', $request['session_id'])->value('title');
            $session_end_date = Session::where('id', $request['session_id'])->value('end_year');
        }

        if ($request['company_id'] != null && $request['company_id'] != '---Select---') {
            $company = Company::where('id', $request['company_id'])->value('name');
        }

        if ($request['branch_id'] != null && $request['branch_id'] != '---Select---') {
            $branch = Branches::where('id', $request['branch_id'])->value('name');
        }

        if ($request['boards'] != null && $request['boards'] != "null") {
            $board = Board::where('id', $request['boards'])->value('name');
        }

        if ($request['programs'] != null && $request['programs'] != "null") {
            $program = Program::where('id', $request['programs'])->value('name');
        }

        if ($request['classes'] != null && $request['classes'] != "null") {
            $class = Classes::where('id', $request['classes'])->value('name');
        }

        if ($request['intake'] != null && $request['intake'] != "null") {
            $intake = InTake::where('id', $request['intake'])->value('name');
        }

        if ($request['sections'] != null && $request['sections'] != "null") {
            $section = Section::where('id', $request['sections'])->value('name');
        }

        if ($request['bank_id'] != null && $request['bank_id'] != "null") {
            $bank = Ledger::where('id', $request['bank_id'])->value('name');
        }

        $dataArray = [
            'dateRange' => $dateRange,
            'session' => $session,
            'company' => $company,
            'branch' => $branch,
            'board' => $board,
            'program' => $program,
            'class' => $class,
            'intake' => $intake,
            'section' => $section,
            'bank' => $bank,
            'erp_fee_heads' => ErpFeeHead::orderBy('id', 'asc')->get(),
            'session_end_date' => $session_end_date,
        ];

        if ($request->type == 'print') {
//            return view('reports.student_head_wise_advance_fee_report.pdf', compact('array', 'dataArray'));
            $content = View::make('reports.student_head_wise_advance_fee_report.pdf', compact('array', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('StudentHeadWiseAdvanceFeeReport.pdf', 'D');
        } elseif ($request->type == 'excel') {
            return self::excel_student_head_wise_advance_fee_report($array, $dataArray);
        } else {
            return response()->json(['data' => $array, 'session_end_date' => $session_end_date]);
        }
    }

    public function excel_student_head_wise_advance_fee_report($array, $dataArray)
    {
        header('Content-Type: application/vnd.ms-excel charset=UTF-8');
        header('Content-disposition: attachment; filename=StudentHeadWiseAdvanceFeeReport.xls');
        $data = '';

        $data .= '<style>
                table{width: 100%;}
                td,th {
                    border: 0.1pt solid #ccc;
                }
                </style>';
        $data .= '<div class="panel-body pad table-responsive">
                    <table align="center">
                        <tbody>
                        <tr>
                            <td colspan="9" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['dateRange'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['company'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['branch'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="9" align="center">
                                <h3><span style="border-bottom: double;">Student Head Wise Advance Fee Report</span></h3>
                            </td>
                        </tr>';

        $data .= '<tr>
            <td colspan="9" align="center">
                <span style="border-bottom: dot-dash;">';

        if ($dataArray['board'] != null) {
            $data .= '<span style="font-weight: bold">Board: </span>' . $dataArray['board'];
        }
        if ($dataArray['program'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Program: </span>' . $dataArray['program'];
        }
        if ($dataArray['class'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Class: </span>' . $dataArray['class'];
        }
        if ($dataArray['intake'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Intake: </span>' . $dataArray['intake'];
        }
        if ($dataArray['section'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Section: </span>' . $dataArray['section'];
        }
        if ($dataArray['bank'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Section: </span>' . $dataArray['bank'];
        }

        $data .= '</span>
            </td>
        </tr>
        </tbody>
    </table>';

        $data .= "<table class='table' style='width:100 %;'>
            <thead>
            <tr>
                <th>Sr.#</th>
                <th>Admission No</th>
                <th>Student Name</th>
                <th>Father Name</th>
                <th>CNIC</th>
                <th>Class Name</th>
                <th>Bill #</th>
                <th>Paid Date</th>
                <th>Installments</th>";

        $colCount = 9;
        $i = 1;
        $k = 1;
        $total = 0;
        $head_total = 0;
        $tuition_fee = 0;

        foreach ($dataArray['erp_fee_heads'] as $fee) {
            $data .= '<th>' . $fee->title . '</th>';
            ++$colCount;
        }

        $data .= '<th style="background-color:yellow;">Tuition Fee</th>
                <th style="background-color:yellow;">LMS Fee</th>
                <th style="background-color:yellow;">Safety Fee</th>
                <th>Arrears</th>
                <th>Fine</th>
                <th>Tax</th>
                <th>Total</th>
                <th>Diff/Issue</th>
                <th>Acc.#</th>
                <th>Starting</th>
                <th>Ending</th>
                </tr>
            </thead>';

        $i = 0;
        $tuition_fee = 0;
        $lms_fee = 0;
        $safety_fee = 0;
        $sub_total = 0;

        foreach ($array as $single) {
            $data .= '<tr class="tr" style="text-align: center !important;">
                    <td>' . ++$i . '</td>
                    <td>' . $single['reg_no'] . '</td>
                    <td>' . $single['name'] . '</td>
                    <td>' . $single['father'] . '</td>
                    <td>' . $single['cnic'] . '</td>
                    <td>' . $single['class_name'] . '</td>
                    <td>' . $single['bill_no'] . '</td>
                    <td>' . $single['paid_date'] . '</td>
                    <td>' . $single['term'] . ' Installment</td>';

            $previous_data = $single['fee'];

            foreach ($dataArray['erp_fee_heads'] as $fee) {
                $validation = 0;
                if ($previous_data != null) {
                    for ($loop = 0; $loop < count($previous_data); $loop++) {
                        if ($single["fee"][$loop]->id == $fee->id) {
                            $data .= '<td>' . number_format($single["fee"][$loop]->amount) . '</td>';

                            $validation++;
                            if ($single["fee"][$loop]->id == 5) {
                                $tuition_fee = $tuition_fee + $single["fee"][$loop]->amount;
                            }
                            if ($single["fee"][$loop]->id == 14) {
                                $lms_fee = $lms_fee + $single["fee"][$loop]->amount;
                            }
                            if ($single["fee"][$loop]->id == 8) {
                                $safety_fee = $safety_fee + $single["fee"][$loop]->amount;
                            }
                            $sub_total = $sub_total + $single["fee"][$loop]->amount;
                        }
                    }
                }
                if ($validation == 0) {
                    $data .= '<td>-</td>';
                }
            }

            $ending_date = new DateTime($single["ending_date"]);
            $session_end_date = new DateTime($dataArray['session_end_date']);

            if ($ending_date > $session_end_date) {

                $advance_difference = self::monthsBtwnDates($session_end_date->format('Y-m-d'), $ending_date->format('Y-m-d'));
                $ending_date->modify('+1 day');
                $difference_bills_month = self::monthsBtwnDates($single['starting_date'], $ending_date->format('Y-m-d'));

            } else {
                $tuition_fee = 0;
                $lms_fee = 0;
                $safety_fee = 0;
            }

            if ($tuition_fee > 0) {
                $tuition_fee = $tuition_fee / $difference_bills_month;
                $tuition_fee = $tuition_fee * $advance_difference;
            }
            if ($lms_fee > 0) {
                $lms_fee = $lms_fee / $difference_bills_month;
                $lms_fee = $lms_fee * $advance_difference;
            }
            if ($safety_fee > 0) {
                $safety_fee = $safety_fee / $difference_bills_month;
                $safety_fee = $safety_fee * $advance_difference;
            }

            $tax = $single["tax"];
            $fine = $single["fine"];
            $arreas_amount = $single["arreas_amount"];

            $sub_total = $tax + $fine + $arreas_amount;

            $data .= '<td style="background-color:yellow;">' . number_format($tuition_fee) . '</td>
                    <td style="background-color:yellow;">' . number_format($lms_fee) . '</td>
                    <td style="background-color:yellow;">' . number_format($safety_fee) . '</td>
                    <td>' . number_format($arreas_amount) . '</td>
                    <td>' . number_format($fine) . '</td>
                    <td>' . number_format($tax) . '</td>
                    <td>' . number_format($sub_total) . '</td>';

            $difference = $sub_total / $single["paid_amount"];

            $data .= '<td style="background-color:red;">' . number_format($difference) . '</td>
                    <td>' . $single["bank"] . '</td>
                    <td>' . $single["starting_date"] . '</td>
                    <td>' . $single["ending_date"] . '</td>';

        }

        $data .= '</tr>
            </tbody>
        </table>';

        echo $data;

    }

    public function monthsBtwnDates($startDate, $endDate)
    {
        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);

        $yearsDiff = $endDate->format('Y') - $startDate->format('Y');
        $monthsDiff = $endDate->format('n') - $startDate->format('n');

        return max(($yearsDiff * 12) + $monthsDiff, 0);
    }

    public function company_wise_receivable()
    {
        $sessions = Session::SessionList();
        $companies = Company::CompanyList();

        return view('reports.company_wise_receivable.index', compact('sessions', 'companies'));

    }

    public function company_wise_receivable_print(Request $request)
    {
        $company_id = $request->company_id;
        $session_id = $request->session_id;
        $array = array();
        $branch_name = '';
        $balance = 0;

        $session_record = Session::where('id', $session_id)->first();

        $query = FeeCollection::selectRaw('erp_companies.name as company_name,sum(tax_amount) as tax_amounts , sum(previous_session_default_amount) as previous_default, sum(other_tax) as other_taxes,sum(fine) as fines,sum(arreas_amount) as arreas,sum(total_amount) as revenue, sum(paid_amount) as recovered, fee_collections.*, erp_branches.name as branch_name')
            ->join('students', 'students.id', '=', 'fee_collections.students_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
            ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
            //->where('erp_branches.company_id','=',$company_id)
            ->where('fee_collections.session_id', '=', $session_id)
            ->where('fee_collections.due_date', '>=', $session_record->start_year)
            ->where('fee_collections.due_date', '<=', $session_record->end_year)
            //        ->where('fee_collections.due_date','>=','2021-07-01')
            // ->where('fee_collections.due_date','<=','2022-06-30')
            ->where('cancel_voucher', 'No')
            ->where('admission_status', 'Regular')
            // ->where('voucher_type','Regular')
            ->where(function ($query) use ($request) {
                if ($request->branch_id != null) {
                    foreach ($request->branch_id as $branch_list) {
                        $query->whereNotIn('erp_branches.id', [$branch_list]);
                    }
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->company_id != null) {
                    foreach ($request->company_id as $branch_list) {
                        $query->whereNotIn('company_id', [$branch_list]);
                    }
                }
            })
            ->where(function ($query) use ($request) {
                if ($request->intake_id != 0) {
                    $query->where('fee_collections.intake_id', $request->intake_id);
                }
            })
            ->orderBy('erp_branches.company_id', 'ASC')
            ->groupBy('branch_id')
            ->get();
        // }

        $i = 0;

        foreach ($query as $key => $records) {

            $total_strength = FeeMasterBasic::where('branch_id', $records->branch_id)->count();

            $i++;

            $revenue = $records->revenue + $records->fines + $records->arreas + $records->previous_default;
            $recovered_amount = $records->recovered - $records->tax_amounts - $records->other_taxes;

            $default_amount = $revenue - $recovered_amount;
            $recoverd = $recovered_amount / $revenue;
            $recoverd = $recoverd * 100;
            $default_per = $default_amount / $revenue;
            $default_per = $default_per * 100;
            $array[] = array('total' => $total_strength, 'previous_default' => number_format(ceil($records->previous_default), 0), 'company_name' => $records->company_name, 'default_per' => $default_per, 'id' => $i, 'branch' => $records->branch_name, 'revenue' => number_format(ceil($revenue), 0), 'recovered' => number_format(ceil($recovered_amount), 0), 'default_amount' => number_format(ceil($default_amount), 0), 'recovered_per' => $recoverd);
        }


        $session = null;
        $intake = null;

        if ($request['session_id'] != null && $request['session_id'] != "null") {
            $session = Session::where('id', $request['session_id'])->value('title');
        }

        if ($request['intake'] != null && $request['intake'] != "null" && $request['intake'] != 0) {
            $intake = InTake::where('id', $request['intake'])->value('name');
        }

        $dataArray = [
            'session' => $session,
            'intake' => $intake,
        ];

        if ($request->type == 'print') {
//            return view('reports.company_wise_receivable.pdf', compact('array', 'dataArray'));
            $content = View::make('reports.company_wise_receivable.pdf', compact('array', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('CompanyWiseReceivableReport.pdf', 'D');
        } elseif ($request->type == 'excel') {
            return self::excel_company_wise_receivable_report($array, $dataArray);
        } else {
            return response()->json(['data' => $array]);
        }
    }

    public function excel_company_wise_receivable_report($array, $dataArray)
    {
        header('Content-Type: application/vnd.ms-excel charset=UTF-8');
        header('Content-disposition: attachment; filename=CompanyWiseReceivableReport.xls');
        $data = '';

        $data .= '<style>
                table{width: 100%;}
                td,th {
                    border: 0.1pt solid #ccc;
                }
                </style>';
        $data .= '<div class="panel-body pad table-responsive">
                    <table align="center">
                        <tbody>
                        <tr>
                            <td colspan="7" align="center">
                            <h3><span style="border-bottom: double;">' . $dataArray['session'] . '</span></h3>
                        </td>
                        </tr>
                        <tr>
                            <td colspan="7" align="center">
                                <h3><span style="border-bottom: double;">Company Wise Receivable Report</span></h3>
                            </td>
                        </tr>';

        $data .= '<tr>
            <td colspan="7" align="center">
                <span style="border-bottom: dot-dash;">';

        if ($dataArray['intake'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Intake: </span>' . $dataArray['intake'];
        }

        $data .= '</span>
            </td>
        </tr>
        </tbody>
    </table>';

        $data .= "<table class='table' style='width:100 %;'>
            <thead>
            <tr>
                <th>Sr.#</th>
                <th>Campus</th>
                <th>Revenue Receivable</th>
                <th>Revenue Received</th>
                <th>Default</th>
                <th>Received %</th>
                <th>% of Default</th>
            </tr>
            </thead>
            <tbody>";

        $i = 0;
        $revenue = 0;
        $recovered = 0;
        $defaulter = 0;
        $company_revenue = 0;
        $company_recovered = 0;
        $company_defaulter = 0;
        $existing = "";
        $new_company = "";
        $default_amount = 0;
        $recovered_per_company = 0;
        $defaulter_per_company = 0;
        $default_amount_overall = 0;

        foreach ($array as $item) {
            $revenue += floatval(str_replace(',', '', $item['revenue']));
            $recovered += floatval(str_replace(',', '', $item['recovered']));
            $defaulter += floatval(str_replace(',', '', $item['default_amount']));

            $new_company = $item['company_name'];
            if ($existing == $new_company) {
                $company_revenue += floatval(str_replace(',', '', $item['revenue']));
                $company_recovered += floatval(str_replace(',', '', $item['recovered']));
                $company_defaulter += floatval(str_replace(',', '', $item['default_amount']));

                $data .= '<tr>';
                $data .= '<td>' . ++$i . '</td>';
                $data .= '<td>' . $item['branch'] . '</td>';
                $data .= '<td>' . $item['revenue'] . '</td>';
                $data .= '<td>' . $item['recovered'] . '</td>';
                $data .= '<td>' . $item['default_amount'] . '</td>';
                $data .= '<td>' . number_format($item['recovered_per'] * 100, 2) . '%</td>';
                $data .= '<td>' . number_format($item['default_per'] * 100, 2) . '%</td>';
                $data .= '</tr>';
            } else {
                if ($i > 1) {
                    $recovered_per_company = $company_recovered / $company_revenue * 100;
                    $defaulter_per_company = $company_defaulter / $company_revenue * 100;

                    $data .= '<tr>';
                    $data .= '<td colspan="2" style="font-size:18px;font-weight:700;text-align:center;background-color:#bbb1b1;color:black;">' . $existing . ': Total</td>';
                    $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:#bbb1b1;color:black;">' . number_format($company_revenue) . '</td>';
                    $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:#bbb1b1;color:black;">' . number_format($company_recovered) . '</td>';
                    $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:#bbb1b1;color:black;">' . number_format($company_defaulter) . '</td>';
                    $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:#bbb1b1;color:black;">' . number_format($recovered_per_company, 2) . '%</td>';
                    $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:#bbb1b1;color:black;">' . number_format($defaulter_per_company, 2) . '%</td>';
                    $data .= '</tr>';
                }
                $existing = $item['company_name'];
                $company_revenue = 0;
                $company_recovered = 0;
                $company_defaulter = 0;
                $default_amount = 0;
                $recovered_per_company = 0;
                $defaulter_per_company = 0;
                $company_revenue += floatval(str_replace(',', '', $item['revenue']));
                $company_recovered += floatval(str_replace(',', '', $item['recovered']));
                $company_defaulter += floatval(str_replace(',', '', $item['default_amount']));

                $data .= '<tr>';
                $data .= '<td colspan="7" style="font-size:18px;font-weight:700;text-align:center;background-color:#9506e2;color:black;">' . $existing . '</td>';
                $data .= '</tr>';

                $data .= '<tr>';
                $data .= '<td>' . ++$i . '</td>';
                $data .= '<td>' . $item['branch'] . '</td>';
                $data .= '<td>' . $item['revenue'] . '</td>';
                $data .= '<td>' . $item['recovered'] . '</td>';
                $data .= '<td>' . $item['default_amount'] . '</td>';
                $data .= '<td>' . number_format($item['recovered_per'] * 100, 2) . '%</td>';
                $data .= '<td>' . number_format($item['default_per'] * 100, 2) . '%</td>';
                $data .= '</tr>';
            }
        }

        $recovered_per = $recovered / $revenue * 100;
        $defaulter_per = $defaulter / $revenue * 100;

        $recovered_per_company = $company_recovered / $company_revenue * 100;
        $defaulter_per_company = $company_defaulter / $company_revenue * 100;

        $data .= '<tr>';
        $data .= '<td colspan="2" style="font-size:18px;font-weight:700;text-align:center;background-color:#bbb1b1;color:black;">' . $existing . ': Total</td>';
        $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:#bbb1b1;color:black;">' . number_format($company_revenue) . '</td>';
        $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:#bbb1b1;color:black;">' . number_format($company_recovered) . '</td>';
        $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:#bbb1b1;color:black;">' . number_format($company_defaulter) . '</td>';
        $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:#bbb1b1;color:black;">' . number_format($recovered_per_company, 2) . '%</td>';
        $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:#bbb1b1;color:black;">' . number_format($defaulter_per_company, 2) . '%</td>';
        $data .= '</tr>';

        $data .= '<tr>';
        $data .= '<td colspan="2" style="font-size:18px;font-weight:700;text-align:center;background-color:grey;color:black;">IVY ACADEMIC NETWORK - Total:</td>';
        $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:grey;color:black;">' . number_format($revenue) . '</td>';
        $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:grey;color:black;">' . number_format($recovered) . '</td>';
        $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:grey;color:black;">' . number_format($defaulter) . '</td>';
        $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:grey;color:black;">' . number_format($recovered_per, 2) . '%</td>';
        $data .= '<td style="font-size:18px;font-weight:700;text-align:center;background-color:grey;color:black;">' . number_format($defaulter_per, 2) . '%</td>';
        $data .= '</tr>';

        echo $data;

    }

    public function head_wise_revenue_report()
    {
        $sessions = Session::SessionList();
//        $companies = Company::CompanyList();
        $fee_heads = ErpFeeHead::get();
        $company = Company::get();

        return view('reports.head_wise_revenue_report.index', compact('sessions', 'company', 'fee_heads'));

    }

    public function head_wise_revenue_report_print(Request $request)
    {
        $array = FeeCollectionDetail::select(DB::raw('sum(fee_collection_detail.amount) as amount ,sum(arreas) as arreas'), 'erp_branches.id as branch_id', 'erp_branches.name as branch_name')
            ->join('fee_collections', 'fee_collections.id', '=', 'fee_collection_detail.fc_id')
            ->join('students', 'students.id', '=', 'fee_collections.students_id')
            ->join('erp_branches', 'erp_branches.id', '=', 'fee_collections.branch_id')
//            ->where('erp_fee_head_id_direct', $request->fee_head)
            ->where('due_date', '>=', $request->from_date)
            ->where('due_date', '<=', $request->to_date)
            ->where('cancel_voucher', 'No')
            ->where('fee_collections.fee_status', 3)
            ->groupby('fee_collections.branch_id')
            ->orderby('erp_branches.company_id', 'ASC')
            ->where('admission_status', 'Regular')
            ->where('fee_collections.session_id', $request->session_id)
            ->where(function ($query) use ($request) {
                if ($request['company_id'] != null && $request['company_id'] != "null") {
                    $query->where('erp_branches.company_id', $request['company_id']);
                }
                if ($request['fee_head'] != null && $request['fee_head'] != "null") {
                    $query->where('erp_fee_head_id_direct', $request['fee_head']);
                }
            })->get();


        $dateRange = null;
        $session = null;
        $company_id = null;
        $fee_head = null;

        if ($request->from_date != null && $request->from_date != "null" || $request->to_date != null && $request->to_date != "null") {
            $dateRange = $request->from_date . ' - ' . $request->to_date;
        }
        if ($request['session_id'] != null && $request['session_id'] != "null") {
            $session = Session::where('id', $request['session_id'])->value('title');
        }

        if ($request['company_id'] != null && $request['company_id'] != "null") {
            $company_id = Company::where('id', $request['company_id'])->value('name');
        }

        if ($request['fee_head'] != null && $request['fee_head'] != "null") {
            $fee_head = ErpFeeHead::where('id', $request['fee_head'])->value('title');
        }

        $dataArray = [
            'dateRange' => $dateRange,
            'session' => $session,
            'company_id' => $company_id,
            'fee_head' => $fee_head,
        ];

        if ($request->type == 'print') {
//            return view('reports.head_wise_revenue_report.pdf', compact('array', 'dataArray'));
            $content = View::make('reports.head_wise_revenue_report.pdf', compact('array', 'dataArray'))->render();
            // Create an instance of the class:
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            // Write some HTML code:
            $mpdf->WriteHTML($content);
            // Output a PDF file directly to the browser
            $mpdf->Output('HeadWiseRevenueReport.pdf', 'D');
        } elseif ($request->type == 'excel') {
            return self::excel_head_wise_revenue_report($array, $dataArray);
        } else {
            return response()->json(['data' => $array]);
        }
    }

    public function excel_head_wise_revenue_report($array, $dataArray)
    {
        header('Content-Type: application/vnd.ms-excel charset=UTF-8');
        header('Content-disposition: attachment; filename=HeadWiseRevenueReceivedReport.xls');
        $data = '';

        $data .= '<style>
                table{width: 100%;}
                td,th {
                    border: 0.1pt solid #ccc;
                }
                </style>';
        $data .= '<div class="panel-body pad table-responsive">
                    <table align="center">
                        <tbody>
                        <tr>
                            <td colspan="3" align="center">
                                <h3><span style="border-bottom: double;">' . $dataArray['dateRange'] . '</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">
                            <h3><span style="border-bottom: double;">' . $dataArray['session'] . '</span></h3>
                        </td>
                        </tr>
                        <tr>
                            <td colspan="3" align="center">
                                <h3><span style="border-bottom: double;">Head Wise Revenue Received Report</span></h3>
                            </td>
                        </tr>';

        $data .= '<tr>
            <td colspan="3" align="center">
                <span style="border-bottom: dot-dash;">';

        if ($dataArray['company_id'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Company: </span>' . $dataArray['company_id'];
        }
        if ($dataArray['fee_head'] != null) {
            $data .= '&nbsp;&nbsp;<span style="font-weight: bold">Fee Head: </span>' . $dataArray['fee_head'];
        }

        $data .= '</span>
            </td>
        </tr>
        </tbody>
    </table>';

        $data .= "<table class='table' style='width:100 %;'>
            <thead>
            <tr>
                <th>Sr.#</th>
                <th>Branch Name</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>";

        $k = 1;
        $total_amount_overall = 0;

        foreach ($array as $item) {
            $total_amount = intval($item['amount']) + intval($item['arreas']);
            if ($total_amount > 0) {
                $total_amount_overall += $total_amount;
                $data .= '<tr>';
                $data .= '<td>' . $k . '</td>';
                $data .= '<td>' . $item['branch_name'] . '</td>';
                $data .= '<td>' . number_format($total_amount) . '</td>';
                $data .= '</tr>';
                $k++;
            }
        }

        $data .= '<tr style="text-align: center;background-color: #bbb1b1;color: black;font-weight: 700;"><th colspan="2">Total Amount:</th><th>' . number_format($total_amount_overall) . '</th></tr>';

        echo $data;

    }

    public function sibling_report()
    {
        $sessions = Session::SessionList();
//        $companies = Company::CompanyList();
        $company = Company::get();
        return view('reports.sibling_report.index', compact('company', 'sessions'));
    }

    public function sibling_report_print(Request $request)
    {
        $data = ParentDetail::with(['student_data' => function ($q) use ($request) {
            if ($request['session_id'] != null && $request['session_id'] != "null") {
                $q->where('session_id', $request['session_id']);
            }
            if ($request['branch_id'] != null && $request['branch_id'] != "null" && $request['branch_id'] != "---Select---") {
                $q->where('branch_id', $request['branch_id']);
            }
            $q->where('admission_status', '=', 'Regular')
                ->where('status', '=', 'Active');
        }])->where(function ($query) {
            $query->whereNotNull('father_cnic')
                ->orWhereNotNull('mother_cnic');
        })
            ->groupBy('father_cnic')
            ->groupBy('mother_cnic')
            ->havingRaw('COUNT(*) > 1')
            ->select('id', 'father_cnic', 'mother_cnic')
//            ->paginate(10);
            ->get();

        $array = collect();
        foreach ($data as $single) {
            $studentData = ParentDetail::with('student_data:id,first_name,last_name,mobile_1,board_id,program_id,class_id,session_id,branch_id,admission_status,status',
                'student_data.program', 'student_data.class_data', 'student_data.board')
//                ->where('id', $single->id)
                ->where(function ($query) use ($single, $request) {
                    if ($single->father_cnic !== null) {
                        $query->where('father_cnic', $single->father_cnic);
                    }
                    if ($single->mother_cnic !== null) {
                        $query->orWhere('mother_cnic', $single->mother_cnic);
                    }
                    $query->whereHas('student_data', function ($subQuery) use ($request) {
                        if ($request['session_id'] !== null && $request['session_id'] !== "null") {
                            $subQuery->where('session_id', $request['session_id']);
                        }
                        if ($request['branch_id'] !== null && $request['branch_id'] !== "null" && $request['branch_id'] !== "---Select---") {
                            $subQuery->where('branch_id', $request['branch_id']);
                        }
                        $subQuery->where('admission_status', '=', 'Regular')
                            ->where('status', '=', 'Active');
                    });
                })
                ->get();

            $array = $array->merge($studentData);

        }
        return DataTables::of($array)->addIndexColumn()
            ->addColumn('full_name', function ($row) {
                if (isset($row->student_data->first_name) && isset($row->student_data->last_name))
                    return $row->student_data->first_name . ' ' . $row->student_data->last_name;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('father_name', function ($row) {
                if ($row->father_first_name && $row->father_last_name)
                    return $row->father_first_name . ' ' . $row->father_last_name;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('mother_name', function ($row) {
                if ($row->mother_first_name && $row->mother_last_name)
                    return $row->mother_first_name . ' ' . $row->mother_last_name;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('board_name', function ($row) {
                if (isset($row->student_data->board->name))
                    return $row->student_data->board->name;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('program_name', function ($row) {
                if (isset($row->student_data->program->name))
                    return $row->student_data->program->name;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('class_name', function ($row) {
                if (isset($row->student_data->class_data->name))
                    return $row->student_data->class_data->name;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('father_cnic', function ($row) {
                if ($row->father_cnic)
                    return $row->father_cnic;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('mother_cnic', function ($row) {
                if ($row->mother_cnic)
                    return $row->mother_cnic;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('father_mobile_1', function ($row) {
                if ($row->father_mobile_1)
                    return $row->father_mobile_1;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('mobile_1', function ($row) {
                if (isset($row->student_data->mobile_1))
                    return $row->student_data->mobile_1;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->rawColumns(['full_name', 'father_name', 'mother_name', 'board_name', 'program_name', 'class_name',
                'father_cnic', 'mother_cnic', 'father_mobile_1', 'mobile_1'])
            ->make(true);
    }

    public function sibling_report_print1(Request $request)
    {

        $ids = Students::whereNotNull('father_cnic')
            ->orWhereNotNull('mother_cnic')
            ->pluck('id');

        $data = Students::where(function ($query) use ($request, $ids) {

            $query->whereIn('id', $ids);

            if ($request['session_id'] != null && $request['session_id'] != "null") {
                $query->where('session_id', $request['session_id']);
            }
            if ($request['branch_id'] != null && $request['branch_id'] != "null" && $request['branch_id'] != "---Select---") {
                $query->where('branch_id', $request['branch_id']);
            } else {
                $branch_ids = PermissionCheck::check_branch();
                $query->whereIn('branch_id', $branch_ids);
            }

            $query->where('admission_status', '=', 'Regular')
                ->where('status', '=', 'Active');

        })
            ->groupBy('father_cnic')
            ->groupBy('mother_cnic')
            ->havingRaw('COUNT(*) > 1')
            ->select('id', 'father_cnic', 'mother_cnic')
//            ->paginate(10);
            ->get();

        $array = collect();
        foreach ($data as $single) {
            $studentData = Students::with('program', 'class_data', 'board',
                'parent_details:students_id,father_first_name,father_last_name,mother_first_name,mother_last_name,father_mobile_1')
                ->select('id', 'first_name', 'last_name', 'mobile_1', 'board_id', 'program_id', 'class_id',
                    'session_id', 'branch_id', 'admission_status', 'status', 'father_cnic', 'mother_cnic')
                ->where(function ($query) use ($single, $request) {

                    if ($single->father_cnic !== null) {
                        $query->where('father_cnic', $single->father_cnic);
                    }

                    if ($single->mother_cnic !== null) {
                        $query->where('mother_cnic', $single->mother_cnic);
                    }

                    if ($request['session_id'] !== null && $request['session_id'] !== "null") {
                        $query->where('session_id', $request['session_id']);
                    }

                    if ($request['branch_id'] !== null && $request['branch_id'] !== "null" && $request['branch_id'] !== "---Select---") {
                        $query->where('branch_id', $request['branch_id']);
                    }

                    $query->where('admission_status', '=', 'Regular')
                        ->where('status', '=', 'Active');
                })
                ->get();

            $array = $array->merge($studentData);
//dd($array);
        }

        return DataTables::of($array)->addIndexColumn()
            ->addColumn('full_name', function ($row) {
                if (isset($row->first_name) && isset($row->last_name))
                    return $row->first_name . ' ' . $row->last_name;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('father_name', function ($row) {
                if (isset($row->parent_details->father_first_name) && isset($row->parent_details->father_last_name))
                    return $row->parent_details->father_first_name . ' ' . $row->parent_details->father_last_name;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('mother_name', function ($row) {
                if (isset($row->parent_details->mother_first_name) && isset($row->parent_details->mother_last_name))
                    return $row->parent_details->mother_first_name . ' ' . $row->parent_details->mother_last_name;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('board_name', function ($row) {
                if (isset($row->board->name))
                    return $row->board->name;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('program_name', function ($row) {
                if (isset($row->program->name))
                    return $row->program->name;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('class_name', function ($row) {
                if (isset($row->class_data->name))
                    return $row->class_data->name;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('father_cnic', function ($row) {
                if ($row->father_cnic)
                    return $row->father_cnic;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('mother_cnic', function ($row) {
                if ($row->mother_cnic)
                    return $row->mother_cnic;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('father_mobile_1', function ($row) {
                if (isset($row->parent_details->father_mobile_1))
                    return $row->parent_details->father_mobile_1;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->addColumn('mobile_1', function ($row) {
                if (isset($row->mobile_1))
                    return $row->mobile_1;
                else
                    return "<span style='color: lightgrey'>N/A</span>";
            })
            ->rawColumns(['full_name', 'father_name', 'mother_name', 'board_name', 'program_name', 'class_name',
                'father_cnic', 'mother_cnic', 'father_mobile_1', 'mobile_1'])
            ->make(true);
    }

    public function update_cnics_to_null()
    {
        Students::select('id', 'father_cnic', 'mother_cnic')
            ->where(function ($query) {

                $query->where('father_cnic', '=', '0')
                    ->orWhere('father_cnic', '=', '00')
                    ->orWhere('father_cnic', '=', '000')
                    ->orWhere('father_cnic', '=', '0000')
                    ->orWhere('father_cnic', '=', '00000')
                    ->orWhere('father_cnic', '=', '000000')
                    ->orWhere('father_cnic', '=', '0000000')
                    ->orWhere('father_cnic', '=', '00000000')
                    ->orWhere('father_cnic', '=', '000000000')
                    ->orWhere('father_cnic', '=', '0000000000')
                    ->orWhere('father_cnic', '=', '00000000000')
                    ->orWhere('father_cnic', '=', '000000000000')
                    ->orWhere('father_cnic', '=', '0000000000000')
                    ->orWhere('father_cnic', '=', '00000000000000')
                    ->orWhere('father_cnic', '=', '000000000000000')
                    ->orWhere('father_cnic', '=', '0000000000000000')
                    ->orWhere('father_cnic', '=', '00000000000000000')
                    ->orWhere('father_cnic', '=', '000000000000000000')
                    ->orWhere('father_cnic', '=', '0000000000000000000')
                    ->orWhere('father_cnic', '=', '00000000000000000000')
                    ->orWhere('father_cnic', '=', '000000000000000000000')
                    ->orWhere('father_cnic', '=', '0000000000000000000000')
                    ->orWhere('father_cnic', '=', '00000000000000000000000')
                    ->orWhere('father_cnic', '=', '00000-0000000-0')
                    ->orWhere('father_cnic', '=', '111111111111')
                    ->orWhere('father_cnic', '=', '11111111111111111')
                    ->orWhere('father_cnic', '=', '123')
                    ->orWhere('father_cnic', '=', 'XXXXX-XXXXXXX-X')
                    ->orWhere('father_cnic', '=', 'XXX')
                    ->orWhere('father_cnic', '=', 'XXXX')
                    ->orWhere('father_cnic', '=', 'XXXXX')
                    ->orWhere('father_cnic', '=', '22222')
                    ->orWhere('father_cnic', '=', '33333')
                    ->orWhere('father_cnic', '=', '222')
                    ->orWhere('father_cnic', '=', '333')
                    ->orWhere('father_cnic', '=', '030000')
                    ->orWhere('father_cnic', '=', '.')
                    ->orWhere('father_cnic', '=', '..')
                    ->orWhere('father_cnic', '=', '...')
                    ->orWhere('father_cnic', '=', '....')
                    ->orWhere('father_cnic', '=', '.....')
                    ->orWhere('father_cnic', '=', '......')
                    ->orWhere('father_cnic', '=', '.......')
                    ->orWhere('father_cnic', '=', '-')
                    ->orWhere('father_cnic', '=', '--')
                    ->orWhere('father_cnic', '=', '---')
                    ->orWhere('father_cnic', '=', '1')
                    ->orWhere('father_cnic', '=', '11')
                    ->orWhere('father_cnic', '=', '1000000000001');

//                $query->where('mother_cnic', '=', '0')
//                    ->orWhere('mother_cnic', '=', '00')
//                    ->orWhere('mother_cnic', '=', '000')
//                    ->orWhere('mother_cnic', '=', '0000')
//                    ->orWhere('mother_cnic', '=', '00000')
//                    ->orWhere('mother_cnic', '=', '000000')
//                    ->orWhere('mother_cnic', '=', '0000000')
//                    ->orWhere('mother_cnic', '=', '00000000')
//                    ->orWhere('mother_cnic', '=', '000000000')
//                    ->orWhere('mother_cnic', '=', '0000000000')
//                    ->orWhere('mother_cnic', '=', '00000000000')
//                    ->orWhere('mother_cnic', '=', '000000000000')
//                    ->orWhere('mother_cnic', '=', '0000000000000')
//                    ->orWhere('mother_cnic', '=', '00000000000000')
//                    ->orWhere('mother_cnic', '=', '000000000000000')
//                    ->orWhere('mother_cnic', '=', '0000000000000000')
//                    ->orWhere('mother_cnic', '=', '00000000000000000')
//                    ->orWhere('mother_cnic', '=', '000000000000000000')
//                    ->orWhere('mother_cnic', '=', '0000000000000000000')
//                    ->orWhere('mother_cnic', '=', '00000000000000000000')
//                    ->orWhere('mother_cnic', '=', '000000000000000000000')
//                    ->orWhere('mother_cnic', '=', '0000000000000000000000')
//                    ->orWhere('mother_cnic', '=', '00000000000000000000000')
//                    ->orWhere('mother_cnic', '=', '00000-0000000-0')
//                    ->orWhere('mother_cnic', '=', '111111111111')
//                    ->orWhere('mother_cnic', '=', '11111111111111111')
//                    ->orWhere('mother_cnic', '=', '123')
//                    ->orWhere('mother_cnic', '=', 'XXXXX-XXXXXXX-X')
//                    ->orWhere('mother_cnic', '=', 'XXX')
//                    ->orWhere('mother_cnic', '=', 'XXXX')
//                    ->orWhere('mother_cnic', '=', 'XXXXX')
//                    ->orWhere('mother_cnic', '=', '22222')
//                    ->orWhere('mother_cnic', '=', '33333')
//                    ->orWhere('mother_cnic', '=', '222')
//                    ->orWhere('mother_cnic', '=', '333')
//                    ->orWhere('mother_cnic', '=', '030000')
//                    ->orWhere('mother_cnic', '=', '.')
//                    ->orWhere('mother_cnic', '=', '..')
//                    ->orWhere('mother_cnic', '=', '...')
//                    ->orWhere('mother_cnic', '=', '....')
//                    ->orWhere('mother_cnic', '=', '.....')
//                    ->orWhere('mother_cnic', '=', '......')
//                    ->orWhere('mother_cnic', '=', '.......')
//                    ->orWhere('mother_cnic', '=', '-')
//                    ->orWhere('mother_cnic', '=', '--')
//                    ->orWhere('mother_cnic', '=', '---')
//                    ->orWhere('mother_cnic', '=', '1')
//                    ->orWhere('mother_cnic', '=', '11')
//                    ->orWhere('mother_cnic', '=', '1000000000001');


            })
            ->update(['father_cnic' => null]);
//            ->update(['mother_cnic' => null]);
    }


    public function student_fee_installment_wise()
    {

//        if (!Gate::allows('erp_nominal_report')) {
//            return abort(401);
//        }
        $sessions = Session::SessionList();
        $city = City::get();
        $company = Company::get();
        $user = Auth::user();

        if ($user != "") {
            return view('reports.fee.student_fee_installment_wise.index', compact('sessions', 'city', 'company'));
        } else {
            return redirect()->route('auth.login');
        }
    }

    public function student_fee_installment_wise_print(Request $request)
    {

        dd('block');
        $user = Auth::user();
        if ($user != "") {

            $student = DB::table('students')
                ->join('active_session_students', 'active_session_students.student_id', '=', 'students.id')
                ->join('active_session_sections', 'active_session_sections.id', '=', 'active_session_students.active_session_section_id')
                ->join('active_sessions', 'active_sessions.id', '=', 'active_session_sections.active_session_id')
                ->join('erp_branches', 'erp_branches.id', '=', 'students.branch_id')
                ->join('erp_city', 'erp_city.id', '=', 'erp_branches.city_id')
                ->join('erp_companies', 'erp_companies.id', '=', 'erp_branches.company_id')
                ->join('boards', 'boards.id', '=', 'active_sessions.board_id')
                ->join('intake', 'intake.id', '=', 'active_sessions.intake_id')
                ->join('programs', 'programs.id', '=', 'active_sessions.program_id')
                ->join('classes', 'classes.id', '=', 'active_sessions.class_id')

                // ->leftJoin('fee_collections','fee_collections.students_id','=','students.id')

                // ->where('cancel_voucher','No')
                ->where('students.sos_status', 'Active')
                ->where('active_sessions.session_id', $request->session_id)
                ->where('students.admission_status', 'Regular')
                ->select('students.*', 'students.id as student_id', 'erp_branches.name as branch_name', 'classes.name as class_name')
                ->where(function ($query) use ($request) {
                    if ($request['type'] != null && $request['type'] != "null") {

                        $query->where('students.admission_status', $request->type);
                    }
                    if ($request['company_id'] != null && $request['company_id'] != "null") {
                        $query->where('erp_branches.company_id', $request['company_id']);
                    }
                    if ($request['city_id'] != null && $request['city_id'] != "null") {
                        $query->where('erp_branches.city_id', $request['city_id']);
                    }
                    if ($request['branch_id'] != null && $request['branch_id'] != "null") {
                        $query->where('erp_branches.id', $request['branch_id']);
                    }
                    if ($request['boards'] != null && $request['boards'] != "null") {
                        $query->where('boards.id', $request['boards']);
                    }
                    if ($request['programs'] != null && $request['programs'] != "null") {
                        $query->where('programs.id', $request['programs']);
                    }
                    if ($request['classes'] != null && $request['classes'] != "null") {
                        $query->where('classes.id', $request['classes']);
                    }
                    if ($request['intake'] != null && $request['intake'] != "null") {
                        $query->where('intake.id', $request['intake']);
                    }
                    if ($request['sections'] != null && $request['sections'] != "null") {
                        $query->where('sections.id', $request['sections']);
                    }

                })
                ->orderby('erp_branches.id', 'asc')
                ->orderby('classes.id', 'asc')
                // ->groupBy('students.id')

                ->get();
            $array = array();
            foreach ($student as $key => $student_id) {

                $fee_bill_not_paid = FeeCollection::where('students_id', '=', $student_id->student_id)->where('session_id', $request->session_id)->where('paid_date', null)->pluck('students_id', 'fee_term_id');

                $a = '';
                $i = 0;
                foreach ($fee_bill_not_paid as $key => $value) {
                    if ($i > 0) {
                        $a = $a . ',' . $key . '-Installemt ';
                    } else {
                        $a = $key . '-Installemt ';
                    }
                    $i++;
                }


                $fee_bill_paid = FeeCollection::where('students_id', '=', $student_id->student_id)->where('session_id', $request->session_id)->where('paid_date', '!=', null)->pluck('students_id', 'fee_term_id');


                $b = '';
                $j = 0;
                foreach ($fee_bill_paid as $key => $value) {
                    if ($j > 0) {
                        $b = $b . ',' . $key . '-Installment ';
                    } else {
                        $b = $key . '-Installment ';
                    }
                    $j++;
                }


                $total_installements = FeeCollection::where('students_id', '=', $student_id->student_id)->where('session_id', $request->session_id)->count('fee_term_id');
                $total_amount = FeeCollection::where('students_id', '=', $student_id->student_id)->where('session_id', $request->session_id)->pluck('total_amount');
                $total_amount_arrears = FeeCollection::where('students_id', '=', $student_id->student_id)->where('session_id', $request->session_id)->sum(\DB::raw('arreas_amount + other_tax + tax_amount'));

                $total_amount_sum = FeeCollection::where('students_id', '=', $student_id->student_id)->where('session_id', $request->session_id)->sum(\DB::raw('total_amount + arreas_amount + other_tax + tax_amount'));

                $total_amount_paid = FeeCollection::where('students_id', '=', $student_id->student_id)->where('session_id', $request->session_id)->sum(\DB::raw('paid_amount  + arreas_amount + other_tax + tax_amount'));


                $array[] = array(
                    'reg_no' => $student_id->reg_no,
                    "first_name" => $student_id->first_name,
                    "middle_name" => $student_id->middle_name,
                    "last_name" => $student_id->last_name,
                    "class_id" => $student_id->class_id,
                    "fee_bill_not_paid" => $a,
                    "total_installements" => $total_installements,
                    "total_amount" => $total_amount,
                    "total_amount_sum" => $total_amount_sum,
                    "total_amount_paid" => $total_amount_paid,
                    "total_amount_arrears" => $total_amount_arrears,
                    "fee_bill_paid" => $b,
                    'branch_name' => $student_id->branch_name,
                    'class_name' => $student_id->class_name
                );


            }

            $branch = null;
            $board = null;
            $session = null;
            $program = null;
            $class = null;
            $section = null;
            $intake = null;
            if ($request['company_id'] != null && $request['company_id'] != '---Select---') {

                $company = Company::where('id', $request['company_id'])->value('name');

            }
            if ($request['branch_id'] != null && $request['branch_id'] != '---Select---') {

                $branch = Branches::where('id', $request['branch_id'])->get();

            }
            if ($request['boards'] != null && $request['boards'] != "null") {

                $board = Board::where('id', $request['boards'])->value('name');

            }

            if ($request['programs'] != null && $request['programs'] != "null") {

                $program = Program::where('id', $request['programs'])->value('name');
            }
            if ($request['classes'] != null && $request['classes'] != "null") {

                $class = Classes::where('id', $request['classes'])->value('name');
            }
            if ($request['intake'] != null && $request['intake'] != "null") {

                $intake = InTake::where('id', $request['intake'])->value('name');
            }
            if ($request['sections'] != null && $request['sections'] != "null") {

                $section = Section::where('id', $request['sections'])->value('name');
            }
            if ($request['session_id'] != null && $request['session_id'] != "null") {

                $session = Session::where('id', $request['session_id'])->value('title');
            }

            if ($request->type == 'Regular') {

                $pdf = PDF::loadView('reports.student_fee_record.print', compact('company', 'student', 'branch', 'board', 'program', 'class', 'section', 'session', 'intake', 'array'));
                return $pdf->stream('student-fee-record-report-print.pdf');

            }
            if ($request->type == 'WalkIn') {

                $pdf = PDF::loadView('reports.student_fee_record.print', compact('company', 'student', 'branch', 'board', 'program', 'class', 'section', 'session', 'intake', 'array'));
                return $pdf->stream('student-fee-record-report-print.pdf');

            } else {


                return response()->json(['data' => $array]);

            }

        } else {
            return redirect()->route('auth.login');
        }
    }


    public function getCreditdebitVendor(Request $request)
    {
        // dd($request->all());
        // Retrieve all request parameters
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $supplier_id = $request->input('supplier_id');

        // Debugging request data
        // dd($request->all());

        // Fetch active suppliers
        $suppliers = Supplier::where('is_active', '1')->get();

        // Fetch CreditDebit records based on supplier_id, start_date, and end_date
        $detailData = CreditDebit::where('supplier_id', $supplier_id)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->get();

        $supplier = Supplier::find($supplier_id);


        // Return the view with the fetched data
        return view('backend.report.credit_debit_report', compact('suppliers', 'detailData', 'request', 'supplier'));
    }
}
