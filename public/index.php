<?php
use App\Config\ResponseHttp;
use  App\Config\ErrorLog;

require dirname(__DIR__).'/vendor/autoload.php';

ErrorLog::ActivarLog();

if (isset($_GET['route'])){
    $url=explode('/',$_GET['route']);
    $lista=['auth','user'];
    $file=dirname(__DIR__).'/src/Routes/'.$url[0].'.php';

    if (!in_array($url[0],$lista)){
      echo json_encode( ResponseHttp::status200());
      error_log('prueba');
        exit;

    }

    if (is_readable($file)){
    require $file;
    exit;
    }else{
        echo 'El archivo no existe';
    }
}else{
echo 'no existe la variable';
exit;
}