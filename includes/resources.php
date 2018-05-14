<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/2/2018
 * Time: 10:06 PM
 */

class Resources {

    static private $cssDirectory = "resources/css";
    static private $jsDirectory = "resources/scripts";


    static public function getCSS() {
        header("Content-type: text/css; charset: UTF-8");
        self::getFiles(self::$cssDirectory);
    }

    static public function getScripts(){
        header("Content-type: application/javascript; charset: UTF-8");
        self::getFiles(self::$jsDirectory);
    }

    static private function getFiles($directory){
        error_reporting(E_ERROR);
        $dir = scandir($directory);
        $file_contents ="";
        foreach($dir as $item){
            if($item === '.' || $item === '..')continue;
            $item_name = $directory.'/'.$item;
            if(is_file($item_name )){
                $file = fopen($item_name, 'r');
                $file_contents .= fread($file, filesize($item_name))."\r\n";
                fclose($file);
            }
        }
        print($file_contents);
        error_reporting(E_ALL);
        exit();
    }
}