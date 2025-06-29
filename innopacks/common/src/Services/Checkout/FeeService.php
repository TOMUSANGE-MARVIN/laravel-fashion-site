<?php
/* */

namespace InnoShop\Common\Services\Checkout;

use InnoShop\Common\Services\Fee\BalanceService;
use InnoShop\Common\Services\Fee\Shipping;
use InnoShop\Common\Services\Fee\Subtotal;
use InnoShop\Common\Services\Fee\Tax;

class FeeService extends BaseService
{
    /**
     * @return void
     */
    public function calculate(): void
    {
        $classes = $this->getFeeMethodClasses();
        foreach ($classes as $class) {
            (new $class($this->checkoutService))->addFee();
        }
    }

    /**
     * Get order fee method classes
     * @return mixed
     */
    public function getFeeMethodClasses(): mixed
    {
        $classes = [
            Subtotal::class,
            Tax::class,
            Shipping::class,
            BalanceService::class,
        ];

        return fire_hook_filter('service.checkout.fee.methods', $classes);
    }
}
