<?php

class ArrayHelper
{
    public static function getValue($array, $key, $default = null)
    {
        return isset($array[$key]) ? $array[$key] : $default;
    }
    
    public static function hasKey($array, $key)
    {
        return isset($array[$key]);
    }
}
