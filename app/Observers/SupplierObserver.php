<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Supplier;

class SupplierObserver
{
    /**
     * Handle the Supplier "created" event.
     */
    public function created(Supplier $supplier): void
    {
        ActivityLogger::log('Supplier  created', ' Supplier created.', ['supplier' => $supplier]);

    }

    /**
     * Handle the Supplier "updated" event.
     */
    public function updated(Supplier $supplier): void
    {
        ActivityLogger::log('Supplier  Update', ' Supplier update.', ['supplier' => $supplier]);

    }

    /**
     * Handle the Supplier "deleted" event.
     */
    public function deleted(Supplier $supplier): void
    {
        ActivityLogger::log('Supplier delete', ' Supplier delete.', ['supplier' => $supplier]);

    }

    /**
     * Handle the Supplier "restored" event.
     */
    public function restored(Supplier $supplier): void
    {
        ActivityLogger::log('Supplier restore', 'A new user was created.', ['supplier' => $supplier]);

    }

    /**
     * Handle the Supplier "force deleted" event.
     */
    public function forceDeleted(Supplier $supplier): void
    {
        ActivityLogger::log('Supplier delete', 'supplier was deleted.', ['supplier' => $supplier]);

    }
}
