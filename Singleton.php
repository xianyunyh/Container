<?php

/**
 * 单例模式
 */
class Singleton
{
    private static $_instance = '';

    private function __clone()
    {

    }

    private function __construct($config = [])
    {

    }

    public static function getInstance($config = [])
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new Singleton($config);
        }
        return self::$_instance;

    }
}

// 使用

$single  = Singleton::getInstance();
$single2 = Singleton::getInstance();

if ($single === $single2) {
    echo "这是一个单例子";
}
