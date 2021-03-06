<?php
/**
 * Class CurrentWeather
 */

namespace App\Receiver;

use App\DataReceiver;
use App\Exception\ApiErrorException;

class CurrentWeather extends DataReceiver
{
    /**
     * @var mixed
     */
    private $current;

    /**
     * CurrentWeather constructor.
     * @param GeoLocation $geolocation
     * @throws ApiErrorException
     */
    public function __construct(GeoLocation $geolocation)
    {
        if($geolocation !== null) {
            $this->setApiName('current');
            $this->setParameters($this->getParamsFromRequest($geolocation));
            $this->current = $this->getUrlContent();
        } else {
            throw new ApiErrorException('Нет данных геолокации', 400);
        }
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return json_decode($this->current, true);
    }

    public function getParamsFromRequest(GeoLocation $geolocation)
    {
        $geolocation = $geolocation->getObject();

        if ($geolocation->country->iso == 'RU') {
            return [
                'ip' => $geolocation->ip,
                'city' => $geolocation->city->name_en,
                'country' => mb_strtolower($geolocation->country->iso),
                'lang' => mb_strtolower($geolocation->country->iso),
                'city_name' => $geolocation->city->name_ru,
                'country_name' => $geolocation->country->name_ru
            ];
        } else {
            return [
                'ip' => $geolocation->ip,
                'city' => $geolocation->city->name_en,
                'country' => mb_strtolower($geolocation->country->iso),
                'lang' => mb_strtolower($geolocation->country->iso),
                'city_name' => $geolocation->city->name_en,
                'country_name' => $geolocation->country->name_en
            ];
        }
    }
}
