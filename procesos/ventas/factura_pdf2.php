<?php

//require_once '../clases/Venta.php';
require_once '../../clases/Conexion.php';
include "../../clases/fpdf/fpdf.php";

if (isset($_GET['id_venta'])) {
    // Obtener los detalles de la venta
    $idVenta = $_GET['id_venta'];

    $c = new Conexion();
    $conexion = $c->conectar();
    $sql = "SELECT p.id_producto, p.nombre, de.cantidad, de.precio,de.importe 
            FROM detalle_ventas AS de
            INNER JOIN productos AS p ON p.id_producto=de.id_productos 
            WHERE de.id_ventas = $idVenta";

    $result = mysqli_query($conexion, $sql);



    $sqlCliente = "SELECT DISTINCT v.id_venta,v.fecha, c.*, v.total 
                    FROM ventas AS v 
                    INNER JOIN cliente AS c ON v.id_cliente=c.id_cliente 
                    WHERE v.id_venta = $idVenta";



    $resultCliente = mysqli_query($conexion, $sqlCliente);


    $pdf = new FPDF($orientation = 'P', $unit = 'mm');

    $pdf->AddPage();

    $pdf->AddFont('PlayfairDisplay-Bold', '', "PlayfairDisplay-Bold.php");
    $pdf->AddFont('PlayfairDisplay-Regular', '', "PlayfairDisplay-Regular.php");

    $pdf->SetFont('PlayfairDisplay-Bold', '', 20);
    $textypos = 5;
    $pdf->setY(15);
    $pdf->setX(25);
    // Agregamos los datos de la empresa
    $pdf->Cell(5, $textypos, "La Diosa");

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
        $total = $fila["total"];
        // Aquí puedes usar las variables como desees
        //echo "ID Venta: $id_venta, Fecha: $fecha, Cliente: $cliente, Número: $id_cliente, Total: $total <br> <br>";
        


    } else {
        echo "No se encontraron resultados.";
    }
    /// Apartir de aqui empezamos con la tabla de productos
    
    $total = 0;
    
    /*foreach ($result as $r) {
        echo $r['id_producto']. $r['nombre']. $r['cantidad']. $r['precio'];
    }*/


    $pdf->output();
} else {
    // Manejar el caso en que no se proporciona un ID de venta válido
    echo 'ID de venta no proporcionado o inválido.';
}