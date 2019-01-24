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
use Cake\Core\Configure;
?>
<?php echo $this->Html->css('Admin./plugins/iCheck/square/blue'); ?>
<!-- Main content -->
<section class="content-header">
  <h1>
    <?php echo __('Edit Role') ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
    <li><a href="javascript:void(0);"><?php echo __('Users') ?></a></li>
    <li class="active"><?php echo __('Edit Role') ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo $this->Form->create($role,['id'=>'role-edit']); ?>
                <div class="box-body">
                    <div class="form-group">
                        <?php 
                            echo $this->Form->input('name',[
                                'id' => 'name',
                                'type' => 'text',
                                'autocomplete' => 'false',
                                'class' => 'form-control required',
                                'placeholder' => 'Enter Role'
                            ]);
                        ?>
                    </div>
                    <div class="form-group">
                        <div class="checkbox icheck">
                            <?php 
                                echo $this->Form->input('is_active',[
                                    'id' => 'is_active',
                                    'type' => 'checkbox',
                                    'class' => 'form-control',
                                    'label' => ['class'=>'no-padding','text' => ' <b>Status</b>','escape' => false]
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <?php 
                        echo $this->Form->button(__('Update'),[
                            'type' => 'submit',
                            'class' => 'btn btn-primary btn-form'
                        ]);

                        echo $this->Html->link(__('Cancel'),'/roles/index',[
                            'id' => 'cancel',
                            'class' => 'btn btn-default btn-form'
                        ]);
                    ?>
                </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
</section>
<?php echo $this->Html->script('Admin./plugins/iCheck/icheck.min'); ?>
<?php echo $this->Html->script('Admin./plugins/jquery-validation/jquery.validate.min'); ?>

<script type="text/javascript">    
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });

    $( "#name" ).change(function(){
        $( "#role-edit" ).validate({
            rules: {
                name: {
                    remote: {
                        url : "<?php echo $this->Url->build(['controller' => 'Roles', 'action' => 'checkUniqueRole']); ?>",
                        type : "post"
                    }
                }
            },
            messages :{
                name: {
                    remote: "This value is already in use"  
                }
            },
        });
    });    

</script>
