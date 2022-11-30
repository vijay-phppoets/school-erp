<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AssignDashboard[]|\Cake\Collection\CollectionInterface $assignDashboards
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Assign Dashboard'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employees'), ['controller' => 'Employees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee'), ['controller' => 'Employees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="assignDashboards index large-9 medium-8 columns content">
    <h3><?= __('Assign Dashboards') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('employee_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('role_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ddashboard_section_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assignDashboards as $assignDashboard): ?>
            <tr>
                <td><?= $this->Number->format($assignDashboard->id) ?></td>
                <td><?= $assignDashboard->has('employee') ? $this->Html->link($assignDashboard->employee->name, ['controller' => 'Employees', 'action' => 'view', $assignDashboard->employee->id]) : '' ?></td>
                <td><?= $assignDashboard->has('role') ? $this->Html->link($assignDashboard->role->name, ['controller' => 'Roles', 'action' => 'view', $assignDashboard->role->id]) : '' ?></td>
                <td><?= $this->Number->format($assignDashboard->ddashboard_section_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $assignDashboard->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $assignDashboard->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $assignDashboard->id], ['confirm' => __('Are you sure you want to delete # {0}?', $assignDashboard->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
