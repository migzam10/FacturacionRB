<?php
require_once '../../clases/Producto.php';
require_once '../../clases/Conexion.php';
$id = $_POST['id_producto'];
$stock = $_POST['txtstock'];
if($stock < 0)
{
    echo "n";
}
else{
   $obj = new Producto();
    echo $obj->stock($id,$stock); 
}

?>