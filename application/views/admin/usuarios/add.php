
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="padding: .5em 2em;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        <b>Usuarios</b>
        <small></small>
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
                        <form action="<?php echo base_url();?>administrador/usuarios/store" method="POST">
                            <div class="form-group col-md-4">
                                <label for="nombres">Nombres:</label>
                                <input type="text" id="nombres" name="nombres" class="form-control" maxlength="50">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control" maxlength="50">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="telefono">Telefono:</label>
                                <input type="text" id="telefono" name="telefono" class="form-control" maxlength="9">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="email">Email:</label>
                                <input type="text" id="email" name="email" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="rol">Roles:</label>
                                <select name="rol" id="rol" class="form-control">
                                    <?php foreach($roles as $rol):?>
                                        <option value="<?php echo $rol->id;?>"><?php echo $rol->nombre;?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="username">Usuario:</label>
                                <input type="text" id="username" name="username" class="form-control"  maxlength="50" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="password">Contraseña:</label>
                                <input type="password" id="password" name="password" class="form-control"  maxlength="50" required>
                            </div>
                            <div class="form-group  col-md-10">
                                <!-- <input type="submit" class="btn btn-success" value="Guardar"> -->
                                <button type="submit" class="btn btn-success btn-lg">
                                    Guardar
                                    <span class="fa fa-send"></span>
                                </button>
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
