<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/11/2018
 * Time: 8:10 PM
 */

require_once('./includes/resources.php');

if($_GET["type"]==="css"){
    Resources::getCSS();
}

if($_GET["type"]==="js"){
    Resources::getScripts();
}