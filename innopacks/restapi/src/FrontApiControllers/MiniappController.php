<?php
/* */

namespace InnoShop\RestAPI\FrontApiControllers;

use Exception;
use Illuminate\Http\Request;
use InnoShop\RestAPI\Libraries\MiniApp\Auth;
use Symfony\Contracts\HttpClient\Exception as HttpClientException;
use Throwable;

class MiniappController extends BaseController
{
    /**
     * @param  Request  $request
     * @return mixed
     * @throws HttpClientException\DecodingExceptionInterface
     * @throws HttpClientException\RedirectionExceptionInterface
     * @throws HttpClientException\ServerExceptionInterface
     * @throws HttpClientException\TransportExceptionInterface
     * @throws Throwable
     */
    public function index(Request $request): mixed
    {
        try {
            $code = $request->get('code');
            if (empty($code)) {
                throw new Exception('Empty MiniApp Code');
            }

            $miniAppAuth = Auth::getInstance($code);
            $customer    = $miniAppAuth->findOrCreateCustomerByCode();

            $token = $customer->createToken('customer-token')->plainTextToken;

            return create_json_success(['token' => $token]);
        } catch (\Exception $e) {
            return json_fail($e->getMessage());
        }
    }
}
