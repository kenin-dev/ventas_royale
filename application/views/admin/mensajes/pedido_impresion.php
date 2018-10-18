<div class="content-wrapper">
    <section class="content">
    	<center>
    		
	    	<h4>¿Que desea hacer?</h4>
	    	<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-pedido">IMPRIMIR NOTA DE PEDIDO&nbsp;<span class="fa fa-print"></span></button>
			<button type="button" class="btn btn-success btn-lg">Ir a las lista de pedidos</button>
    	</center>	
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
                <button type="button" class="btn btn-primary" onclick="imprimir('modal-pedido-body')"><span class="fa fa-print"> </span>Imprimir</button>
            </div>
        </div>
    </div>
</div>

<script>
	// function cargar_modal_pedido(){
	// 	const host = location.hostname;
 //        const port = (location.port=="") ? ':80' : port=":"+location.port;
 //        const url = "http://"+host+port+"/ventas_royale/";
	// 	$.ajax({
 //            type: 'POST',
 //            url: url+'reportes/Ventas/venta_pedido',
 //            data: {
 //                id: id
 //            },
 //            success: function(resp){

 //                const data = JSON.parse(resp);
 //                console.log(data);
                            
	// 			document.querySelector('#m_pedido_titulo').innerHTML = "<b>Pedido de Atencion : </b> "+data[0]['v_id']+"";

	// 	        document.querySelector('#m-pedido-cliente').innerHTML = "<b>Cliente : </b>"+data[0]['c_nombres']+"";

	// 	        var cad_ped = "";
	// 	        for( var i = 0; i < data.length; i++ ){
	// 	            cad_ped += "<ul>";
	// 	            cad_ped += "<li> "+data[i]['ct_nombre']+"</li>";
	// 	            cad_ped += "<li class='no-l'>";
	// 	            cad_ped += "<ul class='no-l'><li>"+data[i]['p_nombre']+"</li>";
	// 	            cad_ped += "<li>"+data[i]['dv_detalle']+"</li>";
	// 	            cad_ped += "</li></ul>";
	// 	            cad_ped += "</ul>";
	// 	        }
	// 	        document.querySelector("#m-pedido-orden").innerHTML = cad_ped;
	// 	        $("#modal-"+modal).modal();  

 //            },
 //            error: function(errorThrown){   
 //                console.log(errorThrown);
 //            }
 //        });
	// }

	function imprimir(id){
        $("#"+id).print();
    }
</script>