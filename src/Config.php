<?php
/**
 * Class Config
 */

namespace App;

use function Helpers\arrayGet;

/**
 * Class Config
 * @package App
 */
final class Config
{
    /**
     * @var Config
     */
    private static $instance;

    /**
     * @var array
     */
    private $configs = [];

    /**
     * Config constructor.
     */
    private function __construct()
    {
        $dir = APP_DIR . "/config/";
        if($handle = opendir($dir)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    $filename = explode('.',$file);
                    if(file_exists($dir . $file) && $filename[1] = "yaml")
                    {
                        $this->configs[$filename[0]] = (new Yaml())->parseFile($dir . $file);
                    }
                }
            }
        }
    }

    /**
     * @return Config
     */
    public static function getInstance(): Config
    {
        if(null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function getConfig($key, $default = null)
    {
        return $this->configs[$key] ?? $default;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setConfig($key, $value)
    {
        $this->configs[$key] = $value;
        return $this;
    }

    /**
     * @param $config
     * @param null $default
     * @return array|mixed|null
     */
    public function get($config, $default = null)
    {
        return arrayGet($this->configs, $config, $default);
    }
}
