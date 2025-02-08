<?php
session_start();
if (isset($_SESSION['usuario'])) {

    require_once '../../clases/Conexion.php';
    include "../../clases/fpdf/fpdf.php";
    require_once '../../clases/EstadoCuenta.php';

    $textypos=10;

    $objEC = new EstadoCuenta();

    // Obtener datos de ventas
    $resultado = $objEC->consultarCreditosPendienteGeneral();

    // Agrupar los datos por cliente
    $clientes = [];

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $id_venta = $fila['id_venta'];
        $cliente = $fila['id_cliente'];
        $nombre = $fila['nombre'];
        $telefono = $fila['telefono'];
        $direccion = $fila['direccion'];
        $fecha = $fila['fecha'];
        $total_venta = $fila['total'];
        $total_pagado = $fila['total_pagado'];
        $saldo_pendiente = $total_venta - $total_pagado;

        if (!isset($clientes[$cliente])) {
            $clientes[$cliente] = [
                'cliente' => $cliente,
                'nombre' => $nombre,
                'telefono' => $telefono,
                'direccion' => $direccion,
                'ventas' => [],
                'total_saldo' => 0
            ];
        }

        $clientes[$cliente]['ventas'][] = [
            'id_venta' => $id_venta,
            'fecha' => $fecha,
            'total_venta' => $total_venta,
            'total_pagado' => $total_pagado,
            'saldo_pendiente' => $saldo_pendiente
        ];

        $clientes[$cliente]['total_saldo'] += $saldo_pendiente;
    }

    // Crear PDF
    $pdf = new FPDF();
    $pdf->SetTitle('Reporte de Créditos Pendientes', true);
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Reporte', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 12);

    // Iterar sobre los clientes y generar el reporte
    foreach ($clientes as $cliente => $data) {
        // Encabezado del cliente
        $pdf->SetFont('Arial', 'B', 12);
        $nombre_cliente = "Cliente: " . $data['nombre'];
        $direccion_cliente = "Dir: ".$data['direccion'];
        $idC = str_repeat(" ", 10) ."CC/NIT: " . $data['cliente'];
        $teleC = str_repeat(" ", 10) ."Telefono: ".$data['telefono'];

        // Obtener el ancho del texto del nombre para ajustar la celda
        $ancho_nombre = $pdf->GetStringWidth($nombre_cliente) + 2; // Se suma un pequeño margen

        $pdf->Cell($ancho_nombre, 7, $nombre_cliente, 0, 0, 'L'); // Celda del nombre con ancho dinámico
        $pdf->Cell(0, 7, $idC, 0, 1, 'L');

       
        $pdf->Cell($ancho_nombre, 7, $direccion_cliente, 0, 0, 'L');
        $pdf->Cell(0, 7, $teleC, 0, 1, 'L');
        $pdf->Ln(2);

        // Encabezado de la tabla
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(25, 7, 'ID Venta', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Fecha', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Total Venta', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Total Pagado', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Saldo Pendiente', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);

        // Datos de las ventas del cliente
        foreach ($data['ventas'] as $venta) {
            $pdf->Cell(25, 7, $venta['id_venta'], 1, 0, 'C');
            $pdf->Cell(30, 7, date('d/m/Y', strtotime($venta['fecha'])), 1, 0, 'C');
            $pdf->Cell(40, 7, number_format($venta['total_venta'], 2, ',', '.'), 1, 0, 'R');
            $pdf->Cell(40, 7, number_format($venta['total_pagado'], 2, ',', '.'), 1, 0, 'R');
            $pdf->Cell(40, 7, number_format($venta['saldo_pendiente'], 2, ',', '.'), 1, 1, 'R');
        }

        // Total por cliente
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(135, 7, 'TOTAL:', 1, 0, 'R');
        $pdf->Cell(40, 7, number_format($data['total_saldo'], 2, ',', '.'), 1, 1, 'R');
        $pdf->Ln(5); // Espacio entre clientes
    }

    $pdf->Output();
}
