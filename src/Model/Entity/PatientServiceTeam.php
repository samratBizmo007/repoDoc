<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PatientServiceTeam Entity
 *
 * @property int $id
 * @property int $hospital_id
 * @property string $name
 * @property bool $status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Hospital $hospital
 * @property \App\Model\Entity\HospitalEmployee[] $hospital_employees
 * @property \App\Model\Entity\Patient[] $patients
 */
class PatientServiceTeam extends Entity
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
