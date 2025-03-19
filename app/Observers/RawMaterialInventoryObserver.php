<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\RawMaterialInventory;

class RawMaterialInventoryObserver
{
    /**
     * Handle the RawMaterialInventory "created" event.
     */
    public function created(RawMaterialInventory $rawMaterialInventory): void
    {
        ActivityLogger::log('RawMaterialInventory  created', ' RawMaterialInventory created.', ['RawMaterialInventory' => $rawMaterialInventory]);
    }

    /**
     * Handle the RawMaterialInventory "updated" event.
     */
    public function updated(RawMaterialInventory $rawMaterialInventory): void
    {
        ActivityLogger::log('RawMaterialInventory  updated', ' RawMaterialInventory updated.', ['RawMaterialInventory' => $rawMaterialInventory]);
    }

    /**
     * Handle the RawMaterialInventory "deleted" event.
     */
    public function deleted(RawMaterialInventory $rawMaterialInventory): void
    {
        ActivityLogger::log('RawMaterialInventory  deleted', ' RawMaterialInventory deleted.', ['RawMaterialInventory' => $rawMaterialInventory]);
    }

    /**
     * Handle the RawMaterialInventory "restored" event.
     */
    public function restored(RawMaterialInventory $rawMaterialInventory): void
    {
        ActivityLogger::log('RawMaterialInventory  restored', ' RawMaterialInventory restored.', ['RawMaterialInventory' => $rawMaterialInventory]);
    }

    /**
     * Handle the RawMaterialInventory "force deleted" event.
     */
    public function forceDeleted(RawMaterialInventory $rawMaterialInventory): void
    {
        ActivityLogger::log('RawMaterialInventory  forceDeleted', ' RawMaterialInventory forceDeleteds.', ['RawMaterialInventory' => $rawMaterialInventory]);
    }
}
