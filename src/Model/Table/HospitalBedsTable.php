<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

use App\Model\Table\AppTable;

/**
 * HospitalBeds Model
 *
 *
 * @method \App\Model\Entity\HospitalBeds get($primaryKey, $options = [])
 * @method \App\Model\Entity\HospitalBeds newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\HospitalBeds[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HospitalBeds|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HospitalBeds patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HospitalBeds[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\HospitalBeds findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HospitalBedsTable extends AppTable
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
        
        $this->table('hospital_beds');
        $this->primaryKey('id');

        $this->belongsTo('Floors', [
            'foreignKey' => 'floor_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Hospitals', [
            'foreignKey' => 'hospital_id',
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
            ->requirePresence('hospital_id', 'create')
            ->notEmpty('hospital_id');

        $validator
            ->requirePresence('floor_id', 'create')
            ->notEmpty('floor_id');
        
        $validator
            ->requirePresence('room_number', 'create')
            ->notEmpty('room_number');

        $validator
            ->requirePresence('bed_number', 'create')
            ->notEmpty('bed_number');

        return $validator;
    }

    public function getBedDetails($hospitalId) {
        
        $result = $this->find('all')
                ->select([
                    'id',
                    'room_number',
                    'bed_number'
                ])
                ->contain([
                    'Floors' => [
                        'fields' => [
                            'name'
                        ]
                    ]
                ])
                ->where([
                    'HospitalBeds.hospital_id' => $hospitalId
                ])
                ->all()
                ->toArray();
        
        $data = array();
        $i=0;
        $this->PatientsBed = TableRegistry::get('PatientsBed');
        foreach($result as $val){
            $data[$i]["id"] = $val->id;
            $data[$i]["room_number"] = $val->room_number;
            $data[$i]["bed_number"] = $val->bed_number;
            $data[$i]["floor_name"] = $val->floor->name;
            $bedData = $this->PatientsBed->getBedDetails($val->id,"OCCUPIED");
            $data[$i]["patient_name"] = !empty($bedData) ? $bedData['patient_name'] :"";
            $data[$i]["status"] = !empty($bedData) ? $bedData['status'] :"";
            $i++;
        }        
        return $data;
    }

    public function isBedExist($hospital_id,$roomNumber,$bedNumber,$floorId = 0){
        
        $conditions = [
            'HospitalBeds.hospital_id' => $hospital_id,
            'HospitalBeds.floor_id' => $floorId,
            'HospitalBeds.room_number' => $roomNumber,
            'HospitalBeds.bed_number' => $bedNumber,
        ];
        
        $query = $this->find('all')
            ->where($conditions)
            ->first();
    
        if(!empty($query)){
            return true;
        } else{
            return false;
        }
    }
    
}
