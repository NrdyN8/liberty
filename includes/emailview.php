<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/6/2018
 * Time: 12:18 PM
 */

class EmailView{

    public function __construct($template, $params = []) {
        try {
            $file = ROOT . '/resources/views/' . strtolower($template) . '.php';

            if (file_exists($file)) {
                $this->render = $file;

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

    protected function assign($variable, $value)
    {
        $this->data[$variable] = $value;
    }

    public function render(){
        ob_start();
        extract($this->data);
        include($this->render);
        return ob_get_clean();
    }
}