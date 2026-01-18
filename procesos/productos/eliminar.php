<?php
require_once '../../clases/Producto.php';
require_once '../../clases/Conexion.php';
$id = $_POST['id'];
$obj = new Producto();
echo $obj->delete($id);
?>