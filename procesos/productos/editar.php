<?php
require_once '../../clases/Producto.php';
require_once '../../clases/Conexion.php';
$id = $_POST['id_producto'];
$nombre = $_POST['txtnombree'];
$txtprecioc = $_POST['txtprecioce'];
$txtpreciov = $_POST['txtpreciove'];
$txtstock = $_POST['txtstocke'];
$txtproveedor = $_POST['txtproveedore'];
$txtcategoria = $_POST['txtcategoriae'];
$datos = array($id,$nombre,$txtprecioc,$txtpreciov,$txtstock,$txtproveedor,$txtcategoria);
$obj = new Producto();
echo $obj->edit($datos);
?>