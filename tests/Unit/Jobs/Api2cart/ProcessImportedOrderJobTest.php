<?php

namespace Tests\Unit\Jobs\Api2cart;

use App\Events\OrderCreatedEvent;
use App\Jobs\Api2cart\ProcessApi2cartImportedOrderJob;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Modules\Api2cart\src\Models\Api2cartOrderImports;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcessImportedOrderJobTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        // prepare
        Event::fake();

        Order::query()->forceDelete();
        OrderProduct::query()->forceDelete();
        Api2cartOrderImports::query()->forceDelete();

        $importedOrder = factory(Api2cartOrderImports::class)->create();

        ProcessApi2cartImportedOrderJob::dispatch($importedOrder);

        $order = Order::query()
            ->where([
                'order_number' => $importedOrder['raw_import']['id']
            ])
            ->first();

        $this->assertNotNull($order, 'Order does not exist in database');
        $this->assertNotNull($order->status_code, 'Status code missing');

    }
}
