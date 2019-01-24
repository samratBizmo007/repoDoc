<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sub Department'), ['action' => 'edit', $subDepartment->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sub Department'), ['action' => 'delete', $subDepartment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subDepartment->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sub Departments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sub Department'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Departments'), ['controller' => 'Departments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Department'), ['controller' => 'Departments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="subDepartments view large-9 medium-8 columns content">
    <h3><?= h($subDepartment->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Department') ?></th>
            <td><?= $subDepartment->has('department') ? $this->Html->link($subDepartment->department->name, ['controller' => 'Departments', 'action' => 'view', $subDepartment->department->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($subDepartment->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($subDepartment->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($subDepartment->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($subDepartment->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Active') ?></th>
            <td><?= $subDepartment->is_active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
