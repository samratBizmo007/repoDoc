<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

use App\Model\Table\AppTable;

/**
 * HospitalEmployees Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\HospitalEmployee get($primaryKey, $options = [])
 * @method \App\Model\Entity\HospitalEmployee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\HospitalEmployee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HospitalEmployee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HospitalEmployee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HospitalEmployee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\HospitalEmployee findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HospitalsEmployeesTable extends AppTable
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
        
        $this->table('hospital_employees');
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
        
        $this->belongsTo('ServiceTeams', [
            'foreignKey' => 'service_team_id',
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

       /*  $validator
            ->requirePresence('employee_id', 'create')
            ->notEmpty('employee_id'); */

        $validator
            ->requirePresence('hospital_id', 'create')
            ->notEmpty('hospital_id');

        $validator
            ->requirePresence('service_team_id', 'create')
            ->notEmpty('service_team_id');

        return $validator;
    }
    
    public function getServiceTeamLists($hospitalId, $serviceTeam, $patientId) {
        
        $serviceTeamList = [];
        $result = [];
        if(!empty($serviceTeam)) {
            foreach ($serviceTeam as $key => $val) {
                $serviceTeamList[] = $val->service_team_id;   
            }
            
            $result = $this->find('all')
                ->select([
                    'id',
                    'employee_id',
                    'hospital_id',
                    'service_team_id'
                ])
                ->contain([
                    'ServiceTeams' => [
                        'fields' => [
                            'id',
                            'name',
                            'status'
                        ]
                    ],
                    'Employees' => [
                        'fields' => [
                            'id',
                            'firstname',
                            'lastname',
                            'designation',
                            'department',
                            'employee_role',
                            'employee_role_short',
                            'availability_status'
                        ]
                    ],
                    'Hospitals' => [
                        'fields' => [
                            'id',
                            'name',
                            'is_active'
                        ]
                    ]
                ])
                ->where([
                    'Hospitals.is_active' => 1,
                    'HospitalsEmployees.hospital_id' => $hospitalId,
                    'HospitalsEmployees.service_team_id IN' => $serviceTeamList
                ])
                ->order(['Employees.availability_status DESC'])
                ->all()
                ->toArray();
        }

        $this->Patients = TableRegistry::get('Patients');
        $patient = $this->Patients->get($patientId);
        $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');    
        $employee = [];
        $i = 0;
        if(!empty($result)) {
            foreach ($result as $key => $val) {
                $employee[$i]['id'] = $val->employee->id;
                $employee[$i]['name'] = !empty($val->employee->full_name) ? $val->employee->full_name : '';
                $employee[$i]['photo'] =  !empty($val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$val->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $employee[$i]['designation'] =  !empty($val->employee->designation) ? $val->employee->designation : '';
                $employee[$i]['department'] =  !empty($val->employee->department) ? $val->employee->department : '';
                $employee[$i]['employee_role'] =  !empty($val->employee->employee_role) ? $val->employee->employee_role : '';
                $employee[$i]['employee_role_short'] =  !empty($val->employee->employee_role_short) ? $val->employee->employee_role_short : '';
                $employee[$i]['is_working'] = !empty($val->employee->availability_status) ? $val->employee->availability_status : 0;
                $employee[$i]['service_team'] = !empty($val->service_team) ? $val->service_team->name : '';
                $employee[$i]['service_team_id'] = !empty($val->service_team) ? $val->service_team->id : '';
                $patientdata = $this->PatientServiceTeams->find('all')->where(['patient_id' => $patient->id,'hospital_id'=>$patient->hospital_id,'service_team_id'=>$val->service_team->id])->first();
                $employee[$i]["isPrimary"] = $patientdata->is_primary;;
                $i++;
            }
        }
        
        $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
        
        $patientsData = $this->EmployeesPatients->find('all')
        ->select([
            'id',
            'employee_id',
            'patient_id',
            'is_primary'
        ])
        ->contain(['Employees' => function($q) {
                return $q
                ->select([
                    'id',
                    'firstname',
                    'lastname',
                    'designation',
                    'department',
                    'employee_role',
                    'employee_role_short',
                    'availability_status'
                ])
                ->where(['status' => 1]);
            },
            'Employees.HospitalsEmployees' => [
                'fields' => [
                    'id',
                    'employee_id',
                    'hospital_id',
                    'service_team_id'
                ]
            ],
            'Employees.HospitalsEmployees.ServiceTeams' => [
                'fields' => [
                    'id',
                    'name',
                    'status'
                ]
            ]
        ])
        ->find('all')
        ->where([
            'EmployeesPatients.patient_id' => $patientId,
            'EmployeesPatients.is_deleted' => 0
        ])
        ->toArray();
        
        if(!empty($patientsData)) {
            foreach ($patientsData as $key => $val) {
                $employee[$i]['id'] = $val->employee->id;
                $employee[$i]['name'] = !empty($val->employee->full_name) ? $val->employee->full_name : '';
                $employee[$i]['photo'] =  !empty($val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$val->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $employee[$i]['designation'] =  !empty($val->employee->designation) ? $val->employee->designation : '';
                $employee[$i]['department'] =  !empty($val->employee->department) ? $val->employee->department : '';
                $employee[$i]['employee_role'] =  !empty($val->employee->employee_role) ? $val->employee->employee_role : '';
                $employee[$i]['employee_role_short'] =  !empty($val->employee->employee_role_short) ? $val->employee->employee_role_short : '';
                $employee[$i]['is_working'] = !empty($val->employee->availability_status) ? $val->employee->availability_status : 0;
                $employee[$i]['service_team'] = !empty($val->employee) && !empty($val->employee->hospitals_employees)  && !empty($val->employee->hospitals_employees[0]->service_team) ? $val->employee->hospitals_employees[0]->service_team->name : '';
                $employee[$i]['service_team_id'] = !empty($val->employee) && !empty($val->employee->hospitals_employees)  && !empty($val->employee->hospitals_employees[0]->service_team) ? $val->employee->hospitals_employees[0]->service_team->id : '';
                $employee[$i]["isPrimary"] = $val->is_primary;
                $i++;
            }
        }
        $employee = $this->array_multi_unique($employee);
        return array_values($this->array_sort($employee, 'is_working', SORT_DESC));
    }
    
    public function getEmployees($hospitalId, $teamId) {
        $result = $this->find('all')
            ->select(['employee_id'])
            ->where(['service_team_id IN' => $teamId, 'hospital_id' => $hospitalId ])
            ->order('employee_id')
            ->all()
            ->toArray();
        
        $newArr = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $newArr[$val->employee_id]['memberId'] = (string)$val->employee_id;
                $newArr[$val->employee_id]['isAdmin'] = false;
                $i++;
            }
        }
       return $newArr;
    }
    
    public function getPatientsEmployees($serviceTeams = [], $provider_name = "", $employee_role = '', $patientId = []) {
        
        if(!empty($serviceTeams)) {
            $conditions['AND']['HospitalsEmployees.service_team_id IN'] = $serviceTeams;
        } else {
            $conditions['AND']['HospitalsEmployees.service_team_id IN'] = [ 0 ];
        }
        
        if(!empty($provider_name)) {
            $provider_name = explode(' ', $provider_name);
        
            $firstname = '';
            $lastname = '';
            if(!empty($provider_name[0])) {
                $firstname = $provider_name[0];
            }
        
            if(!empty($provider_name[1])) {
                $lastname = $provider_name[1];
            } else {
                $lastname = $firstname;
            }
        
            $conditions['OR']['Employees.firstname LIKE'] = '%'.$firstname.'%';
            $conditions['OR']['Employees.lastname LIKE'] = '%'.$lastname.'%';
        }
        
        if(!empty($employee_role)) {
            $conditions['AND']['Employees.employee_role_short'] = $employee_role;
        }
        
        $result = $this->find('all')
            ->select([
                'employee_id',
                'hospital_id'
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
                        'availability_status',
                        'device_token',
                        'device_type',
                        'is_notification'
                    ]
                ]
            ])
            ->where($conditions)
            ->order(['HospitalsEmployees.service_team_id'])
            ->all()
            ->toArray();
        
        $employee = [];
        $i = 0;
        
        if(!empty($result)) {
            foreach ($result as $key => $val) {
                $employee[$i]['id'] = $val->employee->id;
                $employee[$i]['name'] = !empty($val->employee->full_name) ? $val->employee->full_name : '';
                $employee[$i]['photo'] =  !empty($val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$val->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $employee[$i]['designation'] =  !empty($val->employee->designation) ? $val->employee->designation : '';
                $employee[$i]['department'] =  !empty($val->employee->department) ? $val->employee->department : '';
                $employee[$i]['employee_role'] =  !empty($val->employee->employee_role) ? $val->employee->employee_role : '';
                $employee[$i]['employee_role_short'] =  !empty($val->employee->employee_role_short) ? $val->employee->employee_role_short : '';
                $employee[$i]['is_working'] = !empty($val->employee->availability_status) ? $val->employee->availability_status : 0;
                $employee[$i]['device_token'] = !empty($val->employee->device_token) ? $val->employee->device_token : '';
                $employee[$i]['device_type'] = !empty($val->employee->device_type) ? $val->employee->device_type : 1;
                $employee[$i]['is_notification'] = !empty($val->employee->is_notification) ? $val->employee->is_notification : 0;
                $i++;
            }
        }
        
        if(!empty($patientId)) {
            unset($conditions['AND']['HospitalsEmployees.service_team_id IN']);
            $conditions['AND']['EmployeesPatients.patient_id IN'] = $patientId;
            $conditions['AND']['EmployeesPatients.is_deleted'] = 0;
            
            $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
            
            $patientsData = $this->EmployeesPatients->find('all')
            ->select([
                'id',
                'employee_id',
                'patient_id'
            ])
            ->contain(['Employees' => function($q) {
                return $q
                ->select([
                    'id',
                    'firstname',
                    'lastname',
                    'designation',
                    'department',
                    'employee_role',
                    'employee_role_short',
                    'availability_status',
                    'device_token',
                    'device_type',
                    'is_notification'
                ])
                ->where(['status' => 1]);
            },
            ])
            ->find('all')
            ->where($conditions)
            ->toArray();
            
            if(!empty($patientsData)) {
                foreach ($patientsData as $key => $val) {
                    $employee[$i]['id'] = $val->employee->id;
                    $employee[$i]['name'] = !empty($val->employee->full_name) ? $val->employee->full_name : '';
                    $employee[$i]['photo'] =  !empty($val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$val->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                    $employee[$i]['designation'] =  !empty($val->employee->designation) ? $val->employee->designation : '';
                    $employee[$i]['department'] =  !empty($val->employee->department) ? $val->employee->department : '';
                    $employee[$i]['employee_role'] =  !empty($val->employee->employee_role) ? $val->employee->employee_role : '';
                    $employee[$i]['employee_role_short'] =  !empty($val->employee->employee_role_short) ? $val->employee->employee_role_short : '';
                    $employee[$i]['is_working'] = !empty($val->employee->availability_status) ? $val->employee->availability_status : 0;
                    $employee[$i]['device_token'] = !empty($val->employee->device_token) ? $val->employee->device_token : '';
                    $employee[$i]['device_type'] = !empty($val->employee->device_type) ? $val->employee->device_type : 1;
                    $employee[$i]['is_notification'] = !empty($val->employee->is_notification) ? $val->employee->is_notification : 0;
                    $i++;
                }
            }
        }
        return $employee;
    }
    
    public function checkEmployeeIsWorking($serviceTeam, $employeeId) {
        $result = $this->find('all')
            ->select()
            ->where([
                'service_team_id IN' => array_values($serviceTeam),
                'employee_id' => $employeeId
            ])
            ->first();
         
        if(!empty($result)) {
            return true;
        } else {
            return false;
        }
    }
}
