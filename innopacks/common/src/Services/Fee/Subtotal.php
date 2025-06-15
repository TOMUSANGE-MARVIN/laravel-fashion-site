<?php
/* */

namespace InnoShop\Common\Services\Fee;

class Subtotal extends BaseService
{
    /**
     * @return void
     */
    public function addFee(): void
    {
        $total = $this->getSubtotal();

        $subtotalFee = [
            'code'         => 'subtotal',
            'title'        => 'Subtotal',
            'total'        => $total,
            'total_format' => currency_format($total),
        ];

        $this->checkoutService->addFeeList($subtotalFee);
    }

    /**
     * @return float
     */
    public function getSubtotal(): float
    {
        $cartList = $this->checkoutService->getCartList();

        return round(collect($cartList)->sum('subtotal'), 4);
    }
}
