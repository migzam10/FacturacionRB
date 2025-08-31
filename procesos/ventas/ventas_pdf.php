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
            $total = mysqli_fetch_assoc($resultado2);}




        // Crear PDF
        $pdf = new FPDF();

        $pdf->SetTitle('Reportes Ventas', true);
        $pdf->AddPage();

        $pdf->AddFont('PlayfairDisplay-Bold', '', "PlayfairDisplay-Bold.php");
        $pdf->AddFont('PlayfairDisplay-Regular', '', "PlayfairDisplay-Regular.php");

        $pdf->setX(135);
        $pdf->Ln();


        $pdf->SetFont('PlayfairDisplay-Bold', '', 16);

        // Título del documento
        $pdf->Cell(0, 10, 'Reporte de ventas', 0, 1, 'C');
        $pdf->Cell(0, 10, $f1 . '   hasta   ' . $f2, 0, 1, 'C');
        $pdf->Ln();


        $pdf->SetFont('PlayfairDisplay-Bold', '', 12);
        $pdf->Cell(20, 10, 'ID Venta', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Cliente', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Identificacion', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Fecha', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Total', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('PlayfairDisplay-Regular', '', 12);
        // Iterar sobre los datos de la consulta
        while ($fila = mysqli_fetch_row($resultado)) {
            $pdf->Cell(20, 10, $fila[0], 1);
            $pdf->Cell(40, 10, $fila[2], 1);
            $pdf->Cell(40, 10, $fila[6], 1);
            $pdf->Cell(60, 10, $fila[1], 1);
            $pdf->Cell(30, 10, number_format($fila[4], 0, ',', '.'), 1);

            $pdf->Ln();
        }
        $pdf->Ln(10);

        $pdf->setX(185);
        $pdf->Cell(5, $textypos, "TOTAL :  ". number_format($total['total_importe'], 2, ',', '.'), 0, 1, 'R');


        $pdf->Output();
    } else
        echo 'Sin Rango de busqueda';
}
