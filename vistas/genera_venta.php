<?php
require 'header.php';

if (isset($_SESSION['usuario'])) {

?>
    <div class="content-page">

        <!-- Start content -->
        <div class="content">

            <div class="container">

                <div class="row">
                    <div class="col-xl-12">
                        <div class="breadcrumb-holder">
                            <h1 class="main-title float-left">Generar Venta</h1>
                            <div class="clearfix">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-xl-8">

                        <div class="row">
                            <form id="frmventa" class="col-xl-12 col-12">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label>Producto</label>
                                        <input class="form-control" id="txtproducto" name="txtproducto" type="text" />
                                    </div>


                                    <div class="col-lg-2">
                                        <label>Cantidad</label>
                                        <input class="form-control" id="txtcantidad" name="txtcantidad" type="number"
                                            value="1" min="1" />
                                    </div>

                                    <div class="col-lg-2">
                                        <label>V. Unidad</label>
                                        <input class="form-control" id="txtvunidad" name="txtvunidad" type="number" />
                                    </div>

                                    <div class="col-lg-3">
                                        <label>Categoria</label>

                                        <select id="txtcategoria" name="txtcategoria" class="form-control">
                                            <option value="A">Seleccione</option>
                                            <?php
                                            require_once '../clases/Categoria.php';
                                            require_once '../clases/Conexion.php';
                                            $obj1 = new Categoria();
                                            $categoria = $obj1->mostrar();
                                            while ($cat = mysqli_fetch_row($categoria)) {
                                            ?>
                                                <option value="<?php echo $cat[0] ?>"><?php echo $cat[1] ?></option>
                                            <?php
                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label>´</label>
                                        <input type="button" Value="Agregar" id="btnagregar" name="btnagregar"
                                            class="form-control btn btn-primary" />
                                    </div>
                                </div>


                            </form>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div id="tabla_temporal">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <center>
                                    <span class="btn btn-danger" id="btncancelar">Cancelar</span>
                                    <span class="btn btn-success" id="btnguardar">Guardar Venta</span>
                                </center>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <h4 class="text-center">Datos de la Venta</h4>
                        <div class="row">
                            <!-- Button trigger modal -->
                            <div class="card col-12">
                                <div class="card-body">
                                    <div class="col-lg-12" style="padding-bottom:10px;">
                                        <?php date_default_timezone_set("America/Bogota");
                                        $fecha = date("Y-m-d"); ?>
                                        <div class="row justify-content-center align-items-center">
                                            <label class="col-lg-4 font-weight-bold labelCenter">Fecha :</label>

                                            <input type="date" class="form-control form-control-sm col-lg-8" id="txtfecha" name="txtfecha" value="<?= $fecha ?>">
                                        </div>
                                    </div>
                                    <div class="col-lg-12" style="padding-bottom:10px;">
                                        <div class="row justify-content-center align-items-center">
                                            <label class="col-lg-4 font-weight-bold labelCenter">Orden : </label>
                                            <?php
                                            require_once '../clases/Venta.php';
                                            require_once '../clases/Conexion.php';
                                            $obj = new Venta();
                                            $vConse = $obj->consecutivo();
                                            ?>

                                            <input type="number" class="form-control form-control-sm col-lg-8" value="<?php echo $vConse; ?>" id="txtconsecutivo" name="txtconsecutivo">

                                        </div>
                                    </div>

                                    <div class="col-lg-12" style="padding-bottom:10px;">
                                        <div class="row justify-content-center align-items-center">
                                            <label class="col-lg-4 font-weight-bold labelCenter">Cliente :</label>
                                            <select id="txtcliente" name="txtcliente" class="form-control col-lg-8 form-control-sm">
                                                <option value="" disabled selected>Seleccione un cliente</option>
                                                <?php
                                                require_once '../clases/Cliente.php';
                                                require_once '../clases/Conexion.php';
                                                $obj1 = new Cliente();
                                                $cliente = $obj1->mostrar();
                                                while ($pro = mysqli_fetch_row($cliente)) {
                                                ?>

                                                    <option value="<?php echo $pro[1] ?>" data-cliente-id="<?php echo $pro[0] ?>">
                                                        <?php echo $pro[1] ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="row justify-content-center align-items-center">
                                            <label class="col-lg-4 font-weight-bold labelCenter">CC / NIT :</label>
                                            <!-- Coloca el valor de $pro[0] aquí -->
                                            <input id="txtnumero" name="txtnumero" class="form-control col-lg-8 form-control-sm" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <label class="font-weight-bold">Forma de pago</label><br>
                                        <label><input type="radio" name="forma_pago" value="efectivo"> Efectivo
                                            &nbsp;&nbsp;</label>

                                        <label><input type="radio" name="forma_pago" value="transferencia">
                                            Transferencia&nbsp;&nbsp;</label>
                                        <label><input type="radio" name="forma_pago" value="credito">
                                            Credito</label>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <!-- end row -->
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
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener elementos del DOM
            var selectCliente = document.getElementById('txtcliente');
            var inputNumero = document.getElementById('txtnumero');

            // Manejar evento de cambio en el select
            selectCliente.addEventListener('change', function() {
                // Obtener el valor del atributo "data-cliente-id" de la opción seleccionada
                var clienteId = this.options[this.selectedIndex].getAttribute('data-cliente-id');

                // Asignar el valor del clienteId al input
                inputNumero.value = clienteId;
            });
        });

        function quitarp(index) {
            $.ajax({
                type: "POST",
                data: "ind=" + index,
                url: "../procesos/ventas/quitarproducto.php",
                success: function(r) {
                    $('#tabla_temporal').load('tabla_temporal.php');
                    alertify.success("Se quito el producto");
                }
            });
        }

        $(document).ready(function() {
            $('#tabla_temporal').load('tabla_temporal.php');

            $('#btnagregar').click(function() {
                datos = $('#frmventa').serialize();
                vacios = validarFormVacio('frmventa');
                if (vacios <= 0) {
                    $.ajax({
                        url: '../procesos/ventas/agregarproductotem.php',
                        data: datos,
                        type: 'POST',
                        success: function(r) {
                            if (r == "camposventa") {
                                alertify.error("Complete los datos para aregar producto");
                            } else if (r == 1) {
                                $('#txtproducto').val('');
                                $('#txtvunidad').val('');
                                $('#txtcantidad').val('');
                                $('#txtcategoria').val('');
                                $('#tabla_temporal').load('tabla_temporal.php');
                            } else if (r == "n") {

                                alertify.error("Ingrese una cantidad valida");
                            } else if (r == 0) {
                                alert(r);
                            } else {
                                alert(r);
                            }

                        }
                    });
                } else {
                    alertify.error("Complete los datos para aregar producto");
                }
            });

            $('#btncancelar').click(function() {

                alertify.confirm('Venta', '¿Desea cancelar la venta?', function() {
                    $.ajax({
                        url: '../procesos/ventas/vaciartemp.php',
                        success: function(r) {
                            $('#tabla_temporal').load('tabla_temporal.php');
                            $('#txtprecio').val('');
                            $('#txtstock').val('');
                            $('#txtproducto').val('');
                            $('#txtcliente').val('');
                        }
                    });
                    alertify.success('Ok');
                    $('#txtprecio').val('');
                    $('#txtstock').val('');
                    $('#txtproducto').val('');
                    $('#txtcliente').val('');
                }, function() {
                    alertify.error('Cancel')
                });


            });

            $('#btnguardar').click(function() {
                conse = $('#txtconsecutivo').val();
                nom = $('#txtcliente').val();
                total = $('#txttotal').html();
                tipo = $("input[name='forma_pago']:checked").val();
                id_cliente = $('#txtnumero').val();
                fecha =  $('#txtfecha').val();
                if (nom.length != 0) {
                    datos = {
                        "txtconsecutivo": conse,
                        "txttotal": total,
                        "txtcliente": nom,
                        "txttipo": tipo,
                        "txtnumero": id_cliente,
                        "txtfecha": fecha
                    };
                    $.ajax({
                        url: '../procesos/ventas/guardar_venta.php',
                        data: datos,
                        type: 'POST',
                        success: function(r) {
                            if (r == "camposventa") {
                                alertify.error("Complete los datos para guardar la venta");
                            } else if (r == "ok") {

                                $('#tabla_temporal').load('tabla_temporal.php');
                                alertify.success("Venta guardada correctamente");

                                $('#txtvunidad').val('');
                                $('#txtcantidad').val('');
                                $('#txtproducto').val('');
                                $('#txtcategoria').val('A');
                                $('#txtcliente').val('Interno');
                                $('#txtnumero').val('1');
                                setTimeout(function() {
                                    location.reload();
                                }, 600);
                            } else if (r == "v") {

                                alertify.error("Complete los datos para guardar la venta");
                            } else if (r == "tablav") {

                                alertify.error("Esta venta no tiene productos");
                            } else if (r == 0) {
                                alert(r);
                            } else {
                                alert(r);
                            }

                        }
                    });
                } else {
                    alertify.error("Complete los datos para guardar la venta");
                }
            })


        });
    </script>