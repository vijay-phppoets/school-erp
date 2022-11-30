<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Holiday $holiday
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Holiday'), ['action' => 'edit', $holiday->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Holiday'), ['action' => 'delete', $holiday->id], ['confirm' => __('Are you sure you want to delete # {0}?', $holiday->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Holidays'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Holiday'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Holidays'), ['controller' => 'Holidays', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Holiday'), ['controller' => 'Holidays', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="holidays view large-9 medium-8 columns content">
    <h3><?= h($holiday->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($holiday->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Holiday Id') ?></th>
            <td><?= $this->Number->format($holiday->holiday_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($holiday->date) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($holiday->description)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Holidays') ?></h4>
        <?php if (!empty($holiday->holidays)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Holiday Id') ?></th>
                <th scope="col"><?= __('Date') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($holiday->holidays as $holidays): ?>
            <tr>
                <td><?= h($holidays->id) ?></td>
                <td><?= h($holidays->holiday_id) ?></td>
                <td><?= h($holidays->date) ?></td>
                <td><?= h($holidays->description) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Holidays', 'action' => 'view', $holidays->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Holidays', 'action' => 'edit', $holidays->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Holidays', 'action' => 'delete', $holidays->id], ['confirm' => __('Are you sure you want to delete # {0}?', $holidays->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
