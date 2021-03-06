<?php
/**
 * Класс MakeUrl
 * Подготавливает строку Url для cURL
 */

namespace App;


use function Helpers\printArray;

class MakeUrl
{

    /**
     * @var array
     */
    private $settings;

    /**
     * MakeUrl constructor.
     * @param $settings
     * @param array $data
     */
    public function __construct($settings, array $data = [])
    {
        $this->settings = $settings;

        if(!empty($data) && !empty($this->settings['parameters'])) {
            $this->settings['parameters'] = array_replace($this->settings['parameters'], (array) $data);
        } else {
            $this->settings['parameters'] = (array) $data;
        }
    }

    /**
     * @return mixed
     */
    private function parseUrl()
    {
        if(!empty($this->settings['parameters']))
        {
            foreach ($this->settings['parameters'] as $settingKey => $settingValue) {
                $templates[] = '{' . $settingKey . '}';
                $values[] = $settingValue;
            }

            return str_replace($templates, $values, $this->settings['template']);
        }

        return $this->settings['template'];
    }

    /**
     * @return mixed
     */
    public function getRequestUrl()
    {
        return $this->parseUrl();
    }

}