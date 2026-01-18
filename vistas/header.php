<?php

session_start();
if (isset($_SESSION['usuario'])) {


?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Robinar | Dashboard</title>

        <!-- Favicon -->
        <link rel="shortcut icon" href="../assets/images/favicon.ico">

        <!-- Bootstrap CSS -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />


        <link rel="stylesheet" type="text/css" href="../assets/plugins/alertifyjs/css/alertify.css">

        <link rel="stylesheet" type="text/css" href="../assets/plugins/alertifyjs/css/themes/default.css">

        <!-- Font Awesome CSS -->
        <link href="../assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

        <!-- Custom CSS -->
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css" />


        <!-- BEGIN CSS for this page -->
        <link rel="stylesheet" type="text/css" href="../assets/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="../assets/responsive.dataTables.min.css">
        <!-- END CSS for this page -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    </head>

    <body class="adminbody">

        <div id="main">

            <!-- top bar navigation -->
            <div class="headerbar">

                <!-- LOGO -->
                <div class="headerbar-left">
                    <a href="inicio.php" class="logo"><img alt="" src="../assets/images/logo.png" />
                        <span>Robinar</span></a>
                </div>

                <nav class="navbar-custom">

                    <ul class="list-inline float-right mb-0">

                        <li class="list-inline-item dropdown notif">
                            <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <img src="../assets/images/avatars/admin.png" alt="Profile image" class="avatar-rounded">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5 class="text-overflow"><small>Hola, <?php echo $_SESSION['usuario'] ?></small> </h5>
                                </div>

                                <!-- item-->
                                <a href="perfil.php" class="dropdown-item notify-item">
                                    <i class="fa fa-user"></i> <span>Cambiar Contraseña</span>
                                </a>

                                <!-- item-->
                                <a href="../procesos/usuarios/salir.php" class="dropdown-item notify-item">
                                    <i class="fa fa-power-off"></i>
                                    <span>
                                        Salir
                                    </span>
                                </a>

                            </div>
                        </li>

                    </ul>

                    <ul class="list-inline menu-left mb-0">
                        <li class="float-left">
                            <button class="button-menu-mobile open-left">
                                <i class="fa fa-fw fa-bars"></i>
                            </button>
                        </li>
                    </ul>

                </nav>

            </div>
            <!-- End Navigation -->


            <!-- Left Sidebar -->
            <div class="left main-sidebar">

                <div class="sidebar-inner leftscroll">

                    <div id="sidebar-menu">

                        <ul>

                            <!--li class="submenu">
                            <a class="active" href="inicio.php"><i class="fa fa-fw fa-bars"></i><span> Menú </span> </a>
                        </li-->


                            

                            <!--li class="submenu">
                                <a href="#"><i class="fa fa-fw fa-table"></i> <span> Inventario </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="productos.php"> Productos </a></li>
                                    <li><a href="proveedores.php"> Proveedores </a></li>
                                    <li><a href="categorias.php"> Categorias </a></li>
                                </ul>
                            </li-->



                            <li class="submenu">
                                <a href="#"><i class="fa fa-shopping-cart"></i> <span> Ventas </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="genera_venta.php">Generar Venta</a></li>
                                    <!--li><a href="marcar_ventas.php">Ventas a marcar</a></li-->
                                    <li><a href="consultar_ventas.php"> Consultar Ventas</a></li>
                                    <li><a href="consultar_ventas_c.php"> Consultar Ventas Por Categoria</a></li>
                                    <li><a href="marcar_ventas.php"> Anuladas</a></li>
                                </ul>
                            </li>

                            <!--li class="submenu">
                                <a href="marcar_ventas.php"><i class="fa fa-user"></i> <span> Banco </span> <span class="users"></span></a>

                            </li-->
                            <li class="submenu">

                                <a href="#"><i class="fa fa-check"></i> <span> Estado cuenta </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="estado_cuenta.php">Por clientes</a></li>
                                    <li><a href="estado_cuenta_general.php">General</a></li>
                                    <li><a href="comprobante_ingreso.php">Comprobante Ing</a></li>
                                </ul>

                            </li>

                            <li class="submenu">
                                <a href="categorias.php"><i class="fa fa-fw fa-table"></i> <span> Categorias </span> <span class="users"></span></a>

                            </li>
                            
                            <li class="submenu">
                                <a href="cliente.php"><i class="fa fa-user"></i> <span> Clientes </span> <span class="users"></span></a>

                            </li>

                            <!--li class="submenu">
                                <a href="#"><i class="fa fa-info"></i> <span> Informacion </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="stock.php">Stock Bajo</a></li>
                                </ul>
                            </li-->

                        </ul>


                    </div>
                </div>
            </div>
            <!-- End Sidebar -->

        <?php
    } else {
        header("location:../index.php");
    }
        ?>