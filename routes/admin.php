<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CampaignController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ActionLogController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\StripeController;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;


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

    Route::resource('/campaign', CampaignController::class);
    Route::post('/pages/getdata', [CampaignController::class, 'getdata'])->name('campaign.getdata');


    Route::resource('/transaction', TransactionController::class);
    Route::post('/transaction/getdata', [TransactionController::class, 'getdata'])->name('transaction.getdata');

    Route::get('/logs-view', [ActionLogController::class, 'showLogs'])->name('logs.view');




    Route::get('/create-account', [StripeController::class, 'createConnectedAccount'])->name('create.account');
    Route::get('/onboarding/{accountId}', [StripeController::class, 'createAccountLink'])->name('onboarding');
    Route::post('/send-payout', [StripeController::class, 'sendPayout'])->name('send.payout');
    Route::get('/payout-form', [StripeController::class, 'payoutForm'])->name('payout.form');

});
