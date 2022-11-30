<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TimeTablePeriod Entity
 *
 * @property int $id
 * @property int $medium_id
 * @property int $student_class_id
 * @property int $stream_id
 * @property int $section_id
 * @property int $subject_id
 * @property \Cake\I18n\FrozenTime $time_from
 * @property \Cake\I18n\FrozenTime $time_to
 * @property string $day
 * @property int $employee_id
 * @property \Cake\I18n\FrozenTime $created_on
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $edited_on
 * @property int $edited_by
 * @property string $is_deleted
 *
 * @property \App\Model\Entity\Media $media
 * @property \App\Model\Entity\StudentClass $student_class
 * @property \App\Model\Entity\Stream $stream
 * @property \App\Model\Entity\Section $section
 * @property \App\Model\Entity\Subject $subject
 * @property \App\Model\Entity\Employee $employee
 */
class TimeTablePeriod extends Entity
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
        'student_class_id' => true,
        'stream_id' => true,
        'section_id' => true,
        'subject_id' => true,
        'time_from' => true,
        'time_to' => true,
        'day' => true,
        'employee_id' => true,
        'created_on' => true,
        'created_by' => true,
        'edited_on' => true,
        'edited_by' => true,
        'is_deleted' => true,
        'media' => true,
        'student_class' => true,
        'stream' => true,
        'section' => true,
        'subject' => true,
        'employee' => true
    ];
}
