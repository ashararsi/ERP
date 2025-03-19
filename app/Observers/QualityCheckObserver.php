<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\QualityCheck;

class QualityCheckObserver
{
    /**
     * Handle the QualityCheck "created" event.
     */
    public function created(QualityCheck $qualityCheck): void
    {
        ActivityLogger::log('QualityCheck  created', ' QualityCheck created.', ['QualityCheck' => $qualityCheck]);
    }

    /**
     * Handle the QualityCheck "updated" event.
     */
    public function updated(QualityCheck $qualityCheck): void
    {
        ActivityLogger::log('QualityCheck  updated', ' QualityCheck updated.', ['QualityCheck' => $qualityCheck]);
    }

    /**
     * Handle the QualityCheck "deleted" event.
     */
    public function deleted(QualityCheck $qualityCheck): void
    {
        ActivityLogger::log('QualityCheck  deleted', ' QualityCheck deleted.', ['QualityCheck' => $qualityCheck]);
    }

    /**
     * Handle the QualityCheck "restored" event.
     */
    public function restored(QualityCheck $qualityCheck): void
    {
        ActivityLogger::log('QualityCheck  restored', ' QualityCheck restored.', ['QualityCheck' => $qualityCheck]);
    }

    /**
     * Handle the QualityCheck "force deleted" event.
     */
    public function forceDeleted(QualityCheck $qualityCheck): void
    {
        ActivityLogger::log('QualityCheck  forceDeleted', ' QualityCheck forceDeleteds.', ['QualityCheck' => $qualityCheck]);
    }
}
