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
            <form class="row justify-content-center" action="/sendPasswordReset" method="post">
                <div class="col-6 form-group">
                    <input name="username" class="form-control" id="username" type="text" placeholder="<?php $view->_("username") ?>" required/>
                </div>
                <div class="w-100"></div>
                <button class="col-6 btn btn-primary" type="submit"><?php print("Send reset link") ?></button>
            </form>
        </div>
    </section>
<?php
$view->import('partials/footer');