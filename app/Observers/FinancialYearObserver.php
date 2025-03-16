<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\FinancialYear;

class FinancialYearObserver
{
    /**
     * Handle the FinancialYear "created" event.
     */
    public function created(FinancialYear $financialYear): void
    {
        ActivityLogger::log('FinancialYear  created', ' FinancialYear created.', ['FinancialYear' => $financialYear]);

    }

    /**
     * Handle the FinancialYear "updated" event.
     */
    public function updated(FinancialYear $financialYear): void
    {
        ActivityLogger::log('FinancialYear  updated', ' FinancialYear updated.', ['FinancialYear' => $financialYear]);

    }

    /**
     * Handle the FinancialYear "deleted" event.
     */
    public function deleted(FinancialYear $financialYear): void
    {
        ActivityLogger::log('FinancialYear  deleted', ' FinancialYear deleted.', ['FinancialYear' => $financialYear]);

    }

    /**
     * Handle the FinancialYear "restored" event.
     */
    public function restored(FinancialYear $financialYear): void
    {
        ActivityLogger::log('FinancialYear  restored', ' FinancialYear restored.', ['FinancialYear' => $financialYear]);

    }

    /**
     * Handle the FinancialYear "force deleted" event.
     */
    public function forceDeleted(FinancialYear $financialYear): void
    {
        ActivityLogger::log('FinancialYear  forceDeleted', ' FinancialYear forceDeleted.', ['FinancialYear' => $financialYear]);

    }
}
