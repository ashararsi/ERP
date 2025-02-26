<?php

namespace App\Observers;

use App\Models\Formulation;

class FormulationObserver
{
    /**
     * Handle the Formulation "created" event.
     */
    public function created(Formulation $formulation): void
    {
        //
    }

    /**
     * Handle the Formulation "updated" event.
     */
    public function updated(Formulation $formulation): void
    {
        //
    }

    /**
     * Handle the Formulation "deleted" event.
     */
    public function deleted(Formulation $formulation): void
    {
        //
    }

    /**
     * Handle the Formulation "restored" event.
     */
    public function restored(Formulation $formulation): void
    {
        //
    }

    /**
     * Handle the Formulation "force deleted" event.
     */
    public function forceDeleted(Formulation $formulation): void
    {
        //
    }
}
