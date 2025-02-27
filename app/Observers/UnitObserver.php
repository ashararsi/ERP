<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Unit;

class UnitObserver
{
    /**
     * Handle the Unit "created" event.
     */
    public function created(Unit $unit): void
    {
        ActivityLogger::log('Unit  created', ' Unit created.', ['Unit' => $unit]);

    }

    /**
     * Handle the Unit "updated" event.
     */
    public function updated(Unit $unit): void
    {
        ActivityLogger::log('Unit  update', ' Unit update.', ['Unit' => $unit]);

    }

    /**
     * Handle the Unit "deleted" event.
     */
    public function deleted(Unit $unit): void
    {
        ActivityLogger::log('Unit  delete', ' Unit delete.', ['Unit' => $unit]);

    }

    /**
     * Handle the Unit "restored" event.
     */
    public function restored(Unit $unit): void
    {
        ActivityLogger::log('Unit  restored', ' Unit restored.', ['Unit' => $unit]);

    }

    /**
     * Handle the Unit "force deleted" event.
     */
    public function forceDeleted(Unit $unit): void
    {
        ActivityLogger::log('Unit  Force Deleted', ' Unit Frce Deleted.', ['Unit' => $unit]);

    }
}
