<div class="content-wrapper">
    <div class="content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>
                Pedidos
                <small>[ Lista ]</small>
                </h2>
            </div>
            <div class="panel-body">
                <section class="content">
                    <div class="box box-solid">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12 ">
                                    <a href="<?php echo base_url();?>movimientos/pedido/nuevo" class="btn btn-warning">Nuevo Pedido&nbsp;
                                    <span class="fa fa-plus center-block"></span></a>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php 
                                        if ($this->session->flashdata('correcto')) {
                                     ?>
                                        <div class="alert alert-success alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <p><strong>Correcto : </strong><?php echo $this->session->flashdata('correcto'); ?></p>
                                        </div>
                                    <?php 
                                        }
                                     ?>
                                     <!--  -->
                                    <?php 
                                        if ($this->session->flashdata('error')) {
                                     ?>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <p><strong>Error : </strong><?php echo $this->session->flashdata('error'); ?></p>
                                        </div>
                                    <?php 
                                        }
                                     ?>
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Fecha</th>
                                                <th>Tipo de consumo</th>                         
                                                <th>Destino</th>
                                                <th>subtotal</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($pedidos)): ?>
                                            <?php foreach($pedidos as $pedido):?>
                                                <tr>
                                                    <td><?php echo $pedido->ped_id;?></td>
                                                    <td><?php echo $pedido->ped_fecha;?></td>
                                                    <td><?php echo $pedido->ped_tipo_consumo;?></td>
                                                    <td><?php echo $pedido->ped_destino;?></td>
                                                    <td><?php echo $pedido->ped_subtotal;?></td>
                                                    <td>
                                                        <button title="imprimir" class="btn btn-primary" onclick="modal_imprimir(<?= $pedido->ped_id; ?>)">
                                                            <span class="fa fa-print">
                                                            </span>
                                                                Imprimir
                                                        </button>
                                                        <a title="facturar" class="btn btn-success" href="<?= base_url();?>movimientos/ventas/registrar/<?= $pedido->ped_id;?>">
                                                            <span class="fa fa-file-invoice-dollar">
                                                            </span>
                                                                Facturacion
                                                        </a>
                                                        <a title="eliminar" onclick='eliminar(event)' href="<?php echo base_url()?>movimientos/pedido/eliminar/<?php echo $pedido->ped_id;?>" class="btn btn-danger">Eliminar</a>
                                                        <a href="<?= base_url()?>movimientos/pedido/editar/<?= $pedido->ped_id;?>" title="editar" class="btn btn-warning">Editar&nbsp;<span class="fa fa-pencil"></span></a>
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

<div class="modal fade" id="modal-pedido">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <!-- <h4 class="modal-title" id="m_pedido_titulo">Pedido de Atencion</h4> -->
            </div>
            <div class="modal-body" id="mp_body" style="font-family: 'Roboto Mono';">
                <center>
                    <h3 id="mp_titulo">Pedido de Atencion</h3>
                    <hr>
                </center>  
                <p id="mp_tipo_consumo"></p>
                <p id="mp_destino">Mesa : ???</p>
                <hr class="hr-text">
                <h4>Orden : </h4>
                <hr class="hr-text">
                <div id="mp_orden"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="imprimir('mp_body')"><span class="fa fa-print"></span>&nbsp;IMPRIMIR</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-editar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-editar-titulo">Pedido #105</h4>
            </div>
            <div class="modal-body" style="font-family: 'Roboto Mono';">
                <form action="<?= base_url()?>movimientos/pedido/editar" method="POST" autocomplete="off">
                    <div class="col-md-12">
                        <p>Editar Destino: </p>
                        <hr>
                        <div class="form-group col-md-12">
                            <label for="">Pedido</label>
                            <input type="text" name="id" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Tipo de Consumo</label>
                            <select name="tipo_consumo" class="form-control">
                                <!-- <option disabled hidden></option> -->
                                <option value="presencial">Presencial</option>
                                <option value="delivery">Delivery</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8" name="editar_div_destino">
                            <label for="">Nuevo Destino</label><!-- 
                            <input type="text" class="form-control" name="editar-nuevo_destino"> -->
                        </div>

                    </div>
                    <div class="col-md-12 text-center">
                        <hr>    
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-success" type="submit">
                            Guardar cambios&nbsp;<span class="fa fa-check"></span>
                        </button>
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer">
               
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    const get_query = document.querySelector.bind(document);

    document.querySelector('[name=tipo_consumo]').addEventListener('change', function(){
        consumo_destino(this.value);
    }, false);

    function editar(e){            
        var elemento = e.target.parentElement.parentElement.children;
        consumo_destino(elemento[2].textContent);
        get_query('[name=id]').value = elemento[0].textContent;
        get_query('[name=tipo_consumo]').value = elemento[2].textContent;
        get_query('[name=destino]').value = elemento[3].textContent;
        $("#modal-editar").modal();
    }

    function consumo_destino(valor){
        var origen = base_url+'mantenimiento/mesa/get_mesas_rest';
        const div_destino = get_query('[name=editar_div_destino]');
        if (document.querySelector('[name=destino]')) {
            let dest = get_query('[name=destino]');
            div_destino.removeChild(dest);
        }

        switch (valor) {
            case 'presencial':
                var list = document.createElement('select');
                list.setAttribute('name', 'destino');
                list.setAttribute('placeholder', 'seleccione la mesa');
                list.setAttribute('required', 'required');
                list.classList.add('form-control');
                div_destino.appendChild(list);
                    
                $.ajax({
                    url: origen,
                    type: 'POST',
                    data: {},
                    success: function(resp){
                        var data = JSON.parse(resp);
                        for (var i = 0; i < data.length; i++) {
                            var option = document.createElement('option');
                            option.setAttribute('value', data[i]['mesa_numero']);
                            option.text = 'Mesa '+data[i]['mesa_numero']+' - '+data[i]['mesa_estado'];
                        list.appendChild(option);
                            }
                    }
                });
                break;
            case 'delivery':
                var input = document.createElement('input');
                input.setAttribute('name', 'destino');
                input.setAttribute('type', 'text');
                input.setAttribute('required', 'required');
                input.setAttribute('placeholder', 'ingrese la direccion del destino');
                input.classList.add('form-control');
                div_destino.appendChild(input);
                break;
            default:
                break;
        }
    }
     
    function eliminar(e){
        var resp = confirm("Esta seguro que quiere eliminar este pedido?");
           if (resp==true) {
            console.log('eliminado');
           }else{
                e.preventDefault();
           }
    }

    function modal_imprimir(id){
        // var sv = new Servidor();
        $.ajax({
            type: 'POST',
            url: base_url+'movimientos/pedido/pedido_rest',
            data: {
                pedido: id
            },
            success: function(resp){
                var data = JSON.parse(resp);
                document.querySelector('#mp_titulo').innerHTML = "<b>Pedido de Atencion Nº "+data[0]['pedido_id']+"</b>";

                document.querySelector('#mp_tipo_consumo').innerHTML = "<b>Tipo de consumo : </b>"+data[0]['pedido_tipo_consumo'];

                document.querySelector('#mp_destino').innerHTML = "<b>Destino : </b>"+data[0]['pedido_destino'];

                var cad_ped = "";
                for( var i = 0; i < data.length; i++ ){
                    cad_ped += "<ul>";
                    cad_ped += "<li> <b>"+data[i]['prod_categoria']+" ("+data[i]['prod_cantidad']+")</b></li>";
                    cad_ped += "<li class='no-l'>";

                    cad_ped += "<ul class='no-l'><li>"+data[i]['prod_nombre']+"</li>";
                    cad_ped += "<li>Cantidad : "+data[i]['prod_cantidad']+"</li>";
                    cad_ped += "<li>"+data[i]['prod_detalle']+"</li>";
                    cad_ped += "</li></ul>";
                    cad_ped += "</ul>";
                }
                document.querySelector("#mp_orden").innerHTML = cad_ped;
                $("#modal-pedido").modal();             
            },
            error: function(errorThrown){   
                console.log(errorThrown);
            }
        });
    }

    function imprimir(id){
        $("#"+id).print()
    }
</script>