<?php

namespace App\Observers;

use App\Models\GoodReceiptNote;

class GoodReceiptNoteObserver
{
    /**
     * Handle the GoodReceiptNote "created" event.
     */
    public function created(GoodReceiptNote $goodReceiptNote): void
    {
        //
    }

    /**
     * Handle the GoodReceiptNote "updated" event.
     */
    public function updated(GoodReceiptNote $goodReceiptNote): void
    {
        //
    }

    /**
     * Handle the GoodReceiptNote "deleted" event.
     */
    public function deleted(GoodReceiptNote $goodReceiptNote): void
    {
        //
    }

    /**
     * Handle the GoodReceiptNote "restored" event.
     */
    public function restored(GoodReceiptNote $goodReceiptNote): void
    {
        //
    }

    /**
     * Handle the GoodReceiptNote "force deleted" event.
     */
    public function forceDeleted(GoodReceiptNote $goodReceiptNote): void
    {
        //
    }
}
