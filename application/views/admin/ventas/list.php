
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Ventas
        <small>Listado</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 ">
                        <a href="<?php echo base_url();?>movimientos/ventas/add" class="btn btn-primary">
                        <span class="fa fa-shopping-cart center-block small-box"></span> Agregar Venta</a>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre Cliente</th>                                    
                                    <th>Numero del Comprobante</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($ventas)): ?>
                                    <?php foreach($ventas as $venta):?>
                                        <tr>
                                            <td><?php echo $venta->id;?></td>
                                            <td><?php echo $venta->nombre;?></td>
                                            <td><?php echo $venta->num_documento;?></td>
                                            <td><?php echo $venta->fecha;?></td>
                                            <td><?php echo $venta->total;?></td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-view-venta" value="<?php echo $venta->id;?>" data-toggle="modal" data-target="#modal-default"><span class="fa fa-search"></span></button>
                                                <a onclick="recargar()" href="<?php echo base_url()?>movimientos/ventas/delete/<?php echo $venta->id;?>" class="btn btn-danger btn-remove">Eliminar</a>
                                            </td>
                                            
                                        </tr>
                                    <?php endforeach;?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Informacion de la venta</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btn-print"><span class="fa fa-print"> </span>Imprimir</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>

    document.addEventListener('DOMContent', function(){

        /*document.querySelector("#eliminar").addEventListener('click', function(){
                location.reload();
        });*/

        function recargar(){
            location.reload();
        }

    });
    
    function consulta(){

        $.ajax({
            type: 'POST',
            url: Base_Url+'venta/eliminar',
            data: {
                id: id
            },
            success: function(resp){
                alert(resp);                
            },
            error: function(errorThrown){   
                console.log(errorThrown);
            }
        });
    } 
    function base_url(){
        const host = location.hostname;
        const port = (location.port=="") ? ':80' : port=":"+location.port;
        const base_url = "http://"+host+port+"/sistema_prestamo/";
        return base_url;
    }



</script>