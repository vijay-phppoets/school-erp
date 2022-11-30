<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StudentRecord Entity
 *
 * @property int $id
 * @property int $student_id
 * @property string $attend
 * @property string $meeting
 * @property string $marks
 * @property string $grade
 * @property string $percentage
 * @property string $status
 * @property string $remark
 * @property int $parent_id
 * @property int $section_id
 * @property int $stream_id
 * @property int $student_class_id
 * @property int $marksmax
 *
 * @property \App\Model\Entity\Student $student
 * @property \App\Model\Entity\StudentRecord $parent_student_record
 * @property \App\Model\Entity\Section $section
 * @property \App\Model\Entity\StudentRecord[] $child_student_records
 */
class StudentRecord extends Entity
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
        'student_id' => true,
        'attend' => true,
        'meeting' => true,
        'marks' => true,
        'grade' => true,
        'percentage' => true,
        'status' => true,
        'remark' => true,
        'parent_id' => true,
        'section_id' => true,
        'stream_id' => true,
        'student_class_id' => true,
        'marksmax' => true,
        'student' => true,
        'parent_student_record' => true,
        'section' => true,
        'child_student_records' => true
    ];
}
