<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 4/28/2018
 * Time: 10:25 AM
 */

require_once('./models/user.php');

class Controller{

    protected $isAuth = false;

    public function __construct() {
        if($this->isAuth){
            $this->user = User::isAuth();
            if((bool) !$this->user){
                Session::set('old', ["error"=>"Please login"]);
                $this->redirect('login');
            }
        }

        return true;
    }

    public static function load($controller) {
        $controller = explode('@', $controller);
        $class= $controller[0];
        $method = $controller[1];
        require_once('controllers/'.$controller[0].'.php');
        $newController = new $class();
        $newController->$method(new Request());
    }

    public function validate($input, $rules){
        $valid = true;
        foreach($rules as $key => $rule){
            foreach(explode('|', $rule) as $filter){
                if(!$valid) return $valid;
                $filter = strtolower($filter);
                if($filter === "required"){
                    $valid = isset($input[$key]) && strlen($input[$key]) > 0;
                }
                else if($filter === "email"){
                    $valid = (bool) filter_var($input[$key], FILTER_VALIDATE_EMAIL);
                }
                else if($filter === "confirm"){
                    $valid = (isset($input[$key.'_confirm']) && $input[$key]===$input[$key.'_confirm']);
                }
                else if(preg_match("/min:\d+/", $filter)){
                    $amount = explode(':', $filter)[1];
                    $valid = strlen($input[$key]) >= $amount;
                }
                else if(preg_match("/max:\d+/", $filter)){
                    $amount = explode(':', $filter)[1];
                    $valid = strlen($input[$key]) <= $amount;
                }
            }
        }
        return $valid;
    }

    public function redirect($route){
        header('Location: '.APP_URL.'/'.$route);
        exit();
    }
}