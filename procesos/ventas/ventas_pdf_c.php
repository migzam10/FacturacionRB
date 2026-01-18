<?php
session_start();
if (isset($_SESSION['usuario'])) {

    require_once '../../clases/Conexion.php';
    include "../../clases/fpdf/fpdf.php";
    require_once '../../clases/Venta.php';
    // Recibe los datos de la tabla

    // Crear instancia de la clase Venta

    if (isset($_GET['txtfecha1']) && isset($_GET['txtfecha1']) && $_GET['txtcategoria']) {
        // Obtener los detalles de la venta
        $f1 = $_GET['txtfecha1'];
        $f2 = $_GET['txtfecha2'];
        $id_categoria = $_GET['txtcategoria'];

        $objVenta = new Venta();

        // Obtener datos de ventas
        $resultado = $objVenta->consultar_venta_c($f1, $f2, $id_categoria);

        $resultado2 = $objVenta->consultar_venta_c_total($f1, $f2, $id_categoria);
        $total;
        if ($resultado2 && mysqli_num_rows($resultado2) > 0) {
            // Obtén el resultado como un arreglo asociativo.
            $total = mysqli_fetch_assoc($resultado2);}

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
        $pdf->Cell(20, 10, 'ID Venta', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Producto', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Cantidad', 1, 0, 'C');
        $pdf->Cell(40, 10, 'V. Unidad', 1, 0, 'C');
        $pdf->Cell(40, 10, 'V. Total', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 12);
        // Iterar sobre los datos de la consulta
        while ($fila = mysqli_fetch_row($resultado)) {
            $pdf->Cell(20, 10, $fila[0], 1,0,'C');
            $pdf->Cell(40, 10, $fila[2], 1,0,'C');
            $pdf->Cell(40, 10, $fila[3], 1,0,'C');
            $pdf->Cell(40, 10, number_format($fila[4], 3, ',', '.'), 1,0,'C');
            $pdf->Cell(40, 10, number_format($fila[5], 3, ',', '.'), 1,0,'C');

            $pdf->Ln();
        }

        $pdf->Ln(10);

        $pdf->setX(185);
        $pdf->Cell(5, 1, "TOTAL :  ". number_format($total['total_importe'], 3, ',', '.'), 0, 1, 'R');

        $pdf->Output();
    } else
        echo 'Sin Rango de busqueda';
}
