<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 4/28/2018
 * Time: 10:42 AM
 */

$view->import('partials/header');
?>
    <section class="card">
        <div class="card-body container">
            <div class="row justify-content-center text-center">
                <h1 class="col card-title"><?php print('Forgot Password') ?></h1>
            </div>
            <form class="row justify-content-center" action="/resetPassword" method="post">
                <input type="hidden" name="key" value="<?php print($key); ?>" >
                <div class="col-6 form-group">
                    <input name="password" class="form-control" id="password" type="password" placeholder="<?php $view->_("password") ?>" required/>
                </div>
                <div class="w-100"></div>
                <div class="col-6 form-group">
                    <input name="password_confirm" class="form-control" id="password_confirm" type="password" placeholder="<?php $view->_("passwordConfirm") ?>" required/>
                </div>
                <div class="w-100"></div>
                <button class="col-6 btn btn-primary" type="submit"><?php print("Reset password") ?></button>
            </form>
        </div>
    </section>
<?php
$view->import('partials/footer');