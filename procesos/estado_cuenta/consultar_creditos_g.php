<?php
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/EstadoCuenta.php";

$obj = new EstadoCuenta();
$resultado = $obj->consultarCreditosPendienteGeneral();

if (mysqli_num_rows($resultado) > 0) {
    $clientes = [];

    // Agrupar ventas por cliente
    while ($row = mysqli_fetch_assoc($resultado)) {
        $cliente = $row['nombre'];
        $direccion = $row['direccion'] ?? "No disponible"; // Si no tiene dirección, mostrar "No disponible"
        $saldo_pendiente = $row['total'] - $row['total_pagado'];
        $telefono = $row['telefono'];
        $idcliente = $row['id_cliente'];

        if (!isset($clientes[$cliente])) {
            $clientes[$cliente] = [
                'direccion' => $direccion,
                'idcliente' => $idcliente,
                'telefono' => $telefono,
                'ventas' => [],
                'total_saldo' => 0
            ];
        }

        $clientes[$cliente]['ventas'][] = [
            'id_venta' => $row['id_venta'],
            'fecha' => date('d/m/Y', strtotime($row['fecha'])),
            'total_venta' => number_format($row['total'], 2, ',', '.'),
            'total_pagado' => number_format($row['total_pagado'], 2, ',', '.'),
            'saldo_pendiente' => number_format($saldo_pendiente, 2, ',', '.')
        ];

        $clientes[$cliente]['total_saldo'] += $saldo_pendiente;
    }
?>

    <div class="card mt-3">
        <div class="card-body">


            <?php foreach ($clientes as $cliente => $data) { ?>
                <div class="mb-4">

                    <div class="row">
                        <div class="col-6"><strong>Nombre:</strong> <?php echo strtoupper($cliente); ?></div>
                        <div class="col-6"> <strong>Dirección:</strong> <?php echo $data['direccion']; ?></div>

                    </div>

                    <div class="row">
                        <div class="col-6"><strong>CC/NIT:</strong> <?php echo $data['idcliente']; ?></div>
                        <div class="col-6"><strong>Telefono:</strong> <?php echo $data['telefono']; ?></div>
                    </div>




                    <div class="table-responsive">
                        <table class="table table-striped" id="dtcreditos">
                            <thead>
                                <tr>
                                    <th>ID Venta</th>
                                    <th>Fecha</th>
                                    <th>Total Venta</th>
                                    <th>Total Pagado</th>
                                    <th>Saldo Pendiente</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['ventas'] as $venta) { ?>
                                    <tr>
                                        <td><?php echo $venta['id_venta']; ?></td>
                                        <td><?php echo $venta['fecha']; ?></td>
                                        <td><?php echo $venta['total_venta']; ?></td>
                                        <td><?php echo $venta['total_pagado']; ?></td>
                                        <td><?php echo $venta['saldo_pendiente']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end">
                        <strong>TOTAL: $   <?php echo number_format($data['total_saldo'], 2, ',', '.'); ?></strong>
                    </div>
                    <hr>
                    <hr>
                </div>
            <?php } ?>
        </div>
    </div>

<?php
} else {
    echo '<div class="alert alert-info mt-3">No hay créditos pendientes.</div>';
}
?>