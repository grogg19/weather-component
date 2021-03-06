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
     * @throws ApiErrorException
     */
    public function __construct()
    {
        $this->setApiName('geoLocation');

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

    public function getObject()
    {
        return json_decode($this->geolocation, false);
    }
}
