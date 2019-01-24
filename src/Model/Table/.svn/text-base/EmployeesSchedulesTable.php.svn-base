<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\ORM\RulesChecker;

use App\Model\Table\AppTable;

/**
 * EmployeesSchedules Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\EmployeesSchedule get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeesSchedule newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmployeesSchedule[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeesSchedule|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeesSchedule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeesSchedule[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeesSchedule findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeesSchedulesTable extends AppTable
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
            ->requirePresence('hospital_id', 'create')
            ->notEmpty('hospital_id');

        $validator
            ->requirePresence('service_team_id', 'create')
            ->notEmpty('service_team_id');
        
        /* $validator
            ->requirePresence('schedule', 'create')
            ->notEmpty('schedule'); */

        return $validator;
    }
    
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    /* public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
        $rules->add($rules->existsIn(['hospital_id'], 'Hospitals'));
        return $rules;
    } */
    
    public function getEmployeeSchedule($data) {
        
        $employee = $this->find('all')
            ->where([
                'employee_id' => $data['employee_id'],
                //'hospital_id' => $data['hospital_id'],
                //'service_team_id' => $data['service_team_id']
            ])
            ->first();
        
        $employeeSchedule = [];
        if(!empty($employee)){
            $schedule = json_decode($employee->schedule, true);
            $rangeStart = date("Y-m-01", strtotime($data['date']));
            //$rangeStart = date("m-01-Y", strtotime($data['date']));
            $rangeEnd = date("Y-m-t", strtotime($rangeStart));
            
            if(!empty($schedule)) {
                $result = array_filter($schedule, function($val) use ($rangeEnd, $rangeStart) {
                    $date = \DateTime::createFromFormat('m-d-Y', $val);
                    $utime = strtotime($date->format('Y-m-d'));
                   
                    return $utime <= strtotime($rangeEnd) && $utime >= strtotime($rangeStart);
                }, ARRAY_FILTER_USE_KEY);
                $i = 0;
               // print_r($result); die;
               foreach ($result as $schedule_key => $schedule_val) {
                   unset($schedule_val['service_team']);
                   foreach ($schedule_val as $key => $val) {
                       $date = \DateTime::createFromFormat('m-d-Y', $schedule_key);
                       $utime = $date->format('d-m-Y');
                       $employeeSchedule[$i]['date'] = $utime;
                       $employeeSchedule[$i]['time'] = $val['time'];
                       $employeeSchedule[$i]['service'] = $val['service_team'];
                       $i++;
                   }
               }
            }
        }
        
        return $employeeSchedule;
    }
    
}
