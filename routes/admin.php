<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ActionLogController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\RawMaterialController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\FormulationController;
use App\Http\Controllers\Admin\ProcessController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\AccountGroupController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\BranchesController;
use App\Http\Controllers\Admin\LedgerController;
use App\Http\Controllers\Admin\EntriesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\GoodReceiptNoteController;
use App\Http\Controllers\Admin\FinancialYearController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CountryController;
use \App\Http\Controllers\Admin\CustomerController;
use \App\Http\Controllers\Admin\PackingController;

use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\GoodsIssuanceController;
use App\Http\Controllers\Admin\GoodsReceiptController;


use App\Http\Controllers\Admin\PosController;

use App\Models\Formulations;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\BiltyController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PackingMaterialController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RecoverySheetController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:web']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    //  User Management Start
    Route::resource('/permissions', permissionController::class);
    Route::post('/permissions/getdata', [permissionController::class, 'getdata'])->name('permissions.getdata');
    Route::resource('/users', UserController::class);
    Route::post('/users/getdata', [UserController::class, 'getdata'])->name('users.getdata');
    Route::resource('/roles', RolesController::class);
    Route::post('/roles/getdata', [RolesController::class, 'getdata'])->name('roles.getdata');

    //  User Management End

    // Basic setting  Start
//    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
//    Route::post('posts/get_data', [\App\Http\Controllers\Admin\PostController::class, 'getData'])->name('posts.getdata');

//    Route::resource('post_category', \App\Http\Controllers\Admin\PostCategoryController::class);
//    Route::post('post_category/get_data', [\App\Http\Controllers\Admin\PostCategoryController::class, 'getData'])->name('post_cat.getdata');
//
//    Route::get('/posts/status/active/{id}', [\App\Http\Controllers\Admin\PostController::class, 'active'])->name('posts.publish');
//    Route::get('/posts/status/deactive/{id}', [\App\Http\Controllers\Admin\PostController::class, 'deactive'])->name('posts.unpublish');


    // setting curd
    Route::resource('/settings', SettingsController::class);
    Route::post('/settings/getdata', [SettingsController::class, 'getdata'])->name('settings.getdata');

    // pages curd
    Route::resource('/pages', PageController::class);
    Route::post('/pages/getdata', [PageController::class, 'getdata'])->name('pages.getdata');

    //companies curd
    Route::resource('companies', CompaniesController::class);
    Route::post('/companies/getdata', [CompaniesController::class, 'getdata'])->name('companies.getdata');


    //branches curd
    Route::resource('branches', BranchesController::class);
    Route::post('/branches/getdata', [BranchesController::class, 'getdata'])->name('branches.getdata');
    Route::get('/get-branches/{company_id}', [BranchesController::class, 'getBranches']);

    Route::resource('city', CityController::class);
    Route::post('/city/getdata', [CityController::class, 'getdata'])->name('city.getdata');
    Route::resource('country', CountryController::class);
    Route::post('/country/getdata', [CountryController::class, 'getdata'])->name('country.getdata');

    //  Basic setting End

    // raw-material curd
    Route::resource('/raw-material', RawMaterialController::class);
    Route::post('/raw-material/getdata', [RawMaterialController::class, 'getdata'])->name('raw-material.getdata');
    Route::get('/raw-material/importdata/file', [RawMaterialController::class, 'importdata'])->name('raw-material.import');
    Route::post('/raw-material/importdata', [RawMaterialController::class, 'importdata_post'])->name('raw-material.importdata');

    // units curd
    Route::resource('units', UnitController::class);
    Route::post('/units/getdata', [UnitController::class, 'getdata'])->name('units.getdata');

    // suppliers curd
    Route::resource('suppliers', SupplierController::class);
    Route::post('/suppliers/getdata', [SupplierController::class, 'getdata'])->name('suppliers.getdata');
    Route::resource('staff', StaffController::class);
    Route::post('/staff/getdata', [StaffController::class, 'getdata'])->name('staff.getdata');

    //batches curd
    Route::resource('batches', BatchController::class);
    Route::post('/batches/getdata', [BatchController::class, 'getdata'])->name('batches.getdata');

    //processes curd
    Route::resource('processes', ProcessController::class);
    Route::post('/processes/getdata', [ProcessController::class, 'getdata'])->name('processes.getdata');

    //formulations curd
    Route::resource('formulations', FormulationController::class);
    Route::post('/formulations/getdata', [FormulationController::class, 'getdata'])->name('formulations.getdata');
    Route::post('/formulations/fetch/records', [FormulationController::class, 'fetch_po_record'])->name('FormulationController.fetch_po_record');


    //account_groups curd
    Route::resource('account_groups', AccountGroupController::class);
    Route::post('/account_groups/getdata', [AccountGroupController::class, 'getdata'])->name('account_groups.getdata');

    //purchase orders curd
    Route::resource('purchaseorders', PurchaseOrderController::class);
    Route::post('/purchaseorders/getdata', [PurchaseOrderController::class, 'getdata'])->name('purchaseorders.getdata');
    Route::get('/purchaseorders/po-report/{id}', [PurchaseOrderController::class, 'generatePDF'])->name('po.pdf');
    Route::get('/formulation/po-report/{id}', [FormulationController::class, 'generateformulationPDF'])->name('formulation.pdf');


    Route::resource('entries', EntriesController::class);
    Route::post('/entries/getdata', [EntriesController::class, 'getdata'])->name('entries.getdata');
    Route::resource('ledger', LedgerController::class);
    Route::post('/ledger/getdata', [LedgerController::class, 'getdata'])->name('ledger.getdata');


    Route::post('/ledger/already_created', [LedgerController::class, 'already_created'])->name('ledger.already_created');
    Route::post('load-ledger', [LedgerController::class, 'load_ledgers'])->name('load-ledger');

    // GRN curd
    Route::resource('grns', GoodReceiptNoteController::class);
    Route::post('/grns/getdata', [GoodReceiptNoteController::class, 'getdata'])->name('grns.getdata');
    Route::post('/grns/fetch/records', [GoodReceiptNoteController::class, 'fetch_po_record'])->name('grns.fetch_po_record');
    Route::get('/grns/grn-report/{id}', [GoodReceiptNoteController::class, 'generatePDF'])->name('grn.pdf');
    Route::get('/logs-view', [ActionLogController::class, 'showLogs'])->name('logs.view');

    Route::get('/products/import-data', [ProductController::class, 'showImport'])->name('products.import');
    Route::resource('products', ProductController::class);
    Route::post('/products/importdata', [ProductController::class, 'importProductData'])->name('products.import.data');

    Route::post('/products/getdata', [ProductController::class, 'getdata'])->name('products.getdata');

    Route::resource('inventory', InventoryController::class);
    Route::post('/inventory/getdata', [InventoryController::class, 'getdata'])->name('inventory.getdata');

    Route::resource('goods-issuance', GoodsIssuanceController::class);
    Route::post('/goods-issuance/getdata', [GoodsIssuanceController::class, 'getdata'])->name('goods-issuance.getdata');
    Route::get('/goods-issuance/report/{id}', [GoodsIssuanceController::class, 'generatePDF'])->name('goods-issuance.pdf');
    Route::post('/goods-issuance/data', [GoodsIssuanceController::class, 'get_data'])->name('good-issuance.get.data');

    Route::resource('goods-receipt', GoodsReceiptController::class);
    Route::post('/goods-receipt/getdata', [GoodsReceiptController::class, 'getdata'])->name('goods-receipt.getdata');


    Route::resource('financial-year', FinancialYearController::class);
    Route::post('/financial-year/getdata', [FinancialYearController::class, 'getdata'])->name('financial-year.getdata');
    Route::resource('vendor', VendorController::class);
    Route::post('/vendor/getdata', [VendorController::class, 'getdata'])->name('vendor.getdata');

    Route::resource('packing', PackingController::class);
    Route::post('/packing/getdata', [PackingController::class, 'getdata'])->name('packing.getdata');


    Route::resource('pos', PosController::class);
    Route::post('/pos/getdata', [PosController::class, 'getdata'])->name('pos.getdata');
    Route::get('/pos/pdf/{id}', [PosController::class, 'pdf'])->name('pos.pdf');

    Route::get('/order/pdf/{id}', [PosController::class, 'orderPdf'])->name('order_delivery.pdf');

    Route::resource('customers', CustomerController::class);
    Route::post('/customers/getdata', [CustomerController::class, 'getdata'])->name('customers.getdata');
    Route::get('/customers-data', [CustomerController::class, 'getCustomerData'])->name('fetch.customers_data');
    Route::get('/customers-file/importdata/file', [CustomerController::class, 'showImport'])->name('customers.import');
    Route::post('/customers-file/importdata', [CustomerController::class, 'importCustomerData'])->name('customers.importdata');


    // Route::get('/customers/data', [CustomerController::class, 'getCustomerData'])->name('fetch.customers_data');
    Route::get('/payments/create/{order}', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('payments', [PaymentController::class, 'store'])->name('payments.store');

    Route::get('chart-of-accounts', [EntriesController::class, 'chart_of_account'])->name('chart-of-accounts.index');
    Route::post('chart-of-accounts/store', [EntriesController::class, 'chart_of_account_store'])->name('chart-of-accounts.store');
    Route::post('chart-of-accounts/pdf', [EntriesController::class, 'chart_of_account_pdf'])->name('chart-of-accounts.pdf');

    Route::get('/recovery-sheets/filters', [RecoverySheetController::class, 'listStoredFilters'])->name('recovery_sheets.list');
    Route::post('/recovery-sheets/filters-data', [RecoverySheetController::class, 'filtersData'])->name('recovery_sheets.data');
    
    Route::get('/recovery-sheet', [RecoverySheetController::class, 'index'])->name('recovery_sheet.index');
    Route::post('/recovery-sheet/generate', [RecoverySheetController::class, 'generate'])->name('recovery_sheet.generate');

    Route::post('/get-areas-by-cities', [UserController::class, 'getAreasByCities'])->name('get-areas-by-cities');
    Route::post('/recovery/get-locations', [RecoverySheetController::class, 'getLocations'])->name('recovery.getLocations');
    Route::get('/get-areas/{city}', [AreaController::class, 'getByCity'])->name('get-areas');

    Route::get('/recovery-sheets/generate', [RecoverySheetController::class, 'generateRecvoerySheet'])->name('recovery_sheets_data.generate');

//    Route::post('chart-of-accounts/pdf', [ChartOfAccountController::class, 'pdf'])->name('chart-of-accounts.pdf');
//    Route::get('bank-loan-details/{id}', [BankLoanController::class, 'show'])->name('bank-loan-details');
//    Route::get('ledger-report', [ReportsController::class, 'ledger_report'])->name('ledger-report');
//    Route::get('ledger-report-print/{id}/{start_date}/{end_date}', [ReportsController::class, 'ledger_report'])->name('ledger_report_print_from_trial_balance');
//    Route::post('ledger-report-print', [ReportsController::class, 'ledger_print'])->name('ledger_report_print');
//    Route::get('vendor-wise-ledger-report', [ReportsController::class, 'vendor_wise_ledger_report'])->name('vendor-wise-ledger-report');
//    Route::post('vendor-wise-ledger-report-print', [ReportsController::class, 'vendor_wise_ledger_print'])->name('vendor-wise-ledger_report_print');
//    Route::get('profit-loss-report', [ReportsController::class, 'profit_loss'])->name('profit-loss-report');
//    Route::post('profit-loss-report-prints', [ReportsController::class, 'profit_loss_print'])->name('profit-loss-report-prints');
//    Route::get('cmp-profit-loss-report', [ReportsController::class, 'cmp_profit_loss'])->name('cmp-profit-loss-report');
//    Route::post('cmp-profit-loss-report-prints', [ReportsController::class, 'cmp_profit_loss_print'])->name('cmp-profit-loss-report-prints');
//    Route::get('trial-balance-report', [ReportsController::class, 'trial_balance'])->name('trial-balance-report');
//    Route::post('trial-balance-report-print', [ReportsController::class, 'trial_balance_report'])->name('trial-balance-report-print');
//    Route::get('trial-balance-group/{group_id}/{start_date}/{end_date}/{company_id}/{branch_id}', [ReportsController::class, 'trial_balance_group'])->name('trial-balance-group');
//
//    Route::get('balance-sheet-report', [ReportsController::class, 'balance_sheet'])->name('balance-sheet-report');
//    Route::get('notes-to-the-accounts/{start_date}/{end_date}/{group_id}/{company_id}', [ReportsController::class, 'notes_to_the_accounts'])->name('notes-to-the-accounts');
//    Route::post('balance-sheet-report-print', [ReportsController::class, 'balance_sheet_report'])->name('balance-sheet-report-print');
//    Route::get('balance-sheet-test/{g_id}', [ReportsController::class, 'test'])->name('test');
//    Route::get('testBalance', [ReportsController::class, 'testBalance'])->name('testBalance');

    Route::get('/pos/payments/{id}', [PosController::class, 'getPayments'])->name('pos.payments');

    Route::get('bpv-create', [EntriesController::class, 'bpvCreate'])->name('bpv-create');
    Route::get('cpv-create', [EntriesController::class, 'cpvCreate'])->name('cpv-create');
    Route::get('brv-create', [EntriesController::class, 'brvCreate'])->name('brv-create');
    Route::get('crv-create', [EntriesController::class, 'crvCreate'])->name('crv-create');
    Route::get('gjv-create', [EntriesController::class, 'gjvCreate'])->name('gjv-create');
//    Route::get('gjv-edit/{id}', [EntriesController::class, 'gjvedit'])->name('gjv-edit');
    Route::get('show/{id}', [EntriesController::class, 'entry'])->name('show');
    Route::post('bpv-store', [EntriesController::class, 'bpvStore'])->name('bpv-store');
    Route::post('cpv-store', [EntriesController::class, 'bpvStore'])->name('cpv-store');
    Route::post('brv-store', [EntriesController::class, 'bpvStore'])->name('brv-store');
    Route::post('crv-store', [EntriesController::class, 'bpvStore'])->name('crv-store');
    Route::post('gjv-store', [EntriesController::class, 'bpvStore'])->name('gjv-store');
    Route::get('bpv-edit/{id}', [EntriesController::class, 'edit'])->name('bpv-edit');
    Route::get('cpv-edit/{id}', [EntriesController::class, 'edit'])->name('cpv-edit');
    Route::get('brv-edit/{id}', [EntriesController::class, 'edit'])->name('brv-edit');
    Route::get('crv-edit/{id}', [EntriesController::class, 'edit'])->name('crv-edit');
    Route::get('gjv-edit/{id}', [EntriesController::class, 'edit'])->name('gjv-edit');
    Route::get('download/{id}', [EntriesController::class, 'download'])->name('download');
    Route::get('gjv_search', [EntriesController::class, 'gjv_search'])->name('gjv_search');


    //category crud

    Route::resource('categories',CategoryController::class);
    Route::post('/categories/getdata', [CategoryController::class, 'getdata'])->name('categories.getdata');
//packing material crud
    Route::get('/packing-materials/import-data', [PackingMaterialController::class, 'showImport'])->name('packing-materials.import');
    Route::resource('packing-materials',PackingMaterialController::class);
    Route::post('/packing-materials/getdata', [PackingMaterialController::class, 'getdata'])->name('packing-materials.getdata');
    Route::post('/packing-materials/importdata', [PackingMaterialController::class, 'importData'])->name('packing-materials.importdata');


    //areas crud
    Route::get('/areas/by-company', [AreaController::class, 'getByCompany'])->name('areas.byCompany');

    Route::resource('/areas',AreaController::class);
    Route::post('/areas/getdata', [AreaController::class, 'getdata'])->name('areas.getdata');

   //bilties
   Route::resource('/bilties',BiltyController::class);
   Route::post('/bilties/getdata', [BiltyController::class, 'getdata'])->name('bilties.getdata');


    //    Route::get('/invoice', function () {
//        return view('invoice.invoice');
//    });
//    Route::get('/delivery', function () {
//        return view('invoice.delivery');
//    });  Route::get('/invoice_1', function () {
//        return view('invoice.invoice');
//    });
});
