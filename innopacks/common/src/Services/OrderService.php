<?php
/* */

namespace InnoShop\Common\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use InnoShop\Common\Models\Order;
use Throwable;

class OrderService
{
    private Order $order;

    /**
     * @param  int  $orderID
     */
    public function __construct(int $orderID)
    {
        $this->order = Order::query()->findOrFail($orderID);
    }

    /**
     * @param  int  $orderID
     * @return static
     */
    public static function getInstance(int $orderID): static
    {
        return new static($orderID);
    }

    /**
     * Confirm checkout and place order.
     *
     * @return mixed
     * @throws Exception|Throwable
     */
    public function reorder(): mixed
    {
        DB::beginTransaction();

        try {

            $this->order->load(['items', 'fees']);
            $order = $this->order->replicate();

            $order->saveOrFail();

            DB::commit();

            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
