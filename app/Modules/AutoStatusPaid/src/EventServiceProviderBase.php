<?php

namespace App\Modules\AutoStatusPaid\src;

use App\Events\Order\OrderUpdatedEvent;
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
    public string $module_name = 'Auto Paid Status';

    /**
     * @var string
     */
    public string $module_description = 'Automatically changes status from "processing" to "paid" ' .
        'if order has been paid';

    /**
     * @var array
     */
    protected $listen = [
        OrderUpdatedEvent::class => [
            Listeners\OrderUpdatedEvent\ProcessingToPaidListener::class,
        ],
    ];
}
