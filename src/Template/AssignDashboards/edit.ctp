<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssignDashboard $assignDashboard
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $assignDashboard->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $assignDashboard->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Assign Dashboards'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="assignDashboards form large-9 medium-8 columns content">
    <?= $this->Form->create($assignDashboard) ?>
    <fieldset>
        <legend><?= __('Edit Assign Dashboard') ?></legend>
        <?php
            echo $this->Form->control('employee_id', ['options' => $employees]);
            echo $this->Form->control('role_id', ['options' => $roles]);
            echo $this->Form->control('ddashboard_section_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
