<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/4/2018
 * Time: 12:10 AM
 */

class Request {
    public $method;
    public $uri;
    public $time;
    public $ip;
    public $input;
    public $cookies;
    public $referrer;

    public function __get($name) {
        if(!isset($this->input[$name])){
            return $this->$name;
        }
        return $this->input[$name];
    }

    public function __construct() {
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->uri  = $_SERVER["REQUEST_URI"];
        $this->time = $_SERVER["REQUEST_TIME"];
        $this->ip = $_SERVER["REMOTE_ADDR"];
        $this->input = $_GET ?: $_POST;
        $this->cookies = $_COOKIE;
        if(isset($_SERVER["HTTP_REFERER"])){
            $this->referrer = $_SERVER["HTTP_REFERER"];
        }
    }
}