<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/4/2018
 * Time: 12:06 AM
 */

require_once('./models/user.php');

class AuthController extends Controller {

    // --- Login ---
    public function loginUserForm(){
        if(User::isAuth()){
            $this->redirect('');
        }
        return new View('auth/login');
    }

    public function loginUser(Request $request) {
        if(User::isAuth()){
            $this->redirect('');
        }
        $valid = $this->validate($request->input, [
            "username" => "required",
            "password" => "required|min:6"
        ]);

        if(!$valid){
            Session::set("old", ["error"=> "Incorrect Username or Password"]);
            $this->redirect('login');
        }

        $user = User::where('username', $request->username)->get();

        if($user->count() === 0 || $user->count() > 1){
            Session::set("old", ["error"=> "Incorrect Username or Password"]);
            $this->redirect('login');
        }

        $user = $user->first();

        if(!password_verify($request->password, $user->password)){
            Session::set("old", ["error"=> "Incorrect Username or Password"]);
            $this->redirect('login');
        }

        $user->login();

        $this->redirect('');
    }
    // --- End Login ---

    //--- Logout ---

    public function logoutUser(){
        $user = User::isAuth();
        if($user){
            $user->logout();
        }

        $this->redirect('login');
    }

    //--- End Logout ---

    //--- Registration ---
    public function registerUser(Request $request){
        if(User::isAuth()){
            $this->redirect('');
        }
        $valid = $this->validate($request->input, [
            "username" => "required",
            "email"    => "required|email",
            "password" => "required|confirm|min:6"
        ]);

        if(!$valid){
            Session::set("old", ["error"=> "Invalid email or password"]);
            $this->redirect('register');
        }

        $users = User::where('username', $request->username)->get();

        if($users->count() > 0){
            Session::set("old", ["error"=> "Username taken"]);
            $this->redirect('register');
        }

        $user = new User([
            "username"  =>  $request->username,
            "email"     =>  $request->email,
            "pass"      =>  password_hash($request->password, PASSWORD_BCRYPT)
                         ]);
        $user = $user->save();
        $user->login();

        $this->sendActivation(false);
        $this->redirect('');

    }

    public function registerUserForm(){
        if(User::isAuth()){
            $this->redirect('');
        }
        return new View("auth/register");
    }
    //--- End login ---

    //--- Activation ---

    public function sendActivation($redirect = true){
        $user = User::isAuth();
        if(!$user){
            Session::set("old", ["error"=> "Please sign in to send activation"]);
            $this->redirect('login');
        }

        $randKey = randKey();

        $user->update(['activated'=>0, 'activation_key'=>$randKey]);

        $mail= new Mail();
        $view = new EmailView('email/activation', ["activation_key"=>$randKey, "user"=>$user]);

        $mail->to($user->email)->subject("Please activate your account")->html()->message($view->render())->send();

        if($redirect)$this->redirect('');
    }

    public function activateUser(Request $request){
        if(!$request->key){
            Session::set("old", ["error"=> "Activation key not provided"]);
            $this->redirect('');
        }
        $user = User::where('activation_key', $request->key)->first();
        if(is_null($user)){
            Session::set("old", ["error"=> "Incorrect activation key provided"]);
            $this->redirect('');
        }
        if($user->activated){
            Session::set("old", ["error"=> "User already activated"]);
            $this->redirect('');
        }
        $user->update(["activated"=>true, "activation_key"=>null]);
        $this->redirect('');
    }

    //--- End Activation ---

    //--- Forgot Password ---

    public function forgotPasswordForm(){
        if(User::isAuth()){
            $this->redirect('');
        }
        return new View('auth/forgotPassword');
    }

    public function sendPasswordResetLink(Request $request){
        if(User::isAuth()){
            $this->redirect('');
        }

        if(strlen($request->username) === 0){
            Session::set("old", ["error"=> "Username not provided"]);
            $this->redirect('forgotPassword');
        }

        $user = User::where('username', $request->username)->first();

        if(is_null($user)){
            Session::set("old", ["error"=> "Username not found"]);
            $this->redirect('forgotPassword');
        }

        $randKey = randKey();

        $mail = new Mail();

        $user->update(["password_reset_key"=>$randKey]);

        $view = new EmailView('email/resetPassword', ["user"=>$user, "password_key"=>$randKey]);

        $mail->to($user->email)->subject('Password reset link')->message($view->render())->html()->send();

        Session::set('success', "Password reset sent successfully");
        $this->redirect('login');

    }

    public function resetPasswordForm(Request $request){
        if(!$request->key){
            Session::set("old", ["error"=> "Reset password key not provided"]);
            $this->redirect('login');
        }
        $user = User::where('password_reset_key', $request->key)->first();
        if(is_null($user)){
            Session::set("old", ["error"=> "Incorrect password key provided"]);
            $this->redirect('login');
        }

        return new View('auth/resetPassword', ["key"=>$request->key]);
    }

    public function resetPassword(Request $request){
        if(!$request->key){
            Session::set("old", ["error"=> "Reset password key not provided"]);
            $this->redirect('login');
        }
        $user = User::where('password_reset_key', $request->key)->first();
        if(is_null($user)){
            Session::set("old", ["error"=> "Incorrect password key provided"]);
            $this->redirect('login');
        }

        $valid = $this->validate($request->input, [
           "password"=>"required|min:6|confirm"
        ]);

        if(!$valid){
            Session::set("old", ["error"=> "Passwords do no match or are not a minimum of 6 characters"]);
            $this->redirect('resetPassword?key='.$request->key);
        }

        $user->update([
            "pass" => password_hash($request->password, PASSWORD_BCRYPT),
            "password_reset_key"=> null
                      ]);

        Session::set('success', "Password reset successful");
        $this->redirect('login');
    }

    //--- End Forgot Password ---

}