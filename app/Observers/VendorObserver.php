<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Vendor;

class VendorObserver
{
    /**
     * Handle the Vendor "created" event.
     */
    public function created(Vendor $vendor): void
    {
        ActivityLogger::log('Vendor  created', ' Vendor created.', ['Vendor' => $vendor]);

    }

    /**
     * Handle the Vendor "updated" event.
     */
    public function updated(Vendor $vendor): void
    {
        ActivityLogger::log('Vendor  updated', ' Vendor updated.', ['Vendor' => $vendor]);

    }

    /**
     * Handle the Vendor "deleted" event.
     */
    public function deleted(Vendor $vendor): void
    {
        ActivityLogger::log('Vendor  deleted', ' Vendor deleted.', ['Vendor' => $vendor]);

    }

    /**
     * Handle the Vendor "restored" event.
     */
    public function restored(Vendor $vendor): void
    {
        ActivityLogger::log('Vendor  restored', ' Vendor restored.', ['Vendor' => $vendor]);

    }

    /**
     * Handle the Vendor "force deleted" event.
     */
    public function forceDeleted(Vendor $vendor): void
    {
        ActivityLogger::log('Vendor  forceDeleted', ' Vendor forceDeleted.', ['Vendor' => $vendor]);

    }
}
