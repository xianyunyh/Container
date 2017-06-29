<?php

/*
1：大厅里有100盏灯，每盏灯都编了号码，分别为1-100。每盏灯由一个开关来控制。（开关按一下，灯亮，再按一下灯灭。开关的编号与被控制的灯相同。）开始时，灯是全灭的。现在按照以下规则按动开关。
第一次，将所有的灯点亮。
第二次，将所有2的倍数的开关按一下。
第三次，将所有3的倍数的开关按一下。
以此类推。第N次，将所有N的倍数的开关按一下。
问第100次按完以后，大厅里还有几盏灯是亮的。
 */
/**
 * @author 闲云野鹤
 *
 */
class Light
{
    protected static $array; //存放灯的数组
    protected static $num; //灯的数量

    /**
     * 初始化灯 并设置灯的信号关闭 0 表示关闭 1 表示开。
     * @param $num int 灯的数量
     *
     */
    public function __construct($num = 10)
    {
        self::$array = array_fill(0, $num, 0);
        self::$num   = $num;
    }

    /**
     * 按键操作
     *
     * @param $n int 第几次
     *
     */
    public static function button($n = 1)
    {
        for ($i = 0; $i < self::$num; $i++) {
            if ($i % $n == 0) {
                self::$array[$i] = (self::$array[$i] == 1) ? 0 : 1;
            }
        }
    }

    /**
     * 获取最后亮灯的次数
     *
     */
    public static function getLight()
    {
        $num = 0;
        foreach (self::$array as $key => $value) {
            if ($value == 1) {
                $num = $num + 1;
            }
        }
        return $num;
    }
    /**
     * 开始
     *
     */
    public static function start($n)
    {
        for ($i = 1; $i <= $n; $i++) {
            self::button($n);
        }
    }
}

$light = new Light(100);
$light::button(100);
$num = $light::getLight();
echo $num;
