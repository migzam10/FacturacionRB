<?php
require_once '../../clases/Proveedor.php';
require_once '../../clases/Conexion.php';
$id = $_POST['id_proveedor'];
$nombre = $_POST['txtnombree'];
$direccion = $_POST['txtdireccione'];
$telefono = $_POST['txttelefonoe'];
$email = $_POST['txtemaile'];
$datos = array($id,$nombre,$direccion,$telefono,$email);
$obj = new Proveedor();
echo $obj->edit($datos);
?>