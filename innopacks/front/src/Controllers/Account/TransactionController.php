<?php
/* */

namespace InnoShop\Front\Controllers\Account;

use InnoShop\Common\Repositories\Customer\TransactionRepo;
use InnoShop\RestAPI\FrontApiControllers\BaseController;

class TransactionController extends BaseController
{
    /**
     * @return mixed
     */
    public function index(): mixed
    {
        $customer   = current_customer();
        $customerID = $customer->id;

        $filters = [
            'customer_id' => $customerID,
        ];

        $customer->syncBalance();
        $balance = $customer->balance;
        $frozen  = TransactionRepo::getInstance()->getAmountByType('frozen', $customerID);
        $data    = [
            'balance'      => $balance,
            'frozen'       => $frozen,
            'available'    => $balance - $frozen,
            'transactions' => TransactionRepo::getInstance()->list($filters),
        ];

        return inno_view('account.transactions_index', $data);
    }
}
