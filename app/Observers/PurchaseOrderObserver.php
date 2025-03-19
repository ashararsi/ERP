<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\PurchaseOrder;

class PurchaseOrderObserver
{
    /**
     * Handle the PurchaseOrder "created" event.
     */
    public function created(PurchaseOrder $purchaseOrder): void
    {
        ActivityLogger::log('PurchaseOrder  created', ' PurchaseOrder created.', ['PurchaseOrder' => $purchaseOrder]);
    }

    /**
     * Handle the PurchaseOrder "updated" event.
     */
    public function updated(PurchaseOrder $purchaseOrder): void
    {
        ActivityLogger::log('PurchaseOrder  updated', ' PurchaseOrder updated.', ['PurchaseOrder' => $purchaseOrder]);
    }

    /**
     * Handle the PurchaseOrder "deleted" event.
     */
    public function deleted(PurchaseOrder $purchaseOrder): void
    {
        ActivityLogger::log('PurchaseOrder  deleted', ' PurchaseOrder deleted.', ['PurchaseOrder' => $purchaseOrder]);
    }

    /**
     * Handle the PurchaseOrder "restored" event.
     */
    public function restored(PurchaseOrder $purchaseOrder): void
    {
        ActivityLogger::log('PurchaseOrder  restored', ' PurchaseOrder restored.', ['PurchaseOrder' => $purchaseOrder]);
    }

    /**
     * Handle the PurchaseOrder "force deleted" event.
     */
    public function forceDeleted(PurchaseOrder $purchaseOrder): void
    {
        ActivityLogger::log('PurchaseOrder  forceDeleted', ' PurchaseOrder forceDeleted.', ['PurchaseOrder' => $purchaseOrder]);
    }

}
