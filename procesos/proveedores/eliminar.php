<?php
require_once '../../clases/Proveedor.php';
require_once '../../clases/Conexion.php';
$id = $_POST['id'];
$obj = new Proveedor();
echo $obj->delete($id);
?>