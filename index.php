<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 4/28/2018
 * Time: 8:33 AM
 */

ob_start();

require_once('bootstrap.php');
Controller::load(Routes::getController($uri, $method));

ob_end_flush();