<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;

class PHPMailer_Library
{
    public function __construct()
    {
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){

        require_once(APPPATH."third_party/phpmail/src/PHPMailer.php");
        require_once(APPPATH."third_party/phpmail/src/SMTP.php");
        require_once(APPPATH."third_party/phpmail/src/POP3.php");
        require_once(APPPATH."third_party/phpmail/src/Exception.php");
   
        $objMail = new PHPMailer();
        return $objMail;
    }



    public function mailtodb(){

         require_once(APPPATH."third_party/phpmail/class.emailtodb.php");

         $objMail = new EMAIL_TO_DB();

         return $objMail;
    }
}