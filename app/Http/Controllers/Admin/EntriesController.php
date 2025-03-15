<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CoreAccounts;
use App\Helpers\GernalHelper;
use App\Http\Controllers\Controller;
use App\Models\Branch;

use App\Models\Company;
use App\Models\Entries;
use App\Models\EntryItems;
use App\Models\EntryTypes;
use App\Models\Groups;
use App\Models\Ledger;
use App\Models\Staff;
use App\Models\Vendor;
use App\Services\EntriesServices;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Session;
use Config;
use Auth;

class EntriesController extends Controller
{
    public function __construct(EntriesServices $EntriesServices)
    {
        $this->EntriesServices = $EntriesServices;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.entries.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
//        $Entrie = Entries::findOrFail($id);
//        $EntryType = EntryTypes::findOrFail($Entrie->entry_type_id);
//        $EntryTypes = EntryTypes::all();
//        $Branch = Branch::find($Entrie->branch_id);
//        $Employee = Staff::whereId($Entrie->employee_id)->first();
//        $Entry_items = EntryItems::with('vendor_data:vendor_id,vendor_name')->where(['entry_id' => $Entrie->id])
//            ->OrderBy('id', 'asc')->get();
//        $company = Company::where('id', $Entrie->company_id)->first();
//        $Ledgers = Ledger::whereIn(
//            'id',
//            EntryItems::where(['entry_id' => $Entrie->id])->pluck('ledger_id')->toArray()
//        )->get()->getDictionary();
//
//        return view('accounts.entries.voucher.bank_voucher.bank_receipt.entry', compact('Entrie', 'company', 'id', 'EntryType', 'EntryTypes', 'Branch', 'Employee', 'Entry_items', 'Ledgers'));
return view('admin.entries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(Request $request)
//    {
//        //
//    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
//    public function edit(string $id)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     */
//    public function update(Request $request, string $id)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     */
//    public function destroy(string $id)
//    {
//        //
//    }


    public function getdata(Request $request){
        return $this->EntriesServices->getdata($request);
    }
























    public function bpvCreate()
    {

        $entries = [];



            $entries = Entries::with('entry_type')->where('id', 4)->get();


        $companyId = Session::get('company_session') ?? Branch::where('id', Auth::user()->branch_id)->value('company_id');
        $branchId = Session::get('branch_session') ?? 0;
        $sessionFinancialYear = Session::get('financial_year_session') ?? '';
        $sessionVoucherDate = Session::get('voucher_date_session') ?? '';
        $vendor = Vendor::get();
        $vendorDropdown = 1;

//        if (Auth::user()->isAbleTo('create-bank-payment-voucher')) {
            $VoucherData = Session::get('_old_input');
            if (is_array($VoucherData) && !empty($VoucherData)) {
                // Fetch Ledger IDs to create Ledger Objects
                $ledger_ids = array();
                if (isset($VoucherData['entry_items']) && count($VoucherData['entry_items'])) {
                    $entry_items = $VoucherData['entry_items'];
                    foreach ($entry_items['counter'] as $key => $val) {
                        if (isset($entry_items['ledger_id'][$val]) && $entry_items['ledger_id'][$val]) {
                            $ledger_ids[] = $entry_items['ledger_id'][$val];
                        } else {
                            $VoucherData['entry_items']['ledger_id'][$val] = '';
                        }
                    }
                }
                if (count($ledger_ids)) {
                    $VoucherData['ledger_array'] = Ledger::whereIn('id', $ledger_ids)->get()->getDictionary();
                    // dd( $VoucherData);
                } else {
                    $VoucherData['ledger_array'] = array();
                }

                if ($sessionFinancialYear != null) {
                    $VoucherData['financial_year'] = $sessionFinancialYear;
                }
                if ($sessionVoucherDate != null) {
                    $VoucherData['voucher_date'] = $sessionVoucherDate;
                }

            }
            else {
                $VoucherData = array(
                    'number' => str_pad(CoreAccounts::getVouchertMaxId(5, $companyId), 6, '0', STR_PAD_LEFT),
                    'cheque_no' => '',
                    'cheque_date' => '',
                    'invoice_no' => '',
                    'invoice_date' => '',
                    'voucher_date' => $sessionVoucherDate ?? null,
                    'entry_type_id' => '',
                    'branch_id' => '',
                    'employee_id' => '',
                    'suppliers_id' => '',
                    'remarks' => '',
                    'narration' => '',
                    'dr_total' => '',
                    'cr_total' => '',
                    'diff_total' => '',
                    'financial_year' => $sessionFinancialYear ?? null,
                    'entry_items' => array(
                        'counter' => array(),
                        'ledger_id' => array(),
                        'dr_amount' => array(),
                        'cr_amount' => array(),
                        'narration' => array(),
                    ),
                    'ledger_array' => array(),
                );
            }
            // Get All Employees
            $Employees = Staff::get()->pluck('user_id', 'middle_name');
            $Employees->prepend('Select an Employee', '');

            // Get All Branch
            // Get All Branch
            $branches  = Branch::get();
            $companies = Company::get();

            $financial_year = GernalHelper::get_financial_year();

            return view('accounts.entries.voucher.bank_voucher.bank_payment.create', compact('vendor', 'vendorDropdown', 'financial_year', 'Employees', 'entries', 'branches', 'VoucherData', 'companies', 'companyId', 'branchId'));
//        }
//        else {
//            return abort(401);
//        }
    }

    public function cpvCreate()
    {
        $entries = [];

        $entries_session = Session::get('entries');
        if ($entries_session) {
            $entries = Entries::with('entry_type')->whereIn('id', $entries_session)->get();
        }

        $companyId = Session::get('company_session') ?? Branch::where('id', Auth::user()->branch_id)->value('company_id');
        $branchId = Session::get('branch_session') ?? 0;
        $sessionFinancialYear = Session::get('financial_year_session') ?? '';
        $sessionVoucherDate = Session::get('voucher_date_session') ?? '';
        $vendor = Vendor::get();
        $vendorDropdown = 1;

        if (Auth::user()->isAbleTo('create-cash-payment-voucher')) {

            $VoucherData = Session::get('_old_input');
            if (is_array($VoucherData) && !empty($VoucherData)) {
                // Fetch Ledger IDs to create Ledger Objects
                $ledger_ids = array();
                if (isset($VoucherData['entry_items']) && count($VoucherData['entry_items'])) {
                    $entry_items = $VoucherData['entry_items'];
                    foreach ($entry_items['counter'] as $key => $val) {
                        if (isset($entry_items['ledger_id'][$val]) && $entry_items['ledger_id'][$val]) {
                            $ledger_ids[] = $entry_items['ledger_id'][$val];
                        } else {
                            $VoucherData['entry_items']['ledger_id'][$val] = '';
                        }
                    }
                }
                if (count($ledger_ids)) {
                    $VoucherData['ledger_array'] = Ledger::whereIn('id', $ledger_ids)->get()->getDictionary();
                    // dd( $VoucherData);
                } else {
                    $VoucherData['ledger_array'] = array();
                }

                if ($sessionFinancialYear != null) {
                    $VoucherData['financial_year'] = $sessionFinancialYear;
                }
                if ($sessionVoucherDate != null) {
                    $VoucherData['voucher_date'] = $sessionVoucherDate;
                }

            } else {
                $VoucherData = array(
                    'number' => str_pad(CoreAccounts::getVouchertMaxId(3, $companyId), 6, '0', STR_PAD_LEFT),
                    'cheque_no' => '',
                    'cheque_date' => '',
                    'invoice_no' => '',
                    'invoice_date' => '',
                    'voucher_date' => $sessionVoucherDate ?? null,
                    'entry_type_id' => '',
                    'branch_id' => '',
                    'employee_id' => '',
                    'suppliers_id' => '',
                    'remarks' => '',
                    'narration' => '',
                    'dr_total' => '',
                    'cr_total' => '',
                    'diff_total' => '',
                    'financial_year' => $sessionFinancialYear ?? null,
                    'entry_items' => array(
                        'counter' => array(),
                        'ledger_id' => array(),
                        'dr_amount' => array(),
                        'cr_amount' => array(),
                        'narration' => array(),
                        'vendor_id' => array(),
                    ),
                    'ledger_array' => array(),
                );
            }
            // Get All Employees
            $Employees = Staff::get()->pluck('user_id', 'middle_name');
            $Employees->prepend('Select an Employee', '');

            // Get All Branch
            // Get All Branch
            $Branch = Branch::get();
            $companies = Company::get();

            $financial_year = GernalHelper::get_financial_year();

            return view('accounts.entries.voucher.cash_voucher.cash_payment.create', compact('vendor', 'vendorDropdown', 'financial_year', 'Employees', 'entries', 'Branch', 'VoucherData', 'companies', 'companyId', 'branchId'));
        } else {
            return abort(401);
        }
    }

    public function brvCreate()
    {
        $entries = [];

        $entries_session = Session::get('entries');
        if ($entries_session) {
            $entries = Entries::with('entry_type')->whereIn('id', $entries_session)->get();
        }

        $companyId = Session::get('company_session') ?? Branch::where('id', Auth::user()->branch_id)->value('company_id');
        $branchId = Session::get('branch_session') ?? 0;
        $sessionFinancialYear = Session::get('financial_year_session') ?? '';
        $sessionVoucherDate = Session::get('voucher_date_session') ?? '';

        if (Auth::user()->isAbleTo('create-bank-receipt-voucher')) {
            $VoucherData = Session::get('_old_input');
            if (is_array($VoucherData) && !empty($VoucherData)) {
                $ledger_ids = array();
                if (isset($VoucherData['entry_items']) && count($VoucherData['entry_items'])) {
                    $entry_items = $VoucherData['entry_items'];
                    foreach ($entry_items['counter'] as $key => $val) {
                        if (isset($entry_items['ledger_id'][$val]) && $entry_items['ledger_id'][$val]) {
                            $ledger_ids[] = $entry_items['ledger_id'][$val];
                        } else {
                            $VoucherData['entry_items']['ledger_id'][$val] = '';
                        }
                    }
                }
                if (count($ledger_ids)) {
                    $VoucherData['ledger_array'] = Ledger::whereIn('id', $ledger_ids)->get()->getDictionary();
                } else {
                    $VoucherData['ledger_array'] = array();
                }

                if ($sessionFinancialYear != null) {
                    $VoucherData['financial_year'] = $sessionFinancialYear;
                }
                if ($sessionVoucherDate != null) {
                    $VoucherData['voucher_date'] = $sessionVoucherDate;
                }

            } else {
                $VoucherData = array(
                    'number' => str_pad(CoreAccounts::getVouchertMaxId(4, $companyId), 6, '0', STR_PAD_LEFT),
                    'cheque_no' => '',
                    'cheque_date' => '',
                    'invoice_no' => '',
                    'invoice_date' => '',
                    'voucher_date' => $sessionVoucherDate ?? null,
                    'entry_type_id' => '',
                    'branch_id' => '',
                    'employee_id' => '',
                    'suppliers_id' => '',
                    'remarks' => '',
                    'narration' => '',
                    'dr_total' => '',
                    'cr_total' => '',
                    'diff_total' => '',
                    'financial_year' => $sessionFinancialYear ?? null,
                    'entry_items' => array(
                        'counter' => array(),
                        'ledger_id' => array(),
                        'dr_amount' => array(),
                        'cr_amount' => array(),
                        'narration' => array(),
                    ),
                    'ledger_array' => array(),
                );
            }
            $Employees = Staff::get()->pluck('user_id', 'middle_name');
            $Employees->prepend('Select an Employee', '');
            // Get All Branch
            $Branch = Branch::get();
            $companies = Company::get();

            $financial_year = GernalHelper::get_financial_year();

            return view('accounts.entries.voucher.bank_voucher.bank_receipt.create', compact('financial_year', 'Employees', 'entries', 'Branch', 'VoucherData', 'companies', 'companyId', 'branchId'));
        } else {
            return abort(401);
        }
    }

    public function crvCreate()
    {
        $entries = [];

        $entries_session = Session::get('entries');
        if ($entries_session) {
            $entries = Entries::with('entry_type')->whereIn('id', $entries_session)->get();
        }

        $companyId = Session::get('company_session') ?? Branch::where('id', Auth::user()->branch_id)->value('company_id');
        $branchId = Session::get('branch_session') ?? 0;
        $sessionFinancialYear = Session::get('financial_year_session') ?? '';
        $sessionVoucherDate = Session::get('voucher_date_session') ?? '';

        if (Auth::user()->isAbleTo('create-cash-receipt-voucher')) {
            $VoucherData = Session::get('_old_input');
            if (is_array($VoucherData) && !empty($VoucherData)) {
                // Fetch Ledger IDs to create Ledger Objects
                $ledger_ids = array();
                if (isset($VoucherData['entry_items']) && count($VoucherData['entry_items'])) {
                    $entry_items = $VoucherData['entry_items'];
                    foreach ($entry_items['counter'] as $key => $val) {
                        if (isset($entry_items['ledger_id'][$val]) && $entry_items['ledger_id'][$val]) {
                            $ledger_ids[] = $entry_items['ledger_id'][$val];
                        } else {
                            $VoucherData['entry_items']['ledger_id'][$val] = '';
                        }
                    }
                }
                if (count($ledger_ids)) {
                    $VoucherData['ledger_array'] = Ledger::whereIn('id', $ledger_ids)->get()->getDictionary();
                    // dd( $VoucherData);
                } else {
                    $VoucherData['ledger_array'] = array();
                }

                if ($sessionFinancialYear != null) {
                    $VoucherData['financial_year'] = $sessionFinancialYear;
                }
                if ($sessionVoucherDate != null) {
                    $VoucherData['voucher_date'] = $sessionVoucherDate;
                }

            } else {
                $VoucherData = array(
                    'number' => str_pad(CoreAccounts::getVouchertMaxId(2, $companyId), 6, '0', STR_PAD_LEFT),
                    'cheque_no' => '',
                    'cheque_date' => '',
                    'invoice_no' => '',
                    'invoice_date' => '',
                    'voucher_date' => $sessionVoucherDate ?? null,
                    'entry_type_id' => '',
                    'branch_id' => '',
                    'employee_id' => '',
                    'suppliers_id' => '',
                    'remarks' => '',
                    'narration' => '',
                    'dr_total' => '',
                    'cr_total' => '',
                    'diff_total' => '',
                    'financial_year' => $sessionFinancialYear ?? null,
                    'entry_items' => array(
                        'counter' => array(),
                        'ledger_id' => array(),
                        'dr_amount' => array(),
                        'cr_amount' => array(),
                        'narration' => array(),
                    ),
                    'ledger_array' => array(),
                );
            }
            // Get All Employees
            $Employees = Staff::get()->pluck('user_id', 'middle_name');
            $Employees->prepend('Select an Employee', '');

            // Get All Branch
            // Get All Branch
            $Branch = Branch::get();
            $companies = Company::get();

            $financial_year = GernalHelper::get_financial_year();

            return view('accounts.entries.voucher.cash_voucher.cash_receipt.create', compact('financial_year', 'Employees', 'entries', 'Branch', 'VoucherData', 'companies', 'companyId', 'branchId'));
        } else {
            return abort(401);
        }
    }

//   public function gjvedit($id)
//    {
//        dd($id);
//    }
//
    public function gjvCreate()
    {

        $entries = [];

        $entries_session = Session::get('entries');
        if ($entries_session) {
            $entries = Entries::with('entry_type')->whereIn('id', $entries_session)->get();
        }

        $companyId = Session::get('company_session') ?? Branch::where('id', Auth::user()->branch_id)->value('company_id');
        $branchId = Session::get('branch_session') ?? 0;
        $sessionFinancialYear = Session::get('financial_year_session') ?? '';
        $sessionVoucherDate = Session::get('voucher_date_session') ?? '';
        $vendor = Vendor::get();
        $vendorDropdown = 1;


            $VoucherData = Session::get('_old_input');

            if (is_array($VoucherData) && !empty($VoucherData)) {
                $ledger_ids = array();
                if (isset($VoucherData['entry_items']) && count($VoucherData['entry_items'])) {
                    $entry_items = $VoucherData['entry_items'];
                    foreach ($entry_items['counter'] as $key => $val) {
                        if (isset($entry_items['ledger_id'][$val]) && $entry_items['ledger_id'][$val]) {
                            $ledger_ids[] = $entry_items['ledger_id'][$val];
                        } else {
                            $VoucherData['entry_items']['ledger_id'][$val] = '';
                        }
                    }
                }
                if (count($ledger_ids)) {
                    $VoucherData['ledger_array'] = Ledger::whereIn('id', $ledger_ids)->get()->getDictionary();
                } else {
                    $VoucherData['ledger_array'] = array();
                }

                if ($sessionFinancialYear != null) {
                    $VoucherData['financial_year'] = $sessionFinancialYear;
                }
                if ($sessionVoucherDate != null) {
                    $VoucherData['voucher_date'] = $sessionVoucherDate;
                }

            } else {
                $VoucherData = array(
                    'number' => str_pad(CoreAccounts::getVouchertMaxId(1, $companyId), 6, '0', STR_PAD_LEFT),
                    'cheque_no' => '',
                    'cheque_date' => '',
                    'invoice_no' => '',
                    'invoice_date' => '',
                    'voucher_date' => $sessionVoucherDate ?? null,
                    'entry_type_id' => '',
                    'branch_id' => '',
                    'employee_id' => '',
                    'suppliers_id' => '',
                    'remarks' => '',
                    'narration' => '',
                    'dr_total' => '',
                    'cr_total' => '',
                    'diff_total' => '',
                    'financial_year' => $sessionFinancialYear ?? null,
                    'entry_items' => array(
                        'counter' => array(),
                        'ledger_id' => array(),
                        'dr_amount' => array(),
                        'cr_amount' => array(),
                        'narration' => array(),
                        'vendor_id' => array(),
                    ),
                    'ledger_array' => array(),
                );
            }
            // Get All Employees
            $Employees = Staff::get()->pluck('user_id', 'middle_name');
            $Employees->prepend('Select an Employee', '');

            // Get All Branch
        $branches = Branch::get();
            $companies = Company::get();

            $financial_year = GernalHelper::get_financial_year();

            return view('accounts.entries.voucher.journal_voucher.create', compact('vendor', 'vendorDropdown', 'financial_year', 'Employees', 'entries', 'branches', 'VoucherData', 'companies', 'companyId', 'branchId', 'sessionVoucherDate'));

    }

    public function download($id)
    {

            $Entrie = Entries::findOrFail($id);

            $EntryType = EntryTypes::findOrFail($Entrie->entry_type_id);

            $EntryTypes = EntryTypes::all();
            $Branch = Branch::find($Entrie->branch_id);
            $Employee = Staff::whereId($Entrie->employee_id)->first();
            $company = Company::where('id', $Entrie->company_id)->first();
            //dd( $Suppliers);
            // Get Entry Items Associated with this Entry
            $Entry_items = EntryItems::with('vendor_data:vendor_id,vendor_name')->where(['entry_id' => $Entrie->id])
                ->orderby('dc', 'asc')->get();
            // $account = AccountTypes::get();
            $Ledgers = Ledger::whereIn(
                'id',
                EntryItems::where(['entry_id' => $Entrie->id])->orderby('dc', 'desc')->pluck('ledger_id')->toArray()
            )->get()->getDictionary();
            $pdf = PDF::loadView('accounts.entries.print', compact('company', 'Entrie', 'id', 'EntryType', 'EntryTypes', 'Branch', 'Employee', 'Entry_items', 'Ledgers'))->setPaper('a4', 'landscape');
            return $pdf->stream('invoice.pdf');

    }

    public function store(StoreEntriesRequest $request)
    {


        Entries::create([
            'name' => $request['name'],
            'shortcode' => $request['shortcode'],
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
            'status' => 0,
        ]);

        flash('Record has been created successfully.')->success()->important();

        return redirect()->route('admin.entries.index');
    }


    /**
     * Show the form for editing Entrie.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entry_types = EntryTypes::pluck('name', 'id');
        $VoucherData = Entries::findOrFail($id)->toArray();
        $VoucherData['voucher_date'] = date('d-m-Y', strtotime($VoucherData['voucher_date']));

        $VoucherData['entry_items'] = array(
            'counter' => array(),
            'ledger_id' => array(),
            'dr_amount' => array(),
            'cr_amount' => array(),
            'narration' => array(),
            'vendor_id' => array(),
        );
        $VoucherData['ledger_array'] = array();

        // Fetch Entry Items and insert into voucher Data Array
        $EntryItems = EntryItems::where(['entry_id' => $VoucherData['id']])->OrderBy('id', 'asc')->get()->toArray();

        if (count($EntryItems)) {
            $counter = 1;
            $ledger_ids = array();
            foreach ($EntryItems as $EntryItem) {
                $ledger_ids[] = $EntryItem['ledger_id'];
                $VoucherData['entry_items']['counter'][$counter] = $counter;
                $VoucherData['entry_items']['ledger_id'][$counter] = $EntryItem['ledger_id'];
                $VoucherData['entry_items']['narration'][$counter] = $EntryItem['narration'];
                $VoucherData['entry_items']['instrument_number'][$counter] = $EntryItem['instrument_number'];
                if ($EntryItem['dc'] == 'd') {
                    $VoucherData['entry_items']['dr_amount'][$counter] = $EntryItem['amount'];
                    $VoucherData['entry_items']['cr_amount'][$counter] = 0;
                } else {
                    $VoucherData['entry_items']['dr_amount'][$counter] = 0;
                    $VoucherData['entry_items']['cr_amount'][$counter] = $EntryItem['amount'];
                }
                $counter++;
            }
            // Get Ledgers for Entries
            $VoucherData['ledger_array'] = Ledger::whereIn('id', $ledger_ids)->get()->getDictionary();
        }

        // Get All Employees
        $Employees = Staff::get()->pluck('user_id', 'middle_name');
        $Employees->prepend('Select an Employee', '');

        $companies = Company::get();
        $Branch = Branch::get();

        $financial_year = GernalHelper::get_financial_year();
        $vendor = Vendor::get();
        if (
            $VoucherData['entry_type_id'] == 1 ||
            $VoucherData['entry_type_id'] == 3 ||
            $VoucherData['entry_type_id'] == 5
        ) {
            $vendorDropdown = 1;
        } else {
            $vendorDropdown = 0;
        }

        return view('accounts.entries.voucher.bank_voucher.bank_payment.edit', compact('entry_types', 'vendor', 'vendorDropdown', 'financial_year', 'companies', 'Employees', 'Branch', 'VoucherData'));
    }

    /**
     * Update Entrie in storage.
     *
     * @param \App\Http\Requests\Admin\UpdateEntrieRequest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // if (!Gate::allows('erp_entries_edit')) {
        //     return abort(401);
        // }

        $response = CoreAccounts::updateEntry($request->all(), $id);

        if ($response['status']) {
            return redirect()->to('admin/entries')->with('success', 'Record has been updated successfully');
            //return redirect()->route('admin.entries.index');
        } else {
            $request->flash();
            return redirect()->back()
                ->withErrors($response['error'])
                ->withInput();
        }
    }


    /**
     * Remove Entrie from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Gate::allows('erp_entries_destroy')) {
            return abort(401);
        }
        $Entrie = Entries::findOrFail($id);
        $Entrie->delete();

        flash('Record has been deleted successfully.')->success()->important();

        return redirect()->route('admin.entries.index');
    }

    /**
     * Activate Entrie from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function active($id)
    {
        if (!Gate::allows('erp_entries_active')) {
            return abort(401);
        }

        $Entrie = Entries::findOrFail($id);
        $Entrie->update(['status' => 1]);
        EntryItems::where(['entry_id' => $Entrie->id])->update(['status' => 1]);

        flash('Record has been activated successfully.')->success()->important();

        return redirect()->route('admin.entries.index');
    }

    /**
     * Inactivate Entrie from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function inactive($id)
    {
        if (!Gate::allows('erp_entries_inactive')) {
            return abort(401);
        }

        $Entrie = Entries::findOrFail($id);
        $Entrie->update(['status' => 0]);
        EntryItems::where(['entry_id' => $Entrie->id])->update(['status' => 0]);

        flash('Record has been inactivated successfully.')->success()->important();

        return redirect()->route('admin.entries.index');
    }

    /**
     * Create Journal Voucher Entry
     *
     * @return \Illuminate\Http\Response
     */
    public function gjv_create()
    {
        if (!Gate::allows('erp_entries_manage')) {
            return abort(401);
        }

        $VoucherData = Session::get('_old_input');
        if (is_array($VoucherData) && !empty($VoucherData)) {
            // Fetch Ledger IDs to create Ledger Objects
            $ledger_ids = array();
            if (isset($VoucherData['entry_items']) && count($VoucherData['entry_items'])) {
                $entry_items = $VoucherData['entry_items'];
                foreach ($entry_items['counter'] as $key => $val) {
                    if (isset($entry_items['ledger_id'][$val]) && $entry_items['ledger_id'][$val]) {
                        $ledger_ids[] = $entry_items['ledger_id'][$val];
                    } else {
                        $VoucherData['entry_items']['ledger_id'][$val] = '';
                    }
                }
            }
            if (count($ledger_ids)) {
                $VoucherData['ledger_array'] = Ledger::whereIn('id', $ledger_ids)->get()->getDictionary();
                // dd( $VoucherData);
            } else {
                $VoucherData['ledger_array'] = array();
            }
        } else {
            $VoucherData = array(
                'number' => '',
                'cheque_no' => '',
                'cheque_date' => '',
                'invoice_no' => '',
                'invoice_date' => '',
                'voucher_date' => '',
                'entry_type_id' => '',
                'branch_id' => '',
                'employee_id' => '',
                'suppliers_id' => '',
                'remarks' => '',
                'narration' => '',
                'dr_total' => '',
                'cr_total' => '',
                'diff_total' => '',
                'entry_items' => array(
                    'counter' => array(),
                    'ledger_id' => array(),
                    'dr_amount' => array(),
                    'cr_amount' => array(),
                    'narration' => array(),
                ),
                'ledger_array' => array(),
            );
        }

        // Get All Employees
        $Employees = Staff::get()->pluck('user_id', 'middle_name');
        $Employees->prepend('Select an Employee', '');

        // Get All Branch
        $Branch = Branch::pluckActiveOnly();
        $Branch->prepend('Select a Branch', '');

        // Get All Departments
        //        $Departments = Departments::pluckActiveOnly();
        //        $Departments->prepend('Select a Department', '');

        return view('admin.entries.voucher.journal_voucher.create', compact('Employees', 'Branch', 'VoucherData'));
    }

    /**
     * Journal Voucher Items Search
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function gjv_search(Request $request)
    {
        $bankAccountGroupId = Config::get('constants.bank_account_group_id');
        $AccumulatedDepreciationGroupId = Config::get('constants.accumulated_depreciation_group_id');
        $result = array();
        $result['status'] = 0;

        $loggedIn = auth()->user()->branch_id;

        if (isset($request['item']) && $request['item']) {
            $ledgers = Ledger::where(['status' => 1])
                ->where('name', 'LIKE', "%{$request['item']}%")
                ->orwhere('number', 'LIKE', "%{$request['item']}%")->get();

//            if (isset($request['company_id']) && $request['company_id'] > 0) {
//                $ledgers = $ledgers->where('company_id', $request['company_id']);
//            }


//                    $ledgers = $ledgers->where('branch_id', $request['branch_id']);
                    $result['status'] = 1;





                $IncludeLedgers = Ledger::where('name', 'LIKE', "%{$request['item']}%")
                    ->orwhere('number', 'LIKE', "%{$request['item']}%")->get();

                $bankAccountLedgers = $IncludeLedgers->where('group_id', $bankAccountGroupId)
                    ->whereNotIn('id', $ledgers->pluck('id'))->where('status', 1);
                $ledgers = $ledgers->concat($bankAccountLedgers);

                $childDepreciationGroups = Groups::where('parent_id', $AccumulatedDepreciationGroupId)->pluck('id');
                foreach ($childDepreciationGroups as $childDepreciationGroup) {

                    $accumulatedDepreciationLedgers = $IncludeLedgers->where('group_id', $childDepreciationGroup)
                        ->whereNotIn('id', $ledgers->pluck('id'))->where('status', 1);
                    $ledgers = $ledgers->concat($accumulatedDepreciationLedgers);

                }


            $result['data'][] = array(
                'text' => '',
                'id' => '',
            );

            foreach ($ledgers as $ledger) {
                $prefix = Ledger::getAllParent($ledger->group_id);
                if ($prefix == '0' || $prefix == null) {
                    $text_ledger = '( ' . $ledger->number . ' )';
                } else {
                    $text_ledger = $prefix;
                }
                $result['data'][] = array(
                    //'text' => $ledger->number . ' - ' . $ledger->name,
                    'text' => $text_ledger . ' - ' . $ledger->name,
                    'id' => $ledger->id,
                );
            }

            return response()->json($result);
        } else {
            return response()->json([]);
        }
    }

    public function teacher_search(Request $request)
    {
        $bID = 0;
        if ($request['type'] == "Staff") {
            if (isset($request['item']) && $request['item']) {
                $ledgers = "";
                if (isset($request['branch_id']) && $request['branch_id'] > 0) {
                    $bID = $request['branch_id'];
                    $ledgers = Staff::where(['status' => 1])->where('branch_id', $bID)
                        ->where('first_name', 'LIKE', "%{$request['item']}%")
                        // ->orwhere('number','LIKE',"%{$request['item']}%")
                        ->OrderBy('first_name', 'asc')->get();
                } else {
                    $ledgers = Staff::where(['status' => 1])->where('first_name', 'LIKE', "%{$request['item']}%")
                        // ->orwhere('number','LIKE',"%{$request['item']}%")
                        ->OrderBy('first_name', 'asc')->get();
                    $bID = Auth::user()->branch_id;
                }


                // dd($ledgers[0]['group_id']);
                $result = array();

                //if($ledgers->count()) {
                foreach ($ledgers as $ledger) {
                    $prefix = Ledger::getAllParent($ledger->group_id);
                    if ($prefix == '0') {
                        $text_ledger = '(' . $ledger->number . '-' . $ledger->groups['name'] . ')';
                    } else {
                        $text_ledger = $prefix;
                    }
                    $result[] = array(
                        'text' => $ledger->reg_no . ' ' . $ledger->first_name . ' ' . $ledger->last_name,
                        'id' => $ledger->reg_no . ' ' . $ledger->first_name . ' ' . $ledger->last_name,
                    );
                }
                //}

                return response()->json($result);
            } else {
                return response()->json([]);
            }
        } elseif ($request['type'] == "Student") {
            $bID = 0;
            if (isset($request['item']) && $request['item']) {
                $ledgers = "";
                if (isset($request['branch_id']) && $request['branch_id'] > 0) {
                    $bID = $request['branch_id'];
                    $ledgers = Students::where(['status' => 1])->where('branch_id', $bID)
                        ->where('first_name', 'LIKE', "%{$request['item']}%")
                        // ->orwhere('number','LIKE',"%{$request['item']}%")
                        ->OrderBy('first_name', 'asc')->get();
                } else {
                    $ledgers = Students::where(['status' => 1])->where('first_name', 'LIKE', "%{$request['item']}%")
                        // ->orwhere('number','LIKE',"%{$request['item']}%")
                        ->OrderBy('first_name', 'asc')->get();
                    $bID = Auth::user()->branch_id;
                }


                // dd($ledgers[0]['group_id']);
                $result = array();

                //if($ledgers->count()) {
                foreach ($ledgers as $ledger) {
                    $prefix = Ledger::getAllParent($ledger->group_id);
                    if ($prefix == '0') {
                        $text_ledger = '(' . $ledger->number . '-' . $ledger->groups['name'] . ')';
                    } else {
                        $text_ledger = $prefix;
                    }
                    $result[] = array(
                        //'text' => $ledger->number . ' - ' . $ledger->name,
                        'text' => $ledger->reg_no . ' ' . $ledger->first_name . ' ' . $ledger->last_name,
                        'id' => $ledger->reg_no . ' ' . $ledger->first_name . ' ' . $ledger->last_name,
                    );
                }
                //}

                return response()->json($result);
            } else {
                return response()->json([]);
            }
        } else {
            $bID = 0;

            if (isset($request['item']) && $request['item']) {
                $ledgers = "";

                $bID = Auth::user()->branch_id;
                $ledgers = Ledger::where(['status' => 1])->where('branch_id', $bID)
                    ->where('name', 'LIKE', "%{$request['item']}%")
                    ->orwhere('number', 'LIKE', "%{$request['item']}%")
                    ->OrderBy('name', 'asc')->get();

                if ((isset($request['company_id']) && $request['company_id'] > 0) && (isset($request['branch_id']) && $request['branch_id'] > 0)) {
                    $company_id = $request['company_id'];
                    $bID = $request['branch_id'];
                    $ledgers = Ledger::where(['status' => 1])->where('company_id', $company_id)
                        ->where('branch_id', $bID)
                        ->where('name', 'LIKE', "%{$request['item']}%")
                        ->orwhere('number', 'LIKE', "%{$request['item']}%")
                        ->OrderBy('name', 'asc')->get();
                } elseif (isset($request['company_id']) && $request['company_id'] > 0) {
                    $company_id = $request['company_id'];

                    $branchIds = Branch::pluckActiveOnly();
                    $allowedBranch = array();
                    foreach ($branchIds as $key => $value) {
                        if ((Auth::user()->isAbleTo('Branch_' . $key)) || Auth::user()->roles[0]->name == "administrator") {
                            $allowedBranch[] = $key;
                        }
                    }

                    $ledgers = Ledger::where(['status' => 1])->where('company_id', $company_id)
                        ->whereIn('branch_id', $allowedBranch)
                        ->where('name', 'LIKE', "%{$request['item']}%")
                        ->orwhere('number', 'LIKE', "%{$request['item']}%")
                        ->OrderBy('name', 'asc')->get();
                }

                // dd($ledgers[0]['group_id']);
                $result = array();

                //if($ledgers->count()) {
                foreach ($ledgers as $ledger) {
                    $prefix = Ledger::getAllParent($ledger->group_id);
                    if ($prefix == '0') {
                        $text_ledger = '(' . $ledger->number . '-' . $ledger->groups['name'] . ')';
                    } else {
                        $text_ledger = $prefix;
                    }

                    $result[] = array(
                        'text' => $ledger->number . ' - ' . $ledger->name,
                        // 'text' => $text_ledger . ' - ' . $ledger->name,
                        'id' => $ledger->id,
                    );
                }
                //}

                return response()->json($result);
            } else {
                return response()->json([]);
            }
        }
    }

    public function student_search(Request $request)
    {
    }

    /**
     * Store a newly created Journal Voucher in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function gjv_store(Request $request)
    {
        $response = CoreAccounts::createEntry($request->all());

        if ($response['status']) {
            flash('Record has been created successfully.')->success()->important();
            return redirect()->back();
        } else {
            $request->flash();
            return redirect()->back()
                ->withErrors($response['error'])
                ->withInput();
        }
    }


    /*
     * ----------------------------------------------------------------------------------------
     * ------------------------------- Cash Vouchers Starts -----------------------------------
     * ----------------------------------------------------------------------------------------
    */

    /**
     * Create Cash Receipt Voucher Entry
     *
     * @return \Illuminate\Http\Response
     */
    public function crv_create()
    {
        if (!Gate::allows('erp_entries_manage')) {
            return abort(401);
        }

        $VoucherData = Session::get('_old_input');
        if (is_array($VoucherData) && !empty($VoucherData)) {
            // Fetch Ledger IDs to create Ledger Objects
            $ledger_ids = array();
            if (isset($VoucherData['entry_items']) && count($VoucherData['entry_items'])) {
                $entry_items = $VoucherData['entry_items'];
                foreach ($entry_items['counter'] as $key => $val) {
                    if (isset($entry_items['ledger_id'][$val]) && $entry_items['ledger_id'][$val]) {
                        $ledger_ids[] = $entry_items['ledger_id'][$val];
                    } else {
                        $VoucherData['entry_items']['ledger_id'][$val] = '';
                    }
                }
            }
            if (count($ledger_ids)) {
                $VoucherData['ledger_array'] = Ledger::whereIn('id', $ledger_ids)->get()->getDictionary();
            } else {
                $VoucherData['ledger_array'] = array();
            }
        } else {
            $VoucherData = array(
                'number' => '',
                'cheque_no' => '',
                'cheque_date' => '',
                'invoice_no' => '',
                'invoice_date' => '',
                'cdr_no' => '',
                'cdr_date' => '',
                'bdr_no' => '',
                'bdr_date' => '',
                'bank_name' => '',
                'bank_branch' => '',
                'drawn_date' => '',
                'voucher_date' => '',
                'entry_type_id' => '',
                'branch_id' => '',
                'employee_id' => '',
                'department_id' => '',
                'remarks' => '',
                'narration' => '',
                'dr_total' => '',
                'cr_total' => '',
                'diff_total' => '',
                'entry_items' => array(
                    'counter' => array(),
                    'ledger_id' => array(),
                    'dr_amount' => array(),
                    'cr_amount' => array(),
                    'narration' => array(),
                ),
                'ledger_array' => array(),
            );
        }

        // Get All Employees
        $Employees = Staff::get()->pluck('user_id', 'middle_name');
        $Employees->prepend('Select an Employee', '');

        // Get All Branch
        $Branch = Branch::pluckActiveOnly();
        $Branch->prepend('Select a Branch', '');

        // Get All Departments
        $Departments = Departments::pluckActiveOnly();
        $Departments->prepend('Select a Department', '');

        return view('admin.entries.voucher.cash_voucher.cash_receipt.create', compact('Employees', 'Branch', 'Departments', 'VoucherData'));
    }

    /**
     * Store a newly created Cash Receipt Voucher in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function crv_store(Request $request)
    {
        $response = CoreAccounts::createEntry($request->all());

        if ($response['status']) {
            flash('Record has been created successfully.')->success()->important();
            return redirect()->back();
        } else {
            $request->flash();
            return redirect()->back()
                ->withErrors($response['error'])
                ->withInput();
        }
    }

    /**
     * All Items except Bank & Cash Search Search
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function crv_search(Request $request)
    {

        if (isset($request['item']) && $request['item']) {

            $Branch = Sess::get('branch');
            $ledgers = Ledger::where(function ($query) {
                global $request;
                $query->where('name', 'LIKE', "%{$request['item']}%")
                    ->orwhere('number', 'LIKE', "%{$request['item']}%");
            })->OrderBy('name', 'asc')->get();

            $result = array();
            if ($ledgers->count()) {
                foreach ($ledgers as $ledger) {
                    $prefix = Ledger::getAllParent($ledger->group_id);

                    $text_ledger = '(' . $ledger->name . ')';

                    $result[] = array(
                        'text' => $text_ledger . ' - ' . $ledger->name,
                        'id' => $ledger->id,
                    );
                }
            }

            return response()->json($result);
        } else {
            return response()->json([]);
        }
    }

    /**
     * Create Cash Payment Voucher Entry
     *
     * @return \Illuminate\Http\Response
     */
    public function cpv_create()
    {
        if (!Gate::allows('erp_entries_manage')) {
            return abort(401);
        }

        $VoucherData = Session::get('_old_input');
        if (is_array($VoucherData) && !empty($VoucherData)) {
            // Fetch Ledger IDs to create Ledger Objects
            $ledger_ids = array();
            if (isset($VoucherData['entry_items']) && count($VoucherData['entry_items'])) {
                $entry_items = $VoucherData['entry_items'];
                foreach ($entry_items['counter'] as $key => $val) {
                    if (isset($entry_items['ledger_id'][$val]) && $entry_items['ledger_id'][$val]) {
                        $ledger_ids[] = $entry_items['ledger_id'][$val];
                    } else {
                        $VoucherData['entry_items']['ledger_id'][$val] = '';
                    }
                }
            }
            if (count($ledger_ids)) {
                $VoucherData['ledger_array'] = Ledger::whereIn('id', $ledger_ids)->get()->getDictionary();
            } else {
                $VoucherData['ledger_array'] = array();
            }
        } else {
            $VoucherData = array(
                'number' => '',
                'cheque_no' => '',
                'cheque_date' => '',
                'invoice_no' => '',
                'invoice_date' => '',
                'cdr_no' => '',
                'cdr_date' => '',
                'bdr_no' => '',
                'bdr_date' => '',
                'bank_name' => '',
                'bank_branch' => '',
                'drawn_date' => '',
                'voucher_date' => '',
                'entry_type_id' => '',
                'branch_id' => '',
                'employee_id' => '',
                'department_id' => '',
                'remarks' => '',
                'narration' => '',
                'dr_total' => '',
                'cr_total' => '',
                'diff_total' => '',
                'entry_items' => array(
                    'counter' => array(),
                    'ledger_id' => array(),
                    'dr_amount' => array(),
                    'cr_amount' => array(),
                    'narration' => array(),
                ),
                'ledger_array' => array(),
            );
        }

        // Get All Employees
        $Employees = Staff::get()->pluck('user_id', 'middle_name');
        $Employees->prepend('Select an Employee', '');

        // Get All Branch
        $Branch = Branch::pluckActiveOnly();
        $Branch->prepend('Select a Branch', '');

        // Get All Departments
        $Departments = Departments::pluckActiveOnly();
        $Departments->prepend('Select a Department', '');

        return view('admin.entries.voucher.cash_voucher.cash_payment.create', compact('Employees', 'Branch', 'Departments', 'VoucherData'));
    }

    /**
     * Store a newly created Cash Payment Voucher in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function cpv_store(Request $request)
    {
        $response = CoreAccounts::createEntry($request->all());

        if ($response['status']) {
            flash('Record has been created successfully.')->success()->important();
            return redirect()->back();
        } else {
            $request->flash();
            return redirect()->back()
                ->withErrors($response['error'])
                ->withInput();
        }
    }

    /**
     * All Items except Bank & Cash Search Search
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function cpv_search(Request $request)
    {
        if (isset($request['item']) && $request['item']) {
            //            $Setting = Settings::findOrFail(Config::get('constants.accounts_cash_banks_head_setting_id'));
            //            $parentGroups = new GroupsTree();
            //            $parentGroups->current_id = -1;
            //            $parentGroups->build($Setting->description);
            //            $parentGroups->toListArray($parentGroups, -1);

            $ledgers = Ledger::where(['status' => 1])
                //->whereNotIn('group_id', $parentGroups->groupListIDs)
                ->where(function ($query) {
                    global $request;
                    $query->where('name', 'LIKE', "%{$request['item']}%")
                        ->orwhere('number', 'LIKE', "%{$request['item']}%");
                })->OrderBy('name', 'asc')->get();

            $result = array();
            if ($ledgers->count()) {
                foreach ($ledgers as $ledger) {
                    $prefix = Ledger::getAllParent($ledger->group_id);
                    if ($prefix == '0') {
                        $text_ledger = '(' . $ledger->groups['name'] . ')';
                    } else {
                        $text_ledger = $prefix;
                    }
                    $result[] = array(
                        //'text' => $ledger->number . ' - ' . $ledger->name,
                        'text' => $text_ledger . ' - ' . $ledger->name,
                        'id' => $ledger->id,
                    );
                }
            }

            return response()->json($result);
        } else {
            return response()->json([]);
        }
    }

    /*
     * ----------------------------------------------------------------------------------------
     * ------------------------------- Cash Vouchers Ends -----------------------------------
     * ----------------------------------------------------------------------------------------
    */


    /*
     * ----------------------------------------------------------------------------------------
     * ------------------------------- Banks Vouchers Starts -----------------------------------
     * ----------------------------------------------------------------------------------------
    */

    /**
     * Create Bank Receipt Voucher Entry
     *
     * @return \Illuminate\Http\Response
     */
    public function brv_create()
    {
        if (!Gate::allows('erp_entries_manage')) {
            return abort(401);
        }

        $VoucherData = Session::get('_old_input');
        if (is_array($VoucherData) && !empty($VoucherData)) {
            // Fetch Ledger IDs to create Ledger Objects
            $ledger_ids = array();
            if (isset($VoucherData['entry_items']) && count($VoucherData['entry_items'])) {
                $entry_items = $VoucherData['entry_items'];
                foreach ($entry_items['counter'] as $key => $val) {
                    if (isset($entry_items['ledger_id'][$val]) && $entry_items['ledger_id'][$val]) {
                        $ledger_ids[] = $entry_items['ledger_id'][$val];
                    } else {
                        $VoucherData['entry_items']['ledger_id'][$val] = '';
                    }
                }
            }
            if (count($ledger_ids)) {
                $VoucherData['ledger_array'] = Ledger::whereIn('id', $ledger_ids)->get()->getDictionary();
            } else {
                $VoucherData['ledger_array'] = array();
            }
        } else {
            $VoucherData = array(
                'number' => '',
                'cheque_no' => '',
                'cheque_date' => '',
                'invoice_no' => '',
                'invoice_date' => '',
                'cdr_no' => '',
                'cdr_date' => '',
                'bdr_no' => '',
                'bdr_date' => '',
                'bank_name' => '',
                'bank_branch' => '',
                'drawn_date' => '',
                'voucher_date' => '',
                'entry_type_id' => '',
                'branch_id' => '',
                'employee_id' => '',
                'department_id' => '',
                'remarks' => '',
                'narration' => '',
                'dr_total' => '',
                'cr_total' => '',
                'diff_total' => '',
                'entry_items' => array(
                    'counter' => array(),
                    'ledger_id' => array(),
                    'dr_amount' => array(),
                    'cr_amount' => array(),
                    'narration' => array(),
                ),
                'ledger_array' => array(),
            );
        }

        // Get All Employees
        $Employees = Staff::get()->pluck('user_id', 'middle_name');
        $Employees->prepend('Select an Employee', '');

        // Get All Branch
        $Branch = Branch::pluckActiveOnly();
        $Branch->prepend('Select a Branch', '');

        // Get All Departments
        $Departments = Departments::pluckActiveOnly();
        $Departments->prepend('Select a Department', '');

        return view('admin.entries.voucher.bank_voucher.bank_receipt.create', compact('Employees', 'Branch', 'Departments', 'VoucherData'));
    }

    /**
     * Store a newly created Cash Receipt Voucher in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function brv_store(Request $request)
    {
        $response = CoreAccounts::createEntry($request->all());

        if ($response['status']) {
            flash('Record has been created successfully.')->success()->important();
            return redirect()->back();
        } else {
            $request->flash();
            return redirect()->back()
                ->withErrors($response['error'])
                ->withInput();
        }
    }

    /**
     * All Items except Bank & Cash Search Search
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function brv_search(Request $request)
    {
        if (isset($request['item']) && $request['item']) {
            $Setting = Settings::findOrFail(Config::get('constants.accounts_cash_banks_head_setting_id'));
            $parentGroups = new GroupsTree();
            $parentGroups->current_id = -1;
            $parentGroups->build($Setting->description);
            $parentGroups->toListArray($parentGroups, -1);

            $ledgers = Ledger::where(['status' => 1])
                //->whereNotIn('group_id', $parentGroups->groupListIDs)
                ->where(function ($query) {
                    global $request;
                    $query->where('name', 'LIKE', "%{$request['item']}%")
                        ->orwhere('number', 'LIKE', "%{$request['item']}%");
                })->OrderBy('name', 'asc')->get();

            $result = array();
            if ($ledgers->count()) {
                foreach ($ledgers as $ledger) {
                    $prefix = Ledger::getAllParent($ledger->group_id);
                    if ($prefix == '0') {
                        $text_ledger = '(' . $ledger->groups['name'] . ')';
                    } else {
                        $text_ledger = $prefix;
                    }
                    $result[] = array(
                        //'text' => $ledger->number . ' - ' . $ledger->name,
                        'text' => $text_ledger . ' - ' . $ledger->name,
                        'id' => $ledger->id,
                    );
                }
            }

            return response()->json($result);
        } else {
            return response()->json([]);
        }
    }

    /**
     * Create LC Payment Voucher Entry
     *
     * @return \Illuminate\Http\Response
     */

    public function bpv_create()
    {
        /*  if (! Gate::allows('erp_entries_manage')) {
            return abort(401);
        }
        */

        $VoucherData = Session::get('_old_input');
        if (is_array($VoucherData) && !empty($VoucherData)) {
            // Fetch Ledger IDs to create Ledger Objects
            $ledger_ids = array();
            if (isset($VoucherData['entry_items']) && count($VoucherData['entry_items'])) {
                $entry_items = $VoucherData['entry_items'];
                foreach ($entry_items['counter'] as $key => $val) {
                    if (isset($entry_items['ledger_id'][$val]) && $entry_items['ledger_id'][$val]) {
                        $ledger_ids[] = $entry_items['ledger_id'][$val];
                    } else {
                        $VoucherData['entry_items']['ledger_id'][$val] = '';
                    }
                }
            }
            if (count($ledger_ids)) {
                $VoucherData['ledger_array'] = Ledger::whereIn('id', $ledger_ids)->get()->getDictionary();
            } else {
                $VoucherData['ledger_array'] = array();
            }
        } else {
            $VoucherData = array(
                'number' => '',
                'cheque_no' => '',
                'cheque_date' => '',
                'invoice_no' => '',
                'invoice_date' => '',
                'cdr_no' => '',
                'cdr_date' => '',
                'bdr_no' => '',
                'bdr_date' => '',
                'bank_name' => '',
                'bank_branch' => '',
                'drawn_date' => '',
                'voucher_date' => '',
                'entry_type_id' => '',
                'branch_id' => '',
                'employee_id' => '',
                'department_id' => '',
                'remarks' => '',
                'narration' => '',
                'dr_total' => '',
                'cr_total' => '',
                'diff_total' => '',
                'entry_items' => array(
                    'counter' => array(),
                    'ledger_id' => array(),
                    'dr_amount' => array(),
                    'cr_amount' => array(),
                    'narration' => array(),
                ),
                'ledger_array' => array(),
            );
        }

        // Get All Employees
        /*     $Employees = Staff::get()->pluck('user_id','middle_name');
        $Employees->prepend('Select an Employee', '');

        // Get All Branch
        $Branch = Branch::pluckActiveOnly();
        $Branch->prepend('Select a Branch', '');

        // Get All Departments
        $Departments = Departments::pluckActiveOnly();
        $Departments->prepend('Select a Department', '');
        */

        return view('accounts.entries.voucher.bank_voucher.bank_payment.create', compact('VoucherData'));
    }

    /**
     * Store a newly created Cash Payment Voucher in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function bpvStore(Request $request)
    {
//        if (Auth::user()->isAbleTo('store-voucher')) {

            $entries_session_data = Session::get('entries', []);

            $response = CoreAccounts::createEntry($request->all());

            if ($response['status']) {
                $entries_session_data[] = $response['entry'];
                $entry = Entries::find($response['entry']);

                Session::put('financial_year_session', $entry->financial_year);
                Session::put('voucher_date_session', $entry->voucher_date);
                Session::put('entries', $entries_session_data);

                return redirect()->back()->with('success', 'Voucher has been successfully created against number ' . $entry->number);

            } else {
                $request->flash();
                return redirect()->back()
                    ->withErrors($response['error'])
                    ->withInput();
            }
//        } else {
//            return abort(401);
//        }
    }


    /**
     * All Items except Bank & Cash Search Search
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function bpv_search(Request $request)
    {
        if (isset($request['item']) && $request['item']) {


            $ledgers = Ledger::where(['status' => 1])
                //->whereNotIn('group_id', $parentGroups->groupListIDs)
                ->where(function ($query) {
                    global $request;
                    $query->where('name', 'LIKE', "%{$request['item']}%")
                        ->orwhere('number', 'LIKE', "%{$request['item']}%");
                })->OrderBy('name', 'asc')->get();

            $result = array();
            if ($ledgers->count()) {
                foreach ($ledgers as $ledger) {
                    $prefix = Ledger::getAllParent($ledger->group_id);
                    if ($prefix == '0') {
                        $text_ledger = '(' . $ledger->groups['name'] . ')';
                    } else {
                        $text_ledger = $prefix;
                    }
                    $result[] = array(
                        'text' => $text_ledger . ' - ' . $ledger->name,
                        'id' => $ledger->id,
                    );
                }
            }

            return response()->json($result);
        } else {
            return response()->json([]);
        }
    }

    /*
     * ----------------------------------------------------------------------------------------
     * ------------------------------- Cash Vouchers Ends -----------------------------------
     * ----------------------------------------------------------------------------------------
    */

    /**
     * Cash Ledgers Search
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function cash_search(Request $request)
    {
        if (isset($request['item']) && $request['item']) {
            $Group = CoreAccounts::getConfigGroup(Config::get('constants.account_cash_inHand'))['group'];
            $parentGroups = new GroupsTree();
            $parentGroups->current_id = -1;
            $parentGroups->build($Group->id);
            $parentGroups->toListArray($parentGroups, -1);
            $ledgers = Ledger::where(['status' => 1])
                ->whereIn('group_id', $parentGroups->groupListIDs)
                ->where(function ($query) {
                    global $request;
                    $query->where('name', 'LIKE', "%{$request['item']}%")
                        ->orwhere('number', 'LIKE', "%{$request['item']}%");
                })->OrderBy('name', 'asc')->get();

            //dd($ledgers);
            $result = array();
            if ($ledgers->count()) {
                foreach ($ledgers as $ledger) {
                    $result[] = array(
                        'text' => $ledger->number . ' - ' . $ledger->name,
                        'id' => $ledger->id,
                    );
                }
            }

            return response()->json($result);
        } else {
            return response()->json([]);
        }
    }

    /**
     * Banks Ledger Search
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function bank_search(Request $request)
    {


        if (isset($request['item']) && $request['item']) {
            $Group = CoreAccounts::getConfigGroup(Config::get('constants.account_bank_balance'))['group'];

            $parentGroups = new GroupsTree();
            $parentGroups->current_id = -1;
            $parentGroups->build($Group->id);
            $parentGroups->toListArray($parentGroups, -1);

            $ledgers = Ledger::where(['status' => 1])
                ->whereIn('group_id', $parentGroups->groupListIDs)
                ->where(function ($query) {
                    global $request;
                    $query->where('name', 'LIKE', "%{$request['item']}%")
                        ->orwhere('number', 'LIKE', "%{$request['item']}%");
                })->OrderBy('name', 'asc')->get();

            $result = array();
            if ($ledgers->count()) {
                foreach ($ledgers as $ledger) {
                    $prefix_group = Ledger::getParent($ledger->group_id);
                    $result[] = array(
                        //'text' => $ledger->number . ' - ' . $ledger->name,
                        'text' => $prefix_group . ' - ' . $ledger->name,
                        'id' => $ledger->id,
                    );
                }
            }

            return response()->json($result);
        } else {
            return response()->json([]);
        }
    }

    /**
     * Cash & Banks Ledger Search
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function cashbank_search(Request $request)
    {
        if (isset($request['item']) && $request['item']) {
            $Group = CoreAccounts::getConfigGroup(Config::get('constants.assets_current_cash_balance'))['group'];
            $parentGroups = new GroupsTree();
            $parentGroups->current_id = -1;
            $parentGroups->build($Group->id);
            $parentGroups->toListArray($parentGroups, -1);

            $ledgers = Ledger::where(['status' => 1])
                ->whereIn('group_id', $parentGroups->groupListIDs)
                ->where(function ($query) {
                    global $request;
                    $query->where('name', 'LIKE', "%{$request['item']}%")
                        ->orwhere('number', 'LIKE', "%{$request['item']}%");
                })->OrderBy('name', 'asc')->get();

            $result = array();
            if ($ledgers->count()) {
                foreach ($ledgers as $ledger) {
                    $result[] = array(
                        'text' => $ledger->number . ' - ' . $ledger->name,
                        'id' => $ledger->id,
                    );
                }
            }

            return response()->json($result);
        } else {
            return response()->json([]);
        }
    }

    public function checkInstrumentNo(Request $request)
    {
        $status = 0;
        if ($request['instrumentNo'] != null) {
            $entryId = EntryItems::where('instrument_number', '=', $request['instrumentNo'])->first();
            if ($entryId) {
                $status = 1;
            }
        }
        return $status;
    }

    public function getBranchFromSelectedCompany($company_id = 0, $branch_id = 0)
    {
        return Branch::company_Branch($company_id, $branch_id);
    }

    public function getVoucherNo(Request $request)
    {
        $entry_type_id = $request->entry_type_id;
        $company_id = $request->company_id;
        $financial_year_id = $request->financial_year_id;
        $number = CoreAccounts::getVouchertMaxId($entry_type_id, $company_id, $financial_year_id);

        return str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
