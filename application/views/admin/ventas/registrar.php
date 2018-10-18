<div class="content-wrapper">
    <section class="content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Venta 
                    <small>[ Registrar ]</small>
                </h2>

            </div>
            <div class="panel-body">
                <div class="row">
                    <form id="form_venta_registro" action="<?php echo base_url();?>movimientos/ventas/agregar_venta" method="POST" autocomplete='off'>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="">Pedido</label>
                                <input type="text" class="form-control" value="<?= $pedido->ped_id;?>" name="id_pedido" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="">Tipo de consumo</label>
                                <input type="text" class="form-control" value="<?= $pedido->ped_tipo_consumo;?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="">Destino</label>
                                <input type="text" class="form-control" value="<?= $pedido->ped_destino;?>" readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="">Subtotal</label>
                                <input type="text" class="form-control" name='subtotal' value="<?= $pedido->ped_subtotal;?>" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <hr>
                            <div class="col-md-3">
                                <label for="">Comprobante</label>
                                <select name="tipo_comprobante" class="form-control" required>
                                     <option value="" selected disabled hidden>Seleccionar...</option>
                                    <?php if (!empty($tipocomprobantes)) : ?>
                                        <?php foreach($tipocomprobantes as $tc) : ?>
                                        <option value="<?= $tc->id.'-'.$tc->cantidad.'-'.$tc->igv.'-'.$tc->serie;?>">
                                            <?= $tc->nombre;?>
                                        </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="">&nbsp;</label>
                                <!-- <input type="text" class="form-control" name="serie" readonly> -->
                                <div class="input-group">
                                    <span class="input-group-addon"><b>Serie:</b></span>
                                    <input type="text" class="form-control" name="serie" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- <label for="">Numero:</label>
                                <input type="text" class="form-control" name="numero" readonly> -->
                                <label for="">&nbsp;</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><b>Numero:</b></span>
                                    <input type="text" class="form-control" name="numero" readonly="readonly">
                                </div>
                            </div>
                        </div>
                
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <!-- <label for="">IGV:</label>
                                <input type="text" class="form-control" name="igv" readonly> -->
                                <label for="">&nbsp;</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><b>IGV:</b></span>
                                    <input type="text" class="form-control" name="igv" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- <label for="">Descuento</label>
                                <input type="text" class="form-control" name='descuento' readonly> -->
                                <label for="">&nbsp;</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><b>Descuento:</b></span>
                                    <input type="text" class="form-control" placeholder="0.00" name="descuento" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- <label for="">Total</label>
                                <input type="text" class="form-control" name='total' readonly> -->
                                <label for="">&nbsp;</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><b>Total:</b></span>
                                    <input type="text" class="form-control" name="total" readonly="readonly">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <p><b>Datos del cliente</b></p>
                            <div class="col-md-1">
                                <label for="">&nbsp;</label>
                                <br>
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-default" ><span class="fa fa-search"></span> Seleccionar</button>
                            </div>
                            <div class="col-md-2">
                                <label for="">id</label>
                                <input type="text" class="form-control" name='cliente_id' readonly required>
                            </div>
                            <div class="col-md-2">
                                <label for="">Dni</label>
                                <input type="text" class="form-control" name='cliente_dni' readonly required>
                            </div>
                            <div class="col-md-4">
                                <label for="">Nombres y apellidos</label>
                                <input type="text" class="form-control" name='cliente_nombres' readonly>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <div class="col-md-4">
                                <label for="">Recibido ( $ )</label>
                                <input type="number" class="form-control" name='recibido' onkeyup=" calcular_importe()" required>
                            </div>
                            <div class="col-md-4">
                                <label for="">Total a devolver ( $ )</label>
                                <input type="text" class="form-control" name='devuelto' readonly>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <button type="submit" class="btn btn-lg btn-success">
                                    Registrar&nbsp;
                                    <span class="fa fa-send"></span>
                                </button>
                            </div>      
                        </div>

                    </form>
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
                <button class="btn btn-warning" type="button" data-toggle="modal" data-dismiss="modal" data-target="#modal-registro-cliente" ><span class="fa fa-plus"></span> Agregar Nuevo</button>
                <hr>
                <table class="table table-bordered table-striped table-hover">
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
                                    <td><?php echo $cliente->nombre.' '.$cliente->ape_paterno.' '.$cliente->ape_paterno;?></td>
                                    <td><?php echo $cliente->num_documento;?></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-check" onclick="return seleccion_cliente(event)">Seleccionar</button>
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
                    <button type="submit" class="btn btn-success btn-flat">Agregar&nbsp;<span class="fa fa-send"></span></button>
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
            
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    document.addEventListener('DOMContentLoaded' , function(){

        document.querySelector('[name=tipo_comprobante]').addEventListener('change', function(){
            // alert(this.value);
            datos_comprobante(this.value);
        },false);

        document.querySelector('#form_venta_registro').addEventListener('submit', function(event){

            if (document.querySelector('[name=cliente_id]').value == '') {
                event.preventDefault();
                alert("seleccione el cliente");
            }

        }, false);

    }, true);

    function seleccion_cliente(e){
        var elemento = e.target;
        var padre = elemento.parentElement.parentElement.children;
        // var id = padre[0].textContent;
        // var dni = padre[1].textContent;
        // var nombre = padre[2].textContent;
        // console.log(padre[1].textContent);
        document.querySelector('[name=cliente_id]').value = padre[0].textContent;
        document.querySelector('[name=cliente_dni]').value = padre[1].textContent;
        document.querySelector('[name=cliente_nombres]').value = padre[2].textContent;


    }

    function datos_comprobante(comprobante){
        var data  = comprobante.split('-');
        var id = data[0];
        var cantidad = data[1];
        var igv = data[2];
        var serie = data[3];
        
        // document.querySelector('[name=tipo_comprobante]').value = id;

        document.querySelector('[name=numero]').value = generarnumero(cantidad);
        document.querySelector('[name=igv]').value = igv;
        document.querySelector('[name=serie]').value = serie;
        calcular_descuentos();

    }

    function calcular_descuentos(){
        var subtotal = document.querySelector('[name=subtotal]').value;  
        var igv = document.querySelector('[name=igv]').value;
        var descuento = ((subtotal/100)*igv).toFixed(2);
        var total = (parseFloat(subtotal) + parseFloat(descuento)).toFixed(2);
        document.querySelector('[name=descuento]').value = descuento;
        document.querySelector('[name=total]').value = total;

        calcular_importe();

    }

    function calcular_importe(){

        if (document.querySelector('[name=tipo_comprobante]').value == '') {
            alert("seleccione el tipo de comprobante!");
            document.querySelector('[name=recibido]').value = '';
        }else{
            
            if (document.querySelector('[name=recibido]').value == '') {
                var importe = document.querySelector('[name=recibido]').value = '';
            }else{
                var importe = document.querySelector('[name=recibido]').value;
                var total = document.querySelector('[name=total]').value; 
                var devuelto = (parseFloat(importe) - parseFloat(total)).toFixed(2);
                console.log(total+' - '+importe+' - '+devuelto);
                document.querySelector('[name=devuelto]').value = devuelto;
            
            }
        }

    }

    function generarnumero(numero){
        if (numero>= 99999 && numero< 999999) {
            return Number(numero)+1;
        }
        if (numero>= 9999 && numero< 99999) {
            return "0" + (Number(numero)+1);
        }
        if (numero>= 999 && numero< 9999) {
            return "00" + (Number(numero)+1);
        }
        if (numero>= 99 && numero< 999) {
            return "000" + (Number(numero)+1);
        }
        if (numero>= 9 && numero< 99) {
            return "0000" + (Number(numero)+1);
        }
        if (numero < 9 ){
            return "00000" + (Number(numero)+1);
        }
    }


</script>