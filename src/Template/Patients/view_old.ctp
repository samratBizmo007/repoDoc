<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Patient'), ['action' => 'edit', $patient->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Patient'), ['action' => 'delete', $patient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $patient->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Patients'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Patient'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Hospitals'), ['controller' => 'Hospitals', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Hospital'), ['controller' => 'Hospitals', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Service Teams'), ['controller' => 'ServiceTeams', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Service Team'), ['controller' => 'ServiceTeams', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Diagnoses'), ['controller' => 'Diagnoses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Diagnosis'), ['controller' => 'Diagnoses', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Followups'), ['controller' => 'Followups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Followup'), ['controller' => 'Followups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Major Events'), ['controller' => 'MajorEvents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Major Event'), ['controller' => 'MajorEvents', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reminders'), ['controller' => 'Reminders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reminder'), ['controller' => 'Reminders', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Signout Notes'), ['controller' => 'SignoutNotes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Signout Note'), ['controller' => 'SignoutNotes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Voice Notes'), ['controller' => 'VoiceNotes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Voice Note'), ['controller' => 'VoiceNotes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="patients view large-9 medium-8 columns content">
    <h3><?= h($patient->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Hospital') ?></th>
            <td><?= $patient->has('hospital') ? $this->Html->link($patient->hospital->name, ['controller' => 'Hospitals', 'action' => 'view', $patient->hospital->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Service Team') ?></th>
            <td><?= $patient->has('service_team') ? $this->Html->link($patient->service_team->name, ['controller' => 'ServiceTeams', 'action' => 'view', $patient->service_team->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Firstname') ?></th>
            <td><?= h($patient->firstname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lastname') ?></th>
            <td><?= h($patient->lastname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Photo') ?></th>
            <td><?= h($patient->photo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Room') ?></th>
            <td><?= h($patient->room) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Floor') ?></th>
            <td><?= h($patient->floor) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($patient->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Employee Id') ?></th>
            <td><?= $this->Number->format($patient->employee_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Gender') ?></th>
            <td><?= $this->Number->format($patient->gender) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Patient Status') ?></th>
            <td><?= $this->Number->format($patient->patient_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Birthdate') ?></th>
            <td><?= h($patient->birthdate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Admission Date') ?></th>
            <td><?= h($patient->admission_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($patient->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($patient->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $patient->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Pmh') ?></h4>
        <?= $this->Text->autoParagraph(h($patient->pmh)); ?>
    </div>
    <div class="row">
        <h4><?= __('Diagnosed With') ?></h4>
        <?= $this->Text->autoParagraph(h($patient->diagnosed_with)); ?>
    </div>
    <div class="row">
        <h4><?= __('Mrn') ?></h4>
        <?= $this->Text->autoParagraph(h($patient->mrn)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Diagnoses') ?></h4>
        <?php if (!empty($patient->diagnoses)): ?>
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
            <?php foreach ($patient->diagnoses as $diagnoses): ?>
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
        <?php if (!empty($patient->followups)): ?>
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
            <?php foreach ($patient->followups as $followups): ?>
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
        <h4><?= __('Related Major Events') ?></h4>
        <?php if (!empty($patient->major_events)): ?>
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
            <?php foreach ($patient->major_events as $majorEvents): ?>
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
        <?php if (!empty($patient->reminders)): ?>
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
            <?php foreach ($patient->reminders as $reminders): ?>
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
        <?php if (!empty($patient->signout_notes)): ?>
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
            <?php foreach ($patient->signout_notes as $signoutNotes): ?>
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
        <?php if (!empty($patient->voice_notes)): ?>
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
            <?php foreach ($patient->voice_notes as $voiceNotes): ?>
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
        <h4><?= __('Related Employees') ?></h4>
        <?php if (!empty($patient->employees)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Email') ?></th>
                <th scope="col"><?= __('Firstname') ?></th>
                <th scope="col"><?= __('Lastname') ?></th>
                <th scope="col"><?= __('Employee Role') ?></th>
                <th scope="col"><?= __('Designation') ?></th>
                <th scope="col"><?= __('Department') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Qualification') ?></th>
                <th scope="col"><?= __('Photo') ?></th>
                <th scope="col"><?= __('Office Number') ?></th>
                <th scope="col"><?= __('Cell Number') ?></th>
                <th scope="col"><?= __('Fax Number') ?></th>
                <th scope="col"><?= __('Working Time') ?></th>
                <th scope="col"><?= __('Device Type') ?></th>
                <th scope="col"><?= __('Build Version') ?></th>
                <th scope="col"><?= __('Availability Status') ?></th>
                <th scope="col"><?= __('Status') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($patient->employees as $employees): ?>
            <tr>
                <td><?= h($employees->id) ?></td>
                <td><?= h($employees->email) ?></td>
                <td><?= h($employees->firstname) ?></td>
                <td><?= h($employees->lastname) ?></td>
                <td><?= h($employees->employee_role) ?></td>
                <td><?= h($employees->designation) ?></td>
                <td><?= h($employees->department) ?></td>
                <td><?= h($employees->title) ?></td>
                <td><?= h($employees->qualification) ?></td>
                <td><?= h($employees->photo) ?></td>
                <td><?= h($employees->office_number) ?></td>
                <td><?= h($employees->cell_number) ?></td>
                <td><?= h($employees->fax_number) ?></td>
                <td><?= h($employees->working_time) ?></td>
                <td><?= h($employees->device_type) ?></td>
                <td><?= h($employees->build_version) ?></td>
                <td><?= h($employees->availability_status) ?></td>
                <td><?= h($employees->status) ?></td>
                <td><?= h($employees->created) ?></td>
                <td><?= h($employees->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Employees', 'action' => 'view', $employees->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Employees', 'action' => 'edit', $employees->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Employees', 'action' => 'delete', $employees->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employees->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
