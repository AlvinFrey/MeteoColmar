<?php 

namespace Models;
 
use Helpers\Database;
 
class Weather{

    protected $db;
    
    public function __construct(){
        
        $this->db = Database::get();

    }

    public function getLastLightning(){

        return $this->db->select('SELECT `date`,`time`,`value` FROM weather_data WHERE `type`="lightning" ORDER BY `date` LIMIT 6');
    
    }

    //GET LAST DATA NORMALLY OR WITH TYPE

    public function getLastData(){

    	return $this->db->select('SELECT `type`, `value`, `time` FROM weather_data WHERE `date`="'.date('Y-m-d').'" ORDER BY `time` DESC LIMIT 1');

    }

    public function getLastDataByType($type){

    	return $this->db->select('SELECT `value`, `time` FROM weather_data WHERE `date`="'.date('Y-m-d').'" AND `type`="'.$type.'" ORDER BY `time` DESC LIMIT 1');

    }

    //GET ALL VALUE BY TYPE AND DATE

    public function getAllByTypeAndDate($type, $date){

        if($type!="all"){

            return $this->db->select('SELECT * FROM weather_data WHERE `type`="'.$type.'" AND `date`="'.$date.'" ORDER BY `time`');

        }else{

            return $this->db->select('SELECT * FROM weather_data WHERE `date`="'.$date.'" ORDER BY `time`');

        } 

    }

    //GET ALL WITH TYPE AND SPECIFIC MONTH

    public function getAllByTypeAndMonth($type, $month, $year, $display){

        if($type!="all"){

            if($display=="graph"){

                return $this->db->select('SELECT `date`,AVG(`value`) as moyenne FROM weather_data WHERE `type`="'.$type.'" AND MONTH(`date`)="'.$month.'" AND YEAR(`date`)="'.$year.'" GROUP BY `date`');

            }else{

                return $this->db->select('SELECT * FROM weather_data WHERE `type`="'.$type.'" AND MONTH(`date`)="'.$month.'" AND YEAR(`date`)="'.$year.'"');

            }

        }else{

            return $this->db->select('SELECT * FROM weather_data WHERE MONTH(`date`)="'.$month.'" AND YEAR(`date`)="'.$year.'"');

        }

    }

    //GET ALL WITH TYPE AND SPECIFIC YEAR

    public function getAllByTypeAndYear($type, $year, $display){

        if($type!="all"){

            if($display=="graph"){

                return $this->db->select('SELECT `date`,AVG(`value`) as moyenne FROM weather_data WHERE `type`="'.$type.'" AND YEAR(`date`)="'.$year.'" GROUP BY `date`');

            }else{

                return $this->db->select('SELECT * FROM weather_data WHERE `type`="'.$type.'" AND YEAR(`date`)="'.$year.'"'); 

            }

        }else{

            return $this->db->select('SELECT * FROM weather_data WHERE YEAR(`date`)="'.$year.'"');

        }

    }

    //GET ALL VALUE IN AN AMOUNT OF DAY / WEEK / MONTH / YEAR

    public function getAllByDateRow($amount, $filterType){

        switch ($filterType) {
            
            case 'day':
                return $this->db->select("SELECT * FROM `weather_data` WHERE `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." day"))."' AND '".date("Y-m-d")."'");
                break;

            case 'week':

                return $this->db->select("SELECT * FROM `weather_data` WHERE `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." week"))."' AND '".date("Y-m-d")."'");
                break;

            case 'month':

                return $this->db->select("SELECT * FROM `weather_data` WHERE `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." month"))."' AND '".date("Y-m-d")."'");
                break;

            case 'year':
                    
                return $this->db->select("SELECT * FROM `weather_data` WHERE `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." year"))."' AND '".date("Y-m-d")."'");
                break;

            case 'yesterday':
                return $this->db->select("SELECT * FROM `weather_data` WHERE `date` BETWEEN '".date("Y-m-d",strtotime("-1 day"))."' AND '".date("Y-m-d")."'");
                break;
            
        }

    }

    //GET ALL VALUE BETWEEN TWO DATE

    public function getAllBetweenTwoDate($date1, $date2){


        return $this->db->select("SELECT * FROM `weather_data` WHERE `date` BETWEEN '".$date1."' AND '".$date2."'");
        break;

    }

    //EXTREMUM OF THE DATE

    public function getExtremumByTypeAndDate($extremum, $type, $date){

        switch ($extremum) {
      
            case 'max':

                return $this->db->select('SELECT TRUNCATE(MAX(`value` + 0), 2) AS maximum, `date`, `time` FROM weather_data WHERE `date`="'.$date.'" AND `type`="'.$type.'"');
                break;

            case 'min':
                    
                return $this->db->select('SELECT TRUNCATE(MIN(`value` + 0), 2) AS minimum, `date`, `time` FROM weather_data WHERE `date`="'.$date.'" AND `type`="'.$type.'"');
                break;

            case 'avg':
                    
                return $this->db->select('SELECT TRUNCATE(AVG(`value` + 0), 2) AS moyenne, `date`, `time` FROM weather_data WHERE `date`="'.$date.'" AND `type`="'.$type.'"');
                break;

            case 'sum':

                return $this->db->select('SELECT TRUNCATE(SUM(`value` + 0), 2) AS somme FROM weather_data WHERE `date`="'.$date.'" AND `type`="'.$type.'"');
                break;
            
        }

    }

    //GET EXTREMUM IN AN AMOUNT OF DAY / WEEK / MONTH / YEAR

    public function getExtremumByDateRow($extremum, $type, $amount, $filterType){

        if($extremum=="max"){

            switch ($filterType) {

                case 'day':

                    return $this->db->select("SELECT TRUNCATE(MAX(`value` + 0), 2) AS maximum, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." day"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'week':

                    return $this->db->select("SELECT TRUNCATE(MAX(`value` + 0), 2) AS maximum, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." week"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'month':

                    return $this->db->select("SELECT TRUNCATE(MAX(`value` + 0), 2) AS maximum, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." month"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'year':
                        
                    return $this->db->select("SELECT TRUNCATE(MAX(`value` + 0), 2) AS maximum, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." year"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'yesterday':
                    return $this->db->select("SELECT TRUNCATE(MAX(`value` + 0), 2) AS maximum, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-1 day"))."' AND '".date("Y-m-d")."'");
                    break;

            }
                
        }else if($extremum=="min"){

            switch ($filterType) {
    
                case 'day':

                    return $this->db->select("SELECT TRUNCATE(MIN(`value` + 0), 2) AS minimum, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." day"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'week':

                    return $this->db->select("SELECT TRUNCATE(MIN(`value` + 0), 2) AS minimum, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." week"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'month':

                    return $this->db->select("SELECT TRUNCATE(MIN(`value` + 0), 2) AS minimum, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." month"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'year':
                        
                    return $this->db->select("SELECT TRUNCATE(MIN(`value` + 0), 2) AS minimum, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." year"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'yesterday':
                    return $this->db->select("SELECT TRUNCATE(MIN(`value` + 0), 2) AS minimum, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-1 day"))."' AND '".date("Y-m-d")."'");
                    break;
                
            }

        }else if($extremum=="avg"){

            switch ($filterType) {
    
                case 'day':

                    return $this->db->select("SELECT TRUNCATE(AVG(`value` + 0), 2) AS moyenne, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." day"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'week':

                    return $this->db->select("SELECT TRUNCATE(AVG(`value` + 0), 2) AS moyenne, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." week"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'month':

                    return $this->db->select("SELECT TRUNCATE(AVG(`value` + 0), 2) AS moyenne, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." month"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'year':
                        
                    return $this->db->select("SELECT TRUNCATE(AVG(`value` + 0), 2) AS moyenne, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." year"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'yesterday':
                    return $this->db->select("SELECT TRUNCATE(AVG(`value` + 0), 2) AS moyenne, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-1 day"))."' AND '".date("Y-m-d")."'");
                    break;
                
            }

        }else if($extremum=="sum"){

            switch ($filterType) {
    
                case 'day':
                
                    return $this->db->select("SELECT TRUNCATE(SUM(`value` + 0), 2) AS somme FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." day"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'week':

                    return $this->db->select("SELECT TRUNCATE(SUM(`value` + 0), 2) AS somme FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." week"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'month':

                    return $this->db->select("SELECT TRUNCATE(SUM(`value` + 0), 2) AS somme FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." month"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'year':
                        
                    return $this->db->select("SELECT TRUNCATE(SUM(`value` + 0), 2) AS somme FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-".$amount." year"))."' AND '".date("Y-m-d")."'");
                    break;

                case 'yesterday':
                    return $this->db->select("SELECT TRUNCATE(SUM(`value` + 0), 2) AS somme FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".date("Y-m-d",strtotime("-1 day"))."' AND '".date("Y-m-d")."'");
                    break;
                
            }

        }

    }

    //GET EXTREMUM BETWEEN TWO DATE

    public function getExtremumBetweenTwoDate($extremum, $type, $date1, $date2){

        switch ($extremum) {
      
            case 'max':

                return $this->db->select("SELECT TRUNCATE(MAX(`value` + 0), 2) AS maximum, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".$date1."' AND '".$date2."'");
                break;

            case 'min':
                    
                return $this->db->select("SELECT TRUNCATE(MIN(`value` + 0), 2) AS minimum, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".$date1."' AND '".$date2."'");
                break;

            case 'avg':

                return $this->db->select("SELECT TRUNCATE(AVG(`value` + 0), 2) AS moyenne, `date`, `time` FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".$date1."' AND '".$date2."'");
                break;

            case 'sum':

                return $this->db->select("SELECT TRUNCATE(SUM(`value` + 0), 2) AS somme FROM `weather_data` WHERE `type`='".$type."' AND `date` BETWEEN '".$date1."' AND '".$date2."'");
                break;
            
        }

    }

    public function sendData($postData){

        $this->db->insert("weather_data", $postData);

    }

}
