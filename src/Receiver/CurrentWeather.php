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
use function Helpers\printArray;

class CurrentWeather extends DataReceiver
{
    /**
     * @var mixed
     */
    private $current;

    private $geolocation;

    /**
     * CurrentWeather constructor.
     * @param \App\Receiver\GeoLocation $geoLocation
     * @throws ApiErrorException
     */
    public function __construct(GeoLocation $geoLocation)
    {
        $this->geolocation = $geoLocation->getData();

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
        return $this->current;
    }

    /**
     * Подготовка данных для API Openweather
     * @param \App\Receiver\GeoLocation $geolocation
     * @return array
     */
    private function prepareDataForApi()
    {
        if ($this->geolocation->country->iso == 'RU') {
            return [
                'ip' => $this->geolocation->ip,
                'city' => $this->geolocation->city->name_en,
                'country' => mb_strtolower($this->geolocation->country->iso),
                'lang' => mb_strtolower($this->geolocation->country->iso),
                'city_name' => $this->geolocation->city->name_ru,
                'country_name' => $this->geolocation->country->name_ru
            ];
        } else {
            return [
                'ip' => $this->geolocation->ip,
                'city' => $this->geolocation->city->name_en,
                'country' => mb_strtolower($this->geolocation->country->iso),
                'lang' => mb_strtolower($this->geolocation->country->iso),
                'city_name' => $this->geolocation->city->name_en,
                'country_name' => $this->geolocation->country->name_en
            ];
        }
    }

    /**
     * @return array
     */
    public function getGeolocationData(): array
    {
        return $this->prepareDataForApi();
    }
}
