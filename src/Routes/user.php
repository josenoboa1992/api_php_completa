<?php
use App\Controllers\UserController;
use App\Config\ResponseHttp;


$method=strtolower($_SERVER['REQUEST_METHOD']);
$route=$_GET['route'];
$params=explode('/',$route);
$data=json_decode(file_get_contents("php://input"),true);
$header=getallheaders();

$app= new UserController($method,$route,$params,$data,$header);
$app->getAll('user/');
$app->post('user/');

echo json_encode(ResponseHttp::status400());