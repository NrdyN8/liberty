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
            <div class="card-title text-center">
                <h1>Welcome <?php print($user->username); ?></h1>
            </div>
            <div class="text-center">
                <p>
                    <?php if($user->activated): ?>
                        Activated
                    <?php else: ?>
                        Not activated <a href="/sendActivation">(resend activation)</a>
                    <?php endif;?>
                </p>
            </div>
            <form class="form-inline container" action="/edit" method="post">
                <div class="row justify-content-center">
                    <div class="col-3">
                        <label class="col-form-label" for="username">Username: </label>
                    </div>
                    <div class="col-3 form-group justify-content-end">
                        <input name="username" class="disabled form-control" id="username" type="text" value="<?php print($user->username) ?>" disabled/>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-3">
                        <label class="col-form-label" for="email">Email: </label>
                    </div>
                    <div class="col-3 form-group justify-content-end">
                        <input name="email" class="disabled form-control float-right" id="email" type="text" value="<?php print($user->email) ?>" disabled/>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-3">
                        <label class="col-form-label disabled-hidden" for="email">Password: </label>
                    </div>
                    <div class="col-3 form-group justify-content-end">
                        <input name="password" class="disabled-hidden form-control" id="password" type="password" disabled aria-disabled="true"/>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-3">
                        <label class="col-form-label disabled-hidden" for="email">Confirm Password: </label>
                    </div>
                    <div class="col-3 form-group justify-content-end">
                        <input name="password_confirm" class="disabled-hidden form-control" id="password_confirm" disabled aria-disabled="true" type="password"/>
                    </div>
                    <div class="w-100"></div>
                    <button type="submit" class="btn btn-success disabled-hidden col-6" disabled>Submit</button>
                </div>
            </form>
            <button id="editUser" class="btn btn-primary float-right" >Edit</button>
        </div>
    </section>
<?php
$view->import('partials/footer');