<?php
/**
 * Class CurrentWeather
 */

namespace App\Receiver;

use App\DataReceiver;
use App\Receiver\Ip;
use App\Receiver\GeoLocation;
use App\Receiver\ExtendedGeoLocation;
use App\Exception\ApiErrorException;

class CurrentWeather extends DataReceiver
{
    /**
     * @var mixed
     */
    private $current;

    private $geolocation;

    /**
     * CurrentWeather constructor.
     * @throws ApiErrorException
     */
    public function __construct()
    {
        $this->geolocation = new GeoLocation();

        if($this->geolocation !== null) {
            $this->setApiName('current');
            $this->setParameters($this->getGeolocationData());
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

    /**
     * Подготовка данных для API Openweather
     * @param \App\Receiver\GeoLocation $geolocation
     * @return array
     */
    private function prepareDataForApi(GeoLocation $geolocation)
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

    /**
     * @return array
     */
    public function getGeolocationData(): array
    {
        return $this->prepareDataForApi($this->geolocation);
    }
}
