<style>
    .small-box-custom {
        height: 90px;
    }
    .small-box-custom .small-box-footer {
        position: absolute;
        top: calc( 100% - 26px );
        width: 100%;
    }
    .cat_title {
        color: #fff;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
        Ventas
        <small>Nuevo Pedido</small>
        </h1>
    </section>

    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form-venta" action="<?php echo base_url();?>movimientos/ventas/add_pedido" method="POST" class="form-horizontal" autocomplete='off'>
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="">Tipo Consumo</label>
                                    <select name="tipo_consumo" class="form-control" required>
                                        <option value="" selected disabled hidden>Seleccionar</option>
                                        <option value="presencial">Presencial</option>
                                        <option value="deliveri">Deliveri</option>
                                    </select>
                                </div>    
                                <div class="col-md-4" name="div_destino">
                                    <label for="">Destino</label>
                                </div> 
                                <div class="col-md-2">
                                    <label for="">Fecha:</label>
                                    <input id="fecha_actual" type="date" class="form-control" name="fecha" required readonly>
                                    <script>
                                        class fecha{
                                            getFecha(){
                                                var d = new Date();
                                                var year  = d.getFullYear();
                                                var fake_m = d.getMonth() + 1;
                                                var month = ( fake_m > 9 ) ? fake_m : '0'+fake_m;
                                                var day   = (d.getDate()>9) ? d.getDate() : '0'+d.getDate();
                                                return year+'-'+month+'-'+day;
                                                // console.log("In: "+year+'-'+month+'-'+day);
                                            }
                                        }
                                        var f = new fecha();
                                        document.getElementById("fecha_actual").defaultValue = f.getFecha();
                                        // console.log("Out: "+f.getFecha());
                                    </script>
                                </div>  
                            </div>
                            <div class="form-group col-md-12">
                                <hr class="hr-text">
                                <?php foreach($categorias as $value): ?>
                                    <div class="col-lg-3 col-md-4 col-xs-6">
                                <a href="javascript: cargar_modal_productos(<?=$value->id?>)">
                                        <div class="small-box small-box-custom bg-green-active" style="background: url(<?php 
                                            echo base_url().$value->imagen; ?> ">
                                            <div class="inner">
                                                <h4><b class='cat_title'><?=$value->nombre?></b></h4>
                                            </div>
                                        </div>
                                </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <table id="tbventas" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Codigo</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Importe</th>
                                        <th>Detalles</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="pedido-tbody">
                                
                                </tbody>
                            </table>

                            <div class="form-group">
                                <hr class="hr-text">
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">Subtotal:</span>
                                        <input type="text" class="form-control" placeholder="0.00" name="subtotal" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-addon">Cantidad:</span>
                                        <input type="text" class="form-control" placeholder="0" name="pedido-cantidad" readonly>
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
<div class="modal fade" id="modal-productos">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="mod-prod-titulo">Categoria</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Abrev.</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Elegir</th>
                        </tr>
                    </thead>
                    <tbody id="mod-prod-tbody">
                        
                    </tbody>
                </table>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<script>
    
    var producto_memoria = new Array();
    document.addEventListener('DOMContentLoaded', function(){
        const va = new VentaAdd();

        document.querySelector('[name=tipo_consumo]').addEventListener('change', function(){
            const va = new VentaAdd();
            var divdestino = document.querySelector('[name=div_destino]');
            va.asignar_tipo_consumo( this.value, divdestino );

        }, false);
        document.querySelector('#form-venta').addEventListener('submit',function(event){
            
            var cant = document.querySelector('[name=pedido-cantidad]');
            // alert(cant.value.length)
            if (cant.value.length < 1) {
                event.preventDefault();
                alert('no se han agregado productos al pedido!.');
            }

        }, false);

    }, true);


    class VentaAdd {

        ruta(){
            const host = location.hostname;
            const port = (location.port=="") ? ':80' : port=":"+location.port;
            const url = "http://"+host+port+"/ventas_royale/";
            return url;
        }

        asignar_tipo_consumo(tipo, divdestino){
            
            var origen = this.ruta()+'mantenimiento/mesa/get_mesas_rest';
            if (document.querySelector('[name=destino]')) {
                // console.log("existe destino");
                let dest = document.querySelector('[name=destino]');
                divdestino.removeChild(dest);
            }
            switch (tipo) {
                case 'presencial':
                    var list = document.createElement('select');
                    list.setAttribute('name', 'destino');
                    list.setAttribute('placeholder', 'seleccione la mesa');
                    list.setAttribute('required', 'required');
                    list.classList.add('form-control');
                    divdestino.appendChild(list);
                    
                    $.ajax({
                        url: origen,
                        type: 'POST',
                        data: {},
                        success: function(resp){
                            var data = JSON.parse(resp);
                            // console.log(data.length)    
                            // filas 
                            //selected disabled hidden
                            for (var i = 0; i < data.length; i++) {
                                var option = document.createElement('option');
                                option.setAttribute('value', data[i]['mes_id']);
                                option.text = 'Mesa '+data[i]['numero']+' - '+data[i]['estado'];
                                list.appendChild(option);
                            }
                        }
                    });

                    break;
                case 'deliveri':
                    var input = document.createElement('input');
                    input.setAttribute('name', 'destino');
                    input.setAttribute('type', 'text');
                    input.setAttribute('required', 'required');
                    input.setAttribute('placeholder', 'ingrese la direccion del destino');
                    input.classList.add('form-control');
                    divdestino.appendChild(input);
                    break;
                default:
                    // statements_def
                    break;
            }
        }
    }

    function cargar_modal_productos(categoria){
        const va = new VentaAdd();
        $.ajax({
            url: va.ruta()+'mantenimiento/productos/categoria_productos_rest',
            type: 'POST',
            data: {categoria:categoria},
            success: function(resp){
                var data = JSON.parse(resp);
                var cadena = ""; 
                // console.log('productos : '+data.length);
                document.querySelector("#mod-prod-titulo").innerHTML = data[0]['cat_nom'];
              
                for (var i = 0; i < data.length; i++) {
                    cadena += "<tr id='"+data[i]['prod_id']+"'>";
                    cadena += "<td>"+data[i]['prod_id']+"</td>";
                    cadena += "<td>"+data[i]['prod_abrev']+"</td>";
                    cadena += "<td>"+data[i]['prod_nom']+"</td>";
                    cadena += "<td>"+data[i]['prod_prec']+"</td>";
                    cadena += "<td><button class='btn btn-success' onclick='prod_select(event)'>";
                    cadena += "seleccionar</button></td>";
                    cadena += "</tr>";
                }
                document.querySelector("#mod-prod-tbody").innerHTML = cadena;
                $("#modal-productos").modal();
            }
        });
    }

    function calcular(){
        var cant = document.querySelector('[name=pedido-cantidad]');
        var sub_total = document.querySelector('[name=subtotal]');
        var acum = 0;
        // console.log(producto_memoria.length);
        cant.value = producto_memoria.length;
        for(var i=0; i<producto_memoria.length; i++){
            acum = parseFloat(acum + parseFloat(producto_memoria[i]['importe'])); 
        }
        // console.log(acum);
        sub_total.value = acum;
    }

    function cantidad_calculo(e){
        var elemento = e.target;
        var padre = elemento.parentElement.parentElement;
        var indice = padre.children[0].textContent - 1;

        var cantidad = elemento.value;
        var precio = elemento.parentElement.previousElementSibling.textContent;
        var campo_importe = elemento.parentElement.nextElementSibling;
        var importe = (cantidad * precio);
        campo_importe.children[0].value = importe;

        producto_memoria[indice]['cantidad'] = cantidad;  
        producto_memoria[indice]['importe'] = importe;
        calcular();

    }

    function prod_select(e){
        var elemento = e.target;
        var padre = elemento.parentElement.parentElement.children;
        // console.log(padre[2].textContent);
        producto_memoria.push({
            'id_prod':padre[0].textContent,
            'abrev':padre[1].textContent,
            'producto':padre[2].textContent,
            'precio':padre[3].textContent,
            'cantidad':1,
            'importe':padre[3].textContent,
            'detalle':''
        });
        // console.log(producto_memoria); 
        $("#modal-productos").modal('hide');
        tabla_pedido();
    }

    function detalles_reg(e){
        var elemento = e.target;
        var valor = elemento.value;
        var indice = elemento.parentElement.parentElement.children[0].textContent - 1;
        producto_memoria[indice]['detalle'] = valor;
        
    }

    function tabla_pedido(){
        var table = document.querySelector('#pedido-tbody');
        var cadena = "";
        for(var i = 0; i < producto_memoria.length; i++){
            cadena += "<tr>";
            cadena += "<td>"+(i+1)+"</td>";
            cadena += "<td>"+producto_memoria[i]['producto']+"</td>";
            cadena += "<td><input type='hidden' name='idproductos[]' value='"+producto_memoria[i]['id_prod']+"'>"+producto_memoria[i]['id_prod']+"</td>";
            cadena += "<td><input type='hidden' name='precios[]' value='"+producto_memoria[i]['precio']+"'>"+producto_memoria[i]['precio']+"</td>";
            cadena += "<td><input type='number' name='cantidades[]' class='form-control calcula' onkeypress='return cantidad_calculo(event)' onchange='return cantidad_calculo(event)' maxlength='2' value='"+producto_memoria[i]['cantidad']+"'></td>";

            cadena += "<td><input type='text' class='form-control' name='importes[]'  value='"+producto_memoria[i]['importe']+"' readonly></td>";

            cadena += "<td><input type='text' name='detalles[]' class='form-control' value='"+producto_memoria[i]['detalle']+"' onkeyup='detalles_reg(event)'></td>";

            cadena += "<td><button type='button' class='btn btn-danger' onclick='pedido_eliminar(event)'>Borrar</button></td>";
            cadena += "</tr>";

            cadena += "</tr>";
        }
        table.innerHTML = cadena;
        calcular();
    }

    function pedido_eliminar(e){
        var elemento = e.target;
        var indice = elemento.parentElement.parentElement.children[0].textContent;
        var id = (indice > 0) ? indice-1 : 0;

        producto_memoria.splice(id,1);
        tabla_pedido();
    }

    function seleccionarCategoria($idCategoria) {
        $('#loadingProducto').addClass('in');
        $.ajax({
            url: base_url+"movimientos/ventas/getproductosCategoria",
            type: "POST",
            dataType:"json",
            data:{ valor: $idCategoria },
            success:function(data){
                $("#producto").autocomplete({
                    source: $.map(data, function(el, i) {
                        // Cambio aqui
                        return $.extend(true, {}, el, { label: el.nombre+' - S/ '+el.precio });
                    }),
                    minLength: 0,
                    select:function(event, ui){
                        data = ui.item.id + "*"+ ui.item.abreviatura+ "*"+ ui.item.label+ "*"+ ui.item.precio+ "*"+ ui.item.stock;
                        memoria = data;
                    },
                }).on("focus", function () {
                    $(this).autocomplete("search", "");
                }).trigger('focus');
                $('#loadingProducto').removeClass('in');
            }
        });
    }
</script>