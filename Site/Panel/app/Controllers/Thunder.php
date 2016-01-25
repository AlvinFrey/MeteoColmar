<?php

namespace Controllers;

use Core\View;
use Core\Controller;

/*
 * Thunder controller
 *
 * @author Alvin Frey
 *
 */

class Thunder extends Controller{

    public function __construct(){

        parent::__construct();

    }

    public function index(){

        $data["title"]="Orages";

        $data['javascript'] = array('AjaxControllers/Thunder/thunder');

        View::renderTemplate('header', $data);
        View::render('pages/thunder', $data);
        View::renderTemplate('footer', $data);

    }


    public function getLightning(){

        $weather = new \Models\Weather();

        $data["response"] = $weather->getLastLightning();

        echo json_encode($data["response"]);

    }

}

?>