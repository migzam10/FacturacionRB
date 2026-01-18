		        		<!-- BEGIN CSS for this page -->
		<link href="../assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<?php
require 'header.php';

if(isset($_SESSION['usuario']))
{



?>



<!-- Modal -->
<div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form id="frmproducto">
        <div class="row">
           
            <label>Nombre (*)</label>
            <input type="text" class="form-control" id="txtnombre" name="txtnombre">
            <label>Precio Compra (*)</label>
            <input type="number" class="form-control" id="txtprecioc" name="txtprecioc">
            <label>Precio Venta (*)</label>
            <input type="number" class="form-control" id="txtpreciov" name="txtpreciov">
            <label>Stock (*)</label>
            <input type="number" class="form-control" id="txtstock" name="txtstock">
            <label>Proveedor (*)</label><br>

            <select id="txtproveedor" name="txtproveedor" class="form-control select2">
               <option value="A">Seleccione</option>
                <?php
                    require_once '../clases/Proveedor.php';
                    require_once '../clases/Conexion.php';
                    $obj1 = new Proveedor();
                    $proveedor = $obj1->mostrar();
                    while($pro=mysqli_fetch_row($proveedor))
                    {
                ?>
                <option value="<?php echo $pro[0] ?>" ><?php echo $pro[1] ?></option>
                <?php
                    }
                        
                ?>
            </select><br>
            <label>Categoria</label>
            <select id="txtcategoria" name="txtcategoria" class="form-control select2">
                <option value="A">Seleccione</option>
                <?php
                    require_once '../clases/Categoria.php';
                    require_once '../clases/Conexion.php';
                    $obj1 = new Categoria();
                    $proveedor = $obj1->mostrar();
                    while($pro=mysqli_fetch_row($proveedor))
                    {
                ?>
                <option value="<?php echo $pro[0] ?>" ><?php echo $pro[1] ?></option>
                <?php
                    }
                        
                ?>               
            </select>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="btnregistrar">Guardar</button>
      </div>
    </div>
  </div>
</div>
    
    
<!-- Modal -->
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Añadir Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
<div class="modal-body">
       <form id="frmproductoa">
        <div class="row">
            <label>Stock (*)</label>
            <input type="number" class="form-control" id="txtstocka" name="txtstocka">
            </form>
        </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="btnañadir" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal2"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
<div class="modal-body">
       <form id="frmproductoe">
        <div class="row">
           
            <label>Nombre (*)</label>
            <input type="text" class="form-control" id="txtnombree" name="txtnombree">
            <label>Precio Compra (*)</label>
            <input type="number" class="form-control" id="txtprecioce" name="txtprecioce">
            <label>Precio Venta (*)</label>
            <input type="number" class="form-control" id="txtpreciove" name="txtpreciove">
            <label>Stock (*)</label>
            <input type="number" class="form-control" id="txtstocke" name="txtstocke">
            <label>Proveedor (*)</label>
            
            <select id="txtproveedore" name="txtproveedore" class="form-control js-example-basic-single">
               <option value="A">Seleccione</option>
                <?php
                    require_once '../clases/Proveedor.php';
                    require_once '../clases/Conexion.php';
                    $obj1 = new Proveedor();
                    $proveedor = $obj1->mostrar();
                    while($pro=mysqli_fetch_row($proveedor))
                    {
                ?>
                <option value="<?php echo $pro[0] ?>" ><?php echo $pro[1] ?></option>
                <?php
                    }
                        
                ?>
            </select>
            <label>Categoria</label>
            <select id="txtcategoriae" name="txtcategoriae" class="form-control">
                <option value="A">Seleccione</option>
                <?php
                    require_once '../clases/Categoria.php';
                    require_once '../clases/Conexion.php';
                    $obj1 = new Categoria();
                    $proveedor = $obj1->mostrar_cb();
                    while($pro=mysqli_fetch_row($proveedor))
                    {
                ?>
                <option value="<?php echo $pro[0] ?>" ><?php echo $pro[1] ?></option>
                <?php
                    }
                        
                ?>               
            </select>
            </form>
        </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="btneditar" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
    
      

    <div class="content-page">
	
    <!-- Start content -->
    <div class="content">
        
        <div class="container-fluid">
                
                    <div class="row">
                                <div class="col-xl-12">
                                        <div class="breadcrumb-holder">
                                                <h1 class="main-title float-left">Productos</h1>
                                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button"  class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                 Registrar
                                                </button>
                                                <div class="clearfix">
                                                								   
									
                                                </div>
                                        </div>
                                </div>
                    </div>
                    <!-- end row -->
                    <div class="row">
                       <!-- Button trigger modal -->
                       
                        <div class="col-lg-12">
                        <table  id="myTable" class="table">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Nombre</td>
                                    <td>Precio Compra</td>
                                    <td>Precio Venta</td>
                                    <td>Stock</td>
                                    <td>Proveedor</td>
                                    <td>Categoria</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                        </div>
                        
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
$(document).ready(function(){
    $('#txtproveedor').select2({
        dropdownParent: $("#exampleModal .modal-content")
    });
    $('#txtcategoria').select2({
        dropdownParent: $("#exampleModal .modal-content")
    });
    $('#txtproveedore').select2({
        dropdownParent: $("#exampleModal2 .modal-content")
    });
    $('#txtcategoriae').select2({
        dropdownParent: $("#exampleModal2 .modal-content")
    });
    
    var table = $('#myTable').DataTable({
        "ajax":{
            "url":"../procesos/productos/mostrar.php",
            "type":"GET"
            //"crossDomain": "true",
            //"dataType": "json",
            //"dataSrc":""
        },
        "columns":[
            {
                "data":"id_producto"
            },
            {
                "data":"nombre"
            },
            {
                
                "data":"precio_compra"
            },
            {
                
                "data":"precio_venta"
            },
            {
                
                "data":"stock"
            },
            {
                
                "data":"id_proveedor"
            },  
            {
                
                "data":"id_categoria"
            },
            {
                sTitle: "Eliminar",
                mDataProp: "id_producto",
                sWidth: '7%',
                orderable: false,
                render: function(data) {
                    acciones = `<button id="` + data + `" value="Eliminar"  type="button" class="fa fa-times btn btn-danger accionesTabla" >
                                    
                                </button>`;
                    return acciones
                }
            },
            {
                sTitle: "Editar",
                mDataProp: "id_producto",
                sWidth: '7%',
                orderable: false,
                render: function(data) {
                    acciones = `<button id="` + data + `" value="Traer" class="fa fa-pencil-square-o btn btn-primary accionesTabla" data-toggle="modal" data-target="#exampleModal2" type="button"  >
                                    
                                </button>`;
                    return acciones
                }
            },
            {
                sTitle: "Añadir",
                mDataProp: "id_producto",
                sWidth: '7%',
                orderable: false,
                render: function(data) {
                    acciones = `<button id="` + data + `" value="Añadir" class="fa fa-plus-circle btn btn-success accionesTabla" data-toggle="modal" data-target="#exampleModal3" type="button"  >
                                    
                                </button>`;
                    return acciones
                }
            }
        ],
        responsive:true,
                "ordering": false


    });
    
$(document).on('click', '.accionesTabla', function() {
    var id = this.id;
    var val = this.value;

    switch (val) {
        case "Traer":
                    $.ajax({
                        method : "GET",
                        url : "../procesos/productos/traer.php",
                        data:'id_producto='+id
                    }).done(function(msg) {
                        var dato=JSON.parse(msg);
                        
				        $('#txtnombree').val(dato['nombre']);
                        $('#txtprecioce').val(dato['precio_compra']);
                        $('#txtpreciove').val(dato['precio_venta']);
                        $('#txtstocke').val(dato['stock']);
                        $('#txtproveedore').val(dato['id_proveedor']);
                        $('#txtcategoriae').val(dato['id_categoria']);
                        
                        
                        
                        $('#btneditar').unbind().click(function(){
                            vacios = validarFormVacio('frmproductoe');
                            
                            
                            if(vacios <= 0)
                                {
                            noma = $("#txtnombree").val();
                            pc = $("#txtprecioce").val();
                            pv = $("#txtpreciove").val();
                            sto = $("#txtstocke").val();
                            prove = $("#txtproveedore").val();
                            cate = $("#txtcategoriae").val();
                             oka = {
						                "txtnombree" : noma , "id_producto" : id,
                                        "txtprecioce" : pc, "txtpreciove" : pv,
                                        "txtstocke" : sto, "txtproveedore" : prove,
                                        "txtcategoriae" : cate,
                                };
                            //alert(oka);
                            //alert(JSON.stringify(oka));
                            $.ajax({
                                method : "POST",
                                //contentType: 'application/json; charset=utf-8',
                                url : "../procesos/productos/editar.php",
                                data : oka
                                }).done(function(msg) {
                                alertify.success("Producto Editado Correctamente!");
                                table.ajax.reload();
                                });                               
                                    
                                }
                            else{
                                alertify.error("Complete los datos");
                            }

                        });
                    });
            break;
        case "Eliminar":
            
            alertify.confirm('Producto', '¿Esta seguro que desea eliminar este producto?', function()
                {
                        $.ajax({
                                type:"POST",
                                url : "../procesos/productos/eliminar.php",
                                data : "id="+id
                            }).done(function(msg) {
                                alertify.success("Producto Eliminado Correctamente");
                                table.ajax.reload();
                            });
                }
                , function(){
                
                });



        
                    break;
        case "Añadir":
                        $('#btnañadir').unbind().click(function(){
                            vacios = validarFormVacio('frmproductoa');
                            
                            
                            if(vacios <= 0)
                                {
                            noma = $("#txtstocka").val();
                             oka = {
						                "txtstock" : noma , "id_producto" : id
                                };
                            //alert(oka);
                            //alert(JSON.stringify(oka));
                            $.ajax({
                                method : "POST",
                                //contentType: 'application/json; charset=utf-8',
                                url : "../procesos/productos/stock.php",
                                data : oka
                                }).done(function(msg) {
                                if(msg == 1)
                                    {
                                alertify.success("Stock Agregado Correctamente!");
                                table.ajax.reload();  
                                    }
                                else if(msg == "n")
                                    {
                                alertify.error("Ingrese un numero valido");                                        
                                    }
                                else{
                                     alertify.error("No se pudo añadir");
                                }

                                });                               
                                    
                                }
                            else{
                                alertify.error("Complete los datos");
                            }

                        });
            break;
        default:
            alert("No existe el valor");
            break;
    }
    });    
    
    
    
    $('#btnregistrar').click(function(){
        vacios = validarFormVacio('frmproducto');
        if(vacios <= 0 )
            {
            datos=$('#frmproducto').serialize();
            $.ajax({
               type:'post',
                url:'../procesos/productos/registrar.php',
                data:datos,
                success:function(r)
                {
                    
                    if(r==1)
                        {
                            alertify.success("Producto Registrado Correcamente");
                            table.ajax.reload();
                        }
                    else if(r==0)
                        {
                            alertify.error("No se pudo registrar");
                        }
                    else
                        {
                            alert(r);
                        }
                }
            });
            }
        else{
            alertify.error("Complete los datos");
        }
    });
});
</script>


