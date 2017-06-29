<?php

class Event {
    private $events = [];

    public function addEvent(IObserver $observer) {
        $this->events[] = $observer;
    }

    public function notify() {
        foreach ($this->events as $key => $value) {
            $value->update();
        }
    }

}