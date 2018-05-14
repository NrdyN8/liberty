<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 4/28/2018
 * Time: 8:37 AM
 */

class Session{
    static function start(){
        session_start();
    }

    static function get($key){
        if(!isset($_SESSION)) Routes::error(500, 'Bootstrap didn\'t run');
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        return null;
    }

    static function set($key, $value){
        try{
            $_SESSION[$key]=$value;
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    static function unsetKey($key){
        try{
            unset($_SESSION[$key]);
            return true;
        }
        catch (Exception $e){
            return false;
        }
    }

    static function destroy() {
        session_destroy();
    }
}