<?php
require_once '../../clases/Categoria.php';
require_once '../../clases/Conexion.php';
$id = $_GET['id_categoria'];
$obj = new Categoria();
echo json_encode($obj->traer($id));
?>