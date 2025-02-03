<?php
require_once '../../clases/Venta.php';
require_once '../../clases/Conexion.php';
$id = $_POST['id_venta'];
$obj = new Venta();
echo $obj->anular_venta($id);
?>