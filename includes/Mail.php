<?php
/**
 * Created by PhpStorm.
 * User: N8
 * Date: 5/6/2018
 * Time: 10:53 AM
 */

class Mail {

    private $to,
        $subject,
        $message,
        $headers;

    /**
     * Mail constructor.
     * @param array $variables
     */
    public function __construct($variables = []) {
        if(!empty($variables)){
            if(isset($variables["to"]) && filter_var($variables["to"], FILTER_VALIDATE_EMAIL)) $this->to = $variables["to"];
            if(isset($variables["subject"])) $this->subject = $variables["subject"];
            if(isset($variables["message"])) $this->message = $variables["message"];
            if(isset($variables["headers"])) $this->headers = $variables["headers"];
        }
    }

    /**
     * @param $email
     * @throws InvalidEmailException
     * @return Mail
     */
    public function to($email){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            throw new InvalidEmailException($email." is an invalid email");
        }
        $this->to = $email;
        return $this;
    }

    /**
     * @param $subject
     * @return Mail
     */
    public function subject($subject){
        $this->subject = $subject;
        return $this;
    }

    /**
     * @param $message
     * @return Mail
     */
    public function message($message){
        $this->message = $message;
        return $this;
    }

    public function header($header){
        $this->headers .= $header.'\r\n';
        return $this;
    }

    public function html(){
        $this->header('Content-type: text/html; charset=iso-8859-1');
        return $this;
    }

    /**
     *
     */
    public function send(){
        if(SERVER === 'WIN'){
            ini_set('SMTP', WIN_SMTP);
            ini_set('smtp_port', WIN_SMTP_PORT);
            ini_set('sendmail_from', WIN_SEND_FROM);
        }else{
            ini_set('sendmail_path', UNIX_SENDMAIL);
        }

        mail($this->to, $this->subject, $this->message, $this->headers);
    }

}