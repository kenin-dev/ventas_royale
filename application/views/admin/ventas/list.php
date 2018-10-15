<div class="content-wrapper">
    <section class="content-header">
        <h1>
        Ventas
        <small>Listado</small>
        </h1>
    </section>
    <section class="content">
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
                                            <td><?php echo $venta->nombre.' '.$venta->ape_paterno.' '.$venta->ape_materno;?></td>
                                            <td><?php echo $venta->num_documento;?></td>
                                            <td><?php echo $venta->fecha;?></td>
                                            <td><?php echo $venta->total;?></td>
                                            <td>
                                                <!--<button type="button" class="btn btn-info" value="<?php echo $venta->id;?>" data-toggle="modal" data-target="#modal-default"><span class="fa fa-search"></span></button>-->
                                                <button class="btn btn-info" onclick="ModalPRINT(<?= $venta->id; ?>,'doc')">
                                                    <span class="fa fa-print">
                                                    </span>
                                                    Documento
                                                </button>
                                                <button class="btn btn-warning" onclick="ModalPRINT(<?= $venta->id; ?>,'pedido')">
                                                    <span class="fa fa-print">
                                                    </span>
                                                    Pedido
                                                </button>
                                                <a href="<?php echo base_url()?>movimientos/ventas/delete/<?php echo $venta->id;?>" class="btn btn-danger">Eliminar</a>
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
            <p id="m-doc-comprobante">Boleta Nº xxxx</p>
            <!-- <h5 class="modal-title">Venta : <span id="m_pedido_titulo"></span></h5> -->
            <hr>
            <p id="m-doc-fecha">Fecha : 13/10/1994</p>
            <p id="m-doc-cliente">Cliente : Joselo</p>
            <hr>
            
            <table class="table">
                <caption><b>CONSUMO:</b></caption>
                <thead>
                    <tr>
                        <th>PRODUCTO</th>
                        <th>CANT.</th>
                        <th>IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
            <hr class="hr-text">
            <p><b>TOTAL : S/ 199.5 </b></p>
        </center> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="PRINT_MD('modal-doc-body')"><span class="fa fa-print"> </span>Imprimir</button>
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
            <div class="modal-body" id="modal-pedido-body">
                <center>
                    <h3 id="m_pedido_titulo">Pedido de Atencion</h3>
                    <hr>
                </center>  
                <p id="m-pedido-cliente">Cliente : xxx</p>
                <p>Mesa : ???</p>
                <hr class="hr-text">
                <h4>Orden : </h4>
                <hr class="hr-text">
                <div id="m-pedido-orden"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="PRINT_MD('modal-pedido-body')"><span class="fa fa-print"> </span>Imprimir</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContent', function(){


    });

    function ModalPRINT(id,modal){
        const host = location.hostname;
        const port = (location.port=="") ? ':80' : port=":"+location.port;
        const url = "http://"+host+port+"/ventas_royale/";
        // return 'data? : '+id;
        $.ajax({
            type: 'POST',
            url: url+'reportes/Ventas/venta_pedido',
            data: {
                id: id
            },
            success: function(resp){
                const data = JSON.parse(resp);
                console.log(data);
                // document.querySelector('#m_'+modal+"_titulo").innerHTML = data[0]['c_nombres'];
                switch (modal) {
                    case 'pedido':
                        document.querySelector('#m_pedido_titulo').innerHTML = "<b>Pedido de Atencion : </b> "+data[0]['v_id']+"";

                        document.querySelector('#m-pedido-cliente').innerHTML = "<b>Cliente : </b>"+data[0]['c_nombres']+"";

                        var cad_ped = "";
                        // console.log(data.length);
                        for( var i = 0; i < data.length; i++ ){
                            cad_ped += "<ul>";
                            cad_ped += "<li> "+data[i]['ct_nombre']+"</li>";
                            cad_ped += "<li class='no-l'>";
                            cad_ped += "<ul class='no-l'><li>"+data[i]['p_nombre']+"</li>";
                            cad_ped += "<li>"+data[i]['dv_detalle']+"</li>";
                            cad_ped += "</li></ul>";
                            cad_ped += "</ul>";
                        }
                        document.querySelector("#m-pedido-orden").innerHTML = cad_ped;
                        break;
                    case 'doc':
                        // statements_1
                        break;
                    default:
                        // statements_def
                        break;
                }
                $("#modal-"+modal).modal();             
            },
            error: function(errorThrown){   
                console.log(errorThrown);
            }
        });
    }
    function PRINT_MD(id){
        $("#"+id).print();
    }
</script>
<style>
    .hr-text {
        border-top: 1px dashed #8c8b8b;
    }
    .xs{
        text-align:right;
    }
    .no-l{
        list-style: none;
    }
</style>