<?php

include_once 'class/api.php';
include_once 'class/database.php';
$database = new Database();
$db = $database->getConnection();

$api = new Api($db);



if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="Zona Privada"');
    header('HTTP/1.0 401 Unauthorized');
    print 'credenciales incorrectas.';
    exit;
} else {

echo $api->login();

}
?>