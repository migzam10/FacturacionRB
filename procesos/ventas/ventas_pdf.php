<?php
session_start();
if (isset($_SESSION['usuario'])) {

    require_once '../../clases/Conexion.php';
    include "../../clases/fpdf/fpdf.php";
    require_once '../../clases/Venta.php';
    // Recibe los datos de la tabla

    // Crear instancia de la clase Venta

    if (isset($_GET['txtfecha1']) && isset($_GET['txtfecha1'])) {
        // Obtener los detalles de la venta
        $f1 = $_GET['txtfecha1'];
        $f2 = $_GET['txtfecha2'];

        $objVenta = new Venta();

        // Obtener datos de ventas
        $resultado = $objVenta->consultar_venta($f1, $f2);
        $resultado2 = $objVenta->consultar_venta_total($f1, $f2);

        $total;
        if ($resultado2 && mysqli_num_rows($resultado2) > 0) {
            // Obtén el resultado como un arreglo asociativo.
            $total = mysqli_fetch_assoc($resultado2);
        }




        // Crear PDF
        $pdf = new FPDF();

        $pdf->SetTitle('Reportes Ventas', true);
        $pdf->AddPage();


        $pdf->setX(135);
        $pdf->Ln();


        $pdf->SetFont('Arial', 'B', 16);

        // Título del documento
        $pdf->Cell(0, 10, 'Reporte de ventas', 0, 1, 'C');
        $pdf->Cell(0, 10, $f1 . '   hasta   ' . $f2, 0, 1, 'C');
        $pdf->Ln();


        $pdf->SetFont('Arial', 'B', 12);

        // **Paso 1: Calcular anchos máximos de cada columna**
        $ancho_col = [20, 40, 35, 25, 30]; // Valores por defecto
        $datos = []; // Guardar filas para reutilizar después

        while ($fila = mysqli_fetch_row($resultado)) {
            $datos[] = $fila;

            // Calcular el ancho máximo basado en la longitud del texto
            $ancho_col[1] = max($ancho_col[1], $pdf->GetStringWidth($fila[2]) + 5);
            $ancho_col[2] = max($ancho_col[2], $pdf->GetStringWidth($fila[6]) + 5);
            $ancho_col[3] = max($ancho_col[3], $pdf->GetStringWidth(date('d/m/Y', strtotime($fila[1]))) + 5);
            $ancho_col[4] = max($ancho_col[4], $pdf->GetStringWidth(number_format($fila[4], 0, ',', '.')) + 5);
        }

        // **Paso 2: Dibujar encabezados con los anchos calculados**
        $pdf->Cell($ancho_col[0], 10, 'ID Venta', 1, 0, 'C');
        $pdf->Cell($ancho_col[1], 10, 'Cliente', 1, 0, 'C');
        $pdf->Cell($ancho_col[2], 10, 'CC/NIT', 1, 0, 'C');
        $pdf->Cell($ancho_col[3], 10, 'Fecha', 1, 0, 'C');
        $pdf->Cell($ancho_col[4], 10, 'Total', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 12);

        // **Paso 3: Dibujar las filas con los anchos ajustados**
        foreach ($datos as $fila) {
            $pdf->Cell($ancho_col[0], 10, $fila[0], 1,0,'C');
            $pdf->Cell($ancho_col[1], 10, $fila[2], 1);
            $pdf->Cell($ancho_col[2], 10, $fila[6], 1,0,'C');
            $pdf->Cell($ancho_col[3], 10, date('d/m/Y', strtotime($fila[1])), 1,0,'C');
            $pdf->Cell($ancho_col[4], 10, number_format($fila[4], 0, ',', '.'), 1,0,'R');
            $pdf->Ln();
        }

        $pdf->Ln(10);

        $pdf->setX(185);
        $pdf->Cell(5, 10, "TOTAL :  " . number_format($total['total_importe'], 2, ',', '.'), 0, 1, 'R');


        $pdf->Output();
    } else
        echo 'Sin Rango de busqueda';
}
