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
use App\Http\Controllers\Admin\GoodReceiptNoteController;
use App\Models\Formulations;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\BatchController;


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:web']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::resource('/permissions', permissionController::class);
    Route::post('/permissions/getdata', [permissionController::class, 'getdata'])->name('permissions.getdata');

    Route::resource('/users', UserController::class);
    Route::post('/users/getdata', [UserController::class, 'getdata'])->name('users.getdata');


    Route::get('/posts/status/active/{id}', [\App\Http\Controllers\Admin\PostController::class, 'active'])->name('posts.publish');
    Route::get('/posts/status/deactive/{id}', [\App\Http\Controllers\Admin\PostController::class, 'deactive'])->name('posts.unpublish');

    Route::resource('/roles', RolesController::class);
    Route::post('/roles/getdata', [RolesController::class, 'getdata'])->name('roles.getdata');

    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    Route::post('posts/get_data', [\App\Http\Controllers\Admin\PostController::class, 'getData'])->name('posts.getdata');

    Route::resource('post_category', \App\Http\Controllers\Admin\PostCategoryController::class);
    Route::post('post_category/get_data', [\App\Http\Controllers\Admin\PostCategoryController::class, 'getData'])->name('post_cat.getdata');

    Route::resource('/settings', SettingsController::class);
    Route::post('/settings/getdata', [SettingsController::class, 'getdata'])->name('settings.getdata');

    Route::resource('/pages', PageController::class);
    Route::post('/pages/getdata', [PageController::class, 'getdata'])->name('pages.getdata');

    Route::resource('/raw-material', RawMaterialController::class);
    Route::post('/raw-material/getdata', [RawMaterialController::class, 'getdata'])->name('raw-material.getdata');

    Route::resource('units', UnitController::class);
    Route::post('/units/getdata', [UnitController::class, 'getdata'])->name('units.getdata');


    Route::resource('suppliers', SupplierController::class);
    Route::post('/suppliers/getdata', [SupplierController::class, 'getdata'])->name('suppliers.getdata');

    Route::resource('batches', BatchController::class);
    Route::post('/batches/getdata', [BatchController::class, 'getdata'])->name('batches.getdata');


    Route::resource('processes', ProcessController::class);
    Route::post('/processes/getdata', [ProcessController::class, 'getdata'])->name('processes.getdata');


    Route::resource('formulations', FormulationController::class);
    Route::post('/formulations/getdata', [FormulationController::class, 'getdata'])->name('formulations.getdata');



    Route::resource('purchaseorders', PurchaseOrderController::class);
    Route::post('/purchaseorders/getdata', [PurchaseOrderController::class, 'getdata'])->name('purchaseorders.getdata');


   Route::resource('grns', GoodReceiptNoteController::class);
    Route::post('/grns/getdata', [GoodReceiptNoteController::class, 'getdata'])->name('grns.getdata');
    Route::post('/grns/fetch/records/{id}', [GoodReceiptNoteController::class, 'fetch_po_record'])->name('grns.fetch_po_record');




    Route::get('/logs-view', [ActionLogController::class, 'showLogs'])->name('logs.view');


});
