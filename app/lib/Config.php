<?php

class Config
{

    protected static $setting = array();

    public static function get($Key)
    {
        return isset(self::$setting[$Key]) ? self::$setting[$Key] : null;
    }

    public static function set($Key, $Value)
    {
        self::$setting[$Key] = $Value;
    }

}