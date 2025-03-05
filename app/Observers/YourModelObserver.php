<?php

namespace App\Observers;

use App\Models\YourModel;

class YourModelObserver
{
    /**
     * Handle the YourModel "created" event.
     */
    public function created(YourModel $yourModel): void
    {
        //
    }

    /**
     * Handle the YourModel "updated" event.
     */
    public function updated(YourModel $yourModel): void
    {
        //
    }

    /**
     * Handle the YourModel "deleted" event.
     */
    public function deleted(YourModel $yourModel): void
    {
        //
    }

    /**
     * Handle the YourModel "restored" event.
     */
    public function restored(YourModel $yourModel): void
    {
        //
    }

    /**
     * Handle the YourModel "force deleted" event.
     */
    public function forceDeleted(YourModel $yourModel): void
    {
        //
    }
}
