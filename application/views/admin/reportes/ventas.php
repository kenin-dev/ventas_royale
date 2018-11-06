<div class="content-wrapper">
    <div class="content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>
                Reportes
                <small>[ Ventas totales]</small>
                </h2>
            </div>
            <div class="panel-body">
                <section class="content">
                    <div class="box box-solid">
                        <div class="box-body">
                            <div class="row">
                                <form action="<?php echo current_url();?>" method="POST" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="" class="col-md-1 control-label">Desde:</label>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="fechainicio" value="<?php echo !empty($fechainicio) ? $fechainicio:'';?>">
                                        </div>
                                        <label for="" class="col-md-1 control-label">Hasta:</label>
                                        <div class="col-md-3">
                                            <input type="date" class="form-control" name="fechafin" value="<?php  echo !empty($fechafin) ? $fechafin:'';?>">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="submit" name="buscar" value="Buscar" class="btn btn-primary">
                                            <a href="<?php echo base_url(); ?>reportes/ventas" class="btn btn-danger">Restablecer</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="example" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre Cliente</th>
                                                <th>Tipo Comprobante</th>
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
                                                        <td><?php echo $venta->ven_id;?></td>
                                                        <td><?php echo $venta->nombre;?></td>
                                                        <td><?php echo $venta->tipocomprobante;?></td>
                                                        <td><?php echo $venta->num_documento;?></td>
                                                        <td><?php echo $venta->ven_fecha;?></td>
                                                        <td><?php echo $venta->ven_total;?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-info btn-view-venta" value="<?php echo $venta->ven_id;?>" data-toggle="modal" data-target="#modal-default"><span class="fa fa-search"></span></button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach;?>
                                            <?php endif ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
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
