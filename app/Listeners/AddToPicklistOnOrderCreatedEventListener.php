<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Models\Picklist;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddToPicklistOnOrderCreatedEventListener
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
     * @param OrderCreatedEvent $event
     * @return void
     */
    public function handle(OrderCreatedEvent $event)
    {
        if ($event->order->status_code == 'picking') {

            foreach ($event->order->orderProducts()->get() as $orderProduct) {

                Picklist::query()->updateOrCreate([
                    'order_product_id' => $orderProduct->getKey()
                ],[
                    'order_id' => $event->order->getKey(),
                    'product_id' => $orderProduct->product_id,
                    'location_id' => 'WWW',
                    'sku_ordered' => $orderProduct->sku_ordered,
                    'name_ordered' => $orderProduct->name_ordered,
                    'quantity_to_pick' => $orderProduct->quantity,
                ]);

            }

        }
    }
}
