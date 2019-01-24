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
<?php echo $this->Html->css('Admin./plugins/intl-tel-input/css/intlTelInput'); ?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __('Edit Employee') ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
    <li><a href="<?php echo $this->Url->build(['controller' => 'Employees','action' => 'index']); ?>"><?php echo __('Employees') ?></a></li>
    <li class="active"><?php echo __('Edit Employee') ?></li>
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
                    <?php echo $this->Form->create($employee,['id'=>'employee-edit','type'=>'file']); ?>
                        <div class="box-body">
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('hospitals_employees.0.id',[
                                    'id' => 'id',
                                    'type' => 'hidden'
                                ]);
                                
                               echo $this->Form->input('hospitals_employees.0.service_team_id',[
                                    'id' => 'service_team_id',
                                    'type' => 'select',
                                    'options' => $serviceTeams,
                                    'empty' => 'Please select service team',
                                    'class' => 'form-control required',
                                    'label' => ['text' => 'Service Team']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('email',[
                                    'id' => 'email',
                                    'type' => 'email',
                                    'class' => 'form-control required',
                                    'placeholder' => 'Enter Email',
                                    'label' => ['text' => 'Email *']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('password',[
                                    'id' => 'password',
                                    'type' => 'password',
                                    'class' => 'form-control required',
                                    'placeholder' => 'Enter Password',
                                    'value' => '',
                                    'label' => ['text' => 'Password']
                                ]);
                            ?>
                        </div>
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
                                echo $this->Form->input('employee_role',[
                                    'id' => 'employee_role',
                                    'type' => 'select',
                                    'empty' => 'Please select employee role',
                                    'options' => $employee_roles,
                                    'value' => $employee_role,
                                    'class' => 'form-control required',
                                    'label' => ['text' => 'Employee Role *']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('designation',[
                                    'id' => 'designation',
                                    'type' => 'select',
                                    'empty' => 'Please select designation',
                                    'options' => $designations,
                                    'class' => 'form-control required',
                                    'label' => ['text' => 'Designation *']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('department',[
                                    'id' => 'department',
                                    'type' => 'select',
                                    'empty' => 'Please select department',
                                    'options' => $departments,
                                    'class' => 'form-control required',
                                    'label' => ['text' => 'Department']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('sub_department',[
                                    'id' => 'sub_department',
                                    'type' => 'select',
                                    'options' => $sub_departments,
                                    'empty' => 'Please select Sub department',
                                    'class' => 'form-control required',
                                    'label' => ['text' => 'Sub Department *']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('title',[
                                    'id' => 'title',
                                    'type' => 'select',
                                    'empty' => 'Please select title',
                                    'options' => $titles,
                                    'class' => 'form-control required',
                                    'label' => ['text' => 'Title']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('qualification',[
                                    'id' => 'qualification',
                                    'type' => 'text',
                                    'placeholder' => 'Enter Qualification',
                                    'class' => 'form-control required',
                                    'label' => ['text' => 'Qualification *']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('cell_number',[
                                    'id' => 'cell_number',
                                    'type' => 'text',
                                    'empty' => 'Enter Cell Number',
                                    'class' => 'form-control',
                                    'label' => ['text' => 'Cell Number']
                                ]);
                            ?>
                            <label id="cell_number-error" class="error" for="cell_number"></label>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('office_number',[
                                    'id' => 'office_number',
                                    'type' => 'text',
                                    'empty' => 'Enter Office Number',
                                    'class' => 'form-control required phone number',
                                    'label' => ['text' => 'Office Number']
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('fax_number',[
                                    'id' => 'fax_number',
                                    'type' => 'text',
                                    'empty' => 'Enter Office Number',
                                    'class' => 'form-control'
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('pager_number',[
                                    'id' => 'pager_number',
                                    'type' => 'text',
                                    'empty' => 'Enter Pager Number',
                                    'class' => 'form-control',
                                    'label' => ['text' => 'Pager Number']
                                ]);
                            ?>
                            <label id="pager_number-error" class="error" for="pager_number"></label>
                        </div>
                        <div class="form-group">
                            <div class="checkbox icheck">
                                <?php 
                                    echo $this->Form->input('is_first_call',[
                                        'id' => 'is_first_call',
                                        'type' => 'checkbox',
                                        'class' => 'form-control',
                                        'label' => ['class'=>'no-padding','text' => ' <b>first Call</b>','escape' => false]
                                    ]);
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="checkbox icheck">
                                <?php 
                                    echo $this->Form->input('is_attending',[
                                        'id' => 'is_attending',
                                        'type' => 'checkbox',
                                        'class' => 'form-control',
                                        'label' => ['class'=>'no-padding','text' => ' <b>Attending</b>','escape' => false]
                                    ]);
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('photo',[
                                    'id' => 'photo',
                                    'type' => 'file',
                                    'class' => ''
                                ]);
                            ?>
                            <p class="help-block"><?php echo __(Configure::read('IMAGE_IDEAL_SIZE')) ?></p>
                            <?php 
                                $person_photo = !empty($employee['photo']) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$employee['photo'] : Configure::read("DEFAULT_USER_IMAGE_URL"); 
                            ?>
                            <div id="photo-preview" class="image-preview" style="background-image: url('<?php echo $person_photo ?>');">
                            </div>

                            <?php 
                                echo $this->Form->input('old_photo',[
                                    'id' => 'old_photo',
                                    'type' => 'hidden',
                                    'value' => $employee['photo']
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

                                echo $this->Html->link(__('Cancel'),['controller' => 'Employees','action' => 'index'],[
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
<?php echo $this->Html->script('Admin./plugins/iCheck/icheck.min'); ?>
<?php echo $this->Html->script('Admin./plugins/intl-tel-input/js/intlTelInput.min'); ?>
<?php echo $this->Html->script('Admin./plugins/intl-tel-input/js/utils'); ?>

<script type="text/javascript">
jQuery.validator.addMethod("intlTelNumber", function(value, element) {
	return this.optional(element) || $(element).intlTelInput("isValidNumber");
	}, "Please enter a valid Pager Number");

$.validator.addMethod("regex", function(value, element, regexp) {
	var re = new RegExp(regexp);
	return this.optional(element) || re.test(value);
});

$("#cell_number").intlTelInput();

$("form").submit(function() {
	  $("#cell_number").val($("#cell_number").intlTelInput("getNumber"));
});

$(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
    });
  
    $("#photo").change(function(){
        readURL(this);
    });

    $( "#employee-edit" ).validate({
        rules: {
            email: {
                remote: {
                    url : "<?php echo $this->Url->build(['controller' => 'Employees', 'action' => 'checkUniqueEmployeeByEmail', $employee->id]); ?>",
                    type : "post"
                }
            },
            password: {
            	required : false,
            	regex: "^(?=.*[A-Za-z])(?=.*\\d)(?=.*[$@$!%*#?&])[A-Za-z\\d$@$!%*#?&]{6,}$"
            },
            "hospitals_employees[0][service_team_id]" : {
            	required : false,
            },
            cell_number : {
            	required : false,
            	intlTelNumber:true,
            	number:true
            },
            office_number : {
            	required : false,
            },
            title : {
            	required : false,
            },	
            photo: {
            	required : false,
                accept: "image/*"
            },
            pager_number: {
            	required:false,
            	number:true
        	}
        },
        messages :{
            email: {
                remote: "This value is already in use"  
            },
            password: {
            	regex: "Minimum 6 character long. It should have alpha, numeric and special character combination"
            },
            photo   : {
                //required : "Please upload an image",
                accept   : "Allow only image file"
            }
        }
    });

$(document).ready(function(){
		
        $('#department').on("change",function () {
            
        	var url = "<?php echo $this->Url->build(['controller' => 'Employees','action' => 'getSubDepartmentEdit']); ?>";
            var department = $(this).find('option:selected').val();
            $.ajax({
                url: url,
                type: "POST",
                data: "department="+department,
                success: function (response) {
                    $("#sub_department").html(response);
                },
            });
        }); 

    });
</script>
