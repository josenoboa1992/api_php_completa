<?php
use App\Config\Security;

echo json_encode(Security::createTokenJwt(Security::secretKey(),['hola']));

//echo json_encode( Security::createPassword('hola mundo'));