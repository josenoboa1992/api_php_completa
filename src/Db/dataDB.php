<?php
use Dotenv\Dotenv;
use App\Db\conectionDB;

$dotenv=Dotenv::createImmutable(dirname(__DIR__,2));
$dotenv->load();
$data=array(
  'user'=>$_ENV['USER'],
  'pass'=>$_ENV['PASSWORD'],
  'db'=>$_ENV['DB'],
  'host'=>$_ENV['IP'],
    'port'=>$_ENV['PORT']
);

$dsn = 'mysql:host=' . $data['host'] . ';port=' . $data['port'] . ';dbname=' . $data['db'];
conectionDB::from($dsn, $data['user'], $data['pass']);