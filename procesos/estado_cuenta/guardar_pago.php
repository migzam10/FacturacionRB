<?php
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/EstadoCuenta.php";

$obj = new EstadoCuenta();

$id_venta = $_POST['id_venta'];
$monto = $_POST['monto'];
$tipo_pago = $_POST['tipo_pago'];

$resultado = $obj->registrarPago($id_venta, $monto, $tipo_pago);

if($resultado == "ok") {
    echo "ok";
} else if($resultado == "excede") {
    echo "excede";
} else {
    echo "error";
}
?>