<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
<head>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <?php 
        echo $this->Html->meta('favicon.ico','Admin./img/favicon.ico',[
            'type' => 'icon'
        ]);
    ?>

    <title><?php echo isset($theme['title']) ? $theme['title'] : 'Daily Doc'; ?></title>

    <?php echo $this->Html->meta('icon') ?>

    <?php echo $this->Html->css('Admin./bootstrap/css/bootstrap.min'); ?>
    <?php echo $this->Html->css('Admin.error') ?>

</head>
<body>
    <div id="container">
        <div id="content">
            <?= $this->Flash->render() ?>

            <?= $this->fetch('content') ?>
        </div>
    </div>
</body>
</html>
