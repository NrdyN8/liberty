<?php

class View
{
    private $data = array();
    private $render = FALSE;
    private $email;

    private $lang;

    public function __construct($template, $params = [], $email = false) {
        try {
            $file = ROOT . '/resources/views/' . strtolower($template) . '.php';

            if (file_exists($file)) {
                $this->render = $file;

                $this->email = $email;

                if(!empty($params)){
                    foreach($params as $key=>$param){
                        $this->assign($key, $param);
                    }
                }

                $this->data['view'] = $this;

                $this->lang = new i18n();
            } else {
                throw new ViewNotFoundException('Template ' . $template . ' not found!');
            }
        } catch (ViewNotFoundException $e) {
            Routes::error(500, $e->errorMessage());
        }
    }

    public function import($template){
        try {
            $file = ROOT . '/resources/views/' . strtolower($template) . '.php';

            if (file_exists($file)) {
                extract($this->data);
                include($file);
            } else {
                throw new ViewNotFoundException('Template ' . $template . ' not found!');
            }
        } catch (ViewNotFoundException $e) {
            Routes::error(500, $e->errorMessage());
        }
    }

    protected function assign($variable, $value)
    {
        $this->data[$variable] = $value;
    }

    public function __destruct()
    {
        extract($this->data);
        include($this->render);
        Session::unsetKey("old");
        Session::unsetKey("success");
    }

    static public function getView($template, $params =[]){
        return new self($template, $params);
    }

    public function _($key){
        print($this->lang->translate($key));
    }

    public function session($key){
        return Session::get($key);
    }
}