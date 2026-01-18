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
                        <br>
                    </div>
                </div>
                <!-- end row -->


                <div class="row">
                    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                        <a href="consultar_ventas.php">
                            <div class="card-box noradius noborder bg-default h-100">
                                <i class="fa fa-shopping-cart  float-right text-white"></i>
                                <h5 class="text-white text-uppercase m-b-20">Numero de Ventas del Dia</h5>
                                <h4 class="m-b-20 text-white counter">
                                    <?php
                                    require_once '../clases/Reporte.php';
                                    require_once '../clases/Conexion.php';
                                    $obj1 = new Reporte();
                                    $r1 = $obj1->ventas_dia();
                                    echo $r1;
                                    ?>
                                </h4>
                                <span class="text-white"><br><br></span>
                            </div>
                        </a>
                    </div>

                    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                        <a href="consultar_ventas.php">
                            <div class="card-box noradius noborder bg-success h-100">
                                <i class="fa fa-money float-right text-white"></i>
                                <h5 class="text-white text-uppercase m-b-20">Total vendido del Dia</h5>
                                <h4 class="m-b-20 text-white counter">$
                                    <?php
                                    require_once '../clases/Reporte.php';
                                    require_once '../clases/Conexion.php';
                                    $obj1 = new Reporte();
                                    $r1 = $obj1->dinero_dia();
                                    if (empty($r1)) {
                                        echo "0";
                                    } else {
                                        echo number_format($r1, 0, ',', '.');
                                    }

                                    ?>
                                </h4>
                                <span class="text-white"><br></span>
                            </div>
                        </a>
                    </div>

                    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
                        <a href="">
                            <div class="card-box noradius noborder bg-success h-100">
                                <i class="fa fa-money  float-right text-white"></i>
                                <h5 class="text-white text-uppercase m-b-20">Total Vendido el mes</h5>
                                <h4 class="m-b-20 text-white counter">$
                                    <?php
                                    require_once '../clases/Reporte.php';
                                    require_once '../clases/Conexion.php';
                                    $obj2 = new Reporte();
                                    $r2 = $obj2->ventas_mes_total();
                                    if (empty($r2)) {
                                        echo "0";
                                    } else {
                                        echo number_format($r2, 2, ',', '.');
                                    }
                                    ?>
                                </h4>
                                <span class="text-white"><br></span>
                            </div>
                        </a>
                    </div>

                   
                </div>
                <!-- end row -->
                <br>

                <div class="row">
                    <div class="col-xs-6 col-md-6 col-lg-6 col-xl-6">
                        <div>
                            <canvas id="myChart"></canvas>
                        </div>

                    </div>
                </div>


               
                <!-- end row -->


            </div>
            <!-- END container-fluid -->

        </div>
        <!-- END content -->

    </div>
    <!-- END content-page -->



    <?php
    require 'footer.php';
    ?>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Cargar los datos desde reporte.php
        fetch('../procesos/reportes/ventas_mes.php')
            .then(response => response.json())
            .then(data => {
                var colors = ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)']; // Define aquí tus colores
                var borderColor = ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)']; // Colores de borde correspondientes
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Total Vendido',
                            data: data.data,
                            backgroundColor: colors,
                            borderColor: borderColor,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }
                    }
                });
            });
    </script>

    <script>
        $(document).ready(function() {


        });
    </script>


    <!-- END Java Script for this page -->


<?php
} else {
    header("location:../index.php");
}

?>