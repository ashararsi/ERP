<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\HrmLeave;

class HrmLeaveObserver
{
    /**
     * Handle the HrmLeave "created" event.
     */
    public function created(HrmLeave $hrmLeave): void
    {
        ActivityLogger::log('HrmLeave created', 'A new HrmLeave record was created.', ['HrmLeave' => $hrmLeave]);
    }

    /**
     * Handle the HrmLeave "updated" event.
     */
    public function updated(HrmLeave $hrmLeave): void
    {
        ActivityLogger::log('HrmLeave updated', 'HrmLeave record was updated.', ['HrmLeave' => $hrmLeave]);
    }

    /**
     * Handle the HrmLeave "deleted" event.
     */
    public function deleted(HrmLeave $hrmLeave): void
    {
        ActivityLogger::log('HrmLeave deleted', 'HrmLeave record was soft deleted.', ['HrmLeave' => $hrmLeave]);
    }

    /**
     * Handle the HrmLeave "restored" event.
     */
    public function restored(HrmLeave $hrmLeave): void
    {
        ActivityLogger::log('HrmLeave restored', 'HrmLeave record was restored.', ['HrmLeave' => $hrmLeave]);
    }

    /**
     * Handle the HrmLeave "force deleted" event.
     */
    public function forceDeleted(HrmLeave $hrmLeave): void
    {
        ActivityLogger::log('HrmLeave permanently deleted', 'HrmLeave record was force deleted.', ['HrmLeave' => $hrmLeave]);
    }
}
