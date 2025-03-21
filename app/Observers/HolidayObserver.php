<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Holiday;

class HolidayObserver
{
    /**
     * Handle the Holiday "created" event.
     */
    public function created(Holiday $holiday): void
    {
        ActivityLogger::log('Holiday created', 'A Holiday created.', ['Holiday' => $holiday]);
    }

    /**
     * Handle the Holiday "updated" event.
     */
    public function updated(Holiday $holiday): void
    {
       ActivityLogger::log('Holiday updated', 'A Holiday updated.', ['Holiday' => $holiday]);
    }

    /**
     * Handle the Holiday "deleted" event.
     */
    public function deleted(Holiday $holiday): void
    {
        ActivityLogger::log('Holiday deleted', 'A Holiday deleted.', ['Holiday' => $holiday]);
    }

    /**
     * Handle the Holiday "restored" event.
     */
    public function restored(Holiday $holiday): void
    {
         ActivityLogger::log('Holiday restored', 'A Holiday restored.', ['Holiday' => $holiday]);
    }

    /**
     * Handle the Holiday "force deleted" event.
     */
    public function forceDeleted(Holiday $holiday): void
    {
         ActivityLogger::log('Holiday forceDeleted', 'A Holiday forceDeleted.', ['Holiday' => $holiday]);
    }
}
