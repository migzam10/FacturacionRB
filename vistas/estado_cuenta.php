<?php
require 'header.php';

if (isset($_SESSION['usuario'])) {
?>
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="breadcrumb-holder">
                            <h1 class="main-title float-left">Estado de Cuenta</h1>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label>Cliente</label>
                                        <select id="txtcliente" name="txtcliente" class="form-control">
                                            <option value="">Seleccione un cliente</option>
                                            <?php
                                            require_once '../clases/EstadoCuenta.php';
                                            require_once '../clases/Conexion.php';
                                            $obj1 = new EstadoCuenta();
                                            $cliente = $obj1->clientesPendientes();
                                            while ($pro = mysqli_fetch_row($cliente)) {
                                            ?>
                                                <option value="<?php echo $pro[0] ?>"><?php echo $pro[1] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>&nbsp;</label>
                                        <button id="btnConsultar" class="btn btn-primary form-control">Consultar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="resultadoConsulta"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
    require 'footer.php';
} else {
    header("location:../index.php");
}
?>

<script>
$(document).ready(function() {
    $('#btnConsultar').click(function() {
        var cliente = $('#txtcliente').val();
        if(cliente) {
            $.ajax({
                url: '../procesos/estado_cuenta/consultar_creditos.php',
                type: 'POST',
                data: {cliente: cliente},
                success: function(response) {
                    $('#resultadoConsulta').html(response);
                }
            });
        } else {
            alertify.error("Seleccione un cliente");
        }
    });

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
                if(response == 'ok') {
                    $('#modalPago').modal('hide');
                    alertify.success('Pago registrado correctamente');
                    $('#btnConsultar').click();
                } else {
                    alertify.error('Error al registrar el pago');
                }
            }
        });
    });
});
</script>
