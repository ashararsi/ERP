<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Branch;

class BranchObserver
{
    /**
     * Handle the Branch "created" event.
     */
    public function created(Branch $branch): void
    {
        ActivityLogger::log('branch  created', ' branch created.', ['branch' => $branch]);

    }

    /**
     * Handle the Branch "updated" event.
     */
    public function updated(Branch $branch): void
    {
        ActivityLogger::log('branch  updated', ' branch updated.', ['branch' => $branch]);

    }

    /**
     * Handle the Branch "deleted" event.
     */
    public function deleted(Branch $branch): void
    {
        ActivityLogger::log('branch  deleted', ' branch deleted.', ['branch' => $branch]);

    }

    /**
     * Handle the Branch "restored" event.
     */
    public function restored(Branch $branch): void
    {
        ActivityLogger::log('branch  restored', ' branch restored.', ['branch' => $branch]);

    }

    /**
     * Handle the Branch "force deleted" event.
     */
    public function forceDeleted(Branch $branch): void
    {
        ActivityLogger::log('branch  forceDeleted', ' branch forceDeleted.', ['branch' => $branch]);

    }
}
