<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 4/28/2018
 * Time: 10:26 AM
 */

require_once('./models/user.php');

class HomeController extends Controller{

    public function index() {
        $user = User::isAuth();

        if($user){
            return new View('home', ["user"=>$user]);
        }
        else{
            $this->redirect('login');
        }
    }

}