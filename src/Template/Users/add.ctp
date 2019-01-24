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
<?php echo $this->Html->css('Admin./plugins/intl-tel-input/css/intlTelInput'); ?>
<?php echo $this->Html->css('Admin./plugins/select2/select2.min'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo __('Add Admin') ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
	<li><a href="javascript:void(0);"><?php echo __('Admins') ?></a></li>
    <li class="active"><?php echo __('Add Admin') ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo $this->Form->create($user,['id'=>'user-add','enctype'=>'multipart/form-data','autocomplete'=>'off']); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <?php 
                                if(!empty($current_user['hospitals']['id'])) {
                                    echo $this->Form->input('users_hospitals.0.hospital_id',[
                                        'id' => 'hospital_id',
                                        'type' => 'hidden',
                                        'class' => 'form-control required',
                                        'value' => $current_user['hospitals']['id']
                                    ]);
                                }
                                
                                echo $this->Form->input('admin_user',[
                                    'id' => 'admin_user',
                                    'type' => 'hidden',
                                    'value' => $current_user['id']
                                ]);
                            ?>
                            <?php 
                                echo $this->Form->input('email',[
                                    'id' => 'email',
                                    'type' => 'email',
                                    'autocomplete' => 'false',
                                    'class' => 'form-control required',
                                    'placeholder' => 'Enter Email'
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('password',[
                                    'id' => 'password',
                                    'type' => 'password',
                                    'class' => 'form-control required',
                                    'placeholder' => 'Enter Password'
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('firstname',[
                                    'id' => 'firstname',
                                    'type' => 'text',
                                    'class' => 'form-control required',
                                    'placeholder' => 'Enter Firstname'
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('lastname',[
                                    'id' => 'lastname',
                                    'type' => 'text',
                                    'class' => 'form-control required',
                                    'placeholder' => 'Enter Lastname'
                                ]);
                            ?>
                        </div>
						<div class="form-group">
                        	<?php
                        		echo $this->Form->input('country_code', [
                            		'id' => 'country_code',
                            		'type' => 'hidden'
                        		]);
                     		?>
    						<label for="phone_number"><?= __('Phone Number') ?>:</label>
    						<?php
    							echo $this->Form->control("phone_number", [
    							    'label' => false,
    							    'type' => 'text',
    							    'class' => 'form-control required intlTelNumber',
    							    'id' => 'phone_number'
    							]);
    						?>
    						<label id="phone_number-error" class="error" for="phone_number"></label>
    					</div>
    					<div class="form-group">
                            <?php 
                                echo $this->Form->input('role_id',[
                                    'id' => 'role',
                                    'type' => 'select',
                                    'options' => $roles,
                                    'onchange' => 'showHospital(this.value)',
                                    'class' => 'form-control select2',
                                ]);
                            ?>
                            <p class="help-block"><?php echo __(Configure::read('DEFAULT_SUB_ADMIN')) ?></p>
                        </div>
                        
                        <?php if($current_user['role_id'] == 1 || $current_user['role_id'] == 2) {?>
                            <div id="show_hospital" class="form-group">
                                <?php 
                                    echo $this->Form->input('users_hospital.hospital_id',[
                                        'id' => 'role',
                                        'type' => 'select',
                                        'options' => $hospitals,
                                        'class' => 'form-control select2'
                                    ]);
                                ?>
                            </div>
                        <?php } else {?>
                        	<div id="show_hospital" class="form-group">
                                <?php 
                                    echo $this->Form->input('users_hospital.hospital_id',[
                                        'id' => 'users_hospital.hospital_id',
                                        'type' => 'hidden',
                                        'value' => $current_user['hospitals']['id']
                                    ]);
                                ?>
                                <?php 
                                    echo $this->Form->input('users_hospital.hospital_id',[
                                        'id' => 'role',
                                        'type' => 'select',
                                        'options' => $hospitals,
                                        'value' => $current_user['hospitals']['id'],
                                        'class' => 'form-control select2',
                                        'disabled' => TRUE,
                                    ]);
                                ?>
                            </div>
                        <?php }?>
                        <?php if($current_user['role_id'] == 3) { ?>
                        <div id="show_floor" class="form-group">
                            <label for="floors"><?= __('Select Floors')?> </label>
                            <?php 
                                echo $this->Form->select('floors', $floors, [
                                    'id' => 'floors',
                                    'multiple' => true,
                                    'tabindex' => -1,
                                    'placeholder' => 'Enter Floor',
                                    'class' => 'form-control select2',
                                ]);
                            ?>
                            <label id="floors-error" class="error" for="floors"></label>
                        </div>
                        <div id="show_department" class="form-group" style="display: none;">
                            <label for="departments"><?= __('Select Departments')?> </label>
                            <?php 
                                echo $this->Form->select('departments', $departments, [
                                    'id' => 'departments',
                                    'multiple' => true,
                                    'tabindex' => -1,
                                    'placeholder' => 'Enter Department',
                                    'class' => 'form-control select2',
                                ]);
                            ?>
                            <label id="departments-error" class="error" for="departments"></label>
                        </div>
                        <?php }?>
                    <!-- /.box-body -->

                        <div class="box-footer">
                            <?php 
                                echo $this->Form->button(__('Submit'),[
                                    'type' => 'submit',
                                    'class' => 'btn btn-primary btn-form'
                                ]);
    
                                echo $this->Html->link(__('Cancel'),'/users/index',[
                                    'class' => 'btn btn-default btn-form'
                                ]);
                            ?>
                        </div>
                    </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</section>

<?php echo $this->Html->script('Admin./plugins/select2/select2.full.min'); ?>
<?php echo $this->Html->script('Admin./plugins/jquery-validation/jquery.validate.min'); ?>
<?php echo $this->Html->script('Admin./plugins/jquery-validation/additional-methods.min'); ?>
<?php echo $this->Html->script('Admin./plugins/intl-tel-input/js/intlTelInput.min'); ?>
<?php echo $this->Html->script('Admin./plugins/intl-tel-input/js/utils'); ?>

<script type="text/javascript">    

$.validator.addMethod("regex", function(value, element, regexp) {
	var re = new RegExp(regexp);
	return this.optional(element) || re.test(value);
});

$("#phone_number").intlTelInput({
	initialCountry: "us",
	nationalMode: true,
	separateDialCode:true,
	hiddenInput: "phone_number"
});

jQuery.validator.addMethod("intlTelNumber", function(value, element) {
    return this.optional(element) || $(element).intlTelInput("isValidNumber");
}, "Please enter a valid Phone Number");

$('#phone_number').on('change', function() {
	var phone = $('#phone_number').val();
	$("#country_code").val("+"+$("#phone_number").intlTelInput("getSelectedCountryData").dialCode);
});

function showHospital(rolId) {
	console.log(rolId);
	if(rolId == 3 || rolId == 4) {
		$('#show_floor').show();
		$(function () {
	        $(".select2").select2();
	    });
		$('#show_department').hide();
	} else {
		$('#show_department').show();
		$('#show_floor').hide();
		$(function () {
	        $(".select2").select2();
	    });
	}
}
	
    $(function () {
        $(".select2").select2();
    });

    $("#photo").change(function(){
        readURL(this);
    });

    $( "#user-add" ).validate({
        rules: {
            email: {
                email: true,
                remote: {
                	url : "<?php echo $this->Url->build(['controller' => 'users', 'action' => 'checkUniqueEmail']); ?>",
					type : "post"
                },
            },
            password: {
            	regex: "^(?=.*[A-Za-z])(?=.*\\d)(?=.*[$@$!%*#?&])[A-Za-z\\d$@$!%*#?&]{6,}$"
            },
            firstname:{
                lettersonly: true
            },
            photo: {
                accept: "image/*"
            }
        },
        messages :{
        	email: {
        		required : "Please enter email",
                remote: "This value is already in use"  
            },
            password: {
            	regex: "Minimum 6 character long. It should have alpha, numeric and special character combination"
            },
			firstname: {
				required : "Please enter firstname",
				lettersonly: "Letters only please"
			},
			lastname: "Please enter lastname",
			role: "Please enter role",
			photo 	: {
				required : "Please upload image",
				accept   : "Allow only image file"
			}
		},
    });
</script>