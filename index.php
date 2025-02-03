<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Venta</title>
    <link rel="shortcut icon" href="imagenes/ico.png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <script src="assets/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="assets/login/login.css">
    
    
    <link rel="stylesheet" type="text/css" href="assets/alertifyjs/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="assets/alertifyjs/css/themes/default.css">
    <script type="text/javascript" src="assets/alertifyjs/alertify.js"></script>
    
</head>
    
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto"><br><br><br><br>
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center"><strong>Software Venta</strong></h5>
            <form class="form-signin" id="frmlogin">
              <div class="form-label-group">
                <input type="text" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputEmail">Usuario</label>
              </div>

              <div class="form-label-group">
                <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Clave</label>
              </div>

              
              <span class="btn btn-lg btn-success btn-block text-uppercase" id="btningresar" type="submit">Ingresar</span><br>
              <div class="custom-control custom-checkbox mb-3">
               
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>


<script>
    
    $(document).ready(function(){
        $('#btningresar').click(function(){
            datos = $('#frmlogin').serialize();
            var usu = $('#inputEmail').val();
            var cla = $('#inputPassword').val();
            
            if(usu.length == 0 || cla.length ==0)
                {
                    alertify.error("Complete los campos");
                }
            else
            {
            $.ajax(
                {
               type:"POST",
               data:datos,
               url:"procesos/usuarios/login.php", 
                success:function(r)
                {
                    if(r==1)
                        {
                            window.location = "vistas/inicio.php";
                        }
                    else if(r==0){
                            alertify.error("Error al ingresar los datos");
                        }
                    else
                        {
                            //alertify.error("Error al ingresar los datos");
                            alert(r);
                        }
                }
            });                
            }

        });
    });


</script>