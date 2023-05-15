<?php

namespace App\Config;

use Dotenv\Dotenv;
use Firebase\JWT\JWT;


class Security{
    final public  static function secretKey(){
        $dotenv=Dotenv::createImmutable(dirname(__DIR__,2));
        $dotenv->load();
      return $_ENV['SECRET_KEY'];
    }

    final public static function createPassword(string $pw){
        $pass=password_hash($pw,PASSWORD_DEFAULT);
        return $pass;
    }

    final public  static  function  validatePassword(String $paw,string $pwh){
        if (password_verify($paw,$pwh)){
            return true;
        }else{
            return  error_log('password invalidate');
            return false;
        }
    }

    final  public static  function  createTokenJwt(string $key,array $data){
        $payLoad=array(
            "iat"=>time(),
            "exp"=>time()+(60),
            "data"=>$data
        );

        $jwt=JWT::encode($payLoad,$key,'HS256');
        return $jwt;
    }
}