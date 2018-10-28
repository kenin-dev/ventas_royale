<section class="content-wrapper">
    <div class="content">
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Reportes<small> [ Ventas por dia ]</small></h2>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    
                    <form action="<?= base_url() .'reportes/ventatotal' ?>" method="GET">
                        <div class="col-md-4">
                            <label for="">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="form-control">
                            <script>
                                class fecha{
                                    getFecha(){
                                        var d = new Date();
                                        var year  = d.getFullYear();
                                        var fake_m = d.getMonth() + 1;
                                        var month = ( fake_m > 9 ) ? fake_m : '0'+fake_m;
                                        var day   = (d.getDate()>9) ? d.getDate() : '0'+d.getDate();
                                        return year+'-'+month+'-'+day;
                                    }
                                }
                                var f = new fecha();
                                document.querySelector("[name=fecha]").defaultValue = f.getFecha();
                            </script>
                        </div>
                        <div class="col-md-4">
                            <label for="">&nbsp;</label>
                            <br>
                            <button class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-12">
                    <hr>
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#productos" aria-controls="productos" role="tab" data-toggle="tab">
                                <b>Productos Vendidos&nbsp; <?= $fecha; ?> </b>
                            </a>
                        </li>
                        <!-- <li role="presentation">
                            <a href="#ventas" aria-controls="ventas" role="tab" data-toggle="tab">
                                <b>Ventas Realizadas</b>
                            </a>
                        </li> -->
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="ventas">
                            
                        </div>
                        <div role="tabpanel" class="tab-pane active" id="productos">
                            <table class="table table-striped table-bordered table-hover" id="tabla_productos">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($productos as $producto): ?>
                                    <tr>
                                        <td rowspan="1"><?= $producto->categoria.' - '.$producto->Nombre; ?></td>
                                        <td rowspan="1"><?= $producto->Cantidad ?></td>
                                        <td><?= $producto->Precio ?></td>
                                        <td class='prod_subtotal'><?= $producto->SubTotal ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="info">
                                        <td colspan="3"><b>Total</b>&nbsp;</td>
                                        <td><b id="prod_importe_total"></b></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function(){
        CalculoProductos();

    }, true);

    function CalculoProductos(){
        var prod_lista = document.querySelectorAll('#tabla_productos tbody tr td.prod_subtotal');
        var prod_total = 0;
        for (var i = 0; i < prod_lista.length; i++) {
            prod_total = parseFloat(prod_total)+parseFloat(prod_lista[i].textContent);
        }
        // console.log(prod_lista.length)
        document.querySelector("#prod_importe_total").innerHTML = prod_total;
    }
</script>
