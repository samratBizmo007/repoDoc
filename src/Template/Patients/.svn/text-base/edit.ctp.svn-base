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
<?php echo $this->Html->css('Admin./plugins/datepicker/datepicker3'); ?>
<?php echo $this->Html->css('Admin./plugins/select2/select2'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo __('Edit Patient') ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
        <li><a href="<?php echo $this->Url->build(['controller' => 'Patients','action' => 'index']); ?>"><?php echo __('Patients') ?></a></li>
        <li class="active"><?php echo __('Edit Patient') ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Main content -->
            <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo $this->Form->create($patient,['id'=>'patient-add','type'=>'file']); ?>
                    <div class="box-body">
                    	<div class="form-group">
                            <?php 
                                echo $this->Form->input('firstname',[
                                    'id' => 'firstname',
                                    'type' => 'text',
                                    'class' => 'form-control required lettersonly',
                                    'placeholder' => 'Enter Firstname',
                                    'label' => ['text' => 'Firstname *']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('lastname',[
                                    'id' => 'lastname',
                                    'type' => 'text',
                                    'class' => 'form-control required lastname',
                                    'placeholder' => 'Enter Lastname',
                                    'label' => ['text' => 'Lastname *']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('floor_id',[
                                    'id' => 'floor_id',
                                    'type' => 'select',
                                    'empty' => 'Floor Number',
                                    'options' => $floors,
                                    'class' => 'form-control required floor',
                                    'label' => ['text' => 'Floor Number']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('bed',[
                                    'id' => 'bed',
                                    'type' => 'text',
                                    'empty' => 'Enter Bed Number',
                                    'class' => 'form-control required',
                                    'label' => ['text' => 'Bed Number *']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('room',[
                                    'id' => 'room',
                                    'type' => 'text',
                                    'empty' => 'Enter Room Number',
                                    'class' => 'form-control required',
                                    'label' => ['text' => 'Room Number *']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('hospital_id',[
                                    'id' => 'hospital_id',
                                    'type' => 'hidden',
                                    'class' => 'form-control required',
                                    'value' => $current_user['hospitals']['id']
                                ]);
                                
                                echo $this->Form->input('service_team_id',[
                                    'id' => 'service_team_id',
                                    'type' => 'select',
                                    'multiple' => true,
                                    'options' => $serviceTeams,
                                    'val' =>  $selectServiceTeam,
                                    'empty' => 'Please select service team',
                                    'class' => 'form-control required service_team',
                                    'label' => ['text' => 'Service Team *']
                                ]);
                                
                            ?>
                        </div>
                         <div class="form-group">
                            <?php 
                                echo $this->Form->input('employee_id',[
                                    'id' => 'employee_id',
                                    'type' => 'select',
                                    'options' => $employees,
                                    'empty' => 'Please select primary doctor',
                                    'class' => 'form-control employee_list',
                                    'label' => ['text' => 'Primary Doctor']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('mrn',[
                                    'id' => 'mrn',
                                    'type' => 'text',
                                    'class' => 'form-control',
                                    'required' => false,
                                    'placeholder' => 'Enter MRN',
                                    'label' => ['text' => 'MRN']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('birthdate',[
                                    'id' => 'birthdate',
                                    'type' => 'text',
                                    'data-date-end-date' => "0d",
                                    'class' => 'form-control datepicker',
                                    'placeholder' => 'Select Birth Date',
                                    'label' => ['text' => 'Birth Date'],
                                    'required' => false,
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('gender',[
                                    'id' => 'gender',
                                    'type' => 'select',
                                    'options' => [1 => 'Male', 2=> 'Female'],
                                    'class' => 'form-control',
                                    'label' => ['text' => 'Gender *']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('admission_date',[
                                    'id' => 'admission_date',
                                    'type' => 'text',
                                    'data-date-end-date' => "0d",
                                    'placeholder' => 'Select Admission Date',
                                    'class' => 'form-control datepicker',
                                    'label' => ['text' => 'Admission Date']
                                ]);
                            ?>
                        </div>
                        <!-- <div class="form-group">
                            <?php 
                                /* echo $this->Form->input('patient_status',[
                                    'id' => 'patient_status',
                                    'type' => 'select',
                                    'class' => 'form-control required',
                                    'options' => Configure::read('PATIENT_STATUS'),
                                    'label' => ['text' => 'Patient Status']
                                ]); */
                            ?>
                        </div>-->
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <?php 
                            echo $this->Form->button(__('Save'),[
                                'type' => 'submit',
                                'class' => 'btn btn-primary btn-form'
                            ]);

                            echo $this->Html->link(__('Cancel'),['controller' => 'Patients','action' => 'index'],[
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
<?php echo $this->Html->script('Admin./plugins/jquery-validation/jquery.validate.min'); ?>
<?php echo $this->Html->script('Admin./plugins/jquery-validation/additional-methods.min'); ?>
<?php echo $this->Html->script('Admin./plugins/datepicker/bootstrap-datepicker'); ?>
<?php echo $this->Html->script('Admin./plugins/select2/select2.full.min'); ?>

<script type="text/javascript">    
    $('.datepicker').datepicker({
        format: "mm/dd/yy",
        autoclose: true
    });


    $(document).ready(function() {
        $('.service_team').select2();
        $('.floor').select2();
        $('.employee_list').select2();
    });
    
    $( "#employee-add" ).validate({
        rules: {
            mrn: {
            	required: false,
                remote: {
                    url : "<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'checkUniquePatientByMRN']); ?>",
                    type : "post"
                }
            },
            birthdate: {
            	required: false,
            }
        },
        messages :{
            mrn: {
                remote: "This value is already in use"  
            },
            birthdate: {
            	required: false,
            }
        }
    });
</script>

