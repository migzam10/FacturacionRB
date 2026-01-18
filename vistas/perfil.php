<?php
require 'header.php';

if(isset($_SESSION['usuario']))
{




?>


    <div class="content-page">
	
    <!-- Start content -->
    <div class="content">
        
        <div class="container-fluid">
                
                    <div class="row">
                                <div class="col-xl-12">
                                        <div class="breadcrumb-holder">
                                                <h1 class="main-title float-left">Cambiar Contraseña</h1>
                                                <ol class="breadcrumb float-right">
                                                    <li class="breadcrumb-item">Home</li>
                                                    <li class="breadcrumb-item active">Dashboard</li>
                                                </ol>
                                                <div class="clearfix"></div>
                                        </div>
                                </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <div class="col-lg-12">
                        <form id="fcambiar">
                        <label>Ingrese la contraseña actual</label>
                        <input type="password" class="form-control" name="txtcontraseñaactual" id="txtcontraseñaactual"/>
                        <label>Ingrese la contraseña nueva</label>
                        <input type="password" class="form-control"  name="txtcontraseñanueva" id="txtcontraseñanueva"/>
                        <br>
                        <center>
                        <span class="btn btn-primary" id="btncambiar">Actualizar</span>
                        </center>
                        </div>
                        </form>
                        
                    </div>



        </div>
        <!-- END container-fluid -->

    </div>
    <!-- END content -->

</div>
<!-- END content-page -->



<?php
require 'footer.php';
}
else {
	header("location:../index.php");  
}

?>


<script>
$(document).ready(function()
{
  $('#btncambiar').click(function()
{
      datos = $('#fcambiar').serialize();
      $.ajax({
      type:"POST",
      data:datos,
      url:"../procesos/usuarios/cambiarpass.php",
      success:function(r)
      {
        if(r=="v")
        {
          alertify.error('complete todos los campos');
        }
        else if(r==1) {
            window.location = "../procesos/usuarios/salir.php";
        }
        else if(r=="cr") {
          alertify.error("La contraseña actual es incorrecta");
        }
        else{
            alert(r);
        }
      }
    });
});
});
</script>


