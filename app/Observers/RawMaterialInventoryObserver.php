<?php

namespace App\Observers;

use App\Models\RawMaterialInventory;

class RawMaterialInventoryObserver
{
    /**
     * Handle the RawMaterialInventory "created" event.
     */
    public function created(RawMaterialInventory $rawMaterialInventory): void
    {
        //
    }

    /**
     * Handle the RawMaterialInventory "updated" event.
     */
    public function updated(RawMaterialInventory $rawMaterialInventory): void
    {
        //
    }

    /**
     * Handle the RawMaterialInventory "deleted" event.
     */
    public function deleted(RawMaterialInventory $rawMaterialInventory): void
    {
        //
    }

    /**
     * Handle the RawMaterialInventory "restored" event.
     */
    public function restored(RawMaterialInventory $rawMaterialInventory): void
    {
        //
    }

    /**
     * Handle the RawMaterialInventory "force deleted" event.
     */
    public function forceDeleted(RawMaterialInventory $rawMaterialInventory): void
    {
        //
    }
}
