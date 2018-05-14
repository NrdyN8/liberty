<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/5/2018
 * Time: 2:52 PM
 */

class Cookie {
    static function get($key){
        if(isset($_COOKIE[$key])){
            return $_COOKIE[$key];
        }
        return null;
    }

    static function set($key, $value, $days = 1){
        try{
            setcookie($key, $value, time() + (86400 * $days));
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    static function unsetKey($key){
        try{
            setcookie($key, "", time()-3600);
            return true;
        }
        catch (Exception $e){
            return false;
        }
    }
}