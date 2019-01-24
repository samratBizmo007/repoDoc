<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Core\Configure;

use App\Model\Table\AppTable;

/**
 * Reminders Model
 *
 * @method \App\Model\Entity\Reminder get($primaryKey, $options = [])
 * @method \App\Model\Entity\Reminder newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Reminder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reminder|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reminder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Reminder[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reminder findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RemindersTable extends AppTable
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
            
        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');
            
        $validator
            ->requirePresence('date', 'create')
            ->notEmpty('date');
            
        $validator
            ->requirePresence('time', 'create')
            ->notEmpty('time');

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
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
    
        return $rules;
    }
    
    public function getReminders($data) {
        
        $conditions['AND']['Reminders.is_active'] = 1;
        
        if(!empty($data['patient_id'])) {
            $conditions['AND']['Reminders.patient_id'] = $data['patient_id'];
        }
        
        if(!empty($data['employee_id'])) {
            $conditions['AND']['Reminders.employee_id'] = $data['employee_id'];
        }
        
        $result = $this->find('all')
            ->select([
                'id',
                'employee_id',
                'patient_id',
                'content',
                'date',
                'time',
                'status'
            ])
            ->contain([
                'Employees' => [
                    'fields' => [
                        'id',
                        'firstname',
                        'lastname',
                        'designation',
                        'department',
                        'employee_role',
                        'employee_role_short'
                    ]
                ]
            ])
            ->where($conditions)
            ->order(['Reminders.id DESC'])
            ->all()
            ->toArray();
        
        $reminder = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $reminder[$i]['id'] = $val->id;
                $reminder[$i]['employee_id'] = $val->employee->id;
                $reminder[$i]['content'] = $val->content;
                $reminder[$i]['date'] = !empty($val->date) ? date('d-m-y', strtotime($val->date)) : '';
                $reminder[$i]['time'] = !empty($val->time) ? date('h:i a', strtotime($val->time)) : '';
                $reminder[$i]['status'] = $val->status;
                $reminder[$i]['name'] = !empty($val->employee->full_name) ? $val->employee->full_name : '';
                $reminder[$i]['photo'] =  !empty($val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$val->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $reminder[$i]['designation'] =  !empty($val->employee->designation) ? $val->employee->designation : '';
                $reminder[$i]['department'] =  !empty($val->employee->department) ? $val->employee->department : '';
                $reminder[$i]['employee_role'] =  !empty($val->employee->employee_role) ? $val->employee->employee_role : '';
                $reminder[$i]['employee_role_short'] =  !empty($val->employee->employee_role_short) ? $val->employee->employee_role_short : '';
                $i++;
            }
        }
        return $reminder;
    }
    
    public function getReminderDetail($id) {
        $result = $this->find('all')
        ->select([
            'id',
            'employee_id',
            'patient_id',
            'content',
            'date',
            'time'
        ])
        ->contain([
            'Employees' => [
                'fields' => [
                    'id',
                    'firstname',
                    'lastname',
                    'designation',
                    'department',
                    'employee_role',
                    'employee_role_short',
                ]
            ]
        ])
        ->where([
            'Reminders.is_active' => 1,
            'Reminders.id' => $id
        ])
        ->order(['Reminders.id DESC'])
        ->first();
    
        $employee = [];
        if(!empty($result)) {
            $employee['id'] = $result->id;
            $employee['employee_id'] = $result->employee->id;
            $employee['content'] = $result->content;
            $employee['date'] = !empty($result->date) ? date('d-m-y', strtotime($result->date)) : '';
            $employee['time'] = !empty($result->time) ? date('h:i a', strtotime($result->time)) : '';
            $employee['name'] = !empty($result->employee->full_name) ? $result->employee->full_name : '';
            $employee['photo'] =  !empty($result->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$result->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
            $employee['designation'] =  !empty($result->employee->designation) ? $result->employee->designation : '';
            $employee['department'] =  !empty($result->employee->department) ? $result->employee->department : '';
            $employee['employee_role'] =  !empty($result->employee->employee_role) ? $result->employee->employee_role : '';
            $employee['employee_role_short'] =  !empty($result->employee->employee_role_short) ? $result->employee->employee_role_short : '';
        }
        return $employee;
    }
    
}
