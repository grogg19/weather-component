<?php
/**
 * Class ExtendedGeoLocation
 */

namespace App\Receiver;

use App\DataReceiver;
use App\Exception\ApiErrorException;
/**
 * Class ExtendedGeoLocation
 * @package App\Receiver
 */
class ExtendedGeoLocation extends DataReceiver
{
    private $geolocation;

    /**
     * ExtendedGeoLocation constructor.
     * @param Ip $ip
     * @throws ApiErrorException
     */
    public function __construct(Ip $ip)
    {
        $ip = (new Ip())->getData();

        if($ip !== null) {
            $this->setParameters($ip);
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
        return json_decode($this->geolocation, true);
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return json_decode($this->geolocation, false);
    }
}
