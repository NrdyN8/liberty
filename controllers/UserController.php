<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 4/28/2018
 * Time: 12:19 PM
 */

class UserController extends Controller{
    protected $isAuth = true;

    public function editUser(Request $request){

        $user = User::isAuth();

        if(!$user){
            Session::set("old", ["error"=> "Must be logged in to edit your user"]);
            $this->redirect('login');
        }

        $users = User::where('username', $request->username)->get();

        if($users->count() > 1 || ($users->count() === 1 && $users->first()->username !== $user->username)){
            Session::set("old", ["error"=> "Username taken"]);
            $this->redirect('');
        }

        $validator = [
            "username" => "required",
            "email" => "required|email"
        ];

        $editPassword = strlen($request->password) > 0;

        if($editPassword){
            $validator["password"] = "required|min:6|confirm";
        }

        $valid = $this->validate($request->input, $validator);

        if(!$valid){
            Session::set("old", ["error"=> "Invalid username, email, or password"]);
            $this->redirect('');
        }

        $user->update(["email"=>$request->email, "username"=>$request->username]);

        if($editPassword){
            $user->update(["pass"=>password_hash($request->password, PASSWORD_BCRYPT)]);
        }

        Session::set("success", "Successfully edited user!");
        $this->redirect("");
    }

}