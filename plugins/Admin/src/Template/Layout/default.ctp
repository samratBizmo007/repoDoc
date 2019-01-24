<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
        
        <title><?php echo isset($theme['title']) ? $theme['title'] : 'AdminLTE 2'; ?></title>

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
        <!-- Select2 -->
        <?php echo $this->Html->css('Admin./plugins/select2/select2.min'); ?>

        <!-- Toastr -->
        <?php echo $this->Html->css('Admin./plugins/toastr/css/toastr.min'); ?>


        <!-- Theme style -->
        <?php echo $this->Html->css('Admin.AdminLTE.min'); ?>
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <?php echo $this->Html->css('Admin.skins/skin-blue.min'); ?>

        <!-- Custom CSS -->
        <?php echo $this->Html->css('Admin.style'); ?>
        <?php echo $this->Html->css('Admin.utility'); ?>

        <?php echo $this->fetch('css'); ?>

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
    <body class="hold-transition skin-blue fixed sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo $this->Url->build('/dashboard'); ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><?php echo $theme['logo']['mini'] ?></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><?php echo $theme['logo']['large'] ?></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <?php echo $this->element('Admin.nav-top') ?>
            </header>

            <!-- Left side column. contains the sidebar -->
            <?php echo $this->element('Admin.aside-main-sidebar'); ?>

            <!-- =============================================== -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                
                <?php //echo $this->Flash->render(); ?>
                <?php //echo $this->Flash->render('auth'); ?>

                <?php echo $this->fetch('content'); ?>
                <?php echo $this->element('Admin.ajax-modal'); ?>

            </div>
            <!-- /.content-wrapper -->

            <?php echo $this->element('Admin.footer'); ?>

            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <!-- <div class="control-sidebar-bg"></div> -->
        </div>
        <!-- ./wrapper -->

        <!-- SlimScroll -->
        <?php echo $this->Html->script('Admin./plugins/slimScroll/jquery.slimscroll.min'); ?>
        <!-- FastClick -->
        <?php echo $this->Html->script('Admin./plugins/fastclick/fastclick'); ?>

        <!-- Toastr -->
        <?php echo $this->Html->script('Admin./plugins/toastr/js/toastr.min'); ?>

        <!-- AdminLTE App -->
        <?php echo $this->Html->script('Admin.AdminLTE.min'); ?>
        <?php echo $this->Html->script('Admin.custom'); ?>
        
        <!-- AdminLTE for demo purposes -->
        <?php echo $this->fetch('script'); ?>
        <?php echo $this->fetch('scriptBotton'); ?>

        <?php echo $this->element('Admin.notification-messages'); ?>

        <script type="text/javascript">
            $(document).ready(function(){
                $(".navbar .menu").slimscroll({
                    height: "200px",
                    alwaysVisible: false,
                    size: "3px"
                }).css("width", "100%");

                var a = $('a[href="<?php echo $this->request->webroot . $this->request->url ?>"]');
                if (!a.parent().hasClass('treeview')) {
                    a.parent().addClass('active').parents('.treeview').addClass('active');
                }

                setInterval(function(){
                	window.location.href="<?php echo $this->Url->build(['controller' => 'Users','action' => 'logout']); ?>";
                },20*60*1000);
            });
        </script>
    </body>
</html>
