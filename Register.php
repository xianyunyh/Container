<?php

class Register
{
    protected static $array = [];

    public static function set($alias, $class)
    {
        self::$array[$alias] = $class;

    }

    public static function get($alias)
    {
        return self::$array[$alias];
    }

    public static function delete($alias)
    {
        if (isset(self::$array[$alias])) {
            unset(self::$array[$alias]);
        }
    }
}
