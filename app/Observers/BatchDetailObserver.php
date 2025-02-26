<?php

namespace App\Observers;

use App\Models\BatchDetail;

class BatchDetailObserver
{
    /**
     * Handle the BatchDetail "created" event.
     */
    public function created(BatchDetail $batchDetail): void
    {
        //
    }

    /**
     * Handle the BatchDetail "updated" event.
     */
    public function updated(BatchDetail $batchDetail): void
    {
        //
    }

    /**
     * Handle the BatchDetail "deleted" event.
     */
    public function deleted(BatchDetail $batchDetail): void
    {
        //
    }

    /**
     * Handle the BatchDetail "restored" event.
     */
    public function restored(BatchDetail $batchDetail): void
    {
        //
    }

    /**
     * Handle the BatchDetail "force deleted" event.
     */
    public function forceDeleted(BatchDetail $batchDetail): void
    {
        //
    }
}
