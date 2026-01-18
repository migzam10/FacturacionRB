<?php
setlocale(LC_MONETARY, 'es_PE');
    require_once "../../clases/Venta.php";
    require_once "../../clases/Conexion.php";
    $obj = new Venta();
    $id = $_POST['id_venta'];
    $result = $obj->traer_detalles($id);

$re = "<div >
<table id='tbdetalle' class='table table-responsive text-center'>
                                            <tr class='bg-warning'>
                                              <th scope='col' style='width:10%'>Cantidad</th>
                                              <th scope='col' style='width:60%'>Productos</th>
                                              <th scope='col' style='width:15%'>V. Unidad</th>
                                              <th scope='col' style='width:15%''>V. Total</th>
                                            </tr>
";

while($r = mysqli_fetch_array($result))
{

    $re .= '
    <tr>
    <td> '. utf8_decode($r['cantidad']) .'</td>
    <td>'. html_entity_decode($r['id_productos']) .'</td>
    <td>'. utf8_decode(number_format( $r['precio'],0,',','.')) .'</td>
    <td>'. utf8_decode(number_format( $r['importe'],0,',','.')) .'</td>
    </tr>
    ';
}
$re .="</table";

echo $re;
?>