<?php
error_reporting(E_ALL);
ini_set('display_errors',true);

require_once __DIR__ .'/bootstrap.php';

use App\Receiver\CurrentWeather;
use App\View;

use function Helpers\renderException;

/**
 * Simple Example
 */

try {
    $current = new CurrentWeather(); // Get data of current weather in this geolocation

    $view = new View('weather', [
        'title' => 'Прогноз погоды',
        'current' => $current->getData(),
        'geoLocation' => $current->getGeolocationData(),
    ]);

    $view->render();

} catch (\Exception $e) {
    // if catch Exception make renderException()
    renderException($e);
}
