<div class="content-wrapper">
    <section class="content-header">
        <h1>
        Pedidos
        <small>Lista</small>
        </h1>
    </section>
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
                                            <button class="btn btn-primary" onclick="modal_imprimir(<?= $pedido->ped_id; ?>)">
                                                <span class="fa fa-print">
                                                </span>
                                                    Imprimir
                                            </button>
                                            <a class="btn btn-success" href="<?= base_url();?>movimientos/ventas/registrar/<?= $pedido->ped_id;?>">
                                                <span class="fa fa-file-invoice-dollar">
                                                </span>
                                                    Facturacion
                                            </a>
                                            <a onclick='eliminar(event)' href="<?php echo base_url()?>movimientos/pedido/eliminar/<?php echo $pedido->ped_id;?>" class="btn btn-danger">Eliminar</a>
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
<script>
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