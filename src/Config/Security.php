<?php

namespace App\Config;

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class Security{
    private static $jwt_data;
    final public  static function secretKey(){
        $dotenv=Dotenv::createImmutable(dirname(__DIR__,2));
        $dotenv->load();
      return $_ENV['SECRET_KEY'];
    }

    final public static function createPassword(string $pw){
        $pass=password_hash($pw,PASSWORD_DEFAULT);
        return $pass;
    }

    final public  static  function  validatePassword(string $paw,string $pwh){
        if (password_verify($paw,$pwh)){
            return true;
        } else {
             error_log('password invalidate');
            return false;
        }
    }

    final public static function createTokenJwt(string $key, array $data) {
        $payload = array(
            'iat' => time(),
            'exp' => time() + (60 * 60),
            'data' => $data
        );


        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }

    final public static function validateTokenJwt($token, string $key) {
        if (!isset($token['Authorization'])) {
            die(json_encode(ResponseHttp::status400('Sin autorizacion')));
            exit;
        }
        if (empty($token['Authorization'])){
            die(json_encode(ResponseHttp::status400('Su Autorizacion es invalida')));
        }
        try {
            $jwt = explode(" ", $token['Authorization']);
            $data = JWT::decode($jwt[1],new Key($key,'HS256'));

            self::$jwt_data = $data;
            return $data;
            exit;
        } catch (\Exception $e) {
            error_log('Token invalido o expirado' . $e);
            die(json_encode(ResponseHttp::status401('Token invalido o expirado')));
        }
    }

    final public  static  function getDataJwt(){
        $jwt_decoded_array=json_decode(json_encode(self::$jwt_data),true);
        return $jwt_decoded_array;
    }
}