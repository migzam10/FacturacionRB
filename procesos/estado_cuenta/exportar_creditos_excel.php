<?php
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/EstadoCuenta.php";

header('Content-Type: application/json');

$obj = new EstadoCuenta();
$resultado = $obj->consultarCreditosPendienteGeneral();

$datos = [];

if (mysqli_num_rows($resultado) > 0) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $saldo_pendiente = $row['total'] - $row['total_pagado'];
        
        $datos[] = [
            'ID Venta' => $row['id_venta'],
            'Cliente' => $row['nombre'],
            'Fecha' => date('d/m/Y', strtotime($row['fecha'])),
            'Total Venta' => (float)$row['total'],
            'Total Pagado' => (float)$row['total_pagado'],
            'Saldo Pendiente' => (float)$saldo_pendiente
        ];
    }
}

echo json_encode($datos);
exit;
?>
