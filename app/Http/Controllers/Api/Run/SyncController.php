<?php

namespace App\Http\Controllers\Api\Run;

use App\Http\Controllers\Controller;
use App\Models\RmsapiConnection;
use App\Modules\Api2cart\src\Jobs\DispatchImportOrdersJobs;
use App\Modules\Rmsapi\src\Jobs\FetchUpdatedProductsJob;

/**
 * Class SyncController
 * @package App\Http\Controllers
 */
class SyncController extends Controller
{
    /**
     *
     */
    public function index()
    {
        logger('Dispatching sync jobs');

        // import API2CART orders
        DispatchImportOrdersJobs::dispatch();

        // import RMSAPI products
        foreach (RmsapiConnection::all() as $rmsapiConnection) {
            FetchUpdatedProductsJob::dispatch($rmsapiConnection->id);
            info('Rmsapi sync job dispatched', ['connection_id' => $rmsapiConnection->id]);
        }

        info('Sync jobs dispatched');

        return $this->respondOK200('Sync jobs dispatched');
    }
}
