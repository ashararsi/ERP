<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\HrmLeaveType;

class HrmLeaveTypeObserver
{
    /**
     * Handle the HrmLeaveType "created" event.
     */
    public function created(HrmLeaveType $hrmLeaveType): void
    {
        ActivityLogger::log('Leave Type Created', 'A new leave type has been created.', ['HrmLeaveType' => $hrmLeaveType]);
    }

    /**
     * Handle the HrmLeaveType "updated" event.
     */
    public function updated(HrmLeaveType $hrmLeaveType): void
    {
        ActivityLogger::log('Leave Type Updated', 'A leave type has been updated.', ['HrmLeaveType' => $hrmLeaveType]);
    }

    /**
     * Handle the HrmLeaveType "deleted" event.
     */
    public function deleted(HrmLeaveType $hrmLeaveType): void
    {
        ActivityLogger::log('Leave Type Deleted', 'A leave type has been deleted.', ['HrmLeaveType' => $hrmLeaveType]);
    }

    /**
     * Handle the HrmLeaveType "restored" event.
     */
    public function restored(HrmLeaveType $hrmLeaveType): void
    {
        ActivityLogger::log('Leave Type Restored', 'A leave type has been restored.', ['HrmLeaveType' => $hrmLeaveType]);
    }

    /**
     * Handle the HrmLeaveType "force deleted" event.
     */
    public function forceDeleted(HrmLeaveType $hrmLeaveType): void
    {
        ActivityLogger::log('Leave Type Permanently Deleted', 'A leave type has been permanently deleted.', ['HrmLeaveType' => $hrmLeaveType]);
    }
}
