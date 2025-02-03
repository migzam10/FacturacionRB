<?php
require 'header.php';

if (isset($_SESSION['usuario'])) {
    date_default_timezone_set("America/Bogota");

?>





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
                <form action="consultar_ventas_c.php" method="post">
                    <div class="row">
                        <div class="col-lg-2">
                            <select id="txtcategoria" name="txtcategoria" class="form-control">
                                <option value="">Categoria</option>
                                <?php
                                require_once '../clases/Categoria.php';
                                require_once '../clases/Conexion.php';
                                $obj1 = new Categoria();
                                $categoria = $obj1->mostrar();
                                while ($cat = mysqli_fetch_row($categoria)) {
                                ?>
                                    <option value="<?php echo $cat[0]; ?>" <?php echo isset($_POST['txtcategoria']) && $_POST['txtcategoria'] == $cat[0] ? 'selected' : ''; ?>>
                                        <?php echo $cat[1]; ?>
                                    </option>
                                <?php
                                }

                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <?php
                            // Verificar si se han enviado las fechas posteadas, de lo contrario, usar la fecha actual
                            $fecha1 = isset($_POST['txtfecha1']) ? $_POST['txtfecha1'] : date("Y-m-d");
                            ?>
                            <input type="date" class="form-control" name="txtfecha1" value="<?php echo $fecha1; ?>"
                                required />
                        </div>
                        <div class="col-lg-2">
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
                        if (isset($_POST['txtfecha1']) and isset($_POST['txtfecha2']) and isset($_POST['txtcategoria'])) {
                            require_once '../clases/Conexion.php';
                            require_once '../clases/Venta.php';
                            $obj = new Venta();
                            $result = $obj->consultar_venta_c($_POST['txtfecha1'], $_POST['txtfecha2'], $_POST['txtcategoria']);
                        ?>

                            <table id="dtventas" class="table table-bordered table-hover table-condensed">
                                <thead>
                                    <tr>
                                        <td style="width:40px">No. Venta</td>
                                        <td style="width:40px">Categoria</td>
                                        <td style="width:160px">Producto</td>
                                        <td style="width:50px">Cantidad</td>
                                        <td style="width:100px">V. Unidad</td>
                                        <td style="width:50px">V. Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($fila = mysqli_fetch_row($result)) {
                                    ?>

                                        <tr>
                                            <td><?php echo $fila[0] ?></td>
                                            <td><?php echo $fila[1] ?></td>
                                            <td><?php echo $fila[2] ?></td>
                                            <td><?php echo $fila[3] ?></td>
                                            <td><?php echo  number_format($fila[4], 0, ',', '.'); ?></td>
                                            <td><?php echo  number_format($fila[5], 0, ',', '.'); ?></td>
                                        </tr>
                                <?php
                                    }
                                } else {

                                    echo "Seleccione la categoria";
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



<?php
    require 'footer.php';
} else {
    header("location:../index.php");
}

?>


<script>
    $(document).ready(function() {
        $('#dtventas').dataTable({
            "ordering": false,
            "info": false,
            "drawCallback": function(settings) {
                mostrarBotonExportar();
            }
        });

    });


    // Exportar a XLSX
    $('#exportarXLSX').click(function() {
        // Obtiene los datos de la tabla
        var table = $('#dtventas').DataTable();
        var data = table.rows().data().toArray();

        // Crea una matriz para el archivo XLSX
        var xlsxData = [
            ['ID Venta', 'Producto', 'Cantidad', 'V. Unidad', 'V. Total']
        ];
        data.forEach(function(row) {
            xlsxData.push([
                row[0],
                row[2],
                row[3],
                row[4],
                row[5]
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
        window.open('../procesos/ventas/ventas_pdf_c.php?' + formData);
    });


    function mostrarBotonExportar() {
        $("#exportarXLSX").show(); // Muestra el botón de exportar a XLSX
        $("#exportarPDF").show(); // Muestra el botón de exportar a PDF
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>