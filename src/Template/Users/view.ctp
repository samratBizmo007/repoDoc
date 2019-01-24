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
    <div class="box box-primary">
        <div class="box-body box-profile">
            <?php 
                $user_photo = !empty($user->photo) ? Configure::read('UPLOAD_ORIGNAL_IMAGE_URL').$user->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                /* echo $this->Html->image($user_photo,[
                    'class' => 'profile-user-img img-responsive img-circle',
                    'alt' => $user->full_name
                ]); */
            ?>
            <div class="profile-user-img img-responsive img-circle profile-image image-crop" style="background-image: url('<?php echo $user_photo; ?>')"> </div>
            <h3 class="profile-username text-center"><?php echo h($user->full_name) ?></h3>

            <p class="text-muted text-center"><?php echo Configure::read('VIEW_ROLES')[$user->role]; ?></p>

            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b><?php echo __('Email'); ?></b>
                    <a class="pull-right"><?php echo h($user->email); ?></a>
                </li>
                <?php if(!empty($user->users_hospital->hospital)) {?>
                <li class="list-group-item">
                    <b><?php echo __('Hospital'); ?></b> 
                    <a class="pull-right"><?php echo $user->users_hospital->hospital->name; ?></a>
                </li>
                <?php }?>
                <?php if(!empty($user->users_department->department)) {?>
                <li class="list-group-item">
                    <b><?php echo __('Department'); ?></b> 
                    <a class="pull-right"><?php echo $user->users_department->department->name; ?></a>
                </li>
                <?php }?>
                <?php if(!empty($user->floor)) {?>
                <li class="list-group-item">
                    <b><?php echo __('Floor'); ?></b> 
                    <a class="pull-right"><?php echo $user->floor; ?></a>
                </li>
                <?php }?>
                <li class="list-group-item">
                    <b><?php echo __('Status'); ?></b> 
                    <a class="pull-right"><?php echo $user->is_active ? '<span class="label label-success">'.__('Active').'</span>' : '<span class="label label-danger">'.__('Inactive').'</span>'; ?></a>
                </li>
            </ul>
            <?php if(!empty($user->users_floors)) { ?>
            <strong><i class="fa fa-pencil margin-r-5"></i>Floors</strong>
            <p>
				<?php foreach ($user->users_floors as $f_key => $f_val) { ?>
					<?php if(!empty($f_val->floor->name)) {?>
						<span class="label label-info"><?php echo $f_val->floor->name ?></span>
					<?php }?> 
				<?php }?>
			</p>
			<?php }?>
			<?php if(!empty($user->users_departments)) { ?>
            <strong><i class="fa fa-pencil margin-r-5"></i>Department</strong>
            <p>
				<?php foreach ($user->users_departments as $d_key => $d_val) { ?>
					<?php if(!empty($d_val->department->name)) {?>
						<span class="label label-info"><?php echo $d_val->department->name ?></span>
					<?php }?> 
				<?php }?>
			</p>
			<?php }?>
        </div>
        <!-- /.box-body -->
    </div>
</div>



