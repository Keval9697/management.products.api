<?php

namespace App\Observers;

use App\Events\Product\CreatedEvent;
use App\Events\Product\ProductUpdatedEvent;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Exception;

class ProductObserver
{
    /**
     * Handle the product "created" event.
     *
     * @param Product $product
     * @return void
     */
    public function created(Product $product)
    {
        $warehouse_ids = Warehouse::all('id')
            ->map(function ($warehouse) use ($product) {
                return [
                    'warehouse_id' => $warehouse->getKey(),
                    'product_id' => $product->getKey(),
                    'location_id' => $warehouse->getKey(),
                ];
            });

        Inventory::query()->insert($warehouse_ids->toArray());

        CreatedEvent::dispatch($product);
    }

    /**
     * Handle the product "updated" event.
     *
     * @param Product $product
     * @return void
     * @throws Exception
     */
    public function updated(Product $product)
    {
        ProductUpdatedEvent::dispatch($product);
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param Product $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the product "restored" event.
     *
     * @param Product $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the product "force deleted" event.
     *
     * @param Product $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }
}
