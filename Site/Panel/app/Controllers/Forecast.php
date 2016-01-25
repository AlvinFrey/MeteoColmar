<?php

namespace Controllers;

use Core\View;
use Core\Controller; 
use Helpers\Csrf;    
use Helpers\Session;
use Helpers\SimpleCurl as Curl;

/*
 * Forecast controller
 *
 * @author Alvin Frey
 *
 */

class Forecast extends Controller{

    public function __construct(){

        parent::__construct();

    }

    public function index(){

        $cache = new \Helpers\SimpleCache();

        $forecastApi=json_decode($cache->get_data('forecast', 'http://www.prevision-meteo.ch/services/json/colmar'), TRUE);

    	$data["title"]="Prévisions";
        $data['csrf_token'] = Csrf::makeToken();

        $data["tempMin+1"] = $forecastApi["fcst_day_1"]["tmin"];
        $data["tempMax+1"] = $forecastApi["fcst_day_1"]["tmax"];
        $data["tempMin+2"] = $forecastApi["fcst_day_2"]["tmin"];
        $data["tempMax+2"] = $forecastApi["fcst_day_2"]["tmax"];
        $data["tempMin+3"] = $forecastApi["fcst_day_3"]["tmin"];
        $data["tempMax+3"] = $forecastApi["fcst_day_3"]["tmax"];
        $data["tempMin+4"] = $forecastApi["fcst_day_4"]["tmin"];
        $data["tempMax+4"] = $forecastApi["fcst_day_4"]["tmax"];

        $data["resume+1"] = $forecastApi["fcst_day_1"]["condition"];
        $data["resume+2"] = $forecastApi["fcst_day_2"]["condition"];
        $data["resume+3"] = $forecastApi["fcst_day_3"]["condition"];
        $data["resume+4"] = $forecastApi["fcst_day_4"]["condition"];

        $data["icon+1"] = $forecastApi["fcst_day_1"]["icon"];
        $data["icon+2"] = $forecastApi["fcst_day_2"]["icon"];
        $data["icon+3"] = $forecastApi["fcst_day_3"]["icon"];
        $data["icon+4"] = $forecastApi["fcst_day_4"]["icon"];

        $data['javascript'] = array('AjaxControllers/Forecast/forecast');

        View::renderTemplate('header', $data);
        View::render('forecast/index', $data);
        View::renderTemplate('footer', $data);

    }

}
