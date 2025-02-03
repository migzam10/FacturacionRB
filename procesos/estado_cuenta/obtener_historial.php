<?php
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/EstadoCuenta.php";

$obj = new EstadoCuenta();
$id_venta = $_POST['id_venta'];

$pagos = $obj->obtenerHistorialPagos($id_venta);
?>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Tipo de Pago</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_pagado = 0;
            while($row = mysqli_fetch_assoc($pagos)) {
                $total_pagado += $row['monto'];
            ?>
                <tr>
                    <td><?php echo $row['id_pago']; ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($row['fecha'])); ?></td>
                    <td><?php echo number_format($row['monto'], 2); ?></td>
                    <td><?php echo ucfirst($row['tipo_pago']); ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">Total Pagado:</th>
                <th colspan="2"><?php echo number_format($total_pagado, 2); ?></th>
            </tr>
        </tfoot>
    </table>
</div>
