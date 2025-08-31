<?php
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/EstadoCuenta.php";

$obj = new EstadoCuenta();
$cliente = $_POST['cliente'];
$resultado = $obj->consultarCreditosPendientes($cliente);

if(mysqli_num_rows($resultado) > 0) {
    ?>
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Créditos Pendientes</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Venta #</th>
                            <th>Fecha</th>
                            <th>Total Venta</th>
                            <th>Total Pagado</th>
                            <th>Saldo Pendiente</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while($row = mysqli_fetch_assoc($resultado)) {
                            $saldo_pendiente = $row['total'] - $row['total_pagado'];
                            ?>
                            <tr>
                                <td><?php echo $row['id_venta']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row['fecha'])); ?></td>
                                <td><?php echo number_format($row['total'], 2); ?></td>
                                <td><?php echo number_format($row['total_pagado'], 2); ?></td>
                                <td><?php echo number_format($saldo_pendiente, 2); ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm btn-pago" 
                                            data-venta="<?php echo $row['id_venta']; ?>"
                                            data-saldo="<?php echo $saldo_pendiente; ?>">
                                        Registrar Pago
                                    </button>
                                    <button class="btn btn-info btn-sm btn-historial" 
                                            onclick="verHistorial(<?php echo $row['id_venta']; ?>)"
                                            data-venta="<?php echo $row['id_venta']; ?>">
                                        Ver Historial
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
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
    function verHistorial(idVenta) {
        // Actualizar el ID de venta en el título del modal
        $('#idVentaHistorial').text(idVenta);
        
        // Mostrar el modal con el spinner de carga
        $('#modalHistorial').modal('show');
        
        // Realizar la petición AJAX
        $.ajax({
            url: '../procesos/estado_cuenta/obtener_historial.php',
            type: 'POST',
            data: {id_venta: idVenta},
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
    </script>
    <?php
} else {
    echo '<div class="alert alert-info mt-3">No hay créditos pendientes para este cliente.</div>';
}
?>