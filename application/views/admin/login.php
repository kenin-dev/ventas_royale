<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" href="<?php echo base_url();?>assets/img/ventas_isotipo.png" type="icon/png">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/font-awesome/css/font-awesome.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>assets/template/dist/css/AdminLTE.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/fonts/Monda/monda.css">

</head>
<body class="hold-transition login-page" style="background: url(<?= base_url();?>assets/img/comida.jpg);background-repeat: no-repeat;background-size: 100%; background-position: center; background-attachment: fixed;">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="login-box-body">
          <div class="login-logo">
              <img src="<?php echo base_url();?>assets/img/ventas_isologo.png" alt="ventas_logo" class="img-responsive">
              <h3><small>CONTROL DE ACCESO</small></h3>
          </div>
          <?php if($this->session->flashdata("error")):?>
            <div class="alert alert-danger">
              <p><?php echo $this->session->flashdata("error")?></p>
            </div>
          <?php endif; ?>
            <form action="<?php echo base_url();?>auth/login" method="post">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Usuario" name="username">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-success btn-block btn-flat">Acceder</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url();?>assets/template/jquery/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>assets/template/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
