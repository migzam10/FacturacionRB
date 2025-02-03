<?php
if(isset($_POST['txtcontraseñaactual']) or isset($_POST['txtcontraseñanueva']))
{
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/Usuario.php";
$objc = new Conexion();
$obj = new Usuario();
$ccn = $objc->conectar();

$contraseñaa = mysqli_real_escape_string($ccn,$_POST['txtcontraseñaactual']);
$contraseñan = mysqli_real_escape_string($ccn,$_POST['txtcontraseñanueva']);

if(empty($contraseñaa) or empty($contraseñan))
{
  echo "v";
}
else {

  if(sha1(md5($contraseñaa)) == $_SESSION['datos']->clave)
  {
    echo $obj->cambiarpass($contraseñan);
    
  }
  else
  {
    echo "cr";
  }
  
}
}
else{
    echo ":)";
}



?>
