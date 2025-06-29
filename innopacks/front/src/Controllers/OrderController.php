<?php
/* */

namespace InnoShop\Front\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use InnoShop\Common\Models\Order;
use InnoShop\Common\Repositories\OrderRepo;
use InnoShop\Front\Services\PaymentService;

class OrderController extends Controller
{
    /**
     * @param  Request  $request
     * @return mixed
     * @throws Exception
     */
    public function pay(Request $request): mixed
    {
        try {
            $order = Order::query()->where('number', $request->number)->firstOrFail();

            return PaymentService::getInstance($order)->pay();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Order detail
     *
     * @param  int  $number
     * @return mixed
     */
    public function numberShow(int $number): mixed
    {
        $order = OrderRepo::getInstance()->getOrderByNumber($number);
        $order->load(['items', 'fees']);
        $data = [
            'order' => $order,
        ];

        return inno_view('orders.show', $data);
    }
}
