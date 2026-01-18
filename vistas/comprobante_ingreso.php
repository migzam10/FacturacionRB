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
                            <h1 class="main-title float-left">Comprobantes de Ingresos</h1>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">

                        <div class="row">

                            <div class="col-lg-5">
                                <button type="button" id="exportarXLSX" class="btn btn-success ml-2"
                                    style="display: none;">Exportar a EXCEL</button>
                                <button type="button" id="exportarPDF" class="btn btn-info ml-2 btn-danger"
                                    style="display: none;">Exportar a PDF</button>


                            </div>
                        </div>

                        <div id="resultadoConsulta"></div>

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
            $("#exportarXLSX").show();
            $("#exportarPDF").show();

            function cargarCreditos() {
                $.ajax({
                    url: '../procesos/estado_cuenta/consultar_comprobantes.php',
                    type: 'POST',
                    success: function(response) {
                        $('#resultadoConsulta').html(response);
                    }
                });
            }

        });

        // Exportar a XLSX
        $('#exportarXLSX').click(function() {
            $.ajax({
                url: '../procesos/estado_cuenta/exportar_comprobantes_excel.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.length === 0) {
                        alert("No hay datos para exportar.");
                        return;
                    }

                    // Crear hoja de cálculo desde JSON
                    var ws = XLSX.utils.json_to_sheet(response);

                    // Crear libro de Excel
                    var wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, "Reporte de Comprobantes");

                    // Descargar el archivo
                    XLSX.writeFile(wb, 'Reporte de Comprobantes.xlsx');
                },
                error: function() {
                    alert("Error al obtener los datos.");
                }
            });
        });




        $('#exportarPDF').click(function() {
            // Obtiene los datos del formulario
            var formData = $('form').serialize();

            // Abre el PDF generado en una nueva ventana
            window.open('../procesos/estado_cuenta/reporte_comprobante_ingreso.php');
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>