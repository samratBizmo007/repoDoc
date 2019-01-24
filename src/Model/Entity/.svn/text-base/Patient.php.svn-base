<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Patient Entity
 *
 * @property int $id
 * @property int $hospital_id
 * @property int $service_team_id
 * @property int $employee_id
 * @property string $firstname
 * @property string $lastname
 * @property \Cake\I18n\Time $birthdate
 * @property int $gender
 * @property string $photo
 * @property string $pmh
 * @property string $diagnosed_with
 * @property \Cake\I18n\Time $admission_date
 * @property string $mrn
 * @property string $room
 * @property string $floor
 * @property int $patient_status
 * @property bool $status
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\Hospital $hospital
 * @property \App\Model\Entity\ServiceTeam $service_team
 * @property \App\Model\Entity\PrimaryDoctor $primary_doctor
 * @property \App\Model\Entity\Diagnosis[] $diagnoses
 * @property \App\Model\Entity\Followup[] $followups
 * @property \App\Model\Entity\MajorEvent[] $major_events
 * @property \App\Model\Entity\Reminder[] $reminders
 * @property \App\Model\Entity\SignoutNote[] $signout_notes
 * @property \App\Model\Entity\VoiceNote[] $voice_notes
 * @property \App\Model\Entity\Employee[] $employees
 */
class Patient extends Entity
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
    
    protected function _getFullName()
    {
        return $this->_properties['firstname'] . ' ' .
            $this->_properties['lastname'];
    }

    /*protected function _getAdmissionDate()
    {
        if(!empty($this->_properties))
            return date('M d, Y',strtotime($this->_properties['admission_date']));
    }*/

    protected function _setAdmissionDate($admission_date)
    {
        return date('Y-m-d',strtotime($admission_date));
    }

   /* protected function _getBirthdate()
    {   
        
        if(!empty($this->_properties))
            return date('M d, Y',strtotime($this->_properties['birthdate']));
    }*/

    protected function _setBirthdate($birthdate)
    {
        return date('Y-m-d',strtotime($birthdate));
    }
}
