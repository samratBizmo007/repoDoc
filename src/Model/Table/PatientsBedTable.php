<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

use App\Model\Table\AppTable;

/**
 * PatientsBed Model
 *
 *
 * @method \App\Model\Entity\PatientsBed get($primaryKey, $options = [])
 * @method \App\Model\Entity\PatientsBed newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PatientsBed[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PatientsBed|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PatientsBed patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PatientsBed[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PatientsBed findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PatientsBedTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);
        
        $this->table('patients_bed');
        $this->primaryKey('id');

        $this->belongsTo('HospitalBeds', [
            'foreignKey' => 'hospital_bed_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
            'joinType' => 'INNER'
        ]);
       
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('hospital_bed_id', 'create')
            ->notEmpty('hospital_bed_id');

        $validator
            ->requirePresence('patient_id', 'create')
            ->notEmpty('patient_id');
        
        return $validator;
    }

    public function isWaiting($hospitalBedId){
        $result = $this->find('all')
            ->where([
                'PatientsBed.hospital_bed_id' => $hospitalBedId,
                'PatientsBed.status' => "WAITING",
            ])
            ->count();

        if($result > 0){
            return true;
        }

        return false;

    }

    public function getWaitingDetails($hospitalBedId){
  
        $result = $this->find('all')
            ->contain([
                'Patients' => [
                    'fields' => [
                        'firstname',
                        'lastname'
                    ]
                ],
                'HospitalBeds' => [
                    'fields' => [
                        'bed_number',
                        'room_number'
                    ]
                ]
            ])
            ->where([
                'PatientsBed.hospital_bed_id' => $hospitalBedId,
                'PatientsBed.status' => "WAITING"
            ])
            ->all()
            ->toArray();
        $data = array();

        foreach($result as $val){
            $data["id"] = $val->id;
            $data["patient_id"] = $val->patient_id;
            $data["hospital_bed_id"] = $val->hospital_bed_id;
            $data["patient_name"]=$val->patient->firstname." ".$val->patient->lastname;
            $data["room_number"]=$val->hospital_bed->room_number;
            $data["bed_number"]=$val->hospital_bed->bed_number;
        }
        return $data;

    }

    public function getDetails($hospitalBedId){
  
        $result = $this->find('all')
            ->contain([
                'Patients' => [
                    'fields' => [
                        'firstname',
                        'lastname'
                    ]
                ],
                'HospitalBeds' => [
                    'fields' => [
                        'bed_number',
                        'room_number'
                    ]
                ]
            ])
            ->where([
                'PatientsBed.hospital_bed_id' => $hospitalBedId
            ])
            ->all()
            ->toArray();
        $data = array();

        foreach($result as $val){
            $data["patient_name"]=$val->patient->firstname." ".$val->patient->lastname;
            $data["room_number"]=$val->hospital_bed->room_number;
            $data["bed_number"]=$val->hospital_bed->bed_number;
        }
        return $data;

    }

    public function getBedDetails($hospitalBedId,$status){
  
        $result = $this->find('all')
            ->contain([
                'Patients' => [
                    'fields' => [
                        'firstname',
                        'lastname'
                    ]
                ],
                'HospitalBeds' => [
                    'fields' => [
                        'bed_number',
                        'room_number'
                    ]
                ]
            ])
            ->where([
                'PatientsBed.hospital_bed_id' => $hospitalBedId,
                'PatientsBed.status' => $status
            ])
            ->all()
            ->toArray();
        $data = array();

        foreach($result as $val){
            $data["patient_name"]=$val->patient->firstname." ".$val->patient->lastname;
            $data["room_number"]=$val->hospital_bed->room_number;
            $data["bed_number"]=$val->hospital_bed->bed_number;
            $data["status"]=$val->status;
        }
        return $data;

    }

    public function getPatientsBed($patientId){
  
        $result = $this->find('all')
            ->contain([
                'HospitalBeds' => [
                    'fields' => [
                        'bed_number',
                        'room_number',
                        'floor_id'
                    ],
                    "Floors" =>[
                        'fields' =>["name"]
                    ]
                ]
                
            ])
            ->where([
                'PatientsBed.patient_id' => $patientId
            ])
            ->all()
            ->toArray();
        $data = array();

        foreach($result as $val){
            $data["id"]=$val->id;
            $data["hospital_bed_id"]=$val->hospital_bed_id;
            $data["status"]=$val->status;
            $data["floor_name"]=$val->hospital_bed->floor->name;
            $data["room_number"]=$val->hospital_bed->room_number;
            $data["bed_number"]=$val->hospital_bed->bed_number;
        }
        
        return $data;

    }
}
