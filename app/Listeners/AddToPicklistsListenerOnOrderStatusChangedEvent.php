<?php

namespace App\Listeners;

use App\Events\OrderStatusChangedEvent;
use App\Models\Picklist;
use App\Services\PicklistService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddToPicklistsListenerOnOrderStatusChangedEvent
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
     * @param  OrderStatusChangedEvent  $event
     * @return void
     */
    public function handle(OrderStatusChangedEvent $event)
    {
        if ($event->order->status_code == 'picking') {
            PicklistService::fromOrderProduct(
                $event->order->orderProducts()->get()->toArray()
            );
        }
   }
}