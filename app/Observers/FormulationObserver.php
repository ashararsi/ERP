<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Formulations;

class FormulationObserver
{
    /**
     * Handle the Formulation "created" event.
     */
    public function created(Formulations $formulation): void
    {
        ActivityLogger::log('Formulation created', 'A formulation created.', ['formulation' => $formulation]);

    }

    /**
     * Handle the Formulation "updated" event.
     */
    public function updated(Formulations $formulation): void
    {
        ActivityLogger::log('Formulation created', 'A formulation update.', ['formulation' => $formulation]);

    }

    /**
     * Handle the Formulation "deleted" event.
     */
    public function deleted(Formulations $formulation): void
    {
        ActivityLogger::log('Formulation created', 'A formulation deleted.', ['formulation' => $formulation]);

    }

    /**
     * Handle the Formulation "restored" event.
     */
    public function restored(Formulations $formulation): void
    {
        ActivityLogger::log('Formulation restored', 'A formulation restore.', ['formulation' => $formulation]);

    }

    /**
     * Handle the Formulation "force deleted" event.
     */
    public function forceDeleted(Formulations $formulation): void
    {
        ActivityLogger::log('Formulation deleted', 'A formulation deleted.', ['formulation' => $formulation]);

    }
}
