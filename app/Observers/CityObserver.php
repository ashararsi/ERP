<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;


use App\Models\City;

class CityObserver
{
    /**
     * Handle the City "created" event.
     */
    public function created(City $city): void
    {
        ActivityLogger::log('city  created', ' city created.', ['city' => $city]);

    }

    /**
     * Handle the City "updated" event.
     */
    public function updated(City $city): void
    {
         ActivityLogger::log('city  updated', ' city updated.', ['city' => $city]);
    }

    /**
     * Handle the City "deleted" event.
     */
    public function deleted(City $city): void
    {
        ActivityLogger::log('city  deleted', ' city deleted.', ['city' => $city]);
    }

    /**
     * Handle the City "restored" event.
     */
    public function restored(City $city): void
    {
        ActivityLogger::log('city  restored', ' city restored.', ['city' => $city]);
    }

    /**
     * Handle the City "force deleted" event.
     */
    public function forceDeleted(City $city): void
    {
        ActivityLogger::log('city  forceDeleted', ' city forceDeleted.', ['city' => $city]);
    }
}
