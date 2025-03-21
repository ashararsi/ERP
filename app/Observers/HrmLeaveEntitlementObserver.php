<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\HrmLeaveEntitlement;

class HrmLeaveEntitlementObserver
{
    /**
     * Handle the HrmLeaveEntitlement "created" event.
     */
    public function created(HrmLeaveEntitlement $hrmLeaveEntitlement): void
    {
        ActivityLogger::log('HrmLeaveEntitlement created', 'A HrmLeaveEntitlement created.', ['HrmLeaveEntitlement' => $hrmLeaveEntitlement]);
    }

    /**
     * Handle the HrmLeaveEntitlement "updated" event.
     */
    public function updated(HrmLeaveEntitlement $hrmLeaveEntitlement): void
    {
            ActivityLogger::log('HrmLeaveEntitlement updated', 'A HrmLeaveEntitlement updated.', ['HrmLeaveEntitlement' => $hrmLeaveEntitlement]);
    }

    /**
     * Handle the HrmLeaveEntitlement "deleted" event.
     */
    public function deleted(HrmLeaveEntitlement $hrmLeaveEntitlement): void
    {
        ActivityLogger::log('HrmLeaveEntitlement deleted', 'A HrmLeaveEntitlement deleted.', ['HrmLeaveEntitlement' => $hrmLeaveEntitlement]);
    }

    /**
     * Handle the HrmLeaveEntitlement "restored" event.
     */
    public function restored(HrmLeaveEntitlement $hrmLeaveEntitlement): void
    {
        ActivityLogger::log('HrmLeaveEntitlement restored', 'A HrmLeaveEntitlement restored.', ['HrmLeaveEntitlement' => $hrmLeaveEntitlement]);
    }

    /**
     * Handle the HrmLeaveEntitlement "force deleted" event.
     */
    public function forceDeleted(HrmLeaveEntitlement $hrmLeaveEntitlement): void
    {
        ActivityLogger::log('HrmLeaveEntitlement forceDeleted', 'A HrmLeaveEntitlement forceDeleted.', ['HrmLeaveEntitlement' => $hrmLeaveEntitlement]);
    }
}
