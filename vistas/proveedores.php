<?php
require 'header.php';

if(isset($_SESSION['usuario']))
{



?>



<!-- Modal registrar -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
           
           <div class="col-lg-12">
           <form id="frmregistrar">
            <label>Nombre (*)</label>
            <input type="text" class="form-control" id="txtnombre" name="txtnombre">
            <label>Direccion</label>
            <input type="text" class="form-control" id="txtdireccion" name="txtdireccion">
            <label>Telefono</label>
            <input type="text" class="form-control" id="txttelefono" name="txttelefono">
            <label>Email</label>
            <input type="text" class="form-control" id="txtemail" name="txtemail">
             </form>
            </div>
           
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
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
           
           <div class="col-lg-12">
           <form id="frmeditar">
            <label>Nombre (*)</label>
            <input type="text" class="form-control" id="txtnombree" name="txtnombree">
            <label>Direccion</label>
            <input type="text" class="form-control" id="txtdireccione" name="txtdireccione">
            <label>Telefono</label>
            <input type="text" class="form-control" id="txttelefonoe" name="txttelefonoe">
            <label>Email</label>
            <input type="text" class="form-control" id="txtemaile" name="txtemaile">
            </form>
            </div>
           
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
                                                <h1 class="main-title float-left">Proveedores</h1>
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
                                    <td>Direccion</td>
                                    <td>Telefono</td>
                                    <td>Email</td>
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
    
    var table = $('#myTable').DataTable({
        "ajax":{
            "url":"../procesos/proveedores/mostrar.php",
            "type":"GET"
            //"crossDomain": "true",
            //"dataType": "json",
            //"dataSrc":""
        },
        "columns":[
            {
                "data":"id_proveedor"
            },
            {
                
                "data":"nombre"
            },
            {
                
                "data":"direccion"
            },
            {
                "data":"telefono"
            },
            {
                
                "data":"email"
            },
            {
                sTitle: "Eliminar",
                mDataProp: "id_proveedor",
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
                mDataProp: "id_proveedor",
                sWidth: '7%',
                orderable: false,
                render: function(data) {
                    acciones = `<button id="` + data + `" value="Traer" class="fa fa-pencil-square-o btn btn-primary accionesTabla" data-toggle="modal" data-target="#exampleModal2" type="button"  >
                                    
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
                        url : "../procesos/proveedores/traer.php",
                        data:'id_proveedor='+id
                    }).done(function(msg) {
                        var dato=JSON.parse(msg);
				        $('#txtnombree').val(dato['nombre']);
                        $('#txtdireccione').val(dato['direccion']);
                        $('#txttelefonoe').val(dato['telefono']);
                        $('#txtemaile').val(dato['email']);
                        
                        
                        
                        $('#btneditar').unbind().click(function(){
                            
                            noma = $("#txtnombree").val();
                            dire = $("#txtdireccione").val();
                            tele = $("#txttelefonoe").val();
                            ema = $("#txtemaile").val();
                            if(noma.length != 0)
                                {
                             oka = {
						                "txtnombree" : noma , "id_proveedor" : id,
                                        "txtdireccione" : dire , "txttelefonoe" : tele,
                                        "txtemaile" : ema
                                };
                            //alert(oka);
                            //alert(JSON.stringify(oka));
                            $.ajax({
                                method : "POST",
                                //contentType: 'application/json; charset=utf-8',
                                url : "../procesos/proveedores/editar.php",
                                data : oka
                                }).done(function(msg) {
                                alertify.success("proveedor Editado Correctamente!");
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
            
            alertify.confirm('Eliminar Proveedor', '¿Esta seguro que desea eliminar este proveedor?', function()
                {
                        $.ajax({
                                type:"POST",
                                url : "../procesos/proveedores/eliminar.php",
                                data : "id="+id
                            }).done(function(msg) {
                                alertify.success("Proveedor Eliminado Correctamente");
                                table.ajax.reload();
                            });
                }
                , function(){
                
                });



        
                    break;
        default:
            alert("No existe el valor");
            break;
    }
    });    
    
    
    
    $('#btnregistrar').click(function(){
       nom = $('#txtnombre').val();
        if(nom.length != 0 )
            {
            datos = $('#frmregistrar').serialize();
            $.ajax({
               type:'post',
                url:'../procesos/proveedores/registrar.php',
                data:datos,
                success:function(r)
                {
                    
                    if(r==1)
                        {
                            alertify.success("Proveedor Registrado Correcamente");
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


