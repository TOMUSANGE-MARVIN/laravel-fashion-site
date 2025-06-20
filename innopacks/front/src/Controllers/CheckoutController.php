<?php
/* */

namespace InnoShop\Front\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use InnoShop\Common\Exceptions\Unauthorized;
use InnoShop\Common\Repositories\OrderRepo;
use InnoShop\Common\Services\CheckoutService;
use InnoShop\Common\Services\StateMachineService;
use InnoShop\Front\Requests\CheckoutConfirmRequest;
use Throwable;

class CheckoutController extends Controller
{
    /**
     * Get checkout data and render page.
     *
     * @return mixed
     * @throws Throwable
     */
    public function index(): mixed
    {
        try {
            $checkout = CheckoutService::getInstance();
            $result   = $checkout->getCheckoutResult();
            if (empty($result['cart_list'])) {
                return redirect(front_route('carts.index'))->withErrors(['error' => 'Empty Cart']);
            }

            return inno_view('checkout.index', $result);
        } catch (Unauthorized $e) {
            return redirect(front_route('login.index'))->withErrors(['error' => $e->getMessage()]);
        } catch (Exception $e) {
            return redirect(front_route('carts.index'))->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update checkout, include shipping address, shipping method, billing address, billing method
     *
     * @param  Request  $request
     * @return mixed
     * @throws Throwable
     */
    public function update(Request $request): mixed
    {
        $data     = $request->all();
        $checkout = CheckoutService::getInstance();
        $checkout->updateValues($data);
        $result = $checkout->getCheckoutResult();

        return json_success('更新成功', $result);
    }

    /**
     * Confirm checkout and place order
     *
     * @param  CheckoutConfirmRequest  $request
     * @return mixed
     * @throws Throwable
     */
    public function confirm(CheckoutConfirmRequest $request): mixed
    {
        try {
            $checkout = CheckoutService::getInstance();
            $data     = $request->all();
            unset($data['reference']);
            if ($data) {
                $checkout->updateValues($data);
            }

            $order = $checkout->confirm();
            StateMachineService::getInstance($order)->changeStatus(StateMachineService::UNPAID, '', true);

            return json_success(front_trans('common.submitted_success'), $order);
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * Checkout success.
     *
     * @param  Request  $request
     * @return mixed
     * @throws Exception
     */
    public function success(Request $request): mixed
    {
        $orderNumber = $request->get('order_number');
        if (empty($orderNumber)) {
            $orderNumber = session('order_number');
        }

        if ($orderNumber) {
            $order = OrderRepo::getInstance()->builder(['number' => $orderNumber])->firstOrFail();
        }

        if (empty($order)) {
            return redirect(front_route('home.index'));
        }

        $data['order'] = $order;

        return inno_view('checkout.success', $data);
    }
}
