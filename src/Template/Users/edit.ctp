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
<?php $disable = $current_user['role_id'] == 4 || $current_user['role_id'] == 5  ? true : false; ?>

<!-- Content Header (Page header) -->
<?php echo $this->Html->css('Admin./plugins/intl-tel-input/css/intlTelInput'); ?>
<?php echo $this->Html->css('Admin./plugins/select2/select2.min'); ?>
<section class="content-header">
  <h1>
    <?php echo __('Edit Admin') ?>
  </h1>
  <ol class="breadcrumb">
  	<li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i><?php echo __('Home'); ?></a></li>
	<li><a href="javascript:void(0);"><?php echo __('Admins') ?></a></li>
    <li class="active"><?php echo __('Edit Admin') ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- /.box-header -->
                <!-- form start -->
                <?php echo $this->Form->create($user,['id'=>'user-edit','enctype'=>'multipart/form-data']); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('email',[
                                    'id' => 'email',
                                    'type' => 'email',
                                    'class' => 'form-control required',
                                    'placeholder' => 'Enter Email',
                                    'disabled' => $disable,
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('password',[
                                    'id' => 'password',
                                    'type' => 'password',
                                    'class' => 'form-control',
                                    'placeholder' => 'Enter Password',
                                    'value' => ''
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('firstname',[
                                    'id' => 'firstname',
                                    'type' => 'text',
                                    'class' => 'form-control required',
                                    'placeholder' => 'Enter Firstname',
                                    'disabled' => $disable,
                                ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php 
                                echo $this->Form->input('lastname',[
                                    'id' => 'lastname',
                                    'type' => 'text',
                                    'class' => 'form-control required',
                                    'placeholder' => 'Enter Lastname',
                                    'disabled' => $disable,
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
    							    'id' => 'phone_number',
    							    'value' => $user->country_code.$user->phone_number,
    							    'disabled' => $disable,
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
                                    'disabled' => TRUE,
                                ]);
                            ?>
                            <p class="help-block"><?php echo __(Configure::read('DEFAULT_SUB_ADMIN')) ?></p>
                        </div>

						<div id="show_hospital" class="form-group" style="<?php if($user->role_id != 4 && $user->role_id != 3) { echo "display: none;"; }?>">
                            <?php 
                                echo $this->Form->input('users_hospital.hospital_id',[
                                    'id' => 'role',
                                    'type' => 'select',
                                    'options' => $hospitals,
                                    'class' => 'form-control select2',
                                    'disabled' => TRUE,
                                ]);
                            ?>
                        </div>
                        <div id="show_department" class="form-group" style="<?php if($user->role_id != 5) { echo "display: none;"; }?>">
                            <label for="departments"><?= __('Select Departments')?> </label>
                            <?php 
                                echo $this->Form->select('departments', $departments, [
                                    'id' => 'departments',
                                    'multiple' => true,
                                    'tabindex' => -1,
                                    'value' => $userDepartments,
                                    'placeholder' => 'Enter Department',
                                    'class' => 'form-control select2 required',
                                    'disabled' => $disable,
                                ]);
                            ?>
                            <label id="departments-error" class="error" for="departments"></label>
                        </div>
                        <div id="show_floor" class="form-group" style="<?php if($user->role_id != 4) { echo "display: none;"; }?>">
                            <label for="floors"><?= __('Select Floors')?> </label>
                            <?php 
                                echo $this->Form->select('floors', $floors, [
                                    'id' => 'floors',
                                    'multiple' => true,
                                    'tabindex' => -1,
                                    'value' => $userFloors,
                                    'placeholder' => 'Enter Floor',
                                    'class' => 'form-control select2 required',
                                    'disabled' => $disable,
                                ]);
                            ?>
                            <label id="floors-error" class="error" for="floors"></label>
                        </div>
                        
                        <!--<div class="form-group">
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
                        </div>-->
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <?php 
                            echo $this->Form->button(__('Update'),[
                                'type' => 'submit',
                                'class' => 'btn btn-primary btn-form'
                            ]);

                            echo $this->Html->link(__('Cancel'),'/users/index',[
                                'class' => 'btn btn-default btn-form'
                            ]);
                        ?>
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
  <script>

  $.validator.addMethod("regex", function(value, element, regexp) {
	var re = new RegExp(regexp);
	return this.optional(element) || re.test(value);
});
	
  function showHospital(rolId) {
		console.log(rolId);
		if(rolId == 3 || rolId == 4) {
			$('#show_hospital').show();
			$(function () {
		        $(".select2").select2();
		    });
		} else {
			$('#show_hospital').hide();
		}	 
	}
  </script>
<script type="text/javascript">
    $("#phone_number").intlTelInput({
    	initialCountry: "us",
    	nationalMode: true,
    	separateDialCode:true,
    	hiddenInput: "phone_number"
    });

    $(function () {
        $(".select2").select2();
    });

    jQuery.validator.addMethod("intlTelNumber", function(value, element) {
        return this.optional(element) || $(element).intlTelInput("isValidNumber");
    }, "Please enter a valid Phone Number");

    $('#phone_number').on('change', function() {
    	var phone = $('#phone_number').val();
    	$("#country_code").val("+"+$("#phone_number").intlTelInput("getSelectedCountryData").dialCode);
    });
    
    $("#photo").change(function(){
        readURL(this);
    });

    $( "#user-edit" ).validate({
        rules: {
            email: {
                email: true,
                remote: {
                	url : "<?php echo $this->Url->build(['controller' => 'users', 'action' => 'checkUniqueEmail']); ?>",
					type : "post",
                	data : {
                    	user_id : "<?php echo $user->id; ?>"
                    }
                },
            },
            password: {
            	required : false,
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
        		remote   : "This value is already in use" 
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