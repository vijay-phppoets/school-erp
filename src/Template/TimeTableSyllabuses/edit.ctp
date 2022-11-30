<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimeTableSyllabus $timeTableSyllabus
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $timeTableSyllabus->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $timeTableSyllabus->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Time Table Syllabuses'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Streams'), ['controller' => 'Streams', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Stream'), ['controller' => 'Streams', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Subjects'), ['controller' => 'Subjects', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Subject'), ['controller' => 'Subjects', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="timeTableSyllabuses form large-9 medium-8 columns content">
    <?= $this->Form->create($timeTableSyllabus) ?>
    <fieldset>
        <legend><?= __('Edit Time Table Syllabus') ?></legend>
        <?php
            echo $this->Form->control('medium_id');
            echo $this->Form->control('class_id');
            echo $this->Form->control('section_id', ['options' => $sections]);
            echo $this->Form->control('stream_id', ['options' => $streams]);
            echo $this->Form->control('exam_id');
            echo $this->Form->control('subject_id', ['options' => $subjects]);
            echo $this->Form->control('date');
            echo $this->Form->control('time_from');
            echo $this->Form->control('time_to');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
