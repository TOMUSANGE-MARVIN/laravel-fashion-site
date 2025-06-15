<?php
/* */

namespace InnoShop\RestAPI\PanelApiControllers;

use Illuminate\Http\Request;
use InnoShop\Common\Models\Order;
use InnoShop\Common\Resources\OrderSimple;

class OrderController extends BaseController
{
    /**
     * @param  Order  $order
     * @param  Request  $request
     * @return mixed
     */
    public function updateNote(Order $order, Request $request): mixed
    {
        try {
            $adminNote = $request->get('admin_note');
            $order->update([
                'admin_note' => $adminNote,
            ]);

            return update_json_success(new OrderSimple($order));
        } catch (\Exception $e) {
            return json_fail($e->getMessage());
        }

    }
}
