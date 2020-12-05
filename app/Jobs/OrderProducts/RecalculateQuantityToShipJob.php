<?php

namespace App\Jobs\OrderProducts;

use App\Models\OrderProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecalculateQuantityToShipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        OrderProduct::query()
            ->whereRaw('quantity_to_ship != quantity_ordered - quantity_shipped')
            ->latest()
            // for performance purposes limit to 1000 records per job
            ->limit(1000)
            ->each(function ($orderProduct) {
                activity()->on($orderProduct)->log('Incorrect quantity to ship detected');
                $orderProduct->save();
            });
    }
}