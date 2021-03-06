
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Mesas
        <small>Editar</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php if($this->session->flashdata("error")):?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <p><i class="icon fa fa-ban"></i><?php echo $this->session->flashdata("error"); ?></p>
                                
                             </div>
                        <?php endif;?>
                        <form action="<?php echo base_url();?>mantenimiento/mesa/actualizar" method="POST" autocomplete="off">
                            <div class="col-md-2">
                                <label for="">Mesa #</label>
                                <input type="text" name="id" class="form-control" placeholder="ingrese..." value="<?php echo $mesa->mesa_id; ?>" readonly>
                                <hr>
                            </div>
                            <div class="col-md-4">
                                <label for="">Numero / Nombre</label>
                                <input type="text" name="numero" class="form-control" placeholder="ingrese..." value="<?php echo $mesa->mesa_numero; ?>">
                                <hr>
                            </div>
                            <div class="col-md-7">
                                <label for="">Descripcion</label>
                                <textarea name="descripcion" class="form-control" cols="10" rows="3"><?php echo $mesa->mesa_descripcion; ?></textarea>
                            </div>
                            <div class="col-md-12">
                                <br>
                                <label for="">&nbsp;</label>
                                <button type="submit" class="btn btn-success btn-flat">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
