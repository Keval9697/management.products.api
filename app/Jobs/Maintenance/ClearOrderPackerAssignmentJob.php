<?php

namespace App\Jobs\Maintenance;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ClearOrderPackerAssignmentJob implements ShouldQueue
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
        $maxHoursOfInactivity = 12;
        Order::whereNull('packed_at')
            ->whereNotNull('packer_user_id')
            ->where('updated_at', '<', Carbon::now()->subHours($maxHoursOfInactivity))
            ->get()
            ->each(function (Order $order) {
                $order->update(['packer_user_id' => null]);
            });
    }
}
