<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Employee Role'), ['action' => 'edit', $employeeRole->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Employee Role'), ['action' => 'delete', $employeeRole->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employeeRole->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Employee Roles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee Role'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="employeeRoles view large-9 medium-8 columns content">
    <h3><?= h($employeeRole->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($employeeRole->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Short Name') ?></th>
            <td><?= h($employeeRole->short_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($employeeRole->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($employeeRole->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($employeeRole->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Active') ?></th>
            <td><?= $employeeRole->is_active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
