<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
    
    <?php 
        echo $this->Html->meta('favicon.ico','Website./img/favicon.ico',[
            'type' => 'icon'
        ]);
    ?>
    
    <title><?php echo isset($theme['title']) ? $theme['title'] : 'DailyDoc'; ?></title>

    <!-- Google Roboto Fonts -->
    <?php echo $this->Html->css('https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'); ?>
    <?php echo $this->Html->css('https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic'); ?>

    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->css('Website./plugins/bootstrap/css/bootstrap.min'); ?>

    <!-- Font Awesome -->
    <?php echo $this->Html->css('Website./plugins/font-awesome/css/font-awesome.min'); ?>
    
    <!-- Custom CSS -->
    <?php echo $this->Html->css('Website.creative'); ?>
    
    <?php echo $this->fetch('css'); ?>

    <!-- jQuery 2.2.3 -->
    <?php echo $this->Html->script('Website./plugins/jquery/jquery.min'); ?>
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->script('Website./plugins/bootstrap/js/bootstrap.min'); ?>

</head>
<body id="page-top">

    <?php echo $this->element('Website.navigation') ?>

    <?php echo $this->fetch('content'); ?>

    <?php echo $this->element('Website.footer') ?>
    
    <?php echo $this->fetch('script'); ?>
    <?php echo $this->fetch('scriptBotton'); ?>


	<!-- Plugin JavaScript -->
    <?php echo $this->Html->script('Website./plugins/jquery-easing/jquery.easing.min'); ?>
    <?php echo $this->Html->script('Website./plugins/scrollreveal/scrollreveal.min'); ?>
    
	<!-- Custom scripts for this template -->
	<?php echo $this->Html->script('Website.creative.min'); ?>		

</body>
</html>