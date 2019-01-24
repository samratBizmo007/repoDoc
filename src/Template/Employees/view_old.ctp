<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Employee'), ['action' => 'edit', $employee->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Employee'), ['action' => 'delete', $employee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Diagnoses'), ['controller' => 'Diagnoses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Diagnosis'), ['controller' => 'Diagnoses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Followups'), ['controller' => 'Followups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Followup'), ['controller' => 'Followups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Hospital Employees'), ['controller' => 'HospitalEmployees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Hospital Employee'), ['controller' => 'HospitalEmployees', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Major Events'), ['controller' => 'MajorEvents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Major Event'), ['controller' => 'MajorEvents', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reminders'), ['controller' => 'Reminders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reminder'), ['controller' => 'Reminders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Signout Notes'), ['controller' => 'SignoutNotes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Signout Note'), ['controller' => 'SignoutNotes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Voice Notes'), ['controller' => 'VoiceNotes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Voice Note'), ['controller' => 'VoiceNotes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Patients'), ['controller' => 'Patients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Patient'), ['controller' => 'Patients', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="employees view large-9 medium-8 columns content">
    <h3><?= h($employee->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($employee->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Firstname') ?></th>
            <td><?= h($employee->firstname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lastname') ?></th>
            <td><?= h($employee->lastname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Employee Role') ?></th>
            <td><?= h($employee->employee_role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= $employee->has('role') ? $this->Html->link($employee->role->name, ['controller' => 'Roles', 'action' => 'view', $employee->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Designation') ?></th>
            <td><?= h($employee->designation) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Department') ?></th>
            <td><?= h($employee->department) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($employee->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Qualification') ?></th>
            <td><?= h($employee->qualification) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photo') ?></th>
            <td><?= h($employee->photo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Office Number') ?></th>
            <td><?= h($employee->office_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Cell Number') ?></th>
            <td><?= h($employee->cell_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fax Number') ?></th>
            <td><?= h($employee->fax_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Working Time') ?></th>
            <td><?= h($employee->working_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Build Version') ?></th>
            <td><?= h($employee->build_version) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($employee->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Device Type') ?></th>
            <td><?= $this->Number->format($employee->device_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Availability Status') ?></th>
            <td><?= $this->Number->format($employee->availability_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($employee->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($employee->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $employee->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Diagnoses') ?></h4>
        <?php if (!empty($employee->diagnoses)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Employee Id') ?></th>
                <th scope="col"><?= __('Patient Id') ?></th>
                <th scope="col"><?= __('Department Id') ?></th>
                <th scope="col"><?= __('Diagnosed With') ?></th>
                <th scope="col"><?= __('Sign Out Notes') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($employee->diagnoses as $diagnoses): ?>
            <tr>
                <td><?= h($diagnoses->id) ?></td>
                <td><?= h($diagnoses->employee_id) ?></td>
                <td><?= h($diagnoses->patient_id) ?></td>
                <td><?= h($diagnoses->department_id) ?></td>
                <td><?= h($diagnoses->diagnosed_with) ?></td>
                <td><?= h($diagnoses->sign_out_notes) ?></td>
                <td><?= h($diagnoses->created) ?></td>
                <td><?= h($diagnoses->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Diagnoses', 'action' => 'view', $diagnoses->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Diagnoses', 'action' => 'edit', $diagnoses->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Diagnoses', 'action' => 'delete', $diagnoses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $diagnoses->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Followups') ?></h4>
        <?php if (!empty($employee->followups)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Employee Id') ?></th>
                <th scope="col"><?= __('Patient Id') ?></th>
                <th scope="col"><?= __('Department Id') ?></th>
                <th scope="col"><?= __('Content') ?></th>
                <th scope="col"><?= __('Date') ?></th>
                <th scope="col"><?= __('Time') ?></th>
                <th scope="col"><?= __('Is Active') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($employee->followups as $followups): ?>
            <tr>
                <td><?= h($followups->id) ?></td>
                <td><?= h($followups->employee_id) ?></td>
                <td><?= h($followups->patient_id) ?></td>
                <td><?= h($followups->department_id) ?></td>
                <td><?= h($followups->content) ?></td>
                <td><?= h($followups->date) ?></td>
                <td><?= h($followups->time) ?></td>
                <td><?= h($followups->is_active) ?></td>
                <td><?= h($followups->created) ?></td>
                <td><?= h($followups->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Followups', 'action' => 'view', $followups->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Followups', 'action' => 'edit', $followups->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Followups', 'action' => 'delete', $followups->id], ['confirm' => __('Are you sure you want to delete # {0}?', $followups->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Hospital Employees') ?></h4>
        <?php if (!empty($employee->hospital_employees)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Employee Id') ?></th>
                <th scope="col"><?= __('Service Team Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($employee->hospital_employees as $hospitalEmployees): ?>
            <tr>
                <td><?= h($hospitalEmployees->id) ?></td>
                <td><?= h($hospitalEmployees->employee_id) ?></td>
                <td><?= h($hospitalEmployees->service_team_id) ?></td>
                <td><?= h($hospitalEmployees->created) ?></td>
                <td><?= h($hospitalEmployees->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'HospitalEmployees', 'action' => 'view', $hospitalEmployees->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'HospitalEmployees', 'action' => 'edit', $hospitalEmployees->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'HospitalEmployees', 'action' => 'delete', $hospitalEmployees->id], ['confirm' => __('Are you sure you want to delete # {0}?', $hospitalEmployees->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Major Events') ?></h4>
        <?php if (!empty($employee->major_events)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Employee Id') ?></th>
                <th scope="col"><?= __('Patient Id') ?></th>
                <th scope="col"><?= __('Event') ?></th>
                <th scope="col"><?= __('Date') ?></th>
                <th scope="col"><?= __('Time') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($employee->major_events as $majorEvents): ?>
            <tr>
                <td><?= h($majorEvents->id) ?></td>
                <td><?= h($majorEvents->employee_id) ?></td>
                <td><?= h($majorEvents->patient_id) ?></td>
                <td><?= h($majorEvents->event) ?></td>
                <td><?= h($majorEvents->date) ?></td>
                <td><?= h($majorEvents->time) ?></td>
                <td><?= h($majorEvents->created) ?></td>
                <td><?= h($majorEvents->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'MajorEvents', 'action' => 'view', $majorEvents->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'MajorEvents', 'action' => 'edit', $majorEvents->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'MajorEvents', 'action' => 'delete', $majorEvents->id], ['confirm' => __('Are you sure you want to delete # {0}?', $majorEvents->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Reminders') ?></h4>
        <?php if (!empty($employee->reminders)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Employee Id') ?></th>
                <th scope="col"><?= __('Patient Id') ?></th>
                <th scope="col"><?= __('Content') ?></th>
                <th scope="col"><?= __('Date') ?></th>
                <th scope="col"><?= __('Time') ?></th>
                <th scope="col"><?= __('Is Active') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($employee->reminders as $reminders): ?>
            <tr>
                <td><?= h($reminders->id) ?></td>
                <td><?= h($reminders->employee_id) ?></td>
                <td><?= h($reminders->patient_id) ?></td>
                <td><?= h($reminders->content) ?></td>
                <td><?= h($reminders->date) ?></td>
                <td><?= h($reminders->time) ?></td>
                <td><?= h($reminders->is_active) ?></td>
                <td><?= h($reminders->created) ?></td>
                <td><?= h($reminders->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Reminders', 'action' => 'view', $reminders->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Reminders', 'action' => 'edit', $reminders->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Reminders', 'action' => 'delete', $reminders->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reminders->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Signout Notes') ?></h4>
        <?php if (!empty($employee->signout_notes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Employee Id') ?></th>
                <th scope="col"><?= __('Patient Id') ?></th>
                <th scope="col"><?= __('Department Id') ?></th>
                <th scope="col"><?= __('Content') ?></th>
                <th scope="col"><?= __('Date') ?></th>
                <th scope="col"><?= __('Time') ?></th>
                <th scope="col"><?= __('Is Active') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($employee->signout_notes as $signoutNotes): ?>
            <tr>
                <td><?= h($signoutNotes->id) ?></td>
                <td><?= h($signoutNotes->employee_id) ?></td>
                <td><?= h($signoutNotes->patient_id) ?></td>
                <td><?= h($signoutNotes->department_id) ?></td>
                <td><?= h($signoutNotes->content) ?></td>
                <td><?= h($signoutNotes->date) ?></td>
                <td><?= h($signoutNotes->time) ?></td>
                <td><?= h($signoutNotes->is_active) ?></td>
                <td><?= h($signoutNotes->created) ?></td>
                <td><?= h($signoutNotes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SignoutNotes', 'action' => 'view', $signoutNotes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SignoutNotes', 'action' => 'edit', $signoutNotes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SignoutNotes', 'action' => 'delete', $signoutNotes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $signoutNotes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Voice Notes') ?></h4>
        <?php if (!empty($employee->voice_notes)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Employee Id') ?></th>
                <th scope="col"><?= __('Patient Id') ?></th>
                <th scope="col"><?= __('Notes') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($employee->voice_notes as $voiceNotes): ?>
            <tr>
                <td><?= h($voiceNotes->id) ?></td>
                <td><?= h($voiceNotes->employee_id) ?></td>
                <td><?= h($voiceNotes->patient_id) ?></td>
                <td><?= h($voiceNotes->notes) ?></td>
                <td><?= h($voiceNotes->created) ?></td>
                <td><?= h($voiceNotes->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'VoiceNotes', 'action' => 'view', $voiceNotes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'VoiceNotes', 'action' => 'edit', $voiceNotes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'VoiceNotes', 'action' => 'delete', $voiceNotes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $voiceNotes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Patients') ?></h4>
        <?php if (!empty($employee->patients)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Hospital Id') ?></th>
                <th scope="col"><?= __('Service Team Id') ?></th>
                <th scope="col"><?= __('Primary Doctor Id') ?></th>
                <th scope="col"><?= __('Firstname') ?></th>
                <th scope="col"><?= __('Lastname') ?></th>
                <th scope="col"><?= __('Birthdate') ?></th>
                <th scope="col"><?= __('Gender') ?></th>
                <th scope="col"><?= __('Photo') ?></th>
                <th scope="col"><?= __('Pmh') ?></th>
                <th scope="col"><?= __('Diagnosed With') ?></th>
                <th scope="col"><?= __('Admission Date') ?></th>
                <th scope="col"><?= __('Mrn') ?></th>
                <th scope="col"><?= __('Room') ?></th>
                <th scope="col"><?= __('Floor') ?></th>
                <th scope="col"><?= __('Patient Status') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($employee->patients as $patients): ?>
            <tr>
                <td><?= h($patients->id) ?></td>
                <td><?= h($patients->hospital_id) ?></td>
                <td><?= h($patients->service_team_id) ?></td>
                <td><?= h($patients->primary_doctor_id) ?></td>
                <td><?= h($patients->firstname) ?></td>
                <td><?= h($patients->lastname) ?></td>
                <td><?= h($patients->birthdate) ?></td>
                <td><?= h($patients->gender) ?></td>
                <td><?= h($patients->photo) ?></td>
                <td><?= h($patients->pmh) ?></td>
                <td><?= h($patients->diagnosed_with) ?></td>
                <td><?= h($patients->admission_date) ?></td>
                <td><?= h($patients->mrn) ?></td>
                <td><?= h($patients->room) ?></td>
                <td><?= h($patients->floor) ?></td>
                <td><?= h($patients->patient_status) ?></td>
                <td><?= h($patients->status) ?></td>
                <td><?= h($patients->created) ?></td>
                <td><?= h($patients->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Patients', 'action' => 'view', $patients->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Patients', 'action' => 'edit', $patients->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Patients', 'action' => 'delete', $patients->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patients->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
