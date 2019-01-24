<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Core\Configure;

use App\Model\Table\AppTable;

/**
 * EmployeePlans Model
 *
 * @method \App\Model\Entity\EmployeePlan get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeePlan newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmployeePlan[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeePlan|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeePlan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeePlan[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeePlan findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeePlansTable extends AppTable
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

        $this->primaryKey('id');
        
        $this->addBehavior('Timestamp');
        
        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Hospitals', [
            'foreignKey' => 'hospital_id',
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
            ->requirePresence('employee_id', 'create')
            ->notEmpty('employee_id');

        $validator
            ->requirePresence('patient_id', 'create')
            ->notEmpty('patient_id');

        /* $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content'); */
            
        return $validator;
    }
    
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['patient_id'], 'Patients'));
        $rules->add($rules->existsIn(['hospital_id'], 'Hospitals'));
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
    
        return $rules;
    }
    
    public function getEmployeePlans($employeeId, $hospitalId) {
        $result = $this->find('all')
        ->select([
            'id',
            'employee_id',
            'patient_id',
            'content',
            'timestamp'
        ])
        ->contain([
            'Patients' => [
                'fields' => [
                    'id',
                    'firstname',
                    'lastname',
                    'photo',
                    'mrn',
                    'room',
                    'bed'
                ]
            ]
        ])
        ->where([
            'EmployeePlans.is_active' => 1,
            'EmployeePlans.hospital_id' => $hospitalId,
            'EmployeePlans.employee_id' => $employeeId
        ])
        ->order(['EmployeePlans.id DESC'])
        ->all()
        ->toArray();
    
        $employeePlans = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $employeePlans[$i]['id'] = $val->id;
                $employeePlans[$i]['employee_id'] = $val->employee_id;
                $employeePlans[$i]['content'] = $val->content;
                $employeePlans[$i]['timestamp'] = $val->timestamp;
                $employeePlans[$i]['patient_id'] = $val->patient->id;
                $employeePlans[$i]['name'] = !empty($val->patient) && !empty($val->patient->full_name) ? $val->patient->full_name : '';
                $employeePlans[$i]['photo'] = Configure::read('DEFAULT_PATIENT_IMAGE_URL');
                $employeePlans[$i]['mrn'] =  !empty($val->patient) && !empty($val->patient->mrn) ? $val->patient->mrn : '';
                //$employeePlans[$i]['bed'] =  !empty($val->patient) && !empty($val->patient->bed) ? $val->patient->bed : '';
                $roomBad = (!empty($val->patient->room)  && !empty($val->patient->bed)) ?  $val->patient->room.'-'.$val->patient->bed : ( !empty($val->patient->room) ? $val->patient->room : (!empty($val->patient->bed) ? $val->patient->bed : ''));
                $employeePlans[$i]['bed'] =  $roomBad;
                $i++;
            }
        }
        return $employeePlans;
    }
    
    public function getEmployeePlansDetail($employeeId, $patientId) {
        $result = $this->find('all')
            ->select([
                'id',
                'employee_id',
                'patient_id',
                'content',
                'timestamp',
                'discharge',
                'place'
            ])
            ->where([
                'EmployeePlans.is_active' => 1,
                'EmployeePlans.patient_id' => $patientId,
                'EmployeePlans.employee_id' => $employeeId
            ])
            ->order(['EmployeePlans.timestamp DESC'])
            ->first();
            
        $employeePlans = [];
        $employeePlans['plan_id'] = !empty($result->id) ? $result->id : 0;
        $employeePlans['plan_content'] = !empty($result->content) ? $result->content : '';
        $employeePlans['plan_timestamp'] = !empty($result->timestamp) ? $result->timestamp : 0;
        $employeePlans['place'] = !empty($result->place) ? $result->place : 1;
        $employeePlans['discharge'] =  !empty($result->discharge) ? $result->discharge : 1;
        
        return $employeePlans;
    }
    
    
}
