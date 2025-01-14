<?php

namespace App\Modules\AutoStatusReady\src;

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
    public string $module_name = 'Auto "ready" status';

    /**
     * @var string
     */
    public string $module_description = 'Automatically changes status to "ready" when order is fully packed';

    /**
     * @var array
     */
    protected $listen = [
        OrderUpdatedEvent::class => [
            Listeners\OrderUpdatedEvent\SetReadyWhenPacked::class,
        ],
    ];
}
