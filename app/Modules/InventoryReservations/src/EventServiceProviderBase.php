<?php

namespace App\Modules\InventoryReservations\src;

use App\Events\DailyEvent;
use App\Events\Order\OrderUpdatedEvent;
use App\Events\OrderProduct\OrderProductCreatedEvent;
use App\Events\OrderProduct\OrderProductUpdatedEvent;
use App\Modules\InventoryReservations\src\Listeners\OrderProductUpdatedEvent\UpdateQuantityReservedListener;
use App\Modules\BaseModuleServiceProvider;

/**
 * Class EventServiceProviderBase
 * @package App\Providers
 */
class EventServiceProviderBase extends BaseModuleServiceProvider
{
    /**
     * @var string
     */
    public string $module_name = 'Inventory Reservations';

    /**
     * @var string
     */
    public string $module_description = 'Reserves stock for open orders. Is using location 999';

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        DailyEvent::class => [
            Listeners\DailyEvent\RunRecalculateQuantityReservedJobListener::class
        ],

        OrderProductUpdatedEvent::class => [
            UpdateQuantityReservedListener::class,
        ],

        OrderUpdatedEvent::class => [
            Listeners\OrderUpdatedListener::class,
        ],

        OrderProductCreatedEvent::class => [
            Listeners\OrderProductCreatedListener::class,
        ],
    ];
}
