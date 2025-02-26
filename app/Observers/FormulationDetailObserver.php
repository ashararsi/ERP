<?php

namespace App\Observers;

use App\Models\FormulationDetail;

class FormulationDetailObserver
{
    /**
     * Handle the FormulationDetail "created" event.
     */
    public function created(FormulationDetail $formulationDetail): void
    {
        //
    }

    /**
     * Handle the FormulationDetail "updated" event.
     */
    public function updated(FormulationDetail $formulationDetail): void
    {
        //
    }

    /**
     * Handle the FormulationDetail "deleted" event.
     */
    public function deleted(FormulationDetail $formulationDetail): void
    {
        //
    }

    /**
     * Handle the FormulationDetail "restored" event.
     */
    public function restored(FormulationDetail $formulationDetail): void
    {
        //
    }

    /**
     * Handle the FormulationDetail "force deleted" event.
     */
    public function forceDeleted(FormulationDetail $formulationDetail): void
    {
        //
    }
}
