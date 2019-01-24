<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Title'), ['action' => 'edit', $title->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Title'), ['action' => 'delete', $title->id], ['confirm' => __('Are you sure you want to delete # {0}?', $title->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Titles'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Title'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="titles view large-9 medium-8 columns content">
    <h3><?= h($title->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($title->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($title->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($title->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($title->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Active') ?></th>
            <td><?= $title->is_active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
