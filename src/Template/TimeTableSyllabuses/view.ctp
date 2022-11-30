<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TimeTableSyllabus $timeTableSyllabus
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Time Table Syllabus'), ['action' => 'edit', $timeTableSyllabus->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Time Table Syllabus'), ['action' => 'delete', $timeTableSyllabus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $timeTableSyllabus->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Time Table Syllabuses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Time Table Syllabus'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Sections'), ['controller' => 'Sections', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Section'), ['controller' => 'Sections', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Streams'), ['controller' => 'Streams', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stream'), ['controller' => 'Streams', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Subjects'), ['controller' => 'Subjects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Subject'), ['controller' => 'Subjects', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="timeTableSyllabuses view large-9 medium-8 columns content">
    <h3><?= h($timeTableSyllabus->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Section') ?></th>
            <td><?= $timeTableSyllabus->has('section') ? $this->Html->link($timeTableSyllabus->section->name, ['controller' => 'Sections', 'action' => 'view', $timeTableSyllabus->section->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Stream') ?></th>
            <td><?= $timeTableSyllabus->has('stream') ? $this->Html->link($timeTableSyllabus->stream->name, ['controller' => 'Streams', 'action' => 'view', $timeTableSyllabus->stream->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subject') ?></th>
            <td><?= $timeTableSyllabus->has('subject') ? $this->Html->link($timeTableSyllabus->subject->name, ['controller' => 'Subjects', 'action' => 'view', $timeTableSyllabus->subject->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($timeTableSyllabus->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Medium Id') ?></th>
            <td><?= $this->Number->format($timeTableSyllabus->medium_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Class Id') ?></th>
            <td><?= $this->Number->format($timeTableSyllabus->class_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Exam Id') ?></th>
            <td><?= $this->Number->format($timeTableSyllabus->exam_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Date') ?></th>
            <td><?= h($timeTableSyllabus->date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Time From') ?></th>
            <td><?= h($timeTableSyllabus->time_from) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Time To') ?></th>
            <td><?= h($timeTableSyllabus->time_to) ?></td>
        </tr>
    </table>
</div>
