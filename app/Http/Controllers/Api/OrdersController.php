<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\UpdateRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * Class OrdersController
 * @package App\Http\Controllers\Api
 */
class OrdersController extends Controller
{
    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $query = OrderService::getSpatieQueryBuilder();

        return $this->getPerPageAndPaginate($request, $query, 10);
    }

    /**
     * @param StoreOrderRequest $request
     * @return JsonResponse
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::query()->updateOrCreate(
            ['order_number' => $request->order_number],
            $request->all()
        );

        return response()->json($order, 200);
    }

    /**
     * @param UpdateRequest $request
     * @param Order $order
     * @return JsonResource
     */
    public function update(UpdateRequest $request, Order $order)
    {
        $updates = $request->validated();

        if ($request->has('is_packed')) {
            $updates = Arr::add($updates, 'packer_user_id', $request->user()->getKey());
        }

        $order->update($updates);

        return new JsonResource($order);
    }

    /**
     * @param Request $request
     * @param Order $order
     * @return JsonResource
     */
    public function show(Request $request, Order $order)
    {
        return new JsonResource($order);
    }

    /**
     * @param $order_number
     * @throws \Exception
     */
    public function destroy($order_number)
    {
        try {
            $order = Order::query()->where('order_number', $order_number)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return $this->respondNotFound();
        }

        $order->delete();

        return $this->respondOK200();
    }
}
