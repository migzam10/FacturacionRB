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
                                    <div class="col-lg-2">
                                        <button id="btnConsultar" class="btn btn-primary form-control">Consultar</button>
                                    </div>
                                    <div class="col-lg-5">
                                        <button type="button" id="exportarXLSX" class="btn btn-success ml-2"
                                            style="display: none;">Exportar a EXCEL</button>
                                        <button type="button" id="exportarPDF" class="btn btn-info ml-2 btn-danger"
                                            style="display: none;">Exportar a PDF</button>


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

            cargarCreditos();

            $('#btnConsultar').click(function() {
                cargarCreditos();
            });

            function cargarCreditos() {
                $.ajax({
                    url: '../procesos/estado_cuenta/consultar_creditos_g.php',
                    type: 'POST',
                    success: function(response) {
                        $('#resultadoConsulta').html(response);
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
                            $('#btnConsultar').click();
                        } else {
                            alertify.error('Error al registrar el pago');
                        }
                    }
                });
            });
        });

 // Exportar a XLSX
 $('#exportarXLSX').click(function() {
        // Obtiene los datos de la tabla
        var table = $('#dtcreditos').DataTable();
        var data = table.rows().data().toArray();

        // Crea una matriz para el archivo XLSX
        var xlsxData = [
            ['ID Venta', 'Cliente', 'Fecha', 'Total Venta', 'Total Pagado', 'Saldo Pendiente']
        ];
        data.forEach(function(row) {
            xlsxData.push([
                row[0],
                row[1],
                row[2],
                row[3],
                row[4],
                row[5]
            ]);
        });

        // Convierte la matriz en formato XLSX
        var ws = XLSX.utils.aoa_to_sheet(xlsxData);
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Reporte");

        // Descarga el archivo XLSX
        XLSX.writeFile(wb, 'Reporte.xlsx');
    });

    $('#exportarPDF').click(function() {
        // Obtiene los datos del formulario
        var formData = $('form').serialize();

        // Abre el PDF generado en una nueva ventana
        window.open('../procesos/estado_cuenta/reporte_credito_pdf.php');
    });


    
        $("#exportarXLSX").show(); // Muestra el botón de exportar a XLSX
        $("#exportarPDF").show(); // Muestra el botón de exportar a PDF
    

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>