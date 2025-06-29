<?php
/* */

namespace InnoShop\Common\Services;

use Exception;
use InnoShop\Common\Models\Order\Shipment;

class ShippingTraceService
{
    private Shipment $shipment;

    /**
     * @param  Shipment  $shipment
     */
    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * @param  Shipment  $shipment
     * @return static
     */
    public static function getInstance(Shipment $shipment): static
    {
        return new static($shipment);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getTraces(): array
    {
        $traceDriver = fire_hook_filter('service.shipping_trace.driver', null);
        if (empty($traceDriver)) {
            throw new Exception('Empty trace driver');
        }

        $code   = $this->shipment->express_code   ?? '';
        $number = $this->shipment->express_number ?? '';

        return (new $traceDriver)->getTraces($code, $number);
    }
}
