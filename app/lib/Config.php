<?php

/**
 * Class Config
 */
class Config
{

    /**
     * @var array
     */
    protected static $setting = array();

    /**
     * @param $Key
     * @return mixed|null
     */
    public static function get($Key)
    {
        return isset(self::$setting[$Key]) ? self::$setting[$Key] : null;
    }

    /**
     * @param $Key
     * @param $Value
     */
    public static function set($Key, $Value)
    {
        self::$setting[$Key] = $Value;
    }

}