<?php

namespace Controllers;

use Core\View;
use Core\Controller; 
use Helpers\Csrf;    
use Helpers\Session;
use Helpers\SimpleCurl as Curl;

/*
 * Graphics controller
 *
 * @author Alvin Frey
 *
 */

class Graphics extends Controller{

    public function __construct(){

        parent::__construct();

    }

    public function index(){

    	$data["title"]="Graphiques";
        $data['csrf_token'] = Csrf::makeToken();

        $data['javascript'] = array('AjaxControllers/Graphics/graphics', 'Highcharts/highcharts', 'Highcharts/modules/exporting', 'SweetAlert/sweetalert.min');

        View::renderTemplate('header', $data);
        View::render('graphics/index', $data);
        View::renderTemplate('footer', $data);

    }

    public function searchSend(){

        $weather = new \Models\Weather();

        if(isset($_POST["day"]) && isset($_POST["month"]) && isset($_POST["year"]) && isset($_POST["type"])){

            $day = htmlspecialchars(filter_input(INPUT_POST, 'day', FILTER_SANITIZE_NUMBER_INT));
            $month =  htmlspecialchars(filter_input(INPUT_POST, 'month', FILTER_SANITIZE_NUMBER_INT));
            $year =  htmlspecialchars(filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT));
            $type = htmlspecialchars(filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING));
            $date = $year . "-" . $month . "-" . $day;

            $data["response"] = $weather->getAllByTypeAndDate($type, $date);

            echo json_encode($data["response"]);

        }else if(isset($_POST["month"]) && isset($_POST["year"]) && isset($_POST["type"])){

            $month =  htmlspecialchars(filter_input(INPUT_POST, 'month', FILTER_SANITIZE_NUMBER_INT));
            $year =  htmlspecialchars(filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT));
            $type = htmlspecialchars(filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING));

            $data["response"] = $weather->getAllByTypeAndMonth($type, $month, $year, "graph");

            echo json_encode($data["response"]);


        }else if(isset($_POST["year"]) && isset($_POST["type"])){

            $year =  htmlspecialchars(filter_input(INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT));
            $type = htmlspecialchars(filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING));

            $data["response"] = $weather->getAllByTypeAndYear($type, $year, "graph");

            echo json_encode($data["response"]);

        }

    }

}
