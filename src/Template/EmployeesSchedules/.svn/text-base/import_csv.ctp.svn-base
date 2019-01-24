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
        <?php echo $this->Form->create(null,['id'=>'import-csv', 'enctype'=>'multipart/form-data']); ?>
            <div class="box-body">
                <div class="form-group">
                    <?php 
                        echo $this->Form->input('csv',[
                            'id' => 'csv',
                            'type' => 'file',
                            'class' => 'required',
                            'label' => 'Upload CSV'
                        ]);
                    ?>
                    <p class="help-block">allow only .xls and .csv files.</p>
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
<?php echo $this->Html->script('Admin./plugins/jquery-validation/additional-methods.min'); ?>

<script type="text/javascript">    

    $( "#import-csv" ).validate({
        rules: {
        	csv: {
        		required: true,
        		extension: "csv"
        		//accept : "xls, csv, xlsx"
            }
        },
        messages :{
        	csv : {
				required : "Please upload file",
				extension  : "Allow only csv file"
			}
        },
    });
</script>
