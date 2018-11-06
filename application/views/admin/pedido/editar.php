<div class="content-wrapper">
    <div class="content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Editar Pedido #<?= $pedido->ped_id;?></h2>
            </div>
            <div class="panel-body">
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
                </div>
                <div class="col-md-12" style="display: none;">
                    <div class="col-md-3">
                        <label for=""><b>Pedido</b></label>
                        <input type="hidden" class="form-control control-center" value="<?= $pedido->ped_id; ?>" name="id" readonly>
                    </div>
                </div>

                <div id="cont_tipo_consumo" class="col-md-12 panel panel-default">
                    <h4><b>Tipo de consumo y destino</b></h4><hr>
                    <div class="form-group col-md-12">
                        
                        <div class="col-md-3">
                            <label for="">Tipo de Consumo Actual</label>
                            <p class="redrosa" id="tipo_consumo_actual"></p>
                        </div>
                        <div class="col-md-3">
                            <label for="">Destino Actual</label>
                            <p class="redrosa" id="destino_actual"></p>
                        </div>
                        <!-- <div class="col-md-3">
                            <label for="">&nbsp;</label>
                            <br>
                            <button class="btn btn-warning">
                                Editar&nbsp;
                                <span class="fa fa-pencil"></span>
                            </button>
                        </div> -->
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <div class="col-md-3">
                            <label class="">Nuevo Tipo de Consumo</label>
                            <select name="tipo_consumo" class="form-control">
                                <!-- <option disabled hidden></option> -->
                                <option value="presencial">Presencial</option>
                                <option value="delivery">Delivery</option>
                            </select>
                            <br>
                        </div>
                        <div class="col-md-4" name="cont_destino">
                            <label for="">Nuevo Destino</label>
                            <br>
                        </div>
                        <div class="col-md-4">
                            <label for="">&nbsp;</label>
                            <br>
                            <!-- <button id="recargar-tconsumo" title="recargar" class="btn btn-warning">
                                <span class="fa fa-refresh"></span>
                            </button> -->
                            <button id="guardar_tipo_consumo" title="guardar" class="btn btn-success">Guardar Cambios 
                                <span class="fa fa-check"></span>
                            </button>
                            <br>
                        </div>
                    </div>
                </div>
                <div id="cont_detalle_consumo" class="col-md-12 panel panel-default">
                    <h4><b>Consumo</b></h4><hr>
                    <div class="col-md-4">
                        <label for="">Subtotal del pedido</label>
                        <input name="subtotal" type="text" class="form-control focus control-center" value="<?= $pedido->ped_subtotal; ?>" readonly>
                        <hr>
                    </div>
                    <div class="col-md-3">
                        <label for="">&nbsp;</label>
                        <br>
                        <button onclick="cargar_modal_producto()" class="btn btn-warning">Agregar 
                            <span class="fa fa-plus"></span>
                        </button>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="1">#</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Detalle</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                         <tbody id="tbody_productos">
                            <!-- <?php if (!empty($detalle)):?>
                            <?php foreach($detalle as $det): ?>
                                <tr>
                                    <td><?= $det->dp_id; ?></td>
                                    <td>
                                        <b><?= $det->cat_abrev?></b> : <?=$det->producto; ?>
                                    </td>
                                    <td><?= $det->dp_precio; ?></td>
                                    <td><?= $det->dp_cantidad; ?></td>
                                    <td><?= $det->dp_importe; ?></td>
                                    <td>
                                        <button class="btn btn-danger">
                                            <span class="fa fa-times"></span>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php endif; ?> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-producto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Agregar Producto</b></h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    
                    <div class="col-md-6">
                        <label for="">Categoria</label>
                        <select name="select_categoria" class="form-control">
                            <option disabled hidden>seleccionar</option>
                        </select>
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label for="">Producto</label>
                        <select name="select_producto" class="form-control">
                        </select>
                        <br>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-3">
                        <label for="">Precio</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="">Cantidad</label>
                        <input type="number" class="form-control" min="1" max="5" value="1">
                    </div>
                    <div class="col-md-6">
                        <label for="">Detalles</label>
                        <input type="text" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <div class="col-md-6 col-md-offset-2">
                        <label for="">Importe Total</label>
                        <input type="text" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="">&nbsp;</label>
                        <br>
                        <button class="btn btn-success">Agregar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>   
                </div>
            </div>
            <div class="modal-footer">
               
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    const get_id = document.getElementById.bind(document);
    const get_query = document.querySelector.bind(document);

    document.addEventListener('DOMContentLoaded', function(){
        cargar_nuevo_destino(get_query('[name=tipo_consumo]').value);
        cargar_destino_actual();
        cargar_productos_pedido();
        // iziToast.show({
        //     title: 'Error',
        //     message: 'El proceso no se completo, intente de nuevo.',
        //     position: 'topCenter',
        //     backgroundColor: '#fd0054',
        //     titleColor: '#fff',
        //     messageColor: '#fff',
        //     timeout : 3000, 
        //     icon : 'fa fa-info',
        //     iconColor: '#fff' 
        // });
    }, false);


// TIPO CONSUMO - DESTINO

    document.querySelector('[name=tipo_consumo]').addEventListener('change', function(){
        cargar_nuevo_destino(this.value);
    }, false);

    get_id('guardar_tipo_consumo').addEventListener('click', function(){

        if ((get_query('[name=destino]').value).length < 1) {
            alert("Destino no especificado");
            get_query('[name=cont_destino]').classList.add('has-error');
        }else{
            get_query('[name=cont_destino]').classList.remove('has-error');
            let tipo_consumo = get_query('[name=tipo_consumo]').value;
            let destino = get_query('[name=destino]').value;
            actualizar_tipo_consumo(tipo_consumo,destino);
        }

    }, false);




    function cargar_destino_actual(){
        const pedido = get_query('[name=id]').value;
        $.ajax({
            url: base_url+'movimientos/pedido/pedido_info_rest',
            method: 'POST',
            data: {
                id: pedido
            },
            success: function(resp){
                if (resp != 'false')  {
                    var data = JSON.parse(resp); 
                    get_id('tipo_consumo_actual').innerHTML = data['ped_tipo_consumo'];
                    get_id('destino_actual').innerHTML = data['ped_destino'];

                }else{
                    
                }
            }

        });
    }

    function actualizar_tipo_consumo(tc, dst){
        $.ajax({
            url: base_url+'movimientos/pedido/actualizar_tipo_consumo_rest',
            method: 'POST',
            data: {
                id: get_query('[name=id]').value,
                tipo : tc,
                destino : dst
            },
            success: function(resp){
                if (resp != 0 ) {
                    cargar_destino_actual();
                    iziToast.show({
                        title: 'Correcto: ',
                        message: 'Datos actualizados!',
                        position: 'topCenter',
                        backgroundColor: '#a1c45a',
                        messageColor: '#144c52',
                        titleColor: '#144c52',
                        timeout : 3000,
                        icon : 'fa fa-check',
                        iconColor: '#a1c45a' 
                    });
                    cargar_nuevo_destino(get_query('[name=tipo_consumo]').value);
                }else{
                    iziToast.show({
                        title: 'Error: ',
                        message: 'El proceso no se completo, intente de nuevo.',
                        position: 'topCenter',
                        backgroundColor: '#fd0054',
                        titleColor: '#fff',
                        messageColor: '#fff',
                        timeout : 3000, 
                        icon : 'fa fa-info',
                        iconColor: '#fff'
                    });
                }
            }
        });
    }
    
    function cargar_nuevo_destino(valor){
        var origen = base_url+'mantenimiento/mesa/get_mesas_rest';
        const div_destino = get_query('[name=cont_destino]');
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
                            option.text = data[i]['mesa_numero'];
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

// CONSUMO

    function cargar_productos_pedido(){
        const pedido = get_query('[name=id]').value;
        $.ajax({
            url: base_url+'movimientos/pedido/pedido_detalle_info_rest',
            method: 'POST',
            data: {
                id: pedido
            },
            success: function(resp){
                // console.log(resp);
                var data = JSON.parse(resp);
                var tbody = get_id('tbody_productos');
                var subtotal = 0;
                let cadena = "<tr>";
                for(const item in data){
                    cadena += "<td>"+data[item]['dp_id']+"</td>"; 
                    cadena += "<td>"+data[item]['cat_abrev']+' '+data[item]['producto']+"</td>"; 
                    cadena += "<td>"+data[item]['dp_precio']+"</td>"; 
                    cadena += "<td>"+data[item]['dp_cantidad']+"</td>"; 
                    cadena += "<td>"+data[item]['dp_importe']+"</td>"; 
                    cadena += "<td>"+data[item]['dp_detalle']+"</td>"; 
                    cadena += "<td><button onclick='remover(event)' title='remover' class='btn btn-danger'>remover</button</td>";
                    cadena += "</tr>";
                    subtotal = parseFloat(subtotal) + parseFloat(data[item]['dp_importe']);
                }
                get_query('[name=subtotal]').value = subtotal;
                get_id('tbody_productos').innerHTML = cadena;

            }
        });
    }

    function remover(e){
        var elemento = e.target.parentElement.parentElement.children;
        var dp_id = elemento[0].textContent;
        // console.log(elemento[0].textContent);
        var pregunta = confirm("¿seguro de remover producto?");
        if (pregunta) {
            var subtotal_actual = parseFloat(get_query('[name=subtotal]').value);
            var importe_producto = parseFloat(elemento[4].textContent); 
            var nuevo_subtotal = parseFloat(subtotal_actual) - parseFloat(importe_producto);

            $.ajax({
                url: base_url+'movimientos/pedido/eliminar_detalle_rest',
                method: 'POST',
                data: {
                    id_pedido: get_query('[name=id]').value,
                    id_detalle: dp_id,
                    n_subtotal: nuevo_subtotal.toFixed(2)

                },
                success: function(resp){
                    // console.log(resp);
                    cargar_productos_pedido();
                    if (resp > 0) {
                        iziToast.show({
                            title: 'Correcto: ',
                            message: 'Producto eliminado',
                            position: 'topCenter',
                            backgroundColor: '#a1c45a',
                            messageColor: '#144c52',
                            titleColor: '#144c52',
                            timeout : 3000,
                            icon : 'fa fa-check',
                            iconColor: '#a1c45a' 
                        });
                    }else{
                        iziToast.show({
                            title: 'Error: ',
                            message: 'El proceso no se completo, intente de nuevo.',
                            position: 'topCenter',
                            backgroundColor: '#fd0054',
                            titleColor: '#fff',
                            messageColor: '#fff',
                            timeout : 3000, 
                            icon : 'fa fa-info',
                            iconColor: '#fff'
                        });
                    }
                }
            });
        }

    }

    document.querySelector('[name=select_categoria]').addEventListener('change', function(){
        // console.log(this.value);
        cargar_productos(this.value);
    }, false);


    function cargar_modal_producto(){
        $('#modal-producto').modal();
        cargar_categorias();
        cargar_productos(get_query('[name=select_categoria]').value);

    }

    function cargar_categorias(){
        
        $.ajax({
            url: base_url+'mantenimiento/categorias/list_rest',
            method: 'POST',
            data: { },
            success: function(resp){
                // console.log(resp);
                var categorias = JSON.parse(resp);
                var cadena_cat = "";

                if (categorias.length > 0) {
                    cadena_cat += "<option value='' selected disabled hidden>Seleccionar</option>";
                    for(cat in categorias){
                        cadena_cat += "<option value='"+categorias[cat]['id']+"'>"+categorias[cat]['nombre']+"</option>";
                    }
                }else{
                    cadena_cat += "<option >Sin datos</option>";
                }
                get_query('[name=select_categoria]').innerHTML = cadena_cat;
            }
        });

    }

    function cargar_productos(categoria_actual){
        var cadena_prod = "";

        if (categoria_actual != '') {
            $.ajax({
                url: base_url+'mantenimiento/productos/categoria_productos_rest',
                method: 'POST',
                data: {
                    categoria : categoria_actual
                },
                success: function(resp){
                    var producto = JSON.parse(resp);
                    console.log(producto);
                    if (producto.length > 0) {
                        for(prod in producto){
                            // console.log(producto[prod]['prod_nom']);
                            cadena_prod += "<option value='"+producto[prod]['prod_id']+"-"+producto[prod]['prod_prec']+"'>";
                            cadena_prod += producto[prod]['prod_nom']+' - ';
                            cadena_prod += "<b>"+producto[prod]['prod_prec']+" S/</b>";
                            cadena_prod += "</option>";
                            get_query('[name=select_producto]').innerHTML = cadena_prod;
                        }
                    }else{
                        cadena_prod += "<option>Sin Datos</option>";
                        get_query('[name=select_producto]').innerHTML = cadena_prod;

                    }
                }
            });
        }else{
            cadena_prod += "<option>--Seleccione una categoria--</option>";
            get_query('[name=select_producto]').innerHTML = cadena_prod;
        }
    }
</script>

<style>
    .control-center {
       font-size: 18px;
       text-align: center;
       color: #fd0054;
       font-weight: bold;
    }
    .redrosa{
        color: #fd0054;
    }
</style>