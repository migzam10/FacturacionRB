<?php
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/Venta.php";
require_once "../../clases/EstadoCuenta.php";
$objPago = new EstadoCuenta();
$objc = new Conexion();
$obj = new Venta();
$ccn = $objc->conectar();

$nombre_cliente = mysqli_real_escape_string($ccn,$_POST['txtcliente']);
$tipo = $_POST['txttipo'];
$id_cliente = $_POST['txtnumero'];
$id_consecutivo = $_POST['txtconsecutivo'];
$fecha = $_POST['txtfecha'];

//var_dump($_SESSION['tablacomprastemp']);

if($tipo=="credito")
{
    $estado_credito = "pendiente";
}else{
    $estado_credito = "pagado";
   
}
$total = $_POST['txttotal'];

if(empty($nombre_cliente) || empty($tipo) || empty($id_cliente) || empty($id_consecutivo))
{
  echo "v";

}
else {
    if(isset($_SESSION['tablacomprastemp']))
    {
        

    if(count(@$_SESSION['tablacomprastemp']) == 0)
    {
        echo "tablav";
    }
        else {
        //echo $datoscontrato;
        try{

            $obj->save($nombre_cliente,$total,$tipo,$id_cliente, $estado_credito, $id_consecutivo, $fecha);
            $obj->save_detalle($id_consecutivo);
            if($tipo!="credito")
            {
                $objPago->registrarPagoTotal($id_consecutivo, $total, 'total');
            }
            echo "ok";
            unset($_SESSION['tablacomprastemp']);
        }catch(Exception $ex){
            echo $ex;
        }
      }
    }
    else
    {
        echo "tablav";
    }

}


?>
