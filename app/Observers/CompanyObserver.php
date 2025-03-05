<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Company;

class CompanyObserver
{
    /**
     * Handle the Company "created" event.
     */
    public function created(Company $company): void
    {
        ActivityLogger::log('company  created', ' company created.', ['company' => $company]);

    }

    /**
     * Handle the Company "updated" event.
     */
    public function updated(Company $company): void
    {
        ActivityLogger::log('company  updated', ' company updated.', ['company' => $company]);

    }

    /**
     * Handle the Company "deleted" event.
     */
    public function deleted(Company $company): void
    {
        ActivityLogger::log('company  deleted', ' company deleted.', ['company' => $company]);

    }

    /**
     * Handle the Company "restored" event.
     */
    public function restored(Company $company): void
    {
        ActivityLogger::log('company  restored', ' company restored.', ['company' => $company]);

    }

    /**
     * Handle the Company "force deleted" event.
     */
    public function forceDeleted(Company $company): void
    {
        ActivityLogger::log('company  forceDeleted', ' company forceDeleted.', ['company' => $company]);

    }
}
