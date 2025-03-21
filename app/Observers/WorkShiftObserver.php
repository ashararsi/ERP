<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\WorkShift;

class WorkShiftObserver
{
    /**
     * Handle the WorkShift "created" event.
     */
    public function created(WorkShift $workShift): void
    {
        ActivityLogger::log('WorkShift Created', 'A new work shift has been created.', ['WorkShift' => $workShift]);
    }

    /**
     * Handle the WorkShift "updated" event.
     */
    public function updated(WorkShift $workShift): void
    {
        ActivityLogger::log('WorkShift Updated', 'A work shift has been updated.', ['WorkShift' => $workShift]);
    }

    /**
     * Handle the WorkShift "deleted" event.
     */
    public function deleted(WorkShift $workShift): void
    {
        ActivityLogger::log('WorkShift Deleted', 'A work shift has been deleted.', ['WorkShift' => $workShift]);
    }

    /**
     * Handle the WorkShift "restored" event.
     */
    public function restored(WorkShift $workShift): void
    {
        ActivityLogger::log('WorkShift Restored', 'A work shift has been restored.', ['WorkShift' => $workShift]);
    }

    /**
     * Handle the WorkShift "force deleted" event.
     */
    public function forceDeleted(WorkShift $workShift): void
    {
        ActivityLogger::log('WorkShift Permanently Deleted', 'A work shift has been permanently deleted.', ['WorkShift' => $workShift]);
    }
}
