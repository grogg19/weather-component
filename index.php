<?php
error_reporting(E_ALL);
ini_set('display_errors',true);

require_once __DIR__ .'/bootstrap.php';

use App\Receiver\CurrentWeather;
use App\Receiver\GeoLocation;
use App\Receiver\Ip;
use App\View;

use function Helpers\renderException;

/**
 * Simple Example
 */

try {
    $geolocation = new GeoLocation(new Ip());
    $current = new CurrentWeather($geolocation); // Get data of current weather in this geolocation

    $view = new View('weather', [
        'title' => 'Погода сегодня',
        'current' => $current->getData(),
        'geoLocation' => $current->getGeolocationData(),
    ]);

    $view->render();

} catch (\Exception $e) {
    // if catch Exception make renderException()
    renderException($e);
}
