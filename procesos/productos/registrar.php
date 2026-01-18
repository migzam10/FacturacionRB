<?php
require_once '../../clases/Producto.php';
require_once '../../clases/Conexion.php';
$nombre = $_POST['txtnombre'];
$txtprecioc = $_POST['txtprecioc'];
$txtpreciov = $_POST['txtpreciov'];
$txtstock = $_POST['txtstock'];
$txtproveedor = $_POST['txtproveedor'];
$txtcategoria = $_POST['txtcategoria'];
$datos = array($nombre,$txtprecioc,$txtpreciov,$txtstock,$txtproveedor,$txtcategoria);
$obj = new Producto();
echo $obj->save($datos);
?>