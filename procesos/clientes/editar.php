<?php
require_once '../../clases/Cliente.php';
require_once '../../clases/Conexion.php';
$id = $_POST['id_cliente'];
$nombre = $_POST['txtnombree']; // Cambiar a 'txtnombree'
$direccion = $_POST['txtdireccione']; // Cambiar a 'txtdireccione'
$telefono = $_POST['txttelefonoe']; // Cambiar a 'txttelefonoe'
$email = $_POST['txtemaile']; // Cambiar a 'txtemaile'
$ciudad = $_POST['txtciudad'];
$datos = array($id,$nombre,$direccion,$telefono,$email,$ciudad);
$obj = new Cliente();
echo $obj->edit($datos);
?>