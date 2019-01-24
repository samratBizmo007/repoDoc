<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PatientHistory Entity
 *
 * @property int $id
 * @property int $patient_id
 * @property int $employee_id
 * @property int $user_id
 * @property int $hospital_id
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Patient $patient
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Hospital $hospital
 */
class PatientHistory extends Entity
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
        '*' => true,
        'id' => false
    ];
}
