<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<?php echo base_url();?>assets/img/ventas_dash_isotipo.png" type="icon/png">
    <title>Sistema de Ventas | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/jquery-ui/jquery-ui.css">
      <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/Ionicons/css/ionicons.min.css">
     <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- DataTables Export-->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/datatables-export/css/buttons.dataTables.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/dist/css/AdminLTE.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/dist/css/iziToast.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/pace/pace.css">
    <script src="<?php echo base_url();?>assets/pace/pace.js"></script>
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/template/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/fonts/Monda/monda.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/fonts/Roboto Mono/roboto_mono.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo base_url();?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">
                    <img src="<?php echo base_url();?>assets/img/ventas_dash_isotipo.png" alt="">
                </span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">
                    <img src="<?php echo base_url();?>assets/img/ventas_dash_isologo.png" alt="">
                </span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                              <img src="<?php echo base_url();?>assets/img/james.jpg" class="user-image" alt="User Image">
                              <span class="hidden-xs">
                                <b><?php echo $this->session->userdata("nombre")?></b>
                              </span>
                            </a>
                            <ul class="dropdown-menu">
                              <!-- User image -->
                              <li class="user-header">
                                <img src="<?php echo base_url();?>assets/img/james.jpg" class="img-circle" alt="User Image">
                                <p>
                                  <b><?php echo $this->session->userdata("nombre")?></b>
                                  <small><i>usuario casual</i></small>
                                </p>
                              </li>
                              <li class="user-footer">
                                <div class="pull-left">
                                  <a href="#" class="btn btn-primary btn-flat">Perfil</a>
                                </div>
                                <div class="pull-right">
                                  <a href="<?php echo base_url()?>Auth/logout" class="btn btn-danger btn-flat">Salir</a>
                                </div>
                              </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>