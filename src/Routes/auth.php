<?php
use App\Controllers\UserController;
use App\Config\ResponseHttp;
$method=strtolower( $_SERVER['REQUEST_METHOD']);
$route=$_GET['route'];
$params=explode('/',$route);
$data=json_decode(file_get_contents("php://input"),true);
$header=getallheaders();

$App=new UserController($method,$route,$params,$data,$header);
$App->getLogin("auth/{$params[1]}/{$params[2]}/");
echo json_encode(ResponseHttp::status400());