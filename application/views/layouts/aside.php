        <!-- =============================================== -->

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">      
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">PANEL DE CONTROL</li>
                    <li>
                        <a href="<?php echo base_url();?>dashboard">
                            <i class="fa fa-home"></i> <span>Inicio</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-cogs"></i> <span>Mantenimiento</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>mantenimiento/categorias"><i class="fa fa-circle-o"></i> Categorias</a></li>
                            <li><a href="<?php echo base_url();?>mantenimiento/clientes"><i class="fa fa-circle-o"></i> Clientes</a></li>
                            <li><a href="<?php echo base_url(); ?>mantenimiento/productos"><i class="fa fa-circle-o"></i> Productos</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-share-alt"></i> <span>Movimientos</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>movimientos/ventas/listar"><i class="fa fa-circle-o"></i> Ventas</a></li>
                            <li><a href="<?php echo base_url();?>movimientos/pedido/"><i class="fa fa-circle-o"></i> Pedidos</a></li>
                            
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-print"></i> <span>Reportes</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo base_url();?>reportes/ventas"><i class="fa fa-circle-o"></i>Ventas Totales</a></li>
                            <li><a href="<?php echo base_url();?>reportes/ventatotal"><i class="fa fa-circle-o"></i>Ventas por Dia</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-user-circle-o"></i> <span>Administrador</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            
                            <li><a href="<?php echo base_url();?>administrador/usuarios"><i class="fa fa-circle-o"></i> Usuarios</a></li>
                            <li><a href="<?php echo base_url();?>administrador/permisos"><i class="fa fa-circle-o"></i> Permisos</a></li>
                        </ul>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- =============================================== -->