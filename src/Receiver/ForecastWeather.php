<?php
/**
 * Class CurrentWeather
 */


namespace App\Receiver;

use App\DataReceiver;

class ForecastWeather extends DataReceiver
{
    /**
     * @var mixed
     */
    private $forecast;

    /**
     * ForecastWeather constructor.
     * @param GeoLocation $geolocation
     * @throws \App\Exception\ApiErrorException
     */
    public function __construct(GeoLocation $geolocation)
    {
        $this->setApiName('forecast');
        $this->setParameters($this->getParamsFromRequest($geolocation));
        $this->forecast = $this->getUrlContent();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return json_decode($this->forecast, true);
    }

    /**
     * @param GeoLocation $geolocation
     * @return array
     */
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
