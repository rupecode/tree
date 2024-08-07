<?php

namespace App\Request;

class Request
{
    /**
     * @param $key
     * @param $default
     * @return mixed
     */
    public function get($key, $default = null): mixed
    {
        return self::getValue($_REQUEST, $key, $default);
    }

    /**
     * @param $array
     * @param $key
     * @param $default
     * @return mixed
     */
    public static function getValue($array, $key, $default = null): mixed
    {
        if (!is_array($array)) {
            return $default;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        return $default;
    }
}
