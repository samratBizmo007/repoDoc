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

<p class="login-box-msg"><?php echo __('Sign in to start your session') ?></p>

<?php echo $this->Form->create('',['id'=>'login']); ?>
    <div class="form-group has-feedback">
        <?php 
            echo $this->Form->input('otp',[
                'id' => 'text',
                'type' => 'otp',
                'class' => 'form-control required',
                'placeholder' => 'Enter Otp',
                'label' => false
            ]);
        ?>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="row">
    	 <!--<div class="col-xs-12">
            <div class="pull-right">
                <label>
                    <?php //echo $this->Html->link(__('Resend OTP'),['controller' => 'Users', 'action' => 'resendOtp', base64_encode($id)],['class' => '', 'escape' => false]); ?>
                </label>
            </div>
        </div> -->
        <div class="col-xs-12">
            <?php 
                echo $this->Form->button(__('Login'),[
                    'type' => 'submit',
                    'class' => 'btn btn-primary btn-block btn-material'
                ]);
            ?>
        </div>
    </div>
</form>


<?php echo $this->Html->script('Admin./plugins/select2/select2.full.min'); ?>
<?php echo $this->Html->script('Admin./plugins/jquery-validation/jquery.validate.min'); ?>
<?php echo $this->Html->script('Admin./plugins/jquery-validation/additional-methods.min'); ?>

<script type="text/javascript">
    $( "#login" ).validate({
        rules: {
            email: {
                email: true
            },
            password : {
                minlength : 6
            }
        }
    });
</script>