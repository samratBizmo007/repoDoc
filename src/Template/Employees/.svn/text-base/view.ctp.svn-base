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

<div class="modal-dialog modal-lg">
    <div class="box box-primary">
        <div class="box-body box-profile">
            <?php 
                $employee_photo = !empty($employee->photo) && file_exists(Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_PATH').$employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
            ?>
            <div class="profile-user-img img-responsive img-circle profile-image image-crop" style="background-image: url('<?php echo $employee_photo; ?>')"> </div>
            <h3 class="profile-username text-center"><?php echo h($employee->full_name) ?></h3>

            <ul class="col-md-6">
                <li class="list-group-item">
                    <b><?php echo __('Email'); ?></b>
                    <a class="pull-right"><?php echo h($employee->email); ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Hospital'); ?></b>
                    <a class="pull-right"><?php echo !empty($employee->hospitals_employees) && !empty($employee->hospitals_employees[0]->hospital->name) ? h($employee->hospitals_employees[0]->hospital->name) : ''; ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Service Team'); ?></b>
                    <a class="pull-right"><?php echo !empty($employee->hospitals_employees) && !empty($employee->hospitals_employees[0]->service_team->name) ? h($employee->hospitals_employees[0]->service_team->name) : ''; ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Employee Role'); ?></b> 
                    <a class="pull-right"><?php echo h($employee->employee_role); ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Designation'); ?></b> 
                    <a class="pull-right"><?php echo h($employee->designation); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Department'); ?></b> 
                    <a class="pull-right"><?php echo h($employee->department); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Title'); ?></b> 
                    <a class="pull-right"><?php echo h($employee->title); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Qualification'); ?></b> 
                    <a class="pull-right"><?php echo h($employee->qualification); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Office Number'); ?></b> 
                    <a class="pull-right"><?php echo h($employee->office_number); ?></a>
                </li>
                </ul>
                <ul class="col-md-6">
                <li class="list-group-item">
                    <b><?php echo __('Cell Number'); ?></b> 
                    <a class="pull-right"><?php echo h($employee->cell_number); ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Fax Number'); ?></b> 
                    <a class="pull-right"><?php echo h($employee->fax_number); ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Pager Number'); ?></b> 
                    <a class="pull-right"><?php echo h($employee->pager_number); ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Working Time'); ?></b> 
                    <a class="pull-right"><?php echo h($employee->working_time); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Availability Status'); ?></b> 
                    <a class="pull-right"><?php echo $employee->availability_status ? __('Available') : __('Not Available'); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Created At'); ?></b> 
                    <a class="pull-right"><?php echo h($employee->created); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Modified'); ?></b> 
                    <a class="pull-right"><?php echo h($employee->modified); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Status'); ?></b> 
                    <a class="pull-right"><?php echo $employee->status ? __('Yes') : __('No'); ?></a>
                </li>
            </ul>
        </div>
        <!-- /.box-body -->
    </div>
</div>