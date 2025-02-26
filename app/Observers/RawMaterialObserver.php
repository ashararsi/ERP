<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\RawMaterial;

class RawMaterialObserver
{
    /**
     * Handle the RawMaterial "created" event.
     */
    public function created(RawMaterial $rawMaterial): void
    {
        ActivityLogger::log('Raw Material Created', 'A new Raw Material was created.', [ 'rawMaterial'=>$rawMaterial]);
    }

    /**
     * Handle the RawMaterial "updated" event.
     */
    public function updated(RawMaterial $rawMaterial): void
    {
        ActivityLogger::log('Raw Material Update', 'A new Raw Material was Updated.', ['rawMaterial'=>$rawMaterial]);

    }

    /**
     * Handle the RawMaterial "deleted" event.
     */
    public function deleted(RawMaterial $rawMaterial): void
    {
        ActivityLogger::log('Raw Material delete', 'A   Raw Material was deleted.', ['rawMaterial'=>$rawMaterial]);

    }

    /**
     * Handle the RawMaterial "restored" event.
     */
    public function restored(RawMaterial $rawMaterial): void
    {
        ActivityLogger::log('Raw Material restore', 'A   Raw Material was restore.', ['rawMaterial'=>$rawMaterial]);
    }

    /**
     * Handle the RawMaterial "force deleted" event.
     */
    public function forceDeleted(RawMaterial $rawMaterial): void
    {
        //
    }
}
