<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
session_start();
require_once '../../clases/Usuario.php';
require_once '../../clases/Conexion.php';
$usuario = $_POST['inputEmail'];
$clave = $_POST['inputPassword'];
$datos = array($usuario,$clave);
$obj = new Usuario();
echo $obj->login($datos);
