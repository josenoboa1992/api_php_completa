<?php

namespace App\Config;

class ResponseHttp
{
public static $message=array(
    'status'=>'',
    'message'=>''
);

public static function status200(string $res='ok'){
    http_response_code(200);
    self::$message['status']='ok';
    self::$message['message']=$res;
    return self::$message;
}

    public static function status201(string $res = 'Recurso creado satisfactoriamente') {
        http_response_code(201);
        self::$message['status'] = 'Created';
        self::$message['message'] = $res;
        return self::$message;
    }

    public static function status400(string $res = 'Solicitud incorrecta') {
        http_response_code(400);
        self::$message['status'] = 'Bad Request';
        self::$message['message'] = $res;
        return self::$message;
    }

    public static function status401(string $res = 'No autorizado') {
        http_response_code(401);
        self::$message['status'] = 'Unauthorized';
        self::$message['message'] = $res;
        return self::$message;
    }

    public static function status403(string $res = 'Prohibido') {
        http_response_code(403);
        self::$message['status'] = 'Forbidden';
        self::$message['message'] = $res;
        return self::$message;
    }

    public static function status404(string $res = 'No encontrado') {
        http_response_code(404);
        self::$message['status'] = 'Not Found';
        self::$message['message'] = $res;
        return self::$message;
    }

    public static function status500(string $res = 'Error interno del servidor') {
        http_response_code(500);
        self::$message['status'] = 'Internal Server Error';
        self::$message['message'] = $res;
        return self::$message;
    }
}