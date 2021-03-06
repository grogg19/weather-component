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

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $firstSectorIp = explode(".",$ip)[0];

        // Если IP частной сети, получим внешний IP
        if (in_array($firstSectorIp, [192, 172, 127, 0]) === true) {
            $this->ip = $this->getUrlContent();
        } else {
            $this->ip = $ip;
        }
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return json_decode($this->ip, true);
    }
}
