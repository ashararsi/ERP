<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Staff;

class StaffObserver
{
    /**
     * Handle the Staff "created" event.
     */
    public function created(Staff $staff): void
    {
        ActivityLogger::log('Staff  created', ' Staff created.', ['Staff' => $staff]);

    }

    /**
     * Handle the Staff "updated" event.
     */
    public function updated(Staff $staff): void
    {
        ActivityLogger::log('Staff  updated', ' Staff updated.', ['Staff' => $staff]);

    }

    /**
     * Handle the Staff "deleted" event.
     */
    public function deleted(Staff $staff): void
    {
        ActivityLogger::log('Staff  deleted', ' Staff deleted.', ['Staff' => $staff]);

    }

    /**
     * Handle the Staff "restored" event.
     */
    public function restored(Staff $staff): void
    {
        ActivityLogger::log('Staff  restored', ' Staff restored.', ['Staff' => $staff]);
    }

    /**
     * Handle the Staff "force deleted" event.
     */
    public function forceDeleted(Staff $staff): void
    {
        ActivityLogger::log('Staff  forceDeleted', ' Staff forceDeleted.', ['Staff' => $staff]);
    }
}
