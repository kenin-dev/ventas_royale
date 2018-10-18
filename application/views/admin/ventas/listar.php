<div class="content-wrapper">
    <section class="content-header">
        <h1>
        Ventas
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
                                    <th>Cliente</th>
                                    <th>Tipo de consumo</th>                         
                                    <th>Destino</th>
                                    <th>Total</th>
                                    <th>Recibido</th>
                                    <th>Devuelto</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($ventas)): ?>
                                <?php foreach($ventas as $venta):?>
                                    <tr>
                                        <td><?php echo $venta->ven_id;?></td>
                                        <td><?php echo $venta->ven_fecha;?></td>
                                        <td><?php echo $venta->cli_nombres;?></td>
                                        <td><?php echo $venta->ped_tipo_consumo;?></td>
                                        <td><?php echo $venta->ped_destino;?></td>
                                        <td><?php echo $venta->ven_total;?></td>
                                        <td><?php echo $venta->ven_monto_recibido;?></td>
                                        <td><?php echo $venta->ven_monto_devuelto;?></td>
                                        <td>
                                            <button class="btn btn-primary" onclick="modal_imprimir(<?= $venta->ven_id; ?>)">
                                                <span class="fa fa-print">
                                                </span>
                                                    Imprimir
                                            </button>
                                            <!-- <a onclick='eliminar(event)' href="<?php echo base_url()?>movimientos/pedido/eliminar/<?php echo $venta->ped_id;?>" class="btn btn-danger">Eliminar</a> -->
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

<div class="modal fade" id="modal-doc">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" hidden>Venta : <span id="m_doc_titulo"></span></h4>
      </div>
      <div class="modal-body" id="modal-doc-body">
        <center>
            <img src="<?= base_url()?>assets/img/ventas_isologo_print.png" alt="" class="img-responsive">
            <div class="col-xs-12 text-center">
                <b>Empresa de Ventas</b><br>
                Calle Moquegua 430 <br>
                Tel. 481890 <br>
                Email: laroyale@gmail.com
                <hr class="hr-text">
            </div>
            <h3 id="mdoc_numero">Boleta Nº xxxx</h3>
            <!-- <h5 class="modal-title">Venta : <span id="m_pedido_titulo"></span></h5> -->
            <hr>
            <p id="mdoc_fecha">Fecha : 13/10/1994</p>
            <p id="mdoc_cliente">Cliente : Joselo</p>
            <p id="mdoc_tipo_consumo">Fecha : 13/10/1994</p>
            <p id="mdoc_destino">Fecha : 13/10/1994</p>
            <hr>
        </center> 
            <table class="table">
                <caption><b>CONSUMO:</b></caption>
                <thead>
                    <tr>
                        <th>PRODUCTO</th>
                        <th>CANT.</th>
                        <th>IMPORTE</th>
                    </tr>
                </thead>
                <tbody id="mdoc_tbody">
                    
                </tbody>
            </table>
            <hr class="hr-text">
            <p id="mdoc_total"><b>TOTAL : S/ 199.5 </b></p>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="imprimir('modal-doc-body')"><span class="fa fa-print"> </span>Imprimir</button>
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
            url: base_url+'movimientos/ventas/venta_rest',
            data: {
                venta: id
            },
            success: function(resp){
                var data = JSON.parse(resp);
                // console.log(data);
                document.querySelector('#mdoc_numero').innerHTML = "<b>Venta Nº "+data[0]['ven_id']+"</b>";

                document.querySelector('#mdoc_fecha').innerHTML = "<b>Fecha : </b>"+data[0]['ven_fecha'];

                document.querySelector('#mdoc_cliente').innerHTML = "<b>Cliente : </b>"+data[0]['cli_nombres'];

                document.querySelector('#mdoc_tipo_consumo').innerHTML = "<b>Tipo de consumo : </b>"+data[0]['ped_tipo_consumo'];

                document.querySelector('#mdoc_destino').innerHTML = "<b>Destino de Servicio : </b>"+data[0]['ped_destino'];

                document.querySelector('#mdoc_total').innerHTML = "<b>TOTAL : </b>"+data[0]['ven_total'];

                var cad_ped = "";
                for( var i = 0; i < data.length; i++ ){
                    // cad_ped += "<ol style='list-style-type: square;'>";
                    // cad_ped += "<li> <b>"+data[i]['cat_nombre']+" ("+data[i]['dp_cantidad']+")</b></li>";
                    // cad_ped += "<li class='no-l'>";

                    // cad_ped += "<ul class='no-l'><li>"+data[i]['prod_nombre']+"</li>";
                    // cad_ped += "<li><i>Cantidad :"+data[i]['dp_cantidad']+"</i> </li>";
                    // cad_ped += "<li>"+data[i]['dp_detalle']+"</li>";
                    // cad_ped += "</li></ul>";
                    // cad_ped += "</ol>";
                    cad_ped += "<tr>";
                    cad_ped += "<td>"+data[i]['cat_abrev']+" "+data[i]['prod_nombre']+"</td>";
                    cad_ped += "<td>"+data[i]['dp_cantidad']+"</td>";
                    cad_ped += "<td>"+data[i]['dp_importe']+"</td>";
                    cad_ped += "</tr>";
                }
                document.querySelector("#mdoc_tbody").innerHTML = cad_ped;
                $("#modal-doc").modal();             
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