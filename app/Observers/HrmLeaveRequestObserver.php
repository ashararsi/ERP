<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\HrmLeaveRequest;

class HrmLeaveRequestObserver
{
    /**
     * Handle the HrmLeaveRequest "created" event.
     */
    public function created(HrmLeaveRequest $hrmLeaveRequest): void
    {
        ActivityLogger::log('Leave Request Created', 'A new leave request has been created.', ['HrmLeaveRequest' => $hrmLeaveRequest]);
    }

    /**
     * Handle the HrmLeaveRequest "updated" event.
     */
    public function updated(HrmLeaveRequest $hrmLeaveRequest): void
    {
        ActivityLogger::log('Leave Request Updated', 'A leave request has been updated.', ['HrmLeaveRequest' => $hrmLeaveRequest]);
    }

    /**
     * Handle the HrmLeaveRequest "deleted" event.
     */
    public function deleted(HrmLeaveRequest $hrmLeaveRequest): void
    {
        ActivityLogger::log('Leave Request Deleted', 'A leave request has been soft deleted.', ['HrmLeaveRequest' => $hrmLeaveRequest]);
    }

    /**
     * Handle the HrmLeaveRequest "restored" event.
     */
    public function restored(HrmLeaveRequest $hrmLeaveRequest): void
    {
        ActivityLogger::log('Leave Request Restored', 'A leave request has been restored.', ['HrmLeaveRequest' => $hrmLeaveRequest]);
    }

    /**
     * Handle the HrmLeaveRequest "force deleted" event.
     */
    public function forceDeleted(HrmLeaveRequest $hrmLeaveRequest): void
    {
        ActivityLogger::log('Leave Request Permanently Deleted', 'A leave request has been permanently deleted.', ['HrmLeaveRequest' => $hrmLeaveRequest]);
    }
}
