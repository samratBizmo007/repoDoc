<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($theme['title']) ? $theme['title'] : 'AdminLTE 2 | Log in'; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php 
        echo $this->Html->meta('favicon.ico','Admin./img/favicon.png',[
            'type' => 'icon'
        ]);
    ?>

    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->css('Admin./bootstrap/css/bootstrap'); ?>
    <!-- Font Awesome -->
    <?php echo $this->Html->css('Admin./plugins/font-awesome/css/font-awesome.min'); ?>
    <!-- Ionicons -->
    <?php echo $this->Html->css('Admin./plugins/ionicons/css/ionicons.min'); ?>

    <!-- Toastr -->
    <?php echo $this->Html->css('Admin./plugins/toastr/css/toastr.min'); ?>
    
    <!-- Theme style -->
    <?php echo $this->Html->css('Admin.AdminLTE.min'); ?>
    <!-- iCheck -->
    <?php echo $this->Html->css('Admin./plugins/iCheck/square/blue'); ?>

    <!-- Custom CSS -->
    <?php echo $this->Html->css('Admin.style'); ?>
    <?php echo $this->Html->css('Admin.utility'); ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.2.3 -->
    <?php echo $this->Html->script('Admin./plugins/jQuery/jquery-2.2.3.min'); ?>
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->script('Admin./bootstrap/js/bootstrap'); ?>

  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="javascript:void(0);">
          <?php 
              echo $this->Html->image('Admin.logos/logo.png',[
                'alt' => 'Daily Doc',
                'height' => '92',
                'width' => '92'            
              ]); 
          ?>
        </a>
      </div>
      <!-- /.login-logo -->
      <div class="login-box-body">
  
        <?php echo $this->Flash->render(); ?>
        <?php echo $this->fetch('content'); ?>
        <?php
        if (isset($theme['login']['show_social']) && $theme['login']['show_social']) {
            ?>
            <div class="social-auth-links text-center">
              <p>- <?php echo __('OR') ?> -</p>
              <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> <?php echo __('Sign in using Facebook') ?></a>
              <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> <?php echo __('Sign in using Google+') ?></a>
            </div>
            <?php
        }
        ?>

        <?php
        if (isset($theme['login']['show_remember']) && $theme['login']['show_remember']) {
            ?>
            <a href="#"><?php echo __('I forgot my password') ?></a><br>
            <?php
        }
        if (isset($theme['login']['show_register']) && $theme['login']['show_register']) {
            ?>
            <a href="#" class="text-center"><?php echo __('Register a new membership') ?></a>
            <?php
        }
        ?>

      </div>
      <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

  <!-- jQuery 2.2.3 -->
  <?php echo $this->Html->script('Admin./plugins/jQuery/jquery-2.2.3.min'); ?>
  <!-- Bootstrap 3.3.5 -->
  <?php echo $this->Html->script('Admin./bootstrap/js/bootstrap'); ?>
  <!-- iCheck -->
  <?php echo $this->Html->script('Admin./plugins/iCheck/icheck.min'); ?>
  <!-- Toastr -->
  <?php echo $this->Html->script('Admin./plugins/toastr/js/toastr.min'); ?>
        
  <script>
    $(function () {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      });
    });
  </script>
  </body>
</html>
