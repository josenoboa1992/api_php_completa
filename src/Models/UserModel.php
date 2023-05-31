<?php

namespace App\Models;

use App\Config\ResponseHttp;
use App\Config\Security;
use App\Db\conectionDB;
use App\Db\Sql;

class UserModel extends conectionDB {
    private static string $nombre;
    private static  string $dni;
    private static string $correo;
    private static string $rol;
    private static string $password;
    private static  string $IDToken;
    private static string $fecha;

    public function __construct(array $data)
    {
        self::$nombre=$data['name'];
        self::$dni=$data['dni'];
        self::$correo=$data['email'];
        self::$rol=$data['rol'];
        self::$password=$data['password'];
    }
    //metodos get
    final public static function getName(){ return self::$nombre;}
    final public  static  function getDni(){return self::$dni;}
    final public  static  function getEmail(){return self::$correo;}
    final public  static  function  getRol(){return self::$rol;}
    final public  static  function getPassword(){return self::$password;}
    final public static  function getIDToken(){return self::$IDToken;}
    final public static function getDate(){return self::$fecha;}

    //metodos set

    final public static function  setName(string $name){ self::$nombre=$name;}
    final public static function  setDni(string $dni){ self::$dni=$dni;}
    final   public  static function setEmail(string $correo){self::$correo=$correo;}
    final public static function  setRol(string $rol){self::$rol=$rol;}
    final public static function setPassword(string $password){ self::$password=$password;}
    final   public static function setIDToken(string $IDToken){self::$IDToken=$IDToken;}
    final public static  function  setDate(string $fecha){self::$fecha=$fecha;}

    final public  static  function login(){
        try {
            $con=self::getConnection()->prepare("SELECT * FROM usuario WHERE correo=:correo");
            $con->execute([
                ':correo'=>self::getEmail()
            ]);
            if ($con->rowCount()==0){
               return ResponseHttp::status400('Usuario o password invalido');
            }else{
                foreach ($con as $res){

                    if (Security::validatePassword(self::getPassword(),$res['password'])){
                        $payLoad=['IDToken'=>$res['IDToken']];
                        $token=Security::createTokenJwt(Security::secretKey(),$payLoad);
                        $data=[
                            'name'=>$res['nombre'],
                            'rol'=>$res['rol'],
                            'toke'=>$token
                        ];

                        return ResponseHttp::status200($data);
                        exit;
                    }else{

                        return ResponseHttp::status400('Usuario o password invalido');
                    }
                }
            }
        }catch (\PDOException $e){
                error_log('UserModel::Login->'.$e);
                die(json_encode(ResponseHttp::status500()));
        }
    }

    final  public static function getAll(){
        try {
            $con=self::getConnection();
            $query=$con->prepare("SELECT * FROM usuario");
            $query->execute();
            $rs['data']=$query->fetchAll(\PDO::FETCH_ASSOC);
            return $rs;
        }catch (\PDOException   $e){
            error_log('UserModel::getAll->'.$e);
            die(json_encode(ResponseHttp::status500('No se pueden obtener los datos')));
        }
    }
    final public static function post(){
        if (Sql::exists("SELECT dni FROM usuario WHERE dni=:dni",":dni",self::getDni())){
            return ResponseHttp::status401('El DNI ya esta registrado');
        }else if(Sql::exists("SELECT correo FROM usuario WHERE correo =:correo",":correo",self::getEmail())){
            return  ResponseHttp::status400("El correo ya esta registrado");
        }else{
            self::setIDToken(hash('sha512',self::getDni().self::getEmail()));
            self::setDate(date("d-m-y h:i:s"));

            try {
                $con=self::getConnection();
                $query1="INSERT INTO usuario (nombre,dni,correo,rol,password,IDToken,fecha) VALUES";
                $query2="(:nombre,:dni,:correo,:rol,:password,:IDToken,:fecha)";
                $query =$con->prepare($query1.$query2);
                $query->execute([
                    ':nombre'=>self::getName(),
                    ':dni'=>self::getDni(),
                    ':correo'=>self::getEmail(),
                    ':rol'=>self::getRol(),
                    ':password'=>Security::createPassword(self::getPassword()),
                    ':IDToken'=>self::getIDToken(),
                    ':fecha'=>self::getDate()

                ]);

                if ($query->rowCount() > 0){
                    return ResponseHttp::status200('Usuario Registrado con Exito');
                }else{
                    return  ResponseHttp::status500('El suario no fue registrado');
                }


            }catch(\PDOException $e){
                    error_log('UserModel::post->'.$e);
                    die(json_encode(ResponseHttp::status500()));
            }
        }
    }
}