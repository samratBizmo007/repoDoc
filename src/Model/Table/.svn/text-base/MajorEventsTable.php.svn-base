<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Core\Configure;

use App\Model\Table\AppTable;

/**
 * MajorEvents Model
 *
 * @method \App\Model\Entity\MajorEvent get($primaryKey, $options = [])
 * @method \App\Model\Entity\MajorEvent newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MajorEvent[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MajorEvent|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MajorEvent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MajorEvent[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MajorEvent findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MajorEventsTable extends AppTable
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
            ->requirePresence('event', 'create')
            ->notEmpty('event');
        
        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');
            
        $validator
            ->requirePresence('date', 'create')
            ->notEmpty('date');
            
        /* $validator
            ->requirePresence('time', 'create')
            ->notEmpty('time'); */

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
    
    public function uploadAudio($audio,$old_photo = ''){
        $uploads_original_path = Configure::read('UPLOAD_MAJOR_EVENT_PATH');
        return  $this->file($audio, $uploads_original_path);
    }
    
    public function getMajorEvents($patientId) {
        $result = $this->find('all')
            ->select([
                'id',
                'employee_id',
                'patient_id',
                'event',
                'content',
                'duration',
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
                        'employee_role_short'
                    ]
                ]
            ])
            ->where([
                'MajorEvents.is_active' => 1,
                'MajorEvents.patient_id' => $patientId
            ])
            ->order(['MajorEvents.id DESC'])
            ->all()
            ->toArray();
        
        $majorEvents = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $majorEvents[$i]['id'] = $val->id;
                $majorEvents[$i]['employee_id'] = $val->employee->id;
                $majorEvents[$i]['event'] = $val->event;
                $majorEvents[$i]['content'] = !empty($val->content) && file_exists(Configure::read('UPLOAD_MAJOR_EVENT_PATH').$val->content) ? Configure::read('UPLOAD_MAJOR_EVENT_URL').$val->content : '';
                $majorEvents[$i]['duration'] = !empty($val->duration) ? $val->duration : '';
                $majorEvents[$i]['date'] = !empty($val->date) ? date('d-m-y', strtotime($val->date)) : '';
                $majorEvents[$i]['time'] = !empty($val->time) ? date('h:i a', strtotime($val->time)) : '';
                $majorEvents[$i]['name'] = !empty($val->employee->full_name) ? $val->employee->full_name : '';
                $majorEvents[$i]['photo'] =  !empty($val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$val->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $majorEvents[$i]['designation'] =  !empty($val->employee->designation) ? $val->employee->designation : '';
                $majorEvents[$i]['department'] =  !empty($val->employee->department) ? $val->employee->department : '';
                $majorEvents[$i]['employee_role'] =  !empty($val->employee->employee_role) ? $val->employee->employee_role : '';
                $majorEvents[$i]['employee_role_short'] =  !empty($val->employee->employee_role_short) ? $val->employee->employee_role_short : '';
                $i++;
            }
        }
        return $majorEvents;
    }
    
    public function getMajorEventDetail($id) {
        $result = $this->find('all')
        ->select([
            'id',
            'employee_id',
            'patient_id',
            'event',
            'content',
            'duration',
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
            'MajorEvents.is_active' => 1,
            'MajorEvents.id' => $id
        ])
        ->order(['MajorEvents.id DESC'])
        ->first();
        
        $majorEvents = [];
        if(!empty($result)) {
            $majorEvents['id'] = $result->id;
            $majorEvents['employee_id'] = $result->employee->id;
            $majorEvents['event'] = $result->event;
            $majorEvents['content'] = !empty($result->content) && file_exists(Configure::read('UPLOAD_MAJOR_EVENT_PATH').$result->content) ? Configure::read('UPLOAD_MAJOR_EVENT_URL').$result->content : '';
            $majorEvents['duration'] = !empty($result->duration) ? $result->duration : '';
            $majorEvents['date'] = !empty($result->date) ? date('d-m-y', strtotime($result->date)) : '';
            $majorEvents['time'] = !empty($result->time) ? date('h:i a', strtotime($result->time)) : '';
            $majorEvents['name'] = !empty($result->employee->full_name) ? $result->employee->full_name : '';
            $majorEvents['photo'] =  !empty($result->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$result->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
            $majorEvents['designation'] =  !empty($result->employee->designation) ? $result->employee->designation : '';
            $majorEvents['department'] =  !empty($result->employee->department) ? $result->employee->department : '';
            $majorEvents['employee_role'] =  !empty($result->employee->employee_role) ? $result->employee->employee_role : '';
            $majorEvents['employee_role_short'] =  !empty($result->employee->employee_role_short) ? $result->employee->employee_role_short : '';
        }
        return $majorEvents;
    }
}
