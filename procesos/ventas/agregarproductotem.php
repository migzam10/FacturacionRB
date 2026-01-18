<?php
  session_start();
  require_once '../../clases/Conexion.php';
  $c = new Conexion();
  $conexion = $c->conectar();
  $producto=$_POST['txtproducto'];
  //$vUnidad=(float)$_POST['txtvunidad'];
  //$cantidad = (float)$_POST['txtcantidad'];
  $categoria=$_POST['txtcategoria'];

  $cantidad = number_format($_POST['txtcantidad'], 2, '.', '');
  $vUnidad = number_format($_POST['txtvunidad'], 2, '.', '');
  if(!empty($cantidad) and !empty($vUnidad) and !empty($producto)  and is_numeric($cantidad) and is_numeric($vUnidad) )
  {
  
    $consulta = "select nombre,id_categoria from categorias where id_categoria='$categoria'";
    $result = mysqli_query($conexion,$consulta);
    $tablap = $result->fetch_object();


    $total = 0;
        if(isset($_SESSION['tablacomprastemp'])){
           
            foreach (@$_SESSION['tablacomprastemp'] as $key) {

                $d=explode("||",@$key);
                if($d[4] == $producto)
                {
                    $total=$total+$d[2];
                }
            
            }     
        }
        
      if($cantidad <=0)
      {
          echo "n";
      }
      else
      {
            $importe=$cantidad*$vUnidad;
  $articulo = $producto."||".
  $vUnidad."||".
  $cantidad."||".
  $importe."||".
  $tablap->nombre."||".
  $tablap->id_categoria;
  //variable de session-

  $_SESSION['tablacomprastemp'][]=$articulo;
      echo "1";   
      }
   
  }
  

  else
  {
      echo "camposventa";
  }


?>