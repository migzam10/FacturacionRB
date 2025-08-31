<?php
session_start();
if (isset($_SESSION['usuario'])) {

    //require_once '../clases/Venta.php';
    require_once '../../clases/Conexion.php';
    include "../../clases/fpdf/fpdf.php";

    if (isset($_GET['id_venta'])) {
        // Obtener los detalles de la venta
        $idVenta = $_GET['id_venta'];

        $c = new Conexion();
        $conexion = $c->conectar();
        $sql = "SELECT de.id_productos, de.cantidad, de.precio,de.importe 
            FROM detalle_ventas AS de WHERE de.id_ventas = $idVenta";

        $result = mysqli_query($conexion, $sql);



        $sqlCliente = "SELECT DISTINCT v.id_venta,v.fecha, v.tipo, c.*, v.total 
                    FROM ventas AS v 
                    INNER JOIN cliente AS c ON v.id_cliente=c.id_cliente 
                    WHERE v.id_venta = $idVenta";



        $resultCliente = mysqli_query($conexion, $sqlCliente);


        $pdf = new FPDF($orientation = 'P', $unit = 'mm');
        $pdf->SetTitle('Orden  ' . $idVenta, true);

        $pdf->AddPage();

       

        // Agregamos los datos del cliente
        // Verifica si hay resultados
        if (mysqli_num_rows($resultCliente) > 0) {
            // Obtiene la primera fila del resultado
            $fila = mysqli_fetch_assoc($resultCliente);

            // Captura los valores en variables
            $id_venta = $fila["id_venta"];
            $fecha = $fila["fecha"];
            $cliente = $fila["nombre"];
            $id_cliente = $fila["id_cliente"];
            $direccion = $fila["direccion"];
            $email = $fila["email"];
            $telefono = $fila["telefono"];
            $f_pago  = $fila["tipo"];
            $ciudad = $fila["ciudad"];
            //$total = $fila["total"];
            // Aquí puedes usar las variables como desees
            //echo "ID Venta: $id_venta, Fecha: $fecha, Cliente: $cliente, Número: $numero, Total: $total";


            $pdf->SetFont('Arial', 'B', 10);
            $pdf->setY(4);
            $pdf->setX(10);
            $pdf->Cell(5, $textypos, "ORDEN NO. $id_venta");

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->setY(10);
            $pdf->setX(10);
            $pdf->Cell(5, $textypos, "CLIENTE");
            $pdf->SetFont('Arial', '', 10);
            $pdf->setY(10);
            $pdf->setX(33);
            $pdf->Cell(5, $textypos, ":  ".$cliente);

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->setY(15);
            $pdf->setX(10);
            $pdf->Cell(5, $textypos, "NIT/C.C");
            $pdf->SetFont('Arial', '', 10);
            $pdf->setY(15);
            $pdf->setX(33);
            $pdf->Cell(5, $textypos, ":  ".$id_cliente);

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->setY(20);
            $pdf->setX(10);
            $pdf->Cell(5, $textypos, "TELEFONO");
            $pdf->SetFont('Arial', '', 10);
            $pdf->setY(20);
            $pdf->setX(33);
            $pdf->Cell(5, $textypos, ":  ".$telefono);

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->setY(10);
            $pdf->setX(80);
            $pdf->Cell(5, $textypos, "DIRECCION");
            $pdf->SetFont('Arial', '', 10);
            $pdf->setY(10);
            $pdf->setX(105);
            $pdf->Cell(5, $textypos, ":  ".$direccion);

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->setY(15);
            $pdf->setX(80);
            $pdf->Cell(5, $textypos, "CIUDAD");
            $pdf->SetFont('Arial', '', 10);
            $pdf->setY(15);
            $pdf->setX(105);
            $pdf->Cell(5, $textypos, ":  ".$ciudad);
            
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->setY(20);
            $pdf->setX(80);
            $pdf->Cell(5, $textypos, "CORREO");
            $pdf->SetFont('Arial', '', 10);
            $pdf->setY(20);
            $pdf->setX(105);
            $pdf->Cell(5, $textypos, ":  ".$email);

            
            
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->setY(10);
            $pdf->setX(150);
            $pdf->Cell(5, $textypos, "Fecha: $fecha");
            $pdf->setY(15);
            $pdf->setX(150);
            $pdf->Cell(5, $textypos, "Forma de Pago: $f_pago");
            $pdf->setY(20);
            $pdf->setX(155);
            $pdf->Cell(5, $textypos, "");
        } else {
            echo "No se encontraron resultados.";
        }
        /// Apartir de aqui empezamos con la tabla de productos
        $pdf->setY(25);
        $pdf->setX(135);
        $pdf->Ln();


        $pdf->SetFont('Arial', 'B', 16);

        // Título del documento
        $pdf->Cell(0, 10, 'Detalle de Venta', 0, 1, 'C');

        /////////////////////////////
        //// Array de Cabecera
        $header = array("Descripcion", "Cantidad", "V. Unidad", "V. Total");
       

        $pdf->SetFont('Arial', '', 10);

        // Column widths
        $w = array(20, 95, 35, 40);
        // Header
        $pdf->SetFont('Arial', 'B', 10);
        for ($i = 0; $i < count($header); $i++)
            $pdf->Cell($w[$i], 7, $header[$i], 'B', 0, 'C');
        $pdf->Ln();
        // Data
        $total = 0;
        $arrayCount = mysqli_num_rows($result);
        
        $pdf->SetFont('Arial', '', 10);

        foreach ($result as $r) {
            $pdf->Cell($w[0], 6, $r['id_productos'], 0, 0, 'C');
            $pdf->Cell($w[1], 6, number_format($r['cantidad'],2,",", "."), '0', 0, 'C');
            $pdf->Cell($w[2], 6, "$ " . number_format($r['precio'], 2, ",", "."), '0', 0, 'C');
            $pdf->Cell($w[3], 6, "$ " . number_format($r['precio'] * $r['cantidad'], 2, ",", "."), '0', 0, 'C');
            $pdf->Ln();
            $total += $r['precio'] * $r['cantidad'];
        }


        for ($i = 0; $i < count($header); $i++)
            $pdf->Cell($w[$i], 7, '', 'B', 0, 'C');

        /////////////////////////////
        //// Apartir de aqui esta la tabla con los subtotales y totales

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Ln(10); // Espacio adicional
        $pdf->setX(235);
        /////////////////////////////
        $header = array("", "");
        $data2 = array(
            array("Subtotal", $total),
            array("Descuento", 0),
            array("Impuesto", 0),
            array("Total", $total),
        );

        // Column widths
        $w2 = array(40, 40);
        // Header

        // Data
        foreach ($data2 as $row) {
            $pdf->setX(115);
            $pdf->Cell($w2[0], 6, $row[0], 'B');
            $pdf->Cell($w2[1], 6, "$ " . number_format($row[1], 3, ",", "."), 'B', 0, 'R');

            $pdf->Ln();
        }
        


        $pdf->output();
    } else {
        // Manejar el caso en que no se proporciona un ID de venta válido
        echo 'ID de venta no proporcionado o inválido.';
    }
}