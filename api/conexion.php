<?php

class Conexion extends PDO
{
    private $servidor = 'localhost';
    private $basededatos = 'crm';
    private $usuario = 'root';
    private $password = '.abc123.';

    public function __construct()
    {
        try{
            parent::__construct('mysql:host=' . $this->servidor . ';dbname=' . $this->basededatos . ';charset=utf8', $this->usuario, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch(PDOException $e){
            echo 'Error: ' . $e->getMessage();
            exit;
        }
    }
}

?>