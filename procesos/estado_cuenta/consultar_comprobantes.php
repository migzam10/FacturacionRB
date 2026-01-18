<?php
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/EstadoCuenta.php";

$obj = new EstadoCuenta();
$resultado = $obj->consultarComprobantesIngresos();

if (mysqli_num_rows($resultado) > 0) {
    $clientes = [];

    // Agrupar ventas por cliente
    while ($row = mysqli_fetch_assoc($resultado)) {
        $cliente = $row['nombre'];
        $direccion = $row['direccion'] ?? "No disponible"; // Si no tiene dirección, mostrar "No disponible"
        $total_venta = $row['total'];
        $total_pagado = $row['total_pagado'];
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
        $clientes[$cliente]['total_venta'] = ($clientes[$cliente]['total_venta'] ?? 0) + $total_venta;
        $clientes[$cliente]['total_pagado'] = ($clientes[$cliente]['total_pagado'] ?? 0) + $total_pagado;
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
                            <th>Acciones</th>
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
                            <td>
                                <?php 
                                $saldoNumerico = (float)str_replace(['.', ','], ['', '.'], $venta['saldo_pendiente']);
                                if ($saldoNumerico > 0) { ?>
                                <button class="btn btn-primary btn-sm btn-pago"
                                    data-venta="<?php echo $venta['id_venta']; ?>"
                                    data-saldo="<?php echo $venta['saldo_pendiente']; ?>">
                                    Registrar Pago
                                </button>
                                <?php } else { ?>
                                <span class="btn btn-primary btn-adge btn-sm bg-success">Pagado</span>
                                <?php } ?>

                                <button class="btn btn-info btn-sm btn-historial"
                                    onclick="verHistorial(<?php echo $venta['id_venta']; ?>)"
                                    data-venta="<?php echo $venta['id_venta']; ?>">
                                    Ver Pagos
                                </button>
                                <a href="#" class="btn btn-danger" onclick="generarPDF('<?php echo $venta['id_venta'] ?>')">
                                                    <span class="fa fa-file-pdf" role="button"></span>PDF
                                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Total</th>
                            <th><?php echo number_format($data['total_venta'], 2, ',', '.'); ?></th>
                            <th><?php echo number_format($data['total_pagado'], 2, ',', '.'); ?></th>
                            <th><?php echo number_format($data['total_saldo'], 2, ',', '.'); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>


            <hr>
        </div>
        <?php } ?>
    </div>
</div>

<!-- Modal para el historial de pagos -->
<div class="modal fade" id="modalHistorial" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Historial de Pagos - Venta #<span id="idVentaHistorial"></span></h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="contenidoHistorial">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
function generarPDF(idVenta) {
    // Llamar al script PHP que generará el PDF
    window.open('../procesos/estado_cuenta/reporte_pagos_pdf.php?id_venta=' + idVenta, '_blank');
}

function verHistorial(idVenta) {
    // Actualizar el ID de venta en el título del modal
    $('#idVentaHistorial').text(idVenta);

    // Mostrar el modal con el spinner de carga
    $('#modalHistorial').modal('show');

    // Realizar la petición AJAX
    $.ajax({
        url: '../procesos/estado_cuenta/obtener_historial.php',
        type: 'POST',
        data: {
            id_venta: idVenta
        },
        success: function(response) {
            // Actualizar el contenido del modal
            $('#contenidoHistorial').html(response);
        },
        error: function(xhr, status, error) {
            // Mostrar mensaje de error
            $('#contenidoHistorial').html(
                '<div class="alert alert-danger">' +
                'Error al cargar el historial. Detalles: ' + error +
                '</div>'
            );
        }
    });
}


$(document).on('click', '.btn-pago', function() {
    var id_venta = $(this).data('venta');
    var saldo = $(this).data('saldo');

    $('#modalPago').remove();

    var modal = `
        <div class="modal fade" id="modalPago" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar Pago</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formPago">
                            <input type="hidden" name="id_venta" value="${id_venta}">
                            <div class="form-group">
                                <label>Monto a Pagar</label>
                                <input type="number" class="form-control" name="monto" max="${saldo}" step="0.01" required>
                            </div>
                            
                            <input id="tipo_pago" name="tipo_pago" type="hidden" value="abono" />
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btnGuardarPago">Guardar Pago</button>
                    </div>
                </div>
            </div>
        </div>`;

    $('body').append(modal);
    $('#modalPago').modal('show');
});

$(document).on('click', '#btnGuardarPago', function() {
    var formData = $('#formPago').serialize();
    $.ajax({
        url: '../procesos/estado_cuenta/guardar_pago.php',
        type: 'POST',
        data: formData,
        success: function(response) {
            if (response == 'ok') {
                $('#modalPago').modal('hide');
                alertify.success('Pago registrado correctamente');
                
               if ($('#btnConsultar').length > 0) {
                    $('#btnConsultar').click(); 
                } else {
                    // OPCIÓN B: Si no hay botón, recargar la ubicación actual
                    location.reload();
                }


            } else {
                alertify.error('Error al registrar el pago');
            }
        }
    });
});
</script>
<?php
} else {
    echo '<div class="alert alert-info mt-3">No hay créditos pendientes.</div>';
}
?>