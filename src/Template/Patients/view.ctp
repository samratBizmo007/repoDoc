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

$serviceTeamName = '';
if(!empty($patient->patient_service_teams)) {
    foreach ($patient->patient_service_teams as $ps_key => $ps_val){
        if(!empty($ps_val->service_team->name)) {
            $serviceTeamName .= $ps_val->service_team->name.', ';
        }
    }
}
?>

<div class="modal-dialog modal-lg">
    <div class="box box-primary">
        <div class="box-body box-profile">
            <?php 
                $patient_photo = Configure::read('DEFAULT_PATIENT_IMAGE_URL');
            ?>
            <div class="profile-user-img img-responsive img-circle profile-image image-crop" style="background-image: url('<?php echo $patient_photo; ?>')"> </div>
            <h3 class="profile-username text-center"><?php echo h($patient->full_name) ?></h3>

            <ul class="col-md-6">
                <li class="list-group-item">
                    <b><?php echo __('Birthdate'); ?></b>
                    <a class="pull-right"><?php echo h($patient->birthdate); ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Doctor Name'); ?></b>
                    <a class="pull-right"><?php echo !empty($patient->employee) ? h($patient->employee->full_name) : ''; ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Hospital'); ?></b>
                    <a class="pull-right"><?php echo h($patient->hospital->name); ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Service Team'); ?></b>
                    <a class="<?php echo strlen(trim($serviceTeamName, ', ')) < 50 ? 'pull-right' : '' ?>"><?php echo trim($serviceTeamName, ', '); ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Gender'); ?></b> 
                    <a class="pull-right"><?php echo Configure::read('GENDERS.'.$patient->gender); ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('PMH'); ?></b>
                    <?php if(!empty($patient->pmh)) {?>
                    <br/>
                    <?php }?>
                    <a class=""><?php echo h($patient->pmh); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Diagnosed With'); ?></b> 
                    <?php if(!empty($patient->diagnosed_with)) {?>
                    <br/>
                    <?php }?>
                    <a class=""><?php echo h($patient->diagnosed_with); ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Title'); ?></b> 
                    <a class="pull-right"><?php echo h($patient->title); ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Service Team'); ?></b> 
                    <?php echo $this->Html->link(__('<i class="fa fa-fw fa-eye"></i>'),['controller' => 'Patients', 'action' => 'patientServiceTeam', $patient->id,$patient->hospital_id],['class' => 'btn btn-xs btn-info view-remote-modal ajax-sub-modal-popup pull-right', 'escape' => false]); ?>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Patient Followups'); ?></b> 
                    <?php echo $this->Html->link(__('<i class="fa fa-fw fa-eye"></i>'),['controller' => 'Patients', 'action' => 'patientFollowups', $patient->id],['class' => 'btn btn-xs btn-info view-remote-modal ajax-sub-modal-popup pull-right', 'escape' => false]); ?>
                </li>
           </ul>
           <ul class="col-md-6">
                <li class="list-group-item">
                    <b><?php echo __('Admission Date'); ?></b> 
                    <a class="pull-right"><?php echo h($patient->admission_date); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('MRN'); ?></b> 
                    <a class="pull-right"><?php echo h($patient->mrn); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('bed'); ?></b> 
                    <a class="pull-right"><?php echo h($patient->bed); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Room No'); ?></b> 
                    <a class="pull-right"><?php echo h($patient->room); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Floor'); ?></b> 
                    <a class="pull-right"><?php echo h(!empty($patient->floor) ? $patient->floor->name : ''); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Status'); ?></b> 
                    <a class="pull-right"><?php echo Configure::read('PATIENT_STATUS.'.$patient->patient_status); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Created At'); ?></b> 
                    <a class="pull-right"><?php echo h($patient->created); ?></a>
                </li>
                
                <li class="list-group-item">
                    <b><?php echo __('Modified'); ?></b> 
                    <a class="pull-right"><?php echo h($patient->modified); ?></a>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Signout Notes'); ?></b> 
                    <?php echo $this->Html->link(__('<i class="fa fa-fw fa-eye"></i>'),['controller' => 'Patients', 'action' => 'patientSignoutNotes', $patient->id],['class' => 'btn btn-xs btn-info view-remote-modal ajax-sub-modal-popup pull-right', 'escape' => false]); ?>
                </li>
                <li class="list-group-item">
                    <b><?php echo __('Patient Major Events'); ?></b> 
                    <?php echo $this->Html->link(__('<i class="fa fa-fw fa-eye"></i>'),['controller' => 'Patients', 'action' => 'patientMajorEvents', $patient->id],['class' => 'btn btn-xs btn-info view-remote-modal ajax-sub-modal-popup pull-right', 'escape' => false]); ?>
                </li>
            </ul>
        </div>
        <!-- /.box-body -->
    </div>
</div>