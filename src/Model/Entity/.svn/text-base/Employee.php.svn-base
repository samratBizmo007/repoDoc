<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Employee Entity
 *
 * @property int $id
 * @property string $email
 * @property string $firstname
 * @property string $lastname
 * @property string $employee_role
 * @property int $role_id
 * @property string $designation
 * @property string $department
 * @property string $title
 * @property string $qualification
 * @property string $photo
 * @property string $office_number
 * @property string $cell_number
 * @property string $fax_number
 * @property string $working_time
 * @property int $device_type
 * @property string $build_version
 * @property int $availability_status
 * @property bool $status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Diagnosis[] $diagnoses
 * @property \App\Model\Entity\Followup[] $followups
 * @property \App\Model\Entity\HospitalEmployee[] $hospital_employees
 * @property \App\Model\Entity\MajorEvent[] $major_events
 * @property \App\Model\Entity\Reminder[] $reminders
 * @property \App\Model\Entity\SignoutNote[] $signout_notes
 * @property \App\Model\Entity\VoiceNote[] $voice_notes
 * @property \App\Model\Entity\Patient[] $patients
 */
class Employee extends Entity
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

    protected function _setPassword($password){
        return (new DefaultPasswordHasher)->hash($password);
    }
    
    protected function _setEmail($email){
        return trim(strtolower($email));
    }

    protected function _getFullName()
    {
        return $this->_properties['firstname'] . ' ' .
            $this->_properties['lastname'];
    }
}
