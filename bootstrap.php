<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 4/28/2018
 * Time: 8:34 AM
 */

const ROOT = __DIR__;
const APP_URL = "http://liberty.test";
const WIN_SMTP = 'smtp.gmail.com';
const WIN_SMTP_PORT = '587';
const WIN_SEND_FROM = 'nathan@haletek.com';
const UNIX_SENDMAIL = 'sendmail -i -t';


if(strtoupper((substr(PHP_OS, 0, 3)) === 'WIN')){
    define('SERVER', 'WIN');
}else{
    define('SERVER', 'UNIX');
}

require_once('includes/utils.php');//Move to end after development
require_once('includes/i18n.php');//First to load
require_once('includes/errors.php');
require_once('includes/session.php');
require_once('includes/cookie.php');
require_once('includes/resources.php');
require_once('includes/collection.php');
require_once('includes/view.php');
require_once('includes/emailview.php');
require_once('includes/request.php');
require_once('controllers/controller.php');
require_once('includes/routes.php');
require_once('includes/mail.php');//Last to load

Session::start();

require_once('./routes/web.php');

$uri = isset($_GET["page"])?explode('/', $_GET["page"]):[""];

$method = $_SERVER['REQUEST_METHOD'];
