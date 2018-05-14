<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/5/2018
 * Time: 9:36 AM
 */

class Collection implements IteratorAggregate {
    public $items = [];

    public function add($item){
        array_push($this->items, $item);
        return $this;
    }

    public function count(){
        return count($this->items);
    }

    public function first(){
        if($this->count() > 0){
            return $this->items[0];
        }
        return null;
    }

    public function getIterator() {
        return new ArrayIterator($this->items);
    }
}