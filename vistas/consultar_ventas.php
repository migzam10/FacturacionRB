<?php
require 'header.php';

if (isset($_SESSION['usuario'])) {
    date_default_timezone_set("America/Bogota");

?>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:white"><span class="fa fa-file"></span>
                        Detalle de Venta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="fgenerarecibo">
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5>Detalle de Venta<label id="txtidcontr"></label></h5>
                                    </div>

                                </div>
                            </div>

                            <div class="card-body">

                                <form>
                                    <div class="form-group">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-group input-group-sm mb-3">
                                                    <div class="input-group-prepend">
                                                        <h5>Orden No.&nbsp</h5>
                                                        <h5 id="id_venta"></h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="input-group input-group-sm mb-3">

                                                    <h5>Fecha:&nbsp</h5>

                                                    <h5 id="txtfecha" name="txtfecha"></h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="input-group input-group-sm mb-3">

                                                    <h5>Cliente:&nbsp</h5>

                                                    <h5 id="txtcliente" name="txtcliente"></h5>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="input-group input-group-sm mb-3">

                                                    <h5>Identificacion:&nbsp</h5>

                                                    <h5 id="txtnumero" name="txtnumero"></h5>
                                                </div>
                                            </div>

                                        </div>



                                    </div>
                                    <div class="bordde">
                                        <div id="tablaaa"></div>
                                        <div class="col-lg-12">
                                            <h4 style="text-align:right">TOTAL $
                                                <label id="txttotal" name="txttotal"></label>
                                            </h4>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>




    <div class="content-page">

        <!-- Start content -->
        <div class="content">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-xl-12">
                        <div class="breadcrumb-holder">
                            <h1 class="main-title float-left">Consultar Ventas</h1>
                            <div class="clearfix">

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <form action="consultar_ventas.php" method="post">
                    <div class="row">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-3">
                            <?php
                            // Verificar si se han enviado las fechas posteadas, de lo contrario, usar la fecha actual
                            $fecha1 = isset($_POST['txtfecha1']) ? $_POST['txtfecha1'] : date("Y-m-d");
                            ?>
                            <input type="date" class="form-control" name="txtfecha1" value="<?php echo $fecha1; ?>"
                                required />
                        </div>
                        <div class="col-lg-3">
                            <?php
                            $fecha2 = isset($_POST['txtfecha2']) ? $_POST['txtfecha2'] : date("Y-m-d");
                            ?>
                            <input type="date" class="form-control" name="txtfecha2" value="<?php echo $fecha2; ?>"
                                required />

                        </div>
                        <div class="col-lg-5">
                            <input type="submit" value="Buscar" class="btn btn-primary">
                            <button type="button" id="exportarXLSX" class="btn btn-success ml-2"
                                style="display: none;">Exportar a EXCEL</button>
                            <button type="button" id="exportarPDF" class="btn btn-info ml-2 btn-danger"
                                style="display: none;">Exportar a PDF</button>


                        </div>
                    </div>
                    <hr>
                </form>
                <div class="row">
                    <!-- Button trigger modal -->




                    <div class="col-lg-12">


                        <?php
                        if (isset($_POST['txtfecha1']) and isset($_POST['txtfecha2'])) {
                            require_once '../clases/Conexion.php';
                            require_once '../clases/Venta.php';
                            $obj = new Venta();
                            $result = $obj->consultar_venta($_POST['txtfecha1'], $_POST['txtfecha2']);
                        ?>

                            <table id="dtventas" class="table table-bordered table-hover table-condensed" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <td style="width:25px">No. Venta</td>
                                        <td style="width:100px">Cliente</td>
                                        <td style="width:10px">Identificación</td>
                                        <td style="width:100px">Fecha</td>
                                        <td style="width:50px">Total</td>
                                        <td style="width:10px">F. Pago</td>
                                        <td style="width:100px">Accion</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($fila = mysqli_fetch_row($result)) {
                                    ?>

                                        <tr>
                                            <td><?php echo $fila[0] ?></td>
                                            <td><?php echo $fila[2] ?></td>
                                            <td><?php echo $fila[6] ?></td>
                                            <td><?php echo $fila[1] ?></td>
                                            <td><?php echo  number_format($fila[4], 0, ',', '.'); ?></td>
                                            <td><?php echo $fila[5] ?></td>
                                            <td>

                                                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#exampleModal"
                                                    onclick="functions('<?php echo $fila[0] ?>')"  title="Visualizar" >
                                                    <span class="fa fa-credit-card" role="button" data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="Informacion de venta Nro. <?php echo $fila[0] ?>"></span>
                                                </a>
                                                <a href="#" class="btn btn-danger" onclick="generarPDF('<?php echo $fila[0] ?>')">
                                                    <span class="fa fa-file-pdf" role="button"></span>PDF
                                                </a>
                                                <?php
                                                if($fila[5] == 'credito'){
                                                    ?>  <a href="#" class="btn btn-primary" onclick="verHistorial('<?php echo $fila[0] ?>')">
                                                    <span class="fa fa-credit-card" role="button"></span>
                                                    </a>
                                               <?php }
                                                ?>
                                                <a href="#" class="btn btn-danger" title="Anular" onclick="anularVenta('<?php echo $fila[0] ?>')">
                                                    <span class="fa fa-ban" role="button"></span>
                                                </a>
                                                <a href="#" class="btn btn-danger" title="Eliminar" onclick="eliminarVenta('<?php echo $fila[0] ?>')">
                                                    <span class="fa fa-times" role="button"></span>
                                                </a>


                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                } ?>

                                </tbody>
                            </table>
                    </div>

                </div>



            </div>
            <!-- END container-fluid -->

        </div>
        <!-- END content -->

    </div>
    <!-- END content-page -->

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

<?php
    require 'footer.php';
} else {
    header("location:../index.php");
}

?>


<script>
    function generarPDF(idVenta) {
        // Llamar al script PHP que generará el PDF
        window.open('../procesos/ventas/factura_pdf.php?id_venta=' + idVenta, '_blank');
    }

    function anularVenta(idVenta) {
        
        alertify.confirm('Venta', '¿Esta seguro que desea anular esta Venta?', function() {
            $.ajax({
                type: "POST",
                url: "../procesos/ventas/anular.php",
                data: "id_venta=" + idVenta
            }).done(function(msg) {
                alertify.success("Venta anulada Correctamente");
                location.reload();
            });
        }, function() {

        });

    }


    function eliminarVenta(idVenta) {
        
        alertify.confirm('Venta', '¿Esta seguro que desea Eliminar esta Venta?', function() {
            $.ajax({
                type: "POST",
                url: "../procesos/ventas/eliminar.php",
                data: "id_venta=" + idVenta
            }).done(function(msg) {
                alertify.success("Venta eliminada Correctamente");
                location.reload();
            });
        }, function() {

        });

    }


    function functions(id) {
        agregadatosventa(id);
        mostrardetalle(id)
    }

    function mostrardetalle(id) {
        $.ajax({
            type: "POST",
            data: "id_venta=" + id,
            url: "../procesos/ventas/mostrar_porid.php",
            success: function(r) {
                var dato = JSON.parse(r);
                $('#id_venta').html(id);
                $('#txtcliente').html(dato['cliente']);
                $('#txttotal').html(dato['total']);
                $('#txtnumero').html(dato['numero']);
                $('#txtfecha').html(dato['fecha']);
            }
        });
    }

    function agregadatosventa(id) {
        $.ajax({
            type: "POST",
            data: "id_venta=" + id,
            url: "../procesos/ventas/traer_detalles.php",
            success: function(r) {
                $('#tablaaa').html(r);
            }
        });

    }

    $(document).ready(function() {
        $('#dtventas').dataTable({
            "ordering": false,
            "info": false,
            "drawCallback": function(settings) {
                mostrarBotonExportar();
            }
        });

    });

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


    // Exportar a XLSX
    $('#exportarXLSX').click(function() {
        // Obtiene los datos de la tabla
        var table = $('#dtventas').DataTable();
        var data = table.rows().data().toArray();

        // Crea una matriz para el archivo XLSX
        var xlsxData = [
            ['ID', 'Cliente', 'Identificación', 'Fecha', 'Total']
        ];
        data.forEach(function(row) {
            xlsxData.push([
                row[0], // ID
                row[1], // Cliente
                row[2], // Identificación
                row[3], // Fecha
                row[4] // Total
            ]);
        });

        // Convierte la matriz en formato XLSX
        var ws = XLSX.utils.aoa_to_sheet(xlsxData);
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Ventas");

        // Descarga el archivo XLSX
        XLSX.writeFile(wb, 'ventas.xlsx');
    });

    $('#exportarPDF').click(function() {
        // Obtiene los datos del formulario
        var formData = $('form').serialize();

        // Abre el PDF generado en una nueva ventana
        window.open('../procesos/ventas/ventas_pdf.php?' + formData);
    });


    function mostrarBotonExportar() {
        $("#exportarXLSX").show(); // Muestra el botón de exportar a XLSX
        $("#exportarPDF").show(); // Muestra el botón de exportar a PDF
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>