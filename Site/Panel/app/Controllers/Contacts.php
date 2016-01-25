<?php

namespace Controllers;

use Core\View;
use Core\Controller;  
use Helpers\Csrf;    
use Helpers\Session;

/*
 * Contacts controller
 *
 * @author Alvin Frey
 *
 */

class Contacts extends Controller{

    public function __construct(){

        parent::__construct();

    }

    public function index(){

    	$data["title"]="Contact";
        $data["main_title"]="Formulaire de contact : ";
        $data['javascript'] = array('AjaxControllers/Contacts/contact');
        $data['csrf_token'] = Csrf::makeToken();

        View::renderTemplate('header', $data);
        View::render('contacts/index', $data);
        View::renderTemplate('footer', $data);

    }

    public function messageSend(){

        if (Csrf::isTokenValid()) {

            if(isset($_POST["firstName"]) && isset($_POST["mail"]) && isset($_POST["message"])){

                $firstName = $_POST["firstName"];
                $mail =  htmlspecialchars($_POST["mail"]);
                $message =  htmlspecialchars($_POST["message"]);
                $userIp = $_SERVER["REMOTE_ADDR"];  

                $sendMail = new \Helpers\PhpMailer\Mail();
                $sendMail->setFrom($mail);
                $sendMail->addAddress("contact@meteo-colmar.fr");
                $sendMail->subject("Formulaire de contact : Message de " . $firstName . "");
                $sendMail->body($message . "<br><br> IP de l'utilisateur : " . $userIp);
                $sendMail->send();

            }

        }

    }

}
