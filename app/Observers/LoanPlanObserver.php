<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\LoanPlan;

class LoanPlanObserver
{
    /**
     * Handle the LoanPlan "created" event.
     */
    public function created(LoanPlan $loanPlan): void
    {
        ActivityLogger::log('LoanPlan Created', 'A new loan plan has been created.', ['LoanPlan' => $loanPlan]);
    }

    /**
     * Handle the LoanPlan "updated" event.
     */
    public function updated(LoanPlan $loanPlan): void
    {
        ActivityLogger::log('LoanPlan Updated', 'A loan plan has been updated.', ['LoanPlan' => $loanPlan]);
    }

    /**
     * Handle the LoanPlan "deleted" event.
     */
    public function deleted(LoanPlan $loanPlan): void
    {
        ActivityLogger::log('LoanPlan Deleted', 'A loan plan has been deleted.', ['LoanPlan' => $loanPlan]);
    }

    /**
     * Handle the LoanPlan "restored" event.
     */
    public function restored(LoanPlan $loanPlan): void
    {
        ActivityLogger::log('LoanPlan Restored', 'A loan plan has been restored.', ['LoanPlan' => $loanPlan]);
    }

    /**
     * Handle the LoanPlan "force deleted" event.
     */
    public function forceDeleted(LoanPlan $loanPlan): void
    {
        ActivityLogger::log('LoanPlan Permanently Deleted', 'A loan plan has been permanently deleted.', ['LoanPlan' => $loanPlan]);
    }
}
