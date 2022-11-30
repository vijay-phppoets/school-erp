<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssignDashboard Entity
 *
 * @property int $id
 * @property int $employee_id
 * @property int $role_id
 * @property int $ddashboard_section_id
 *
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\DdashboardSection $ddashboard_section
 */
class AssignDashboard extends Entity
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
        'employee_id' => true,
        'role_id' => true,
        'dashboard_section_ids' => true,
        'employee' => true,
        'role' => true,
        'ddashboard_section' => true
    ];
}
