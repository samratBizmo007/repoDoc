<?php
namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Hash;

/**
 * EmployeesPatients Model
 *
 * @method \App\Model\Entity\EmployeesPatient get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeesPatient newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmployeesPatient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeesPatient|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeesPatient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeesPatient[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeesPatient findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeesPatientsTable extends AppTable
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

        //$this->table('patients');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        
        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
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
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
        $rules->add($rules->existsIn(['patient_id'], 'Patients'));

        return $rules;
    }
    
    public function getEmployeePatients($employee_id) {
        $patientLists = $this->find('all')
            ->select(['patient_id'])
            ->where(['employee_id' => $employee_id, 'is_deleted' => 1])
            ->toArray();
        
        $result = array_values(array_unique(Hash::extract($patientLists, '{n}.patient_id')));
        
        return $result;
    }
    
    public function getEmployeePatientIds($employee_id) {
        return $this->find('list', ['keyField' => 'patient_id','valueField' =>'patient_id'])->where([ 'employee_id' => $employee_id, 'is_deleted !=' => 1])->toArray();
    }
    
    public function getUniquePatients($employee_id,$patient_id) {
        $patients_arr = explode(',', $patient_id);
    
        $patientLists = $this->find('all')
        ->select(['patient_id'])
        ->where(['employee_id' => $employee_id, 'patient_id IN' => $patients_arr ,'is_deleted' => 0])
        ->toArray();
    
        $unique_result = array_values(array_unique(Hash::extract($patientLists, '{n}.patient_id')));
        $result = array_merge(array_diff($unique_result, $patients_arr), array_diff($patients_arr, $unique_result));
         
        return $result;
    }
    
    public function checkEmployeePatients($employee_id, $patient_id) {
        $patientLists = $this->find('all')
            ->select()
            ->where(['employee_id' => $employee_id,'patient_id' => $patient_id, 'is_deleted !=' => 1])
            ->first();
    
        if(!empty($patientLists)) {
            return true;
        } else {
            return false;
        }
    }
}
