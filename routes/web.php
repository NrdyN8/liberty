<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 4/28/2018
 * Time: 8:44 AM
 */

try{
    //Get Routes
    Routes::get("", "ProductsController@index");
    Routes::get("login", "AuthController@loginUserForm");
    Routes::get("logout", "AuthController@logoutUser");
    Routes::get("register", "AuthController@registerUserForm");
    Routes::get("sendActivation", "AuthController@sendActivation");
    Routes::get("activate","AuthController@activateUser");
    Routes::get("forgotPassword", "AuthController@forgotPasswordForm");
    Routes::get("resetPassword", "AuthController@resetPasswordForm");

    //Post Routes
    Routes::post("login", "AuthController@loginUser");
    Routes::post("register", "AuthController@registerUser");
    Routes::post("edit", "UserController@editUser");
    Routes::post("sendPasswordReset", "AuthController@sendPasswordResetLink");
    Routes::post("resetPassword", "AuthController@resetPassword");

    Routes::group('', function (){
        Routes::get("reset", "UserController@dump");
    });
}
catch(Exception $e){
    print($e->getMessage());
    Routes::error(500);
}