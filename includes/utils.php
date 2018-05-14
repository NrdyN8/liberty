<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 4/28/2018
 * Time: 9:08 AM
 */

/**
 * @param mixed ...$var
 */
function dd(...$var){
    print('<pre>');
    foreach($var as $v){
        var_dump($v);
    }
    print('</pre>');
    die;
}

function randKey(){
    $max = ceil(2);
    $random = '';
    for ($i = 0; $i < $max; $i ++) {
        $random .= md5(microtime(true).mt_rand(10000,90000));
    }
    return substr($random, 0, 64);
}

function email($buffer){
    dd("here");
    dd($buffer);

}