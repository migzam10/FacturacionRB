<?php
session_start();
$index = $_POST['ind'];
unset($_SESSION['tablacomprastemp'][$index]);
$datos=array_values($_SESSION['tablacomprastemp']);
unset($_SESSION['tablacomprastemp']);
$_SESSION['tablacomprastemp']=$datos;

?>


gabriel|| juan

jorge || brad