<?php
use App\Config\Security;
use App\Db\conectionDB;


conectionDB::getConnection();
echo json_encode(Security::createTokenJwt(Security::secretKey(),['hola']));

//echo json_encode( Security::createPassword('hola mundo'));