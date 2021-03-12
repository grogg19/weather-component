<?php
/**
 * Класс GeoLocation
 */

namespace App\Receiver;

use App\DataReceiver;
use App\Exception\ApiErrorException;

/**
 * Class GeoLocation
 * @package App\Receiver
 */
class GeoLocation extends DataReceiver
{
    private $geolocation;

    /**
     * GeoLocation constructor.
     * @param Ip $ip
     * @throws ApiErrorException
     */
    public function __construct(Ip $ip)
    {
        $this->setApiName('geoLocation');

        if($ip !== null) {
            $this->setParameters(
                [
                    'ip' => $ip->getData()
                ]
            );
        } else {
            throw new ApiErrorException('Нет данных IP адреса', 400);
        }

        $this->geolocation = $this->getUrlContent();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->geolocation;
    }

}
