<div class="content-wrapper">
    <section class="content-header">
        <h1>
        Reportes
        <small>Monto de ventas</small>
        </h1>
    </section>
    <div class="content">
        <div class="box box-solid">
            <div class="box-body">
                <form action="<?= base_url() .'reportes/ventatotal' ?>" method="POST">
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
                                    // console.log("In: "+year+'-'+month+'-'+day);
                                }
                            }
                            var f = new fecha();
                            document.querySelector("[name=fecha]").defaultValue = f.getFecha();
                        </script>
                    </div>
                    <div class="col-md-4">
                        <br>
                        <label for="">&nbsp;</label>
                        <button class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($ventas as $venta): ?>
                                <tr>
                                    <td rowspan="1"><?= $venta->Nombre ?></td>
                                    <td rowspan="1"><?= $venta->Cantidad ?></td>
                                    <td><?= $venta->Precio ?></td>
                                    <td><?= $venta->SubTotal ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row pull-right">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="col-xs-4" for="">Igv</label>
                            <div class="col-xs-8"><?= count($ventas) > 0 ? $ventas[0]->Igv : 0 ?></div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label class="col-xs-4" for="">Total</label>
                            <div class="col-xs-8"><?= count($ventas) > 0 ? $ventas[0]->Total : 0 ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
