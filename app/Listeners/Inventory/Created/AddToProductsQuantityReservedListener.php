<?php

namespace App\Listeners\Inventory\Created;

use App\Events\Inventory\CreatedEvent;

class AddToProductsQuantityReservedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param CreatedEvent $event
     * @return void
     */
    public function handle(CreatedEvent $event)
    {
        $event->getInventory()
            ->product()
            ->increment(
                'quantity_reserved',
                $event->getInventory()->quantity_reserved
            );
    }
}