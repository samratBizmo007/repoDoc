<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Service Team'), ['action' => 'edit', $serviceTeam->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Service Team'), ['action' => 'delete', $serviceTeam->id], ['confirm' => __('Are you sure you want to delete # {0}?', $serviceTeam->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Service Teams'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Service Team'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Hospitals'), ['controller' => 'Hospitals', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Hospital'), ['controller' => 'Hospitals', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Hospital Employees'), ['controller' => 'HospitalsEmployees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Hospital Employee'), ['controller' => 'HospitalsEmployees', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Patients'), ['controller' => 'Patients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Patient'), ['controller' => 'Patients', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="serviceTeams view large-9 medium-8 columns content">
    <h3><?= h($serviceTeam->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Hospital') ?></th>
            <td><?= $serviceTeam->has('hospital') ? $this->Html->link($serviceTeam->hospital->name, ['controller' => 'Hospitals', 'action' => 'view', $serviceTeam->hospital->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($serviceTeam->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($serviceTeam->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($serviceTeam->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($serviceTeam->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= $serviceTeam->status ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Hospital Employees') ?></h4>
        <?php if (!empty($serviceTeam->hospital_employees)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Employee Id') ?></th>
                <th scope="col"><?= __('Service Team Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($serviceTeam->hospital_employees as $hospitalEmployees): ?>
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
        <h4><?= __('Related Patients') ?></h4>
        <?php if (!empty($serviceTeam->patients)): ?>
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
            <?php foreach ($serviceTeam->patients as $patients): ?>
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
