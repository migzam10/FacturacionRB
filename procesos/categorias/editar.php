<?php
require_once '../../clases/Categoria.php';
require_once '../../clases/Conexion.php';

$nombre = $_POST['txtnom'];
$id = $_POST['id_categoriaa'];
$datos = array($id,$nombre);
$obj = new Categoria();
echo $obj->edit($datos);
?>