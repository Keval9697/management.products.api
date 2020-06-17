<?php

namespace App\Jobs\Rmsapi;

use App\Models\RmsapiConnection;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncRmsapiConnectionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $connection = null;

    /**
     * Create a new job instance.
     *
     * @param RmsapiConnection $connection
     */
    public function __construct(RmsapiConnection $connection)
    {
        $this->connection = $connection;
        logger('Job Rmsapi\SyncRmsapiConnectionJob dispatched');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ImportProductsJob::dispatch($this->connection);

        ProcessImportedProductsJob::dispatch();
    }
}
