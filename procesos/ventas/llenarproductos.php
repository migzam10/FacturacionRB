<?php
require_once '../../clases/Conexion.php';
require_once '../../clases/Producto.php';

$obj = new Producto();
$r=$_POST['idproducto'];
if($r=="A")
{
  echo "A";
}else {
  echo json_encode($obj->traer_datos_cb($r));
}

?>
