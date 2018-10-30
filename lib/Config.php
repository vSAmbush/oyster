<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 25.10.2018
 * Time: 14:00
 */

namespace lib;

/**
 * Class Config
 * @package lib
 *
 * Additional class for working with a config file
 */
class Config
{
    protected static $settings = [];

    /**
     * Get property by the key
     *
     * @param $key
     * @return mixed|null
     */
    public static function get($key) {
        return isset(self::$settings[$key]) ? self::$settings[$key] : null;
    }

    /**
     * Set property by the key
     *
     * @param $key
     * @param $value
     */
    public static function set($key, $value) {
        self::$settings[$key] = $value;
    }
}