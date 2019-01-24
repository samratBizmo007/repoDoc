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
<div class="modal-dialog modal-sm modal-sm-450">
    <!-- Main content -->
    <div class="box box-primary">
        <!-- /.box-header -->
        <!-- form start -->
        <?php echo $this->Form->create($designation,['id'=>'designation-add']); ?>
            <div class="box-body">
                <div class="form-group">
                    <?php 
                        echo $this->Form->input('name',[
                            'id' => 'name',
                            'type' => 'text',
                            'autocomplete' => 'false',
                            'class' => 'form-control required',
                            'placeholder' => 'Enter Designation'
                        ]);
                    ?>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?php 
                    echo $this->Form->button(__('Save'),[
                        'type' => 'submit',
                        'class' => 'btn btn-primary btn-form'
                    ]);

                    echo $this->Html->link(__('Cancel'),'javascript:void(0);',[
                        'id' => 'cancel',
                        'class' => 'btn btn-default btn-form'
                    ]);
                ?>
            </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<?php echo $this->Html->script('Admin./plugins/jquery-validation/jquery.validate.min'); ?>

<script type="text/javascript">    

    $( "#designation-add" ).validate({
        rules: {
            name: {
                remote: {
                    url : "<?php echo $this->Url->build(['controller' => 'Designations', 'action' => 'checkUniqueDesignation']); ?>",
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
</script>
