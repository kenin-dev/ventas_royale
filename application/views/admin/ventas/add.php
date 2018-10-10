<style>
    .small-box-custom {
        height: 90px;
    }
    .small-box-custom .small-box-footer {
        position: absolute;
        top: calc( 100% - 26px );
        width: 100%;
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Ventas
        <small>Nuevo</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        
                        <form action="<?php echo base_url();?>movimientos/ventas/store" method="POST" class="form-horizontal">
                            <div class="form-group">
                                <div class="col-md-3">
                                    <label for="">Comprobante:</label>
                                    <select name="comprobantes" id="comprobantes" class="form-control" required>
                                        <option value="">Seleccione...</option>
                                        <?php foreach($tipocomprobantes as $tipocomprobante):?> 
                                            <?php $datacomprobante = $tipocomprobante->id."*".$tipocomprobante->cantidad."*".$tipocomprobante->igv."*".$tipocomprobante->serie;?>
                                            <option value="<?php echo $datacomprobante;?>"><?php echo $tipocomprobante->nombre?></option>
                                        <?php endforeach;?>
                                    </select>
                                    <input type="hidden" id="idcomprobante" name="idcomprobante">
                                    <input type="hidden" id="igv">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Serie:</label>
                                    <input type="text" class="form-control" id="serie" name="serie" readonly>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Numero:</label>
                                    <input type="text" class="form-control" id="numero" name="numero" readonly>
                                </div>
                                 
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="">Cliente:</label>
                                    <div class="input-group">
                                        <input type="hidden" name="idcliente" id="idcliente">
                                        <input type="text" class="form-control" disabled="disabled" id="cliente">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-default" ><span class="fa fa-search"></span> Buscar</button>
                                        </span>
                                    </div><!-- /input-group -->
                                </div> 
                                <div class="col-md-3">
                                    <label for="">Fecha:</label>
                                    <input id="fecha_actual" type="date" class="form-control" name="fecha" required readonly>
                                    <script>
                                        class fecha{
                                            getFecha(){
                                                var d = new Date();
                                                var year  = d.getFullYear();
                                                var month = (d.getMonth()>9) ? d.getMonth() : '0'+d.getMonth();
                                                var day   = (d.getDay()>9) ? d.getDay() : '0'+d.getDay();
                                                return year+'-'+month+'-'+day;
                                            }
                                        }
                                        var cf = new fecha();

                                        document.getElementById("fecha_actual").defaultValue = cf.getFecha();
                                        console.log(cf.getFecha());
                                    </script>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label for="">Producto:</label>
                                    <input type="text" class="form-control" id="producto">
                                </div>
                                <div class="col-md-2">
                                    <label for="">&nbsp;</label>
                                    <button id="btn-agregar" type="button" class="btn btn-warning btn-flat btn-block"><span class="fa fa-plus"></span> Agregar</button>
                                </div>
                                <div class="col-md-4">
                                    <label class="help-block">&nbsp;</label>
                                    <span id="loadingProducto" class="fade"><i class="fa fa-spinner fa-spin"></i> <strong>Cargando</strong></span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <hr>
                                <?php foreach($categorias as $value): ?>
                                    <div class="col-lg-3 col-md-4 col-xs-6">
                                <a href="javascript: seleccionarCategoria(<?=$value->id?>)">
                                        <div class="small-box small-box-custom bg-green-active" style="background: url(<?php 
                                            echo base_url().$value->imagen; ?> ">
                                            <div class="inner">
                                                <h4><b style="color: #fff;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black"><?=$value->nombre?></b></h4>
                                            </div>
                                            <!-- <div class="icon">
                                                <i class="fa fa-list"></i>
                                            </div> -->
                                            <!-- <a style="color: #fff;" href="javascript: seleccionarCategoria(<?=$value->id?>)" class="small-box-footer"><b>SELECIONAR <i class="fa fa-arrow-circle-right"></i></b></a> -->
                                        </div>
                                </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <table id="tbventas" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Abreviatura</th>
                                        <th>Nombre</th>

                                        <th>Precio</th>
                                        <th>Stock Max.</th>
                                        <th>Cantidad</th>
                                        <th>Importe</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>

                            <div class="form-group">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">Subtotal:</span>
                                        <input type="text" class="form-control" placeholder="0.00" name="subtotal" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">IGV:</span>
                                        <input type="text" class="form-control" placeholder="0.00" name="igv" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">Descuento:</span>
                                        <input type="text" class="form-control" placeholder="0.00" name="descuento" value="0.00" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">Total:</span>
                                        <input type="text" class="form-control" placeholder="0.00" name="total" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-md-12">
                                    <br>
                                    <button type="submit" class="btn btn-lg btn-success btn-flat">Guardar&nbsp;<span class="fa fa-send"></span></button>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Seleccionar Cliente</h4>
            </div>
            <div class="modal-body">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-dismiss="modal" data-target="#modal-registro-cliente" ><span class="fa fa-plus"></span> Agregar Nuevo</button>
                <hr>
                <table id="example1" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Documento</th>
                            <th>Opcion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($clientes)):?>
                            <?php foreach($clientes as $cliente):?>
                                <tr>
                                    <td><?php echo $cliente->id;?></td>
                                    <td><?php echo $cliente->nombre;?></td>
                                    <td><?php echo $cliente->num_documento;?></td>
                                    <?php $datacliente = $cliente->id."*".$cliente->nombre."*".$cliente->tipocliente."*".$cliente->tipodocumento."*".$cliente->num_documento."*".$cliente->telefono."*".$cliente->direccion;?>
                                    <td>
                                        <button type="button" class="btn btn-success btn-check" value="<?php echo $datacliente;?>"><span class="fa fa-check"></span></button>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal-registro-cliente">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cliente Nuevo</h4>
            </div>
            <form action="<?php echo base_url();?>mantenimiento/clientes/store" method="POST">
                <div class="modal-body">
                    <div class="form-group col-md-10 <?php echo form_error("nombre") != false ? 'has-error':'';?>">
                        <label for="nombre">Nombres:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo set_value("nombre");?>">
                        <?php echo form_error("nombre","<span class='help-block'>","</span>");?>
                    </div>
                    <div class="form-group col-md-6 <?php echo form_error("nombre") != false ? 'has-error':'';?>">
                        <label for="paterno">Apellido Paterno:</label>
                        <input type="text" class="form-control" id="paterno" name="paterno" value="<?php echo set_value("paterno");?>">
                        <?php echo form_error("paterno","<span class='help-block'>","</span>");?>
                    </div>
                    <div class="form-group col-md-6 <?php echo form_error("materno") != false ? 'has-error':'';?>">
                        <label for="materno">Apellido Materno:</label>
                         <input type="text" class="form-control" id="materno" name="materno" value="<?php echo set_value("materno");?>">
                        <?php echo form_error("materno","<span class='help-block'>","</span>");?>
                    </div>
                    <div class="form-group col-md-6 <?php echo form_error("tipocliente") != false ? 'has-error':'';?>">
                        <label for="tipocliente">Tipo de Cliente</label>
                        <select name="tipocliente" id="tipocliente" class="form-control">
                            <option value="">Seleccione...</option>
                            <?php foreach ($tipoclientes as $tipocliente) :?>
                            <option value="<?php echo $tipocliente->id;?>" <?php echo set_select("tipocliente",$tipocliente->id);?>><?php echo $tipocliente->nombre ?></option>
                            <?php endforeach;?>
                        </select>
                        <?php echo form_error("tipocliente","<span class='help-block'>","</span>");?>
                    </div>
                    <div class="form-group col-md-6 <?php echo form_error("tipodocumento") != false ? 'has-error':'';?>">
                        <label for="tipodocumento">Tipo de Documento</label>
                        <select name="tipodocumento" id="tipodocumento" class="form-control" >
                            <option value="">Seleccione...</option>
                            <?php foreach ($tipodocumentos as $tipodocumento) :?>
                            <option value="<?php echo $tipodocumento->id;?>" <?php echo set_select("tipodocumento",$tipodocumento->id);?>><?php echo $tipodocumento->nombre ?></option>
                            <?php endforeach;?>
                        </select>
                        <?php echo form_error("tipodocumento","<span class='help-block'>","</span>");?>
                    </div>
                    <div class="form-group col-md-6 <?php echo form_error("numero") != false ? 'has-error':'';?>">
                        <label for="numero">Numero del Documento:</label>
                        <input type="text" class="form-control" id="numero" name="numero" value="<?php echo set_value("numero");?>">
                         <?php echo form_error("numero","<span class='help-block'>","</span>");?>
                    </div>    
                    <div class="form-group col-md-6">
                        <label for="telefono">Telefono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="direccion">Direccion:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion">
                    </div>
                </div>
                <div class="modal-footer">
                    <hr>   
                    <button type="submit" class="btn btn-lg btn-success btn-flat">Guardar&nbsp;<span class="fa fa-send"></span></button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>