<?php
namespace App\Config;

date_default_timezone_set('America/Santo_Domingo');
class ErrorLog{
     public  static function ActivarLog(){
        error_reporting(E_ALL);
        ini_set('ignore_repeated_errors',true);
        ini_set('display_errors',false);
        ini_set('log_errors',true);
        ini_set('error_log',dirname(__DIR__).'/Logs/php-error.log');
}
}