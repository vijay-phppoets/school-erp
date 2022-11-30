<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssignDashboard $assignDashboard
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Assign Dashboard'), ['action' => 'edit', $assignDashboard->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Assign Dashboard'), ['action' => 'delete', $assignDashboard->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assignDashboard->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Assign Dashboards'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Assign Dashboard'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="assignDashboards view large-9 medium-8 columns content">
    <h3><?= h($assignDashboard->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Employee') ?></th>
            <td><?= $assignDashboard->has('employee') ? $this->Html->link($assignDashboard->employee->name, ['controller' => 'Employees', 'action' => 'view', $assignDashboard->employee->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= $assignDashboard->has('role') ? $this->Html->link($assignDashboard->role->name, ['controller' => 'Roles', 'action' => 'view', $assignDashboard->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($assignDashboard->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ddashboard Section Id') ?></th>
            <td><?= $this->Number->format($assignDashboard->ddashboard_section_id) ?></td>
        </tr>
    </table>
</div>
