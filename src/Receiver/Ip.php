<?php
/**
 * Class Ip
 */

namespace App\Receiver;

use App\DataReceiver;
use function Helpers\printArray;

/**
 * Class Ip
 * @package App\Receiver
 */
class Ip extends DataReceiver
{
    public function __construct()
    {
        $this->setApiName('ownExternalIp');
    }

    /**
     * @return mixed
     * @throws \App\Exception\ApiErrorException
     */
    public function getData()
    {

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

            $ip = $this->getUrlContent();
        } else {
            return ['ip' => $ip];
        }

        return json_decode($ip, true);
    }

}
