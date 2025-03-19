<?php

namespace App\Observers;

use App\Models\Country;

class CountryObserver
{
    /**
     * Handle the Country "created" event.
     */
    public function created(Country $country): void
    {
        ActivityLogger::log('country  created', ' country created.', ['country' => $country]);
    }

    /**
     * Handle the Country "updated" event.
     */
    public function updated(Country $country): void
    {
        ActivityLogger::log('country  updated', ' country updated.', ['country' => $country]);
    }

    /**
     * Handle the Country "deleted" event.
     */
    public function deleted(Country $country): void
    {
        ActivityLogger::log('country  deleted', ' country deleted.', ['country' => $country]);
    }

    /**
     * Handle the Country "restored" event.
     */
    public function restored(Country $country): void
    {
        ActivityLogger::log('country  restored', ' country restored.', ['country' => $country]);
    }

    /**
     * Handle the Country "force deleted" event.
     */
    public function forceDeleted(Country $country): void
    {
        ActivityLogger::log('country  forceDeleted', ' country forceDeleted.', ['country' => $country]);
    }
}
