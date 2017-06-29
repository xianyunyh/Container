<?php
/**
 * @author 闲云野鹤
 */
interface IObserver {

    public function update();
}

/**
 * @author
 */
class Observer implements IObserver {

    public function update() {
        echo "this is test";
    }
}

?>