<?php
/* */

namespace InnoShop\Front\Controllers\Account;

use Exception;
use Illuminate\Http\Request;
use InnoShop\Common\Models\OrderReturn;
use InnoShop\Common\Repositories\Order\ItemRepo;
use InnoShop\Common\Repositories\OrderRepo;
use InnoShop\Common\Repositories\OrderReturnRepo;
use InnoShop\Front\Controllers\BaseController;
use Throwable;

class OrderReturnController extends BaseController
{
    public function index(Request $request)
    {
        $filters = $request->all();

        $filters['customer_id'] = current_customer_id();

        $data = [
            'order_returns' => OrderReturnRepo::getInstance()->list($filters),
        ];

        return inno_view('account.order_return_index', $data);
    }

    /**
     * @param  Request  $request
     * @return mixed
     */
    public function create(Request $request): mixed
    {
        $number  = $request->get('order_number');
        $filters = [
            'number'      => $number,
            'customer_id' => current_customer_id(),
        ];
        $order   = OrderRepo::getInstance()->builder($filters)->firstOrFail();
        $options = ItemRepo::getInstance()->getOptions($order);

        $data = [
            'number'  => $number,
            'order'   => $order,
            'options' => $options,
        ];

        return inno_view('account.order_return_create', $data);
    }

    /**
     * @param  Request  $request
     * @return mixed
     * @throws Exception|Throwable
     */
    public function store(Request $request): mixed
    {
        $data = $request->all();
        try {
            $data['customer_id'] = current_customer_id();
            $orderReturn         = OrderReturnRepo::getInstance()->create($data);

            return redirect(account_route('order_returns.index'))
                ->with('instance', $orderReturn);
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    /**
     * @param  OrderReturn  $orderReturn
     * @return mixed
     */
    public function show(OrderReturn $orderReturn): mixed
    {
        $data = [
            'order_return' => $orderReturn,
            'histories'    => $orderReturn->histories()->orderByDesc('id')->get(),
        ];

        return inno_view('account.order_return_show', $data);
    }

    /**
     * @param  OrderReturn  $order_return
     * @return mixed
     * @throws Exception
     */
    public function destroy(OrderReturn $order_return): mixed
    {
        $order_return->delete();

        return redirect(account_route('order_returns.index'));
    }
}
