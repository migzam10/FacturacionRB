<?php
session_start();

?>

<table id="dtproductos" class="table table-responsive-xl table-bordered table-hover table-condensed">
    <thead>
        <tr>
            <td style="width:50%">Producto</td>
            <td style="width:10%">Cantidad</td>
            <td style="width:20%">Vlr. Unid.</td>
            <td style="width:20%">Vlr. Total</td>
            <td style="width:10%">Categoria</td>
            <td style="width:10%">Acciones</td>
        </tr>

    </thead>

    <?php
 $total = 0;//total de la compra en dinero
 if(isset($_SESSION['tablacomprastemp']))
 {
  $index=0;
  foreach (@$_SESSION['tablacomprastemp'] as $key) {

  $d=explode("||",@$key);
  $total=$total+$d[3];
?>


    <tbody>

        <tr>
            <td><?php echo $d[0]; ?></td>
            <td><?php echo $d[2]; ?></td>
            <td><?php echo number_format($d[1],0,',','.'); ?></td>
            <td><?php echo number_format($d[3],0,',','.'); ?></td>
            <td><?php echo $d[4]; ?></td>

            <td>
                <span class="btn btn-danger btn-sm" onclick="quitarp('<?php echo $index ?>')">
                    <span class="fa fa-window-close"></span>
                </span>
            </td>
        </tr>

        <?php
$index++;
}

} ?>

        <tr>
            
            <td class="bg-primary text-center">
                <h5>TOTAL A PAGAR $ </h5>
            </td>
            <td class="bg-primary"></td>
            <td class="bg-primary"></td>
            .<td class="bg-primary">
                <h5 ><?php echo number_format($total,0,',','.');?></h5>
                <h5 id="txttotal" name="txttotal" hidden><?php echo $total;?></h5>
            </td>
        </tr>
    </tbody>
</table>