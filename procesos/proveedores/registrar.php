<?php
require_once '../../clases/Proveedor.php';
require_once '../../clases/Conexion.php';
$nombre = $_POST['txtnombre'];
$direccion = $_POST['txtdireccion'];
$telefono = $_POST['txttelefono'];
$email = $_POST['txtemail'];
$datos = array($nombre,$direccion,$telefono,$email);
$obj = new Proveedor();
echo $obj->save($datos);
?>