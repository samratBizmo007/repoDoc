<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Department'), ['action' => 'edit', $department->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Department'), ['action' => 'delete', $department->id], ['confirm' => __('Are you sure you want to delete # {0}?', $department->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Departments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Department'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Followups'), ['controller' => 'Followups', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Followup'), ['controller' => 'Followups', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Signout Notes'), ['controller' => 'SignoutNotes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Signout Note'), ['controller' => 'SignoutNotes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="departments view large-9 medium-8 columns content">
    <h3><?= h($department->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($department->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($department->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($department->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($department->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Active') ?></th>
            <td><?= $department->is_active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Followups') ?></h4>
        <?php if (!empty($department->followups)): ?>
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
            <?php foreach ($department->followups as $followups): ?>
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
        <h4><?= __('Related Signout Notes') ?></h4>
        <?php if (!empty($department->signout_notes)): ?>
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
            <?php foreach ($department->signout_notes as $signoutNotes): ?>
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
</div>
