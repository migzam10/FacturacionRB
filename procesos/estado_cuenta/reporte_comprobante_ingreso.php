<?php
session_start();
if (isset($_SESSION['usuario'])) {

    require_once '../../clases/Conexion.php';
    include "../../clases/fpdf/fpdf.php";
    require_once '../../clases/EstadoCuenta.php';

    $textypos=10;

    $objEC = new EstadoCuenta();

    // Obtener datos de ventas
    $resultado = $objEC->consultarComprobantesIngresos();

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
    $pdf->SetTitle('Reporte de Créditos', true);
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Reporte', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', '', 12);

    $gran_total_venta = 0;
    $gran_total_pagado = 0;
    $gran_total_saldo = 0;

foreach ($clientes as $cliente => $data) {
    // --- AJUSTE 1: ENCABEZADO TIPO FACTURA ---
    $pdf->Cell(140, 7, "", 'B', 0, 'L'); 
    $pdf->Cell(0, 7, "", 'B', 1, 'R');

    // --- AJUSTE 2: COLUMNAS FIJAS PARA ALINEACIÓN PERFECTA ---
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 6, "CLIENTE", 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(70, 6, ": " . strtoupper($data['nombre']), 0, 0); // Ancho fijo de 70
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 6, "NIT/C.C", 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 6, ": " . $data['cliente'], 0, 1);

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 6, "DIRECCION", 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(70, 6, ": " . strtoupper($data['direccion']), 0, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 6, "TELEFONO", 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 6, ": " . $data['telefono'], 0, 1);
    $pdf->Ln(5);

    // --- AJUSTE 3: ENCABEZADO DE TABLA CON FONDO GRIS ---
    $pdf->SetFillColor(245, 245, 245);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(25, 8, 'ID Venta', 'B', 0, 'C', true);
    $pdf->Cell(30, 8, 'Fecha', 'B', 0, 'C', true);
    $pdf->Cell(45, 8, 'Total Venta', 'B', 0, 'R', true);
    $pdf->Cell(45, 8, 'Total Pagado', 'B', 0, 'R', true);
    $pdf->Cell(0, 8, 'Saldo Pendiente', 'B', 1, 'R', true);

    $pdf->SetFont('Arial', '', 10);

    $sum_venta = 0;
    $sum_pagado = 0;
    $sum_saldo = 0;

    // Datos con borde 'B' (Solo línea inferior)
    foreach ($data['ventas'] as $venta) {
        $pdf->Cell(25, 8, $venta['id_venta'], 'B', 0, 'C');
        $pdf->Cell(30, 8, date('d/m/Y', strtotime($venta['fecha'])), 'B', 0, 'C');
        $pdf->Cell(45, 8, number_format($venta['total_venta'], 2, ',', '.'), 'B', 0, 'R');
        $pdf->Cell(45, 8, number_format($venta['total_pagado'], 2, ',', '.'), 'B', 0, 'R');
        $pdf->Cell(0, 8, number_format($venta['saldo_pendiente'], 2, ',', '.'), 'B', 1, 'R');

        $sum_venta += $venta['total_venta'];
        $sum_pagado += $venta['total_pagado'];
        $sum_saldo += $venta['saldo_pendiente'];
    }

    // Resumen Final
    $pdf->Ln(2);
    $pdf->Cell(25, 8, '', '', 0, 'C');
    $pdf->Cell(30, 8, '', '', 0, 'C');
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(45, 10, number_format($sum_venta, 2, ',', '.'), 0, 0, 'R');
    $pdf->Cell(45, 10, number_format($sum_pagado, 2, ',', '.'), 0, 0, 'R');
    $pdf->Cell(45, 10, number_format($sum_saldo, 2, ',', '.'), 0, 1, 'R');

    $gran_total_venta += $sum_venta;
    $gran_total_pagado += $sum_pagado;
    $gran_total_saldo += $sum_saldo;


    $pdf->Ln(10); // Espacio para el siguiente cliente
}

    $pdf->Ln(5);
    $pdf->SetFillColor(230, 230, 230); // Un gris un poco más oscuro para resaltar
    $pdf->SetFont('Arial', 'B', 11);

    // Etiqueta de Gran Total
    $pdf->Cell(25 + 30, 12, 'GRAN TOTAL REPORTE:', 'T', 0, 'R', true);
    // Sumatorias globales alineadas
    $pdf->Cell(45, 12, number_format($gran_total_venta, 2, ',', '.'), 'T', 0, 'R', true);
    $pdf->Cell(45, 12, number_format($gran_total_pagado, 2, ',', '.'), 'T', 0, 'R', true);
    $pdf->Cell(45, 12, number_format($gran_total_saldo, 2, ',', '.'), 'T', 1, 'R', true);

    $pdf->Output();
}
