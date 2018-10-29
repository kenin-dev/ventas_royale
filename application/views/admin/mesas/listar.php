<div class="content-wrapper">
    <section class="content-header">
        <h1>
        Mesas
        <small>Lista</small>
        </h1>
    </section>
    <section class="content">
        <div class="box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12 ">
                        <a href="<?php echo base_url();?>mantenimiento/mesa/nuevo" class="btn btn-warning">Agregar Mesa&nbsp;
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
                                    <th>Mesa</th>
                                    <th>Descripcion</th>                         
                                    <th>Estado</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($mesas)): ?>
                                <?php foreach($mesas as $mesa):?>
                                    <tr>
                                        <td><?php echo $mesa->mesa_id;?></td>
                                        <td><?php echo $mesa->mesa_numero;?></td>
                                        <td><?php echo $mesa->mesa_descripcion;?></td>
                                        <td><?php echo $mesa->mesa_estado;?></td>
                                        <td>
                                            <a href="<?php echo base_url()?>mantenimiento/mesa/editar/<?php echo $mesa->mesa_id;?>" class="btn btn-info">Editar&nbsp;<span class="fa fa-pencil"></span></a>
                                            <a onclick='eliminar(event)' href="<?php echo base_url()?>mantenimiento/mesa/eliminar/<?php echo $mesa->mesa_id;?>" class="btn btn-danger">Eliminar&nbsp;<span class="fa fa-times"></span></a>
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
<script type="text/javascript">
    function eliminar(e){
        var resp = confirm("Esta seguro que quiere eliminar esta mesa?");
        if (resp == true) {
            console.log('eliminado');
        }else{
            e.preventDefault();
        }
    }
</script>