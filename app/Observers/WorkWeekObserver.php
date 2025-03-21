<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\WorkWeek;

class WorkWeekObserver
{
    /**
     * Handle the WorkWeek "created" event.
     */
    public function created(WorkWeek $workWeek): void
    {
        ActivityLogger::log('WorkWeek Created', 'A new work week has been created.', ['WorkWeek' => $workWeek]);
    }

    /**
     * Handle the WorkWeek "updated" event.
     */
    public function updated(WorkWeek $workWeek): void
    {
        ActivityLogger::log('WorkWeek Updated', 'A work week has been updated.', ['WorkWeek' => $workWeek]);
    }

    /**
     * Handle the WorkWeek "deleted" event.
     */
    public function deleted(WorkWeek $workWeek): void
    {
        ActivityLogger::log('WorkWeek Deleted', 'A work week has been deleted.', ['WorkWeek' => $workWeek]);
    }

    /**
     * Handle the WorkWeek "restored" event.
     */
    public function restored(WorkWeek $workWeek): void
    {
        ActivityLogger::log('WorkWeek Restored', 'A work week has been restored.', ['WorkWeek' => $workWeek]);
    }

    /**
     * Handle the WorkWeek "force deleted" event.
     */
    public function forceDeleted(WorkWeek $workWeek): void
    {
        ActivityLogger::log('WorkWeek Permanently Deleted', 'A work week has been permanently deleted.', ['WorkWeek' => $workWeek]);
    }
}
