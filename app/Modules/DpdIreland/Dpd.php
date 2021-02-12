<?php


namespace App\Modules\DpdIreland;

use App\Models\Order;
use App\Models\OrderAddress;
use App\Modules\DpdIreland\src\Client;
use App\Modules\DpdIreland\src\Consignment;
use App\Modules\DpdIreland\src\Exceptions\PreAdviceRequestException;
use App\Modules\DpdIreland\src\Responses\PreAdvice;
use Illuminate\Support\Facades\Log;

/**
 * Class Dpd
 * @package App\Modules\Dpd\src
 */
class Dpd
{
    /**
     * @param Order $order
     * @return PreAdvice
     * @throws src\Exceptions\ConsignmentValidationException
     */
    public static function shipOrder(Order $order): PreAdvice
    {
        $shipping_address = $order->shippingAddress()->first();

        $consignment = new Consignment([
            'RecordID' => $order->order_number,
            'DeliveryAddress' => self::getDeliveryAddress($shipping_address)
        ]);

        return self::getPreAdvice($consignment);
    }

    /**
     * @param Consignment $consignment
     * @return PreAdvice
     * @throws PreAdviceRequestException
     */
    public static function getPreAdvice(Consignment $consignment): PreAdvice
    {
        $response = Client::postXml($consignment->toXml());

        $preAdvice = new PreAdvice($response->getBody()->getContents());

        if($preAdvice->isNotSuccess()) {
            Log::error('DPD PreAdvice request failed', [
                'xml_received' => $preAdvice->toString(),
                'xml_sent' => $consignment->toString(),
            ]);
            throw new PreAdviceRequestException();
        }

        return $preAdvice;
    }

    /**
     * @param OrderAddress $shipping_address
     * @return array
     */
    private static function getDeliveryAddress(OrderAddress $shipping_address): array
    {
        return [
            'Contact' => $shipping_address->full_name,
            'ContactTelephone' => $shipping_address->phone,
            'ContactEmail' => '',
            'AddressLine1' => $shipping_address->address1,
            'AddressLine2' => $shipping_address->address2,
            'AddressLine3' => $shipping_address->city,
            'AddressLine4' => $shipping_address->state_name ?: $shipping_address->city,
            'CountryCode' => $shipping_address->country_code,
        ];
    }
}