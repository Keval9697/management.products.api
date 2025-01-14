<?php

namespace Tests\Unit\Jobs\Maintenance;

use App\Events\HourlyEvent;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Modules\AutoStatusPicking\src\EventServiceProviderBase;
use App\Services\AutoPilot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RefillWebPickingStatusListJobTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        EventServiceProviderBase::enableModule();

        Product::query()->forceDelete();
        OrderProduct::query()->forceDelete();
        Order::query()->forceDelete();

        factory(Product::class, 30)->create();

        factory(Order::class, 150)
            ->with('orderProducts', 2)
            ->create(['status_code' => 'paid']);

        HourlyEvent::dispatch();

        $this->assertEquals(
            AutoPilot::getBatchSize(),
            Order::whereStatusCode('picking')->count()
        );
    }
}
