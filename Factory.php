<?php

interface Factory
{

    public static function create();
}
/**
 * 工厂模式
 */
class Factory
{
    public static function create($type = '')
    {
        switch ($type) {
            case 'mysql':
                return new Mysql();
                break;
            case 'mysqli':
                return new Mysqli();
                break;
            default:
                break;
        }

    }
}

$mysql  = Factory::create('mysql');
$mysqli = Factory::create('mysqli');
