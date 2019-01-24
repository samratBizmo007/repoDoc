<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\Utility\Hash;

use App\Model\Table\AppTable;
use Cake\ORM\TableRegistry;

/**
 * Followups Model
 *
 * @method \App\Model\Entity\Followup get($primaryKey, $options = [])
 * @method \App\Model\Entity\Followup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Followup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Followup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Followup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Followup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Followup findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FollowupsTable extends AppTable
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
        
        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id',
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
            ->requirePresence('department_id', 'create')
            ->notEmpty('department_id');
        
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
        $rules->add($rules->existsIn(['department_id'], 'Departments'));
    
        return $rules;
    }
    
    public function getFollowups($patientId) {
        $result = $this->find('all')
            ->select([
                'id',
                'employee_id',
                'patient_id',
                'department_id',
                'content',
                'status',
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
                'Followups.is_active' => 1,
                'Followups.patient_id' => $patientId
            ])
            ->order(['Followups.id DESC'])
            ->all()
            ->toArray();
        
        $employee = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $employee[$i]['id'] = $val->id;
                $employee[$i]['employee_id'] = $val->employee->id;
                $employee[$i]['content'] = $val->content;
                $employee[$i]['status'] = $val->status;
                $employee[$i]['date'] = !empty($val->date) ? date('d-m-y', strtotime($val->date)) : '';
                $employee[$i]['time'] = !empty($val->time) ? date('h:i a', strtotime($val->time)) : '';
                $employee[$i]['name'] = !empty($val->employee->full_name) ? $val->employee->full_name : '';
                $employee[$i]['photo'] =  !empty($val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$val->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $employee[$i]['designation'] =  !empty($val->employee->designation) ? $val->employee->designation : '';
                $employee[$i]['department'] =  !empty($val->employee->department) ? $val->employee->department : '';
                $employee[$i]['employee_role'] =  !empty($val->employee->employee_role) ? $val->employee->employee_role : '';
                $employee[$i]['employee_role_short'] =  !empty($val->employee->employee_role_short) ? $val->employee->employee_role_short : '';
                $i++;
            }
        }
        return $employee;
    }
    
    public function getEmployeeFollowups($employeeId) {
        $this->PatientsBed = TableRegistry::get('PatientsBed');
        $result = $this->find('all')
        ->select([
            'id',
            'employee_id',
            'patient_id',
            'department_id',
            'content',
            'date',
            'time',
            'status'
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
            'Followups.is_active' => 1,
            'Followups.employee_id' => $employeeId
        ])
        ->order(['Followups.id DESC'])
        ->all()
        ->toArray();
    
        $followups = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $followups[$i]['id'] = $val->id;
                $followups[$i]['employee_id'] = $val->patient_id;
                $followups[$i]['content'] = $val->content;
                $followups[$i]['date'] = !empty($val->date) ? date('d-m-y', strtotime($val->date)) : '';
                $followups[$i]['time'] = !empty($val->time) ? date('h:i a', strtotime($val->time)) : '';
                $followups[$i]['status'] = $val->status;
                $followups[$i]['patient_id'] = $val->patient->id;
                $followups[$i]['name'] = !empty($val->patient) && !empty($val->patient->full_name) ? $val->patient->full_name : '';
                $followups[$i]['photo'] =  Configure::read('DEFAULT_PATIENT_IMAGE_URL');
                $followups[$i]['mrn'] =  !empty($val->patient) && !empty($val->patient->mrn) ? $val->patient->mrn : '';
                //$followups[$i]['bed'] =  !empty($val->patient) && !empty($val->patient->bed) ? $val->patient->bed : '';
                $bedData = $this->PatientsBed->getPatientsBed($val->patient->id);
                $roomBad = (!empty($bedData["room_number"])  && !empty($bedData["bed_number"])) ?  $bedData["room_number"].'-'.$bedData["bed_number"] : ( !empty($bedData["room_number"]) ? $bedData["room_number"] : (!empty($bedData["bed_number"]) ? $bedData["bed_number"] : ''));
                $followups[$i]['bed'] =  $roomBad;
                $i++;
            }
        }
        return $followups;
    }
    
    public function getFollowupDetail($id) {
        $result = $this->find('all')
        ->select([
            'id',
            'employee_id',
            'patient_id',
            'department_id',
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
            'Followups.is_active' => 1,
            'Followups.id' => $id
        ])
        ->order(['Followups.id DESC'])
        ->first();
        
        $employee = [];
        if(!empty($result)) {
            $employee['id'] = $result->id;
            //$employee['employee_id'] = $result->employee->id;
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
    
    public function getPatientsFollowupLists($employeeId, $hospitalId,$serviceteamId) {
        $this->PatientsBed = TableRegistry::get('PatientsBed');
        $conditions = [
            'Followups.employee_id' => $employeeId,
        ];
        
        $this->employeesPatients = TableRegistry::get('EmployeesPatients');
        $patientIds = $this->employeesPatients->getEmployeePatientIds($employeeId);
        
        if($serviceteamId > 0) {
            $this->patientServiceTeams = TableRegistry::get('PatientServiceTeams');
            $patientIds += $this->patientServiceTeams->getServiceTeamPatientIds($serviceteamId);
        }
        
        $deletePatients = $this->employeesPatients->getEmployeePatients($employeeId);
        
        if(!empty($deletePatients)) {
            $conditions += [
                'Followups.patient_id NOT IN' => $deletePatients
            ];
        }
        
        if(!empty($patientIds)) {
            $patientIds = array_values(array_unique(array_values($patientIds)));
            $conditions += [
                'Followups.patient_id IN' => $patientIds
            ];
        }
        
        $result = $this->find('all')
            ->select([
                'id',
                'employee_id',
                'patient_id',
                'department_id',
                'content',
                'date',
                'time',
                'status'
               
            ])
            ->contain([
                'Patients' => [
                    'fields' => [
                        'id',
                        'firstname',
                        'lastname',
                        'birthdate',
                        'gender',
                        'admission_date',
                        'photo',
                        'mrn',
                        'room',
                        'bed',
                        'pmh',
                        'diagnosed_with',
                        'patient_status'
                     ]   
                ],
                'Employees' => [
                    'fields' => [
                        'Employees.id',
                        'firstname',
                        'lastname',
                        'designation',
                        'department',
                        'employee_role',
                        'employee_role_short'
                    ]
                ]])
                ->where($conditions)
                //->hydrate(false)
                ->toArray();
            
            $patients = [];
            if(!empty($result)) {
                $patientIds = array_values(array_unique(Hash::extract($result, '{n}.patient_id')));
                $i = 0;
                foreach ($patientIds as $key => $val) {
                    $followups = Hash::extract($result, '{n}[patient_id = ' . $val . ']');
                    if(!empty($followups)) {
                        $patients[$i]['id'] = $followups[0]->patient->id;
                        $patients[$i]['name'] = $followups[0]->patient->full_name;
                        $patients[$i]['photo'] =  Configure::read('DEFAULT_PATIENT_IMAGE_URL');
                        $patients[$i]['mrn'] =  $followups[0]->patient->mrn;
                        $bedData = $this->PatientsBed->getPatientsBed($followups[0]->patient->id);
                        $roomBad = (!empty($bedData["room_number"])  && !empty($bedData["bed_number"])) ?  $bedData["room_number"].'-'.$bedData["bed_number"] : ( !empty($bedData["room_number"]) ? $bedData["room_number"] : (!empty($bedData["bed_number"]) ? $bedData["bed_number"] : ''));
                        $patients[$i]['bed'] =  $roomBad;
                        //$patients[$i]['bed'] =  $followups[0]->patient->bed;
                        $patients[$i]['pmh'] =  $followups[0]->patient->pmh;
                        $patients[$i]['age'] =  $this->getAgeFromBirthDate($followups[0]->patient->birthdate);
                        $patients[$i]['gender'] =  Configure::read('GENDERS')[$followups[0]->patient->gender];
                        $patients[$i]['admission_days'] = !empty($followups[0]->patient->admission_date) ? $this->getDateDiff($followups[0]->patient->admission_date) : 0;
                        $patients[$i]['diagnosed_with'] =  $followups[0]->patient->diagnosed_with;
                        $patients[$i]['patient_status'] =  $followups[0]->patient->patient_status;
                        $followup = [];
                        $j =0;
                        foreach ($followups as $f_key  => $f_val) {
                            $followup[$j]['id'] = $f_val->id;
                            $followup[$j]['content'] = $f_val->content;
                            $followup[$j]['date'] = date('d-m-y', strtotime($f_val->date));
                            $followup[$j]['time'] = date('h:i a', strtotime($f_val->time));
                            $followup[$j]['status'] = $f_val->status;
                            $followup[$j]['employee_name'] = !empty($f_val->employee) ? $f_val->employee->full_name : '';
                            $followup[$j]['employee_photo'] =  !empty($f_val->employee) && !empty($f_val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$f_val->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                            $followup[$j]['employee_designation'] = !empty($f_val->employee) ? $f_val->employee->designation : '';
                            $followup[$j]['employee_department'] =  !empty($f_val->employee) ? $f_val->employee->department : '';
                            $followup[$j]['employee_role'] =  !empty($f_val->employee) ? $f_val->employee->employee_role : '';
                            $followup[$j]['employee_role_short'] =  !empty($f_val->employee) ? $f_val->employee->employee_role_short : '';
                            $j++;
                        }
                        $patients[$i]['followups'] = $followup;
                        $i++;
                    }
                }
            }
    
            return $patients;
    }
    
    public function getDateDiff($date) {
    
    
        $now = time(); // or your date as well
        $your_date = strtotime($date);
        $datediff = $now - $your_date;
    
        return floor($datediff / (60 * 60 * 24));
    
    
    }
}
