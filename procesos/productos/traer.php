<?php
require_once '../../clases/Producto.php';
require_once '../../clases/Conexion.php';
$id = $_GET['id_producto'];
$obj = new Producto();
echo json_encode($obj->traer($id));
?>