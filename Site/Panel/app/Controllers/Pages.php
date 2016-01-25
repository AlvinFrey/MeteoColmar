<?php

namespace Controllers;

use Core\View;
use Core\Controller;
use Helpers\SimpleCurl as Curl;

/*
 * StaticPages controller
 *
 * @author Alvin Frey
 *
 */

class Pages extends Controller{

    public function __construct(){

        parent::__construct();

    }

    public function index(){
        
        $cache = new \Helpers\SimpleCache();

        $sunriseSunset=json_decode($cache->get_data('sunrise-sunset', 'http://api.sunrise-sunset.org/json?lat=48.0833&lng=7.3667&date=today&formatted=1'), TRUE);
        $data["forecast_api"]=json_decode($cache->get_data('forecast', 'http://www.prevision-meteo.ch/services/json/colmar'), TRUE);
        //$saint=json_decode($cache->get_data('fete', 'http://fetedujour.fr/api/v2/'.FETE_API_KEY.'/json-normal'), TRUE);

        $data["title"]="Accueil";
        $data['javascript'] = array('AjaxControllers/Index/index');

        $weather = new \Models\Weather();

        $data["saintDuJour"] = $saint["name"];
        $data["last_temp"] = $weather->getLastDataByType("temperature");
        $data["last_dewPoint"] = $weather->getLastDataByType("dewPoint");
        $data["max_temp"] = $weather->getExtremumByTypeAndDate("max", "temperature", date('Y-m-d'));
        $data["min_temp"] = $weather->getExtremumByTypeAndDate("min", "temperature", date('Y-m-d'));

        $data["last_windSpeed"] = $weather->getLastDataByType("windSpeed");
        $data["last_windDir"] = $weather->getLastDataByType("windDir");
        $data["max_windSpeed"] = $weather->getExtremumByTypeAndDate("max", "windSpeed", date('Y-m-d'));
        $data["min_windSpeed"] = $weather->getExtremumByTypeAndDate("min", "windSpeed", date('Y-m-d'));

        $data["last_rainFall"] = $weather->getLastDataByType("rainFall");
        $data["sumWeek_rainFall"] = $weather->getExtremumByDateRow("sum", "rainFall", "1", "week");
        $data["sumMonth_rainFall"] = $weather->getExtremumByDateRow("sum", "rainFall", "1", "month");

        $data["last_humidity"] = $weather->getLastDataByType("humidity");
        $data["last_pressure"] = $weather->getLastDataByType("pressure");

        $data["last_uvIndex"] = $weather->getLastDataByType("uvIndex");

        $data["vigilance"] = simplexml_load_file("http://vigilance.meteofrance.com/data/NXFR33_LFPW_.xml");

        $data["sunrise_hour"] = strtotime($sunriseSunset["results"]["sunrise"]) + 3600;
        $data["sunrise_hour"] = date('G\hi\ms\s', $data["sunrise_hour"]);

        $data["sunset_hour"] = strtotime($sunriseSunset["results"]["sunset"]) + 3600;
        $data["sunset_hour"] = date('G\hi\ms\s', $data["sunset_hour"]);
        $data["day_length"] = gmdate("G\hi\ms\s", strtotime($sunriseSunset["results"]["day_length"]));

        View::renderTemplate('header', $data);
        View::render('pages/index', $data);
        View::renderTemplate('footer', $data);

    }

    public function about(){

    	$data["title"]="Présentation de la station";

        View::renderTemplate('header', $data);
        View::render('pages/about', $data);
        View::renderTemplate('footer', $data);

    }

    public function adsb(){

        $data["title"]="Trafic Aérien";

        View::renderTemplate('header', $data);
        View::render('pages/adsb', $data);
        View::renderTemplate('footer', $data);
        
    }

}
