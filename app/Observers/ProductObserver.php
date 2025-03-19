<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Product;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        ActivityLogger::log('Product  created', ' Product created.', ['Product' => $product]);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        ActivityLogger::log('Product  updated', ' Product updated.', ['Product' => $product]);
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        ActivityLogger::log('Product  deleted', ' Product deleted.', ['Product' => $product]);
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        ActivityLogger::log('Product  restored', ' Product restored.', ['Product' => $product]);
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        ActivityLogger::log('Product  forceDeleted', ' Product forceDeleted.', ['Product' => $product]);
    }
}
