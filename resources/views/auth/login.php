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
                <h1 class="col card-title"><?php $view->_("welcome") ?></h1>
            </div>
            <form class="row justify-content-center" action="/login" method="post">
                <?php if(!is_null($this->session("old")) && isset($this->session("old")["error"])): ?>
                    <div class="col-12 text-danger text-center">
                        <h3><?php print($this->session("old"))["error"] ?></h3>
                    </div>
                <?php endif;?>
                <div class="col-3 form-group">
                    <input name="username" class="form-control" id="username" type="text" placeholder="<?php $view->_("username") ?>" required/>
                </div>
                <div class="col-3 form-group">
                    <input name="password" class="form-control" id="password" type="password" placeholder="<?php $view->_("password") ?>" required/>
                </div>
                <div class="w-100"></div>
                <button class="col-6 btn btn-primary" type="submit"><?php $view->_("login") ?></button>
            </form>
            <div class="row justify-content-center">
                <a id="registerButton" href="/register" class="btn btn-success col-6"><?php $view->_("register")?></a>
                <div class="w-100"></div>
                <a href="/forgotPassword"><?php $view->_("forgotPassword")?></a>
            </div>
        </div>
    </section>
<?php
$view->import('partials/footer');
