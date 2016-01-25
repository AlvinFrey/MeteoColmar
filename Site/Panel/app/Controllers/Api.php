<?php

namespace Controllers;

use Core\View;
use Core\Controller;    
use Helpers\Session;

/*
 * Api controller
 *
 * @author Alvin Frey
 *
 */

class Api extends Controller{

    public function __construct(){

        parent::__construct();

    }

    public function index(){

    	echo "<meta charset='utf-8'></meta><b>Bienvenue sur l'API de cette station météo ! </b>";

    }

    public function arduinoFetcher(){

        if(isset($_GET)){

            if(isset($_GET['type']) && isset($_GET['value']) && isset($_GET['key'])){

                $weather = new \Models\Weather();

                $postData = array(
                    'id' => "",
                    'type' => $_GET['type'],                                 
                    'value' => $_GET['value'],                     
                );

                $weather->sendData($postData);

            }

        }

    }

}
