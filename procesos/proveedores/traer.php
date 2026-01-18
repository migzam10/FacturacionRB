<?php
require_once '../../clases/Proveedor.php';
require_once '../../clases/Conexion.php';
$id = $_GET['id_proveedor'];
$obj = new Proveedor();
echo json_encode($obj->traer($id));
?>