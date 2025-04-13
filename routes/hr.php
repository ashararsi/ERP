<?php
use App\Http\Controllers\Admin\HolydaysController;
use App\Http\Controllers\Admin\LeaveEntitlementsController;
use App\Http\Controllers\Admin\LeaveRequestsController;
use App\Http\Controllers\Admin\LeavesController;
use App\Http\Controllers\Admin\LeavesStatusesController;
use App\Http\Controllers\Admin\LeavesTypeController;
use App\Http\Controllers\Admin\LoanPlansController;
use App\Http\Controllers\Admin\LoansController;
use App\Http\Controllers\Admin\WorkShiftsController;
use App\Http\Controllers\Admin\WorkWeeksController;
use App\Http\Controllers\Admin\DailyAttendanceController;


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:web']], function () {

//Holydays
    Route::resource('holidays', HolydaysController::class);
    Route::post('/holidays/getdata', [HolydaysController::class, 'getdata'])->name('holidays.getdata');

    Route::resource('leave-entitlement', LeaveEntitlementsController::class);
    Route::post('/leave-entitlement/getdata', [LeaveEntitlementsController::class, 'getdata'])->name('leave-entitlement.getdata');

    Route::resource('hrm-leave-requests', LeaveRequestsController::class);
    Route::post('/hrm-leave-requests/getdata', [LeaveRequestsController::class, 'getdata'])->name('hrm-leave-requests.getdata');

   Route::resource('attendance', DailyAttendanceController::class);
    Route::post('/attendance/getdata', [DailyAttendanceController::class, 'getdata'])->name('attendance.getdata');


    Route::resource('hrm-leaves', LeavesController::class);
    Route::post('/hrm-leaves/getdata', [LeavesController::class, 'getdata'])->name('hrm-leaves.getdata');
    Route::resource('hrm-leave-statuses', LeavesStatusesController::class);
    Route::post('/hrm-leave-statuses/getdata', [LeavesStatusesController::class, 'getdata'])->name('hrm-leave-statuses.getdata');
    Route::resource('hrm-leave-types', LeavesTypeController::class);
    Route::post('/hrm-leave-types/getdata', [LeavesTypeController::class, 'getdata'])->name('hrm-leave-types.getdata');
    Route::resource('loan-plans', LoanPlansController::class);
    Route::post('/loan-plans/getdata', [LoanPlansController::class, 'getdata'])->name('loan-plans.getdata');
    Route::resource('loans', LoansController::class);
    Route::post('/loans/getdata', [LoansController::class, 'getdata'])->name('loans.getdata');
    Route::resource('work-shifts', WorkShiftsController::class);
    Route::post('/work-shifts/getdata', [WorkShiftsController::class, 'getdata'])->name('work-shifts.getdata');
    Route::resource('work-weeks', WorkWeeksController::class);
    Route::post('/work-weeks/getdata', [WorkWeeksController::class, 'getdata'])->name('work-weeks.getdata');
});
