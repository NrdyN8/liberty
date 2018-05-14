<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/3/2018
 * Time: 10:52 PM
 */

class i18n{


    private $defaultLang = "en_us";
    private $availableLanguages = ["en_us"];
    private $translations;

    public function __construct($selectedLang = "en_us") {
        $languageDirectory = ROOT.'/resources/lang';

        if(!in_array($selectedLang, $this->availableLanguages)){
            $selectedLang = $this->defaultLang;
        }
        $this->translations = json_decode(file_get_contents(realpath($languageDirectory.'/'. $selectedLang .'.json')), true);
    }

    public function translate($key) {
        return isset($this->translations[$key])?$this->translations[$key]:$key;
    }

}