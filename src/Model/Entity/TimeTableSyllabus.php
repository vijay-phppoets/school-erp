<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TimeTableSyllabus Entity
 *
 * @property int $id
 * @property int $medium_id
 * @property int $class_id
 * @property int $section_id
 * @property int $stream_id
 * @property int $exam_id
 * @property int $subject_id
 * @property \Cake\I18n\FrozenDate $date
 * @property \Cake\I18n\FrozenTime $time_from
 * @property \Cake\I18n\FrozenTime $time_to
 *
 * @property \App\Model\Entity\Media $media
 * @property \App\Model\Entity\Class $class
 * @property \App\Model\Entity\Section $section
 * @property \App\Model\Entity\Stream $stream
 * @property \App\Model\Entity\Subject $subject
 */
class TimeTableSyllabus extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'medium_id' => true,
        'class_id' => true,
        'section_id' => true,
        'stream_id' => true,
        'exam_id' => true,
        'subject_id' => true,
        'date' => true,
        'time_from' => true,
        'time_to' => true,
        'media' => true,
        'class' => true,
        'section' => true,
        'stream' => true,
        'subject' => true
    ];
}
