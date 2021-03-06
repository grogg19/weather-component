<?php
/**
 * class DataReceiver
 */

namespace App;

use App\Exception\ApiErrorException;
use App\MakeUrl;

/**
 * Class DataReceiver
 * @package App
 */
abstract class DataReceiver
{
    /**
     * @var string
     */
    private $apiName = '';
    private $parameters = [];

    /**
     * @return mixed
     */
    abstract public function getData();

    /**
     * Инициализация CURL,
     * запрос к серверу и получение данных в формате JSON
     * @return bool|mixed
     * @throws ApiErrorException
     */
    public function getUrlContent()
    {
        if(empty($this->getApiName())) {

            throw new ApiErrorException('Не указан идентификатор API', 400);

        }

        $ch = curl_init();

        curl_setopt_array($ch, $this->prepareCurlParameters());

        $responseData = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return ($httpcode >= 200 && $httpcode < 300) ? $responseData : false;
    }

    /**
     * Подготовка параметров для CURL
     * @return mixed|null
     */
    private function prepareCurlParameters()
    {
        $api = Config::getInstance()->getConfig('api-dev');

        $curl[CURLOPT_USERAGENT] = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        $curl[CURLOPT_RETURNTRANSFER] = 1;
        $curl[CURLOPT_CONNECTTIMEOUT] = 5;
        $curl[CURLOPT_TIMEOUT] = 5;
        $curl[CURLOPT_URL] = (new MakeUrl($api[$this->apiName], $this->parameters))->getRequestUrl();

        return $curl;
    }

    /**
     * @return string
     */
    public function getApiName(): string
    {
        return $this->apiName;
    }

    /**
     * @param string $apiName
     */
    public function setApiName(string $apiName): void
    {
        $this->apiName = $apiName;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

}
