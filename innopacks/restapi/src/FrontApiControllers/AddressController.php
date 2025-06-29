<?php
/* */

namespace InnoShop\RestAPI\FrontApiControllers;

use Illuminate\Http\Request;
use InnoShop\Common\Models\Address;
use InnoShop\Common\Repositories\AddressRepo;
use InnoShop\Common\Resources\AddressListItem;
use Throwable;

class AddressController extends BaseController
{
    /**
     * @return mixed
     */
    public function index(): mixed
    {
        $filters = [
            'customer_id' => token_customer_id(),
        ];

        $items     = AddressRepo::getInstance()->builder($filters)->get();
        $addresses = AddressListItem::collection($items)->jsonSerialize();

        return read_json_success($addresses);
    }

    /**
     * @param  Request  $request
     * @return mixed
     * @throws Throwable
     */
    public function store(Request $request): mixed
    {
        $data = $request->all();

        $data['customer_id'] = token_customer_id();

        $address = AddressRepo::getInstance()->create($data);
        $result  = new AddressListItem($address);

        return create_json_success($result);
    }

    /**
     * @param  Address  $address
     * @return mixed
     */
    public function show(Address $address): mixed
    {
        $customerID = token_customer_id();
        if ($customerID != $address->customer_id) {
            return json_fail('Unauthorized', null, 403);
        }

        $result = new AddressListItem($address);

        return read_json_success($result);
    }

    /**
     * @param  Request  $request
     * @param  Address  $address
     * @return mixed
     */
    public function update(Request $request, Address $address): mixed
    {
        $customerID = token_customer_id();
        if ($customerID != $address->customer_id) {
            return json_fail('Unauthorized', null, 403);
        }

        $data = $request->all();

        $data['customer_id'] = $customerID;

        $address = AddressRepo::getInstance()->update($address, $data);
        $result  = new AddressListItem($address);

        return update_json_success($result);
    }

    /**
     * @param  Address  $address
     * @return mixed
     */
    public function destroy(Address $address): mixed
    {
        $customerID = token_customer_id();
        if ($customerID != $address->customer_id) {
            return json_fail('Unauthorized', null, 403);
        }

        AddressRepo::getInstance()->destroy($address);

        return delete_json_success('success');
    }
}
