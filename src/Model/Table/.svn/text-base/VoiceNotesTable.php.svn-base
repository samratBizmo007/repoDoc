<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Core\Configure;

use App\Model\Table\AppTable;
use Cake\ORM\TableRegistry;

/**
 * VoiceNotes Model
 *
 * @method \App\Model\Entity\VoiceNote get($primaryKey, $options = [])
 * @method \App\Model\Entity\VoiceNote newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\VoiceNote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\VoiceNote|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\VoiceNote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\VoiceNote[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\VoiceNote findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class VoiceNotesTable extends AppTable
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

       /*  $validator
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
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
    
        return $rules;
    }
    
    public function getVoiceNotes($patientId) {
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
                'VoiceNotes.is_active' => 1,
                'VoiceNotes.patient_id' => $patientId
            ])
            ->order(['VoiceNotes.id DESC'])
            ->all()
            ->toArray();
        
        $employee = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $employee[$i]['id'] = $val->id;
                $employee[$i]['employee_id'] = $val->employee->id;
                $employee[$i]['content'] = $val->content;
                $employee[$i]['date'] = !empty($val->date) ? date('d-m-y', strtotime($val->date)) : '';
                $employee[$i]['time'] = !empty($val->time) ? date('h:i a', strtotime($val->time)) : '';
                $employee[$i]['name'] = !empty($val->employee->full_name) ? $val->employee->full_name : '';
                $employee[$i]['photo'] =  !empty($val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$val->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $employee[$i]['designation'] =  !empty($val->employee->designation) ? $val->employee->designation : '';
                $employee[$i]['employee_role'] =  !empty($val->employee->employee_role) ? $val->employee->employee_role : '';
                $employee[$i]['employee_role_short'] =  !empty($val->employee->employee_role_short) ? $val->employee->employee_role_short : '';
                $i++;
            }
        }
        return $employee;
    }
    
    public function getEmployeeVoiceNotes($data) {
        $result = $this->find('all')
        ->select([
            'id',
            'employee_id',
            'patient_id',
            'content',
            'timestamp'
        ])
        ->where([
            'VoiceNotes.is_active' => 1,
            'VoiceNotes.employee_id' => $data['employee_id'],
            'VoiceNotes.patient_id' => $data['patient_id']
        ])
        ->order(['VoiceNotes.timestamp DESC'])
        ->first();
    
        $voiceNotes = [];
        if(!empty($result)) {
                $voiceNotes['id'] = $result->id;
                $voiceNotes['employee_id'] = $result->employee_id;
                $voiceNotes['content'] = $result->content;
                $voiceNotes['timestamp'] = $result->timestamp;
                $voiceNotes['patient_id'] = $result->patient_id;
        }
        return $voiceNotes;
    }
    
    public function getEmployeeVoiceNotesLists($employeeId, $serviceteamId) {
        
        $this->employeesPatients = TableRegistry::get('EmployeesPatients');
        $patientIds = $this->employeesPatients->getEmployeePatientIds($employeeId);
        
        if($serviceteamId > 0) {
            $this->patientServiceTeams = TableRegistry::get('PatientServiceTeams');
            $patientIds += $this->patientServiceTeams->getServiceTeamPatientIds($serviceteamId);
        }
        
        $deletePatients = $this->employeesPatients->getEmployeePatients($employeeId);
        
        $conditions = [
            'VoiceNotes.is_active' => 1,
            'VoiceNotes.employee_id' => $employeeId
        ];
        
        if(!empty($deletePatients)) {
        
            $conditions += [
                'VoiceNotes.patient_id NOT IN' => $deletePatients
            ];
        }
        
        if(!empty($patientIds)) {
            $patientIds = array_values(array_unique(array_values($patientIds)));
            $conditions += [
                'VoiceNotes.patient_id IN' => $patientIds
            ];
        }
        
        
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
            ->where($conditions)
            ->order(['VoiceNotes.id DESC'])
            ->all()
            ->toArray();
    
        $followups = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $followups[$i]['id'] = $val->id;
                $followups[$i]['employee_id'] = $val->employee_id;
                $followups[$i]['content'] = $val->content;
                $followups[$i]['timestamp'] = $val->timestamp;
                $followups[$i]['patient_id'] = $val->patient->id;
                $followups[$i]['name'] = !empty($val->patient) && !empty($val->patient->full_name) ? $val->patient->full_name : '';
                $followups[$i]['photo'] =  Configure::read('DEFAULT_PATIENT_IMAGE_URL');
                $followups[$i]['mrn'] =  !empty($val->patient) && !empty($val->patient->mrn) ? $val->patient->mrn : '';
                $roomBad = (!empty($val->patient->room)  && !empty($val->patient->bed)) ?  $val->patient->room.'-'.$val->patient->bed : ( !empty($val->patient->room) ? $val->patient->room : (!empty($val->patient->bed) ? $val->patient->bed : ''));
                $followups[$i]['bed'] =  $roomBad;
                //$followups[$i]['bed'] =  !empty($val->patient) && !empty($val->patient->bed) ? $val->patient->bed : '';
                $i++;
            }
        }
        return $followups;
    }
    
    public function getNotesDetail($id) {
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
            'VoiceNotes.is_active' => 1,
            'VoiceNotes.id' => $id
        ])
        ->order(['VoiceNotes.id DESC'])
        ->first();
    
        $followups = [];
        if(!empty($result)) {
            $followups['id'] = $result->id;
            $followups['employee_id'] = $result->patient_id;
            $followups['content'] = $result->content;
            $followups['timestamp'] = $result->timestamp;
            $followups['patient_id'] = $result->patient->id;
            $followups['name'] = !empty($result->patient) && !empty($result->patient->full_name) ? $result->patient->full_name : '';
            $followups['photo'] =  Configure::read('DEFAULT_PATIENT_IMAGE_URL');
            $followups['mrn'] =  !empty($result->patient) && !empty($result->patient->mrn) ? $result->patient->mrn : '';
            $roomBad = (!empty($result->patient->room)  && !empty($result->patient->bed)) ?  $result->patient->room.'-'.$result->patient->bed : ( !empty($result->patient->room) ? $result->patient->room : (!empty($result->patient->bed) ? $result->patient->bed : ''));
            $followups['bed'] =  $roomBad;
            //$followups['bed'] =  !empty($result->patient) && !empty($result->patient->bed) ? $result->patient->bed : '';
        }
        return $followups;
    }
    
    
}
