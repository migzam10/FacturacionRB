<?php
require_once '../../clases/Conexion.php';
require_once '../../clases/Venta.php';
$obj = new Venta();
$id = $_POST['id_venta'];
echo json_encode($obj->mostrar_porid($id), JSON_UNESCAPED_UNICODE);
?>