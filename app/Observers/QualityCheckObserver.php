<?php

namespace App\Observers;

use App\Models\QualityCheck;

class QualityCheckObserver
{
    /**
     * Handle the QualityCheck "created" event.
     */
    public function created(QualityCheck $qualityCheck): void
    {
        //
    }

    /**
     * Handle the QualityCheck "updated" event.
     */
    public function updated(QualityCheck $qualityCheck): void
    {
        //
    }

    /**
     * Handle the QualityCheck "deleted" event.
     */
    public function deleted(QualityCheck $qualityCheck): void
    {
        //
    }

    /**
     * Handle the QualityCheck "restored" event.
     */
    public function restored(QualityCheck $qualityCheck): void
    {
        //
    }

    /**
     * Handle the QualityCheck "force deleted" event.
     */
    public function forceDeleted(QualityCheck $qualityCheck): void
    {
        //
    }
}
