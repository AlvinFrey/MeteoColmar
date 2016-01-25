<?php
namespace Core;

use Helpers\Session;

/*
 * config - an example for setting up system settings
 * When you are done editing, rename this file to 'config.php'
 *
 * @author David Carr - dave@simplemvcframework.com
 * @author Edwin Hoksberg - info@edwinhoksberg.nl
 * @version 2.2
 * @date June 27, 2014
 * @date updated May 18 2015
 */
class Config
{
    public function __construct()
    {

        ob_start();

        define('DIR', 'http://meteo-colmar.fr/');

        define('DEFAULT_CONTROLLER', 'StaticPages');
        define('DEFAULT_METHOD', 'index');

        define('TEMPLATE', 'default');

        define('LANGUAGE_CODE', 'fr');

        define('DB_TYPE', 'mysql');
        define('DB_HOST', '***');
        define('DB_NAME', '***');
        define('DB_USER', '***');
        define('DB_PASS', '***');

        define('SESSION_PREFIX', 'smvc_');

        define('SITETITLE', 'Météo Colmar');

        define('SITEEMAIL', 'contact@meteo-colmar.fr');

        define('CAPTCHA_SITE_KEY', '***');
        define('CAPTCHA_SECRET_KEY', '***');

        define('NASA_API_KEY', '***');
        define('FETE_API_KEY', '***');

        set_exception_handler('Core\Logger::ExceptionHandler');
        set_error_handler('Core\Logger::ErrorHandler');

        date_default_timezone_set('Europe/London');

        Session::init();
        
    }
}
