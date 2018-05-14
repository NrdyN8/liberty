<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/3/2018
 * Time: 9:53 PM
 */

require_once('./models/model.php');

class User extends Model {
    public $primaryKey = "user_id";

    public $fillable = [
        "username", "email", "remember_key",
        "lang_id", "pass", 'remember_key',
        'remember_key_generated', 'activated', 'activation_key', 'password_reset_key'];

    public $hidden = ['remember_key', 'remember_key_generated'];


    public function getPasswordAttribute(){
        return $this->pass;
    }

    /**
     * Logs the user in
     */
    public function login(){
        try{
            $this->update([
                              "remember_key" => randKey(),
                              "remember_key_generated" => date("Y-m-d H:i:s")
                          ]);
        }
        catch(Exception $e){
            Routes::error(500, ["message"=>$e->getMessage()]);
        }

        Session::set("auth", TRUE);
        Session::set("remember_key", $this->remember_key);
        Session::set("user_id", $this->user_id);
        Cookie::set("remember_key", $this->remember_key);
        Cookie::set("user_id", $this->user_id);
    }

    public function logout(){
        Session::unsetKey("auth");
        Session::unsetKey("remember_key");
        Session::unsetKey("user_id");
        Cookie::unsetKey("remember_key");
        Cookie::unsetKey("user_id");
    }

    /**
     * @return bool|array
     * @throws QueryNotCreatedException
     */
    static public function isAuth(){
        if(!Session::get('auth')) return false;
        $user = User::find(Session::get("user_id"));
        if(is_null($user)) return false;
        if(Session::get("remember_key") !== $user->remember_key) return false;
        return $user;
    }
}