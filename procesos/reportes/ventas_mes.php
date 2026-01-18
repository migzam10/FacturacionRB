<?php
require "../../clases/Reporte.php";
require "../../clases/Conexion.php";
$obj = new Reporte();
$result = $obj->ventas_mes();

$labels = array();
$data = array();

// Recorrer los resultados de la consulta y guardarlos en los arrays
while ($fila = mysqli_fetch_assoc($result)) {
    $labels[] = "Día " . $fila['dia'];
    $data[] = $fila['total_vendido'];
}

// Imprimir los arrays como JSON para que JavaScript los pueda usar
echo json_encode(array(
    'labels' => $labels,
    'data' => $data
));
