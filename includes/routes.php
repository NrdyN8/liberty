<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 4/28/2018
 * Time: 8:44 AM
 */

class Routes {

    private static $route = [];

    private static $routeToFollow = [];


    public static function get(String $name, String $controller) {
        self::addRoute($name, $controller, "GET");
    }


    public static function post(String $name, String $controller) {
        self::addRoute($name, $controller, "POST");
    }

    private static function addRoute(String $name, String $controller, String $method){
        $route = &self::$route;
        foreach(self::$routeToFollow as $item){
            $route[$item] = array();
            $route = &$route[$item];
        }
        $route[$method.'_'.$name]=["name"=>$name, "controller"=>$controller, "type"=>$method];
    }

    /***
     * Defines a group for routes
     *
     * @param String $groupName
     * @param callable $cb
     * @throws InvalidRouteException
     */
    public static function group(String $groupName,  callable $cb) {
        if(isset(self::$route[$groupName]))
            throw new InvalidRouteException("Route ".$groupName." has already been set");
        array_push(self::$routeToFollow, $groupName);
        $cb();
        array_pop(self::$routeToFollow);
    }


    public static function getController(array $uri, String $method){
        $route = &self::$route;

        foreach($uri as $bit){

            if(array_key_exists($method.'_'.$bit, $route)){
                return $route[$method.'_'.$bit]["controller"];
            }

            if(!array_key_exists($bit, $route)){
                $route = $route[$bit];
            }


            self::error(500, 'Route /'.implode('/', $uri).' doesn\'t exist for '.$method);
        }
    }

    public static function dump(){
        dd(self::$route);
    }

    public static function error($code, $message = ""){
        http_response_code($code);
        if($message !== ""){
            View::getView('errors/'.$code, ["error"=>$message]);
        }
        else{
            View::getView('errors/'.$code);
        }
        return exit();
    }
}



    /**
    function bootstrapRoutes(){
        include('routes/web.php');
    }

    function addRoute($method, $key, $controller){
        $this->routes[$method][$key] = $controller;
    }

    static function get($key, $controller){
        if(!isset($GLOBALS["routes"])){
            throw new VariableNotSetException("Routes variable not set");
        }

        $GLOBALS["routes"]->addRoute("GET", $key, $controller);
    }
    static function post($key, $controller){
        if(!isset($GLOBALS["routes"])){
            throw new VariableNotSetException("Routes variable not set");
        }

        $GLOBALS["routes"]->addRoute("POST", $key, $controller);
    }

    function getRoutes(){
        return $this->routes;
    }
}*/