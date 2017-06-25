<?php
/**
 * Created by PhpStorm.
 * User: tianlei
 * Date: 17-6-25
 * Time: 下午8:24
 */


namespace Tests;

use ReflectionClass;
use ReflectionParameter;
use ReflectionMethod;


class Container implements \ArrayAccess
{

    protected $values = [];
    protected static $_instance;

    /**
     * 绑定类到容器
     *
     * @param $key
     * @param $value
     */
    public function bind($key, $value)
    {
        $this->values['bindings'][$key] = $value;

    }

    /**
     * 获取container的单例
     *
     * @return Container
     */
    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new Container();
        }
        return self::$_instance;
    }


    public function make($key)
    {
        $class = $this->getBind($key);

        if (false == $class) {
            throw new \Exception($key . 'is not binding ');
        }
        // 判断绑定的参数是不是闭包
        if ($class instanceof \Closure) {
            return $class();
        }
        // 反射类
        $reflector = new ReflectionClass($class);

        // 没有构造
        if (null == $reflector->getConstructor()) {
            return new $class;
        }
        // 获取类的构造参数
        $constructor = $reflector->getConstructor();

        $dependencies = $constructor->getParameters();

        $results = [];

        //遍历参数
        foreach ($dependencies as $dependency) {

            //对象参数
            if (null !== $dependency->getClass()) {
                $results[] = $this->makeClass($dependency);
            }
            //普通参数 是不是有默认值
            if ($dependency->isDefaultValueAvailable()) {
                $results[] = $dependency->getDefaultValue();
            }

        }
        return $reflector->newInstanceArgs($results);

    }

    /**
     * 构造函数的对象参数
     * @param ReflectionParameter $parameter
     * @return mixed|object
     * @throws \Exception
     */
    protected function makeClass(ReflectionParameter $parameter)
    {
        try {
            return $this->make($parameter->getClass()->name);
        } catch (\Exception $e) {
            if ($parameter->isOptional()) {
                return $parameter->getDefaultValue();
            }
            throw $e;
        }
    }

    /**
     * ArrayAccess 接口方法实现
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->values['bindings'][$offset]);
    }


    /**
     * 获取binding中的值
     *
     * @param $key
     * @return null
     */
    public function getBind($key)
    {
        return ($this->offsetExists($key))?$this->values['bindings'][$key]:null;
    }
    /**
     * ArrayAccess 接口实现
     *
     * @param mixed $offset
     * @return null
     */
    public function offsetGet($offset)
    {
        if($this->offsetExists($offset)){
           return  $this->make($offset);
        }
        throw  new \Exception($offset.'is not exists');
    }

    public function offsetSet($offset, $value)
    {
        $this->values['bindings'][$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if (isset($this->values['bindings'][$offset])) {
            unset($this->values['bindings'][$offset]);
        }
    }


}

ini_set('display_errors','1');
error_reporting(2047);
require_once './C.php';

require_once './D.php';
$container = Container::getInstance();


// 绑定闭包
$container->bind('db', function () use ($container) {
    return new D();
});


//绑定类名
$container->bind('test', "Tests\\C");




// 生成实例
$test = $container->make('test');


// 数组方式方式
//$db = $container->make('db');

//var_dump($db);

