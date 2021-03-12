<?php
/**
 * Class Ip
 */

namespace App\Receiver;

use App\DataReceiver;

/**
 * Class Ip
 * @package App\Receiver
 */
class Ip extends DataReceiver
{
    private $ip;

    /**
     * Ip constructor.
     * @throws \App\Exception\ApiErrorException
     */
    public function __construct()
    {
        $this->setApiName('ownExternalIp');

        $ip = $this->getIpAddress();

        $firstSectorIp = explode(".", $ip)[0];

        // Если IP частной сети, получим внешний IP
        if (in_array($firstSectorIp, [192, 172, 127, 0]) === true) {
            $this->ip = $this->getUrlContent()->ip;
        } else {
            $this->ip = $ip;
        }
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->ip;
    }

    /**
     * @return mixed
     */
    private function getIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $ip = $_SERVER['HTTP_CLIENT_IP'];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }

        return $ip = $_SERVER['REMOTE_ADDR'];
    }
}
