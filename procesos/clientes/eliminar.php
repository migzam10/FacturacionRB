<?php
require_once '../../clases/Cliente.php';
require_once '../../clases/Conexion.php';
$id = $_POST['id'];
$obj = new Cliente();
echo $obj->delete($id);
?>