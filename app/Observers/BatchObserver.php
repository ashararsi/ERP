<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Batch;

class BatchObserver
{
    /**
     * Handle the Batch "created" event.
     */
    public function created(Batch $batch): void
    {
        ActivityLogger::log('Batch created', 'A Batch created.', ['Batch' => $batch]);

    }

    /**
     * Handle the Batch "updated" event.
     */
    public function updated(Batch $batch): void
    {
        ActivityLogger::log('Batch updated', 'A Batch updated.', ['Batch' => $batch]);

    }

    /**
     * Handle the Batch "deleted" event.
     */
    public function deleted(Batch $batch): void
    {
        ActivityLogger::log('Batch deleted', 'A Batch deleted.', ['Batch' => $batch]);

    }

    /**
     * Handle the Batch "restored" event.
     */
    public function restored(Batch $batch): void
    {
        ActivityLogger::log('Batch restored', 'A Batch restored.', ['Batch' => $batch]);

    }

    /**
     * Handle the Batch "force deleted" event.
     */
    public function forceDeleted(Batch $batch): void
    {
        ActivityLogger::log('Batch deleted', 'A Batch deleted.', ['Batch' => $batch]);

    }
}
