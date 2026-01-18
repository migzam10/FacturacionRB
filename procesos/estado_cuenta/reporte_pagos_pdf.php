<?php
session_start();
if (isset($_SESSION['usuario'])) {

    require_once '../../clases/Conexion.php';
    include "../../clases/fpdf/fpdf.php";
    require_once '../../clases/EstadoCuenta.php';

    $objEC = new EstadoCuenta();
    $id_venta = $_GET['id_venta']; // Recibimos el ID por URL

    // 1. Obtener datos de la venta y cliente (ajusta el método según tu clase)
    // Suponiendo que tienes un método que trae los datos de una sola venta
    $datosVenta = $objEC->obtenerDatosVentaCliente($id_venta); 
    $v = mysqli_fetch_assoc($datosVenta);

    // 2. Obtener el historial de pagos
    $pagos = $objEC->obtenerHistorialPagos($id_venta);

    $pdf = new FPDF();
    $pdf->SetTitle('Historial de Pagos - Venta #' . $id_venta, true);
    $pdf->AddPage();
    
    // --- TÍTULO PRINCIPAL ---
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, ("Comprobante de ingreso - Venta #$id_venta"), 'B', 1, 'L');
    $pdf->Ln(2);

    $pdf->SetFont('Arial', 'B', 9);
    // Fila 1
    $pdf->Cell(20, 6, "CLIENTE", 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(75, 6, ": " . strtoupper($v['nombre']), 0, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 6, "DIRECCION", 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 6, ": " . strtoupper($v['direccion']), 0, 1);

    // Fila 2
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 6, "NIT/C.C", 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(75, 6, ": " . $v['id_cliente'], 0, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 6, "FECHA VENTA", 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 6, ": " . date('d/m/Y', strtotime($v['fecha'])), 0, 1);

    // Fila 3
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 6, "TELEFONO", 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(75, 6, ": " . $v['telefono'], 0, 0);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(25, 6, "FORMA PAGO", 0, 0);
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 6, ": " . strtoupper($v['tipo']), 0, 1);

    $pdf->Ln(1);

    // --- TABLA DE PAGOS (Imagen 1) ---
    $pdf->SetFillColor(245, 245, 245); // Gris claro
    $pdf->SetFont('Arial', 'B', 10);
    
    // Encabezados con línea inferior
    $pdf->Cell(20, 10, "#", 'B', 0, 'C', true);
    $pdf->Cell(60, 10, "Fecha de Pago", 'B', 0, 'C', true);
    $pdf->Cell(50, 10, "Tipo de Pago", 'B', 0, 'C', true);
    $pdf->Cell(60, 10, "Monto", 'B', 1, 'C', true);

    $pdf->SetFont('Arial', '', 10);
    $total_sumado = 0;

    while ($row = mysqli_fetch_assoc($pagos)) {
        // Usamos 'B' para que solo pinte la línea inferior de cada fila
        $pdf->Cell(20, 9, $row['id_pago'], 'B', 0, 'C');
        $pdf->Cell(60, 9, date('d/m/Y H:i', strtotime($row['fecha'])), 'B', 0, 'C');
        $pdf->Cell(50, 9, ($row['tipo_pago']), 'B', 0, 'C');
        $pdf->Cell(60, 9, number_format($row['monto'], 2, ',', '.'), 'B', 1, 'C');
        $total_sumado += $row['monto'];
    }

    $pdf->Cell(115, 6, "", 0, 0); // Espacio
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(35, 6, "Total Venta:", 0, 0, 'R');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(30, 6, number_format($v['total'], 2, ',', '.'), 0, 1, 'R');


    $pdf->Cell(115, 6, "", 0, 0); 
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(35, 6, "Total Pagado:", 0, 0, 'R');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(30, 6, "- " . number_format($total_sumado, 2, ',', '.'), 0, 1, 'R');

    $pdf->Cell(115, 1, "", 0, 0);
    $pdf->Cell(65, 1, "", 'T', 1);

    $pdf->Cell(115, 7, "", 0, 0);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(35, 7, "Saldo Pendiente:", 0, 0, 'R');
    $pdf->Cell(30, 7, number_format($v['total'] - $total_sumado, 2, ',', '.'), 0, 1, 'R');

    $pdf->Output();
}