<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * HospitalBeds Entity
 *
 * @property int $id
 * @property int $hospital_id
 * @property int $floor_id
 * @property int $room_number
 * @property int $bed_number
 *
 * @property \App\Model\Entity\Hospital $hospital
 * @property \App\Model\Entity\Floor $floor
 */
class HospitalBeds extends Entity
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
