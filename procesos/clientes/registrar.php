<?php
require_once '../../clases/Cliente.php';
require_once '../../clases/Conexion.php';


$id = $_POST['txtId'];
$nombre = $_POST['txtnombre'];
$direccion = $_POST['txtdireccion'];
$telefono = $_POST['txttelefono'];
$email = $_POST['txtemail'];
$ciudad = $_POST['txtciudad'];

$datos = array($id,$nombre,$direccion,$telefono,$email,$ciudad);
$obj = new Cliente();
echo $obj->save($datos);
?>