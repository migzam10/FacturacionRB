<?php
session_start();
if (isset($_SESSION['usuario'])) {

    require_once '../../clases/Conexion.php';
    include "../../clases/fpdf/fpdf.php";
    require_once '../../clases/EstadoCuenta.php';
    // Recibe los datos de la tabla

    // Crear instancia de la clase Venta


        $objEC = new EstadoCuenta();

        // Obtener datos de ventas
        $resultado = $objEC->consultarCreditosPendienteGeneral();

        $resultado2 = $objEC->consultarCreditosTotal();
        $total;
        if ($resultado2 && mysqli_num_rows($resultado2) > 0) {
            // Obtén el resultado como un arreglo asociativo.
            $total = mysqli_fetch_assoc($resultado2);}

        // Crear PDF
        $pdf = new FPDF();

        $pdf->SetTitle('Reporte', true);
        $pdf->AddPage();


        $pdf->setX(135);
        $pdf->Ln();


        $pdf->SetFont('Arial', 'B', 16);

        // Título del documento
        $pdf->Cell(0, 10, 'Reporte', 0, 1, 'C');

        $pdf->Ln();


        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, 'ID Venta', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Cliente', 1, 0, 'C');
        $pdf->Cell(25, 10, 'Fecha', 1, 0, 'C');
        $pdf->Cell(35, 10, 'Total Venta', 1, 0, 'C');
        $pdf->Cell(35, 10, 'Total Pagado', 1, 0, 'C');
        $pdf->Cell(35, 10, 'Saldo Pendiente', 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 12);
        // Iterar sobre los datos de la consulta
        while ($fila = mysqli_fetch_row($resultado)) {
            $pdf->Cell(20, 10, $fila[0], 1,0,'C');
            $pdf->Cell(40, 10, $fila[1], 1,0,'C');
            $pdf->Cell(25, 10, date('d/m/Y', strtotime($fila[2])), 1,0,'C');
            $pdf->Cell(35, 10, number_format($fila[3], 2, ',', '.'), 1,0,'C');
            $pdf->Cell(35, 10, number_format($fila[4], 2, ',', '.'), 1,0,'C');
            $pdf->Cell(35, 10, number_format($fila[5], 2, ',', '.'), 1,0,'C');

            $pdf->Ln();
        }

        $pdf->Ln(10);

        $pdf->setX(185);
        $pdf->Cell(5, $textypos, "TOTAL :  ". number_format($total['saldo_pendiente'], 3, ',', '.'), 0, 1, 'R');

        $pdf->Output();
   
}
