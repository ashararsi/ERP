<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Loan;
use Illuminate\Support\Facades\Log;

class LoanObserver
{
    /**
     * Handle the Loan "created" event.
     */
    public function created(Loan $loan): void
    {
        ActivityLogger::log('Loan Created', 'A new loan has been created.', ['Loan' => $loan]);
    }

    /**
     * Handle the Loan "updated" event.
     */
    public function updated(Loan $loan): void
    {
        ActivityLogger::log('Loan Updated', 'A loan has been updated.', ['Loan' => $loan]);
    }

    /**
     * Handle the Loan "deleted" event.
     */
    public function deleted(Loan $loan): void
    {
        ActivityLogger::log('Loan Deleted', 'A loan has been deleted.', ['Loan' => $loan]);
    }

    /**
     * Handle the Loan "restored" event.
     */
    public function restored(Loan $loan): void
    {
        ActivityLogger::log('Loan Restored', 'A loan has been restored.', ['Loan' => $loan]);
    }

    /**
     * Handle the Loan "force deleted" event.
     */
    public function forceDeleted(Loan $loan): void
    {
        ActivityLogger::log('Loan Permanently Deleted', 'A loan has been permanently deleted.', ['Loan' => $loan]);
    }
}
