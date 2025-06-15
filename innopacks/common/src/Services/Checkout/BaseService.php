<?php
/* */

namespace InnoShop\Common\Services\Checkout;

use InnoShop\Common\Services\CheckoutService;

class BaseService
{
    protected CheckoutService $checkoutService;

    /**
     * @param  CheckoutService  $checkoutService
     */
    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    /**
     * @param  CheckoutService  $checkoutService
     * @return static
     */
    public static function getInstance(CheckoutService $checkoutService): static
    {
        return new static($checkoutService);
    }
}
