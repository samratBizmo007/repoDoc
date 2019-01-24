<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use function Cake\ORM\toArray;
use Cake\Event\Event;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Routing\Router;

/**
 * Patients Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Hospitals
 * @property \Cake\ORM\Association\BelongsTo $ServiceTeams
 * @property \Cake\ORM\Association\BelongsTo $Employees
 * @property \Cake\ORM\Association\HasMany $Diagnoses
 * @property \Cake\ORM\Association\HasMany $Followups
 * @property \Cake\ORM\Association\HasMany $MajorEvents
 * @property \Cake\ORM\Association\HasMany $Reminders
 * @property \Cake\ORM\Association\HasMany $SignoutNotes
 * @property \Cake\ORM\Association\HasMany $VoiceNotes
 * @property \Cake\ORM\Association\BelongsToMany $Employees
 *
 * @method \App\Model\Entity\Patient get($primaryKey, $options = [])
 * @method \App\Model\Entity\Patient newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Patient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Patient|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Patient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Patient[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Patient findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PatientsTable extends AppTable
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

        $this->table('patients');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Hospitals', [
            'foreignKey' => 'hospital_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ServiceTeams', [
            'foreignKey' => 'service_team_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
        /* $this->hasMany('Diagnoses', [
            'foreignKey' => 'patient_id'
        ]); */
        
        $this->hasMany('Followups', [
            'foreignKey' => 'patient_id'
        ]);
        
        $this->hasMany('MajorEvents', [
            'foreignKey' => 'patient_id'
        ]);
        
        $this->hasMany('Reminders', [
            'foreignKey' => 'patient_id'
        ]);
        
        $this->hasMany('SignoutNotes', [
            'foreignKey' => 'patient_id'
        ]);
        
        $this->hasMany('VoiceNotes', [
            'foreignKey' => 'patient_id'
        ]);
        
        $this->belongsTo('ServiceTeams', [
            'foreignKey' => 'service_team_id',
        ]);
        
        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
        ]);
        
        $this->belongsTo('Floors', [
            'foreignKey' => 'floor_id',
        ]);
        
        $this->hasMany('PatientServiceTeams', [
            'foreignKey' => 'patient_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
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
            ->requirePresence('firstname', 'create')
            ->notEmpty('firstname');

        $validator
            ->requirePresence('lastname', 'create')
            ->notEmpty('lastname');

        /* $validator
            ->date('birthdate')
            ->requirePresence('birthdate', 'create')
            ->notEmpty('birthdate'); */

        /*$validator
            ->integer('gender')
            ->requirePresence('gender', 'create')
            ->notEmpty('gender');
        */

        /* $validator
            ->requirePresence('photo', 'create')
            ->notEmpty('photo','Please upload image','create'); */

        /* $validator
            ->requirePresence('pmh', 'create')
            ->notEmpty('pmh'); */

        /* $validator
            ->requirePresence('diagnosed_with', 'create')
            ->notEmpty('diagnosed_with'); */

        /* $validator
            ->date('admission_date')
            ->requirePresence('admission_date', 'create')
            ->notEmpty('admission_date'); */

        /* $validator
            ->requirePresence('mrn', 'create')
            ->notEmpty('mrn'); */

        /* $validator
            ->requirePresence('room', 'create')
            ->notEmpty('room');
        */

        /* $validator
            ->requirePresence('floor', 'create')
            ->notEmpty('floor'); */

        /* $validator
            ->integer('patient_status')
            ->requirePresence('patient_status', 'create')
            ->notEmpty('patient_status'); */


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
        $rules->add($rules->existsIn(['hospital_id'], 'Hospitals'));
        //$rules->add($rules->existsIn(['service_team_id'], 'ServiceTeams'));
        //$rules->add($rules->existsIn(['employee_id'], 'Employees'));

        return $rules;
    }

    public function isPatientExist($mrn){
        $query = $this->find()
            ->select([
                'mrn'
            ])
            ->where(['Patients.mrn' => $mrn])
            ->first();

        if(!empty($query)){
            return true;
        } else{
            return false;
        }
    }

    public function uploadProfilePhoto($photo,$old_photo = ''){
        $uploads_original_path = Configure::read('UPLOAD_PATIENT_ORIGINAL_IMAGE_PATH');
        $uploads_thumb_path = Configure::read('UPLOAD_PATIENT_THUMB_IMAGE_PATH');
        $allowed_exntentions = Configure::read('ALLOWED_IMAGE_EXTENSIONS');
        return  $this->_uploadImage($photo,$uploads_original_path,$allowed_exntentions,$uploads_thumb_path,$old_photo);
    }
    
    public function validationOnlyCheck(Validator $validator) {
        $validator = $this->validationDefault($validator);
        $validator->remove('photo');
        return $validator;
    }
    
	public function getPatientsLists($hospital_id, $service_team_id) {
        $result = $this->find('all')
            ->select([
                'id',
                'firstname',
                'lastname',
                'photo',
                'mrn',
                'room',
                'bed',
                'group_id'
            ])
            ->where([
                'hospital_id' => $hospital_id,
                'service_team_id' => $service_team_id,
                'status' => 1
            ])
            ->all()
            ->toArray();
        
        $patients = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $patients[$i]['id'] = $val->id;
                $patients[$i]['name'] = $val->full_name;
                $patients[$i]['photo'] =  Configure::read('DEFAULT_PATIENT_IMAGE_URL');
                $patients[$i]['mrn'] =  $val->mrn;
                $roomBad = (!empty($val->room)  && !empty($val->bed)) ?  $val->room.'-'.$val->bed : ( !empty($val->room) ? $val->room : (!empty($val->bed) ? $val->bed : ''));   
                $patients[$i]['bed'] =  $roomBad;
                $patients[$i]['group_id'] =  $val->group_id;
                $i++;
            }
        }
        return $patients;
    }
    
    public function getPatientsDoctorLists($hospital_id, $employee_id, $provider_name, $room, $employee_role) {
        
        $this->PatientsBed = TableRegistry::get('PatientsBed');

        $conditions['AND']['Patients.status'] = 1;
        
        if(!empty($hospital_id) && $hospital_id > 0) {
            $conditions['AND']['Patients.hospital_id'] = $hospital_id;
        }
        
        $commonConditions['AND']['Employees.status'] = 1;
        //$commonConditions['AND']['Employees.availability_status'] = 1;
        
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
        
            $commonConditions['OR']['Employees.firstname LIKE'] = '%'.$firstname.'%';
            $commonConditions['OR']['Employees.lastname LIKE'] = '%'.$lastname.'%';
        }
        
        if(!empty($employee_role)) {
            $commonConditions['AND']['Employees.employee_role_short'] = $employee_role;
        }
        
        $patientId = [];
        if(!empty($room)) {
            $roomBed = explode('-', $room);

            $this->HospitalBeds = TableRegistry::get('HospitalBeds');
            $hospitalBeds = $this->HospitalBeds->find('list', ['keyField' => 'id','valueField' =>'id'])->where([ 'HospitalBeds.room_number' => $roomBed[0],'HospitalBeds.bed_number' => $roomBed[1]])->toArray();
                
            if(!empty($hospitalBeds)){
                    
                $patientsBed = $this->PatientsBed->find('list', ['keyField' => 'id','valueField' =>'patient_id'])->where([ 'PatientsBed.hospital_bed_id IN' => $hospitalBeds])->toArray();
            }

            if(!empty($patientsBed)) {
                $conditions['AND']['Patients.id IN'] = array_values($patientsBed);
            } else {
                $conditions['AND']['Patients.id'] = 0;
            }
            
            $result = $this->find()
                ->select([
                    'id',
                    'employee_id',
                    'hospital_id',
                    'room',
                    'bed',
                ])
                ->contain([
                    'PatientServiceTeams.ServiceTeams.HospitalsEmployees.Employees' => function($q) use ($commonConditions) {
                        return $q
                            ->select([
                                'Employees.id',
                                'firstname',
                                'lastname',
                                'designation',
                                'department',
                                'employee_role',
                                'employee_role_short',
                                'availability_status',
                                'status'
                            ])
                            ->where($commonConditions)
                            ->group('Employees.id');
                    }
                ])
                ->where($conditions)
                ->order('Patients.room ASC, Patients.bed ASC')
                ->all()
                ->toArray();
            
            $i = 0;
            $employee = [];
            if(!empty($result)) {    
                foreach ($result as $val) {
                    if(!empty($val->patient_service_teams)) {
                        foreach ($val->patient_service_teams as $pat_serv_key => $pat_serv_val) {
                            
                            if(!empty($pat_serv_val->service_team) && !empty($pat_serv_val->service_team->hospitals_employees)) {
                                foreach ($pat_serv_val->service_team->hospitals_employees as $hosp_emp_key => $hosp_emp_val) {
                                    if(!empty($hosp_emp_val->employee)) {
                                        $employee[$i]['id'] = $hosp_emp_val->employee->id;
                                        $employee[$i]['name'] = !empty($hosp_emp_val->employee->full_name) ? $hosp_emp_val->employee->full_name : '';
                                        $employee[$i]['photo'] =  !empty($hosp_emp_val->employee->photo) &&  file_exists(Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_PATH').$hosp_emp_val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$hosp_emp_val->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                                        $employee[$i]['designation'] =  !empty($hosp_emp_val->employee->designation) ? $hosp_emp_val->employee->designation : '';
                                        $employee[$i]['department'] =  !empty($hosp_emp_val->employee->department) ? $hosp_emp_val->employee->department : '';
                                        $employee[$i]['employee_role'] =  !empty($hosp_emp_val->employee->employee_role) ? $hosp_emp_val->employee->employee_role : '';
                                        $employee[$i]['employee_role_short'] =  !empty($hosp_emp_val->employee->employee_role_short) ? $hosp_emp_val->employee->employee_role_short : '';
                                        $employee[$i]['is_working'] = !empty($hosp_emp_val->employee->availability_status) ? $hosp_emp_val->employee->availability_status : 0;
                                        $bedData = $this->PatientsBed->getPatientsBed($val->id);
                                        $roomBad = (!empty($bedData["room_number"])  && !empty($bedData["bed_number"])) ?  $bedData["room_number"].'-'.$bedData["bed_number"] : ( !empty($bedData["room_number"]) ? $bedData["room_number"] : (!empty($bedData["bed_number"]) ? $bedData["bed_number"] : ''));
                                        $employee[$i]['bed'] =  $roomBad;
                                        $employee[$i]['device_token'] = !empty($hosp_emp_val->employee->device_token) ? $hosp_emp_val->employee->device_token : '';
                                        $employee[$i]['device_type'] = !empty($hosp_emp_val->employee->device_type) ? $hosp_emp_val->employee->device_type : 1;
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                    $patientId[] = $val->id;
                }
            }
        }
        
        
        if(!empty($patientId)) {
            $patientConditions['AND']['EmployeesPatients.patient_id IN'] = $patientId;
            $patientConditions['AND']['EmployeesPatients.is_deleted'] = 0;
        
            $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
        
            $patientsData = $this->EmployeesPatients->find()
                ->select([
                    'id',
                    'employee_id',
                    'patient_id'
                ])
                ->contain(['Employees' => function($q) use ($commonConditions)  {
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
                            'device_type'
                        ])
                        ->where($commonConditions);
                },
                ])
                ->contain(['Patients' => function($q) use ($conditions)  {
                    return $q
                    ->select([
                        'id',
                        'employee_id',
                        'hospital_id',
                        'room',
                        'bed',
                    ])
                    ->where($conditions);
                },
                ])
                ->where($patientConditions)
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
                    $bedData = $this->PatientsBed->getPatientsBed($val->patient->id);
                    $roomBad = (!empty($bedData["room_number"])  && !empty($bedData["bed_number"])) ?  $bedData["room_number"].'-'.$bedData["bed_number"] : ( !empty($bedData["room_number"]) ? $bedData["room_number"] : (!empty($bedData["bed_number"]) ? $bedData["bed_number"] : ''));
                    $employee[$i]['bed'] =  $roomBad;
                    $i++;
                }
            }
        }
        
        //return $employee;
        return $this->array_multi_unique($employee);
    }
    
    public function findPataients($data) {
        
        /* $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');
        $serviceTeamList = $this->PatientServiceTeams->find('list')->select(['service_team_id'])->where(['patient_id' => $patientId])->toArray(); */
        
        $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');
        $this->HospitalsEmployees = TableRegistry::get('HospitalsEmployees');
        $this->PatientsBed = TableRegistry::get('PatientsBed');
        
        $serviceTeamCond = [];
        
        $conditions['AND']['Patients.status'] = 1;
        $conditions['AND']['Patients.discharge !='] = 1;
        
        if(!empty($data['hospital_id']) &&  $data['hospital_id'] > 0) {
            $conditions['AND']['Patients.hospital_id'] = $data['hospital_id'];
        }
        
        $empoyeepatientLists = [];
        if(!empty($data['employee_id'])) {
            $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
                $empoyeepatientLists = $this->EmployeesPatients->find('list', ['keyField' => 'id','valueField' =>'patient_id'])->where([ 'employee_id' => $data['employee_id'], 'is_deleted' => 0 ])->toArray();    
            if(!empty($empoyeepatientLists)) {
                $conditions['AND']['Patients.id NOT IN'] = array_values($empoyeepatientLists);
            }else{
                $hospitalEmployees = $this->HospitalsEmployees->find('list', ['keyField' => 'service_team_id','valueField' =>'service_team_id'])->where([ 'employee_id' => $data['employee_id']])->toArray();    
                if(!empty($hospitalEmployees)){
                    $patientServiceTeams = $this->PatientServiceTeams->find('list', ['keyField' => 'id','valueField' =>'patient_id'])->where([ 'service_team_id IN' => array_values($hospitalEmployees)])->toArray();    
                    if(!empty($patientServiceTeams)){
                        $conditions['AND']['Patients.id NOT IN'] = array_values($patientServiceTeams);
                    }
                }
            }
        }
        
        if(!empty($data['service_team_id'])  &&  $data['service_team_id'] > 0) {
            $patientLists = $this->PatientServiceTeams->find('list', ['keyField' => 'id','valueField' =>'patient_id'])->where(['service_team_id' => $data['service_team_id']])->toArray();
            if(!empty($patientLists)) {
                $patientLists = array_values($patientLists);
                $mainArr = !empty($empoyeepatientLists) ? array_values(array_unique(array_merge($patientLists, $empoyeepatientLists))) : array_values($patientLists);
                $conditions['AND']['Patients.id NOT IN'] = $mainArr;
            }
        }
        
        if(!empty($data['search_param'])) {
            $search = $data['search_param'];
            if($data['type'] == 1) { 
                $search = explode(' ', $search);
                
                $firstname = '';
                $lastname = '';
                
                if(!empty($search[0])) {
                    $firstname = $search[0];
                }
                
                if(!empty($search[1])) {
                    $lastname = $search[1];
                } else {
                    $lastname = $firstname;
                }
                
                $conditions['OR']['Patients.firstname LIKE'] = '%'.$firstname.'%';
                $conditions['OR']['Patients.lastname LIKE'] = '%'.$lastname.'%';
            } elseif ($data['type'] == 2) {
                $roomBed = explode('-', $search);

                $this->HospitalBeds = TableRegistry::get('HospitalBeds');
                $hospitalBeds = $this->HospitalBeds->find('list', ['keyField' => 'id','valueField' =>'id'])->where([ 'HospitalBeds.room_number' => $roomBed[0],'HospitalBeds.bed_number' => $roomBed[1]])->toArray();
                
                if(!empty($hospitalBeds)){
                    
                    $patientsBed = $this->PatientsBed->find('list', ['keyField' => 'id','valueField' =>'patient_id'])->where([ 'PatientsBed.hospital_bed_id IN' => $hospitalBeds])->toArray();
                }

                if(!empty($patientsBed)) {
                    $conditions['AND']['Patients.id IN'] = array_values($patientsBed);
                } else {
                    $conditions['AND']['Patients.id'] = 0;
                }
                
            } elseif ($data['type'] == 3) {

                $this->Floors = TableRegistry::get('Floors');
                $floors = $this->Floors->find('list', ['keyField' => 'id','valueField' =>'id'])->where([ 'LOWER(Floors.name)' => strtolower($search)])->toArray();
                if(!empty($floors)){
                    $this->HospitalBeds = TableRegistry::get('HospitalBeds');
                    $hospitalBeds = $this->HospitalBeds->find('list', ['keyField' => 'id','valueField' =>'id'])->where([ 'HospitalBeds.floor_id IN' => $floors])->toArray();
                }
                if(!empty($hospitalBeds)){
                    
                    $patientsBed = $this->PatientsBed->find('list', ['keyField' => 'id','valueField' =>'patient_id'])->where([ 'PatientsBed.hospital_bed_id IN' => $hospitalBeds])->toArray();
                }
                if(!empty($patientsBed)) {
                    $conditions['AND']['Patients.id IN'] = array_values($patientsBed);
                } else {
                    $conditions['AND']['Patients.id'] = 0;
                }
            } elseif ($data['type'] == 4) {
                if(isset($search)){
                    $conditions['AND']['ServiceTeams.name LIKE'] =  '%'.strtolower($search).'%';
                }
                
            }
        }
        
        
            $result = $this->find('all')
                ->select([
                    'id',
                    'firstname',
                    'lastname',
                    'photo',
                    'mrn',
                    'room',
                    'bed',
                    'group_id',
                    'ServiceTeams.name',
                    'ServiceTeams.id'
                ])
                ->join(
                    [
                        'PatientServiceTeams' => [
                            'table' => 'patient_service_teams',
                            'type' => 'LEFT',
                            'conditions' => 'PatientServiceTeams.patient_id = patients.id',
                        ],
                        'ServiceTeams' => [
                            'table' => 'service_teams',
                            'type' => 'LEFT',
                            'conditions' => 'ServiceTeams.id = PatientServiceTeams.service_team_id',
                        ]
                    ])    
                ->where($conditions)
                ->toArray();
                
            $patients = [];
            if(!empty($result)) {
                $i = 0;
                foreach ($result as $key => $val) {
                    
                    $patients[$i]['id'] = $val->id;
                    $patients[$i]['name'] = $val->full_name;
                    $patients[$i]['photo'] =  Configure::read('DEFAULT_PATIENT_IMAGE_URL');
                    $patients[$i]['mrn'] =  $val->mrn;
                    $patients[$i]['group_id'] =  $val->group_id;
                    $bedData = $this->PatientsBed->getPatientsBed($val->id);
                    $patients[$i]['floor'] = (!empty($bedData["floor_name"])) ? $bedData["floor_name"] : '';
                    $patients[$i]['bed'] = (!empty($bedData["room_number"])  && !empty($bedData["bed_number"])) ?  $bedData["room_number"].'-'.$bedData["bed_number"] : ( !empty($bedData["room_number"]) ? $bedData["room_number"] : (!empty($bedData["bed_number"]) ? $bedData["bed_number"] : ''));
                    $patients[$i]['bed status'] = (!empty($bedData["status"])) ? $bedData["status"] : '';
                    $patients[$i]['service_team_id'] =  isset($val->ServiceTeams["id"]) && !empty($val->ServiceTeams["id"]) ? $val->ServiceTeams["id"] : "";
                    $patients[$i]['service_team'] = isset($val->ServiceTeams["name"]) && !empty($val->ServiceTeams["name"]) ? $val->ServiceTeams["name"] : "";
                    $i++;
                }
            }
        
        return $patients;
    }


    public function searchPataients($data) {

        $this->PatientsBed = TableRegistry::get('PatientsBed');
        
        $search = explode(' ', $data['name']);
                
        $firstname = '';
        $lastname = '';
                
        if(!empty($search[0])) {
            $firstname = $search[0];
        }
                
        if(!empty($search[1])) {
            $lastname = $search[1];
        } else {
            $lastname = $firstname;
        }
                
        $conditions['OR']['Patients.firstname LIKE'] = '%'.$firstname.'%';
        $conditions['OR']['Patients.lastname LIKE'] = '%'.$lastname.'%';
        
        $result = $this->find('all')
            ->select([
                'id',
                'firstname',
                'lastname',
                'photo',
                'mrn',
                'room',
                'bed',
                'group_id'
            ])
            ->where($conditions)
            ->group('Patients.id')
            ->all()
            ->toArray();
        
        $patients = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $patients[$i]['id'] = $val->id;
                $patients[$i]['name'] = $val->full_name;
                $patients[$i]['photo'] =  Configure::read('DEFAULT_PATIENT_IMAGE_URL');
                $patients[$i]['mrn'] =  $val->mrn;
                $patients[$i]['group_id'] =  $val->group_id;

                $bedData = $this->PatientsBed->getPatientsBed($val->id);
                $patients[$i]['floor'] = (!empty($bedData["floor_name"])) ? $bedData["floor_name"] : '';
                $patients[$i]['bed'] = (!empty($bedData["room_number"])  && !empty($bedData["bed_number"])) ?  $bedData["room_number"].'-'.$bedData["bed_number"] : ( !empty($bedData["room_number"]) ? $bedData["room_number"] : (!empty($bedData["bed_number"]) ? $bedData["bed_number"] : ''));
                $patients[$i]['bed status'] = (!empty($bedData["status"])) ? $bedData["status"] : '';
                $i++;
            }
        }
        return $patients;
    }
    
    public function getPatientDetails($patientId, $employeeId) {
        $this->PatientsBed = TableRegistry::get('PatientsBed');
        $result = $this->find('all')
            ->select([
                'id',
                'employee_id',
                'hospital_id',
                'service_team_id',
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
                'content',
                'discharge',
                'place',
                'timestamp',
                'diagnosed_with',
                'patient_status',
                'status'
            ])
            ->contain([
                'Employees' => [
                    'fields' => [
                        'id',
                        'firstname',
                        'lastname',
                        'photo',
                        'designation',
                        'employee_role',
                        'department',
                        'employee_role_short'
                    ]
                ],
                'PatientServiceTeams'
            ])
            ->where([
                'Patients.id' => $patientId,
                'Patients.status' => 1
            ])
            ->first();
        
        $patients = [];
        if(!empty($result)) {
            $patients['id'] = $result->id;
            $patients['service_team_id'] = $result->service_team_id;
            $patients['hospital_id'] = $result->hospital_id;
            $patients['name'] = $result->full_name;
            $patients['photo'] =  Configure::read('DEFAULT_PATIENT_IMAGE_URL');
            $patients['age'] =  $this->getAgeFromBirthDate($result->birthdate);
            $patients['gender'] =  !empty($result->gender) ? Configure::read('GENDERS')[$result->gender] : '';
            $patients['admission_days'] = !empty($result->admission_date) ? $this->getDateDiff($result->admission_date) : 0;
            $patients['mrn'] =  $result->mrn;
            $bedData = $this->PatientsBed->getPatientsBed($result->id);
            $roomBad = (!empty($bedData["room_number"])  && !empty($bedData["bed_number"])) ?  $bedData["room_number"].'-'.$bedData["bed_number"] : ( !empty($bedData["room_number"]) ? $bedData["room_number"] : (!empty($bedData["bed_number"]) ? $bedData["bed_number"] : ''));
            $patients['bed'] =  $roomBad;
            //$patients['bed'] =  $result->bed;
            $patients['pmh'] =  $result->pmh;
            $patients['content'] =  $result->content;
            $patients['discharge'] =  !empty($result->discharge) ? $result->discharge : 2;
            $patients['place'] =  !empty($result->place) ? $result->place : 2;
            $patients['timestamp'] =  $result->timestamp;
            $patients['diagnosed_with'] =  $result->diagnosed_with;
            $patients['status'] =  $result->patient_status;
            $patients['is_pcp'] =  !empty($result->employee) ? 1 : 0;
            $patients['patient_service_teams'] =  $result->patient_service_teams;
            if(!empty($result->employee)) {
                $patients['employee']['id'] = $result->employee->id;
                $patients['employee']['name'] = $result->employee->full_name;
                $patients['employee']['photo'] =  !empty($result->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$result->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $patients['employee']['designation'] =  $result->employee->designation;
                $patients['employee']['department'] =  !empty($result->employee->department) ? $result->employee->department : '';
                $patients['employee']['employee_role'] =  $result->employee->employee_role;
                $patients['employee']['employee_role_short'] =  $result->employee->employee_role_short;
            } else {
                $patients['employee'] = (object)[];
            }
        }
        
        /* $employeePlans = TableRegistry::get('EmployeePlans');
        $patients += $employeePlans->getEmployeePlansDetail($employeeId, $patientId); */
        
        return $patients;
    }
    
    public function getPatientDetailById($patientId) {
    
        return $this->find('all')
            ->where([
                'Patients.id' => $patientId,
                'Patients.status' => 1
            ])
            ->first();
    }
    
    public function getPatientReport($patientId) {
    
        $this->PatientsBed = TableRegistry::get('PatientsBed');

        $result = $this->find('all')
            ->select([
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
            ])
            ->contain([
                'SignoutNotes' => function($q) {
                    return $q
                        ->select([
                            'SignoutNotes.id',
                            'employee_id',
                            'patient_id',
                            'department_id',
                            'content',
                            'date',
                            'time'
                        ])
                        ->order('SignoutNotes.id DESC')
                        ->limit(1);
                },
                'Followups' => function($q) {
                    return $q
                        ->select([
                            'Followups.id',
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
                                    'Employees.id',
                                    'firstname',
                                    'lastname',
                                    'designation',
                                    'department',
                                    'employee_role',
                                    'employee_role_short'
                                ]
                            ]
                        ])
                        ->order('Followups.id DESC')
                        ->limit(1);
                },
                'MajorEvents' => function($q) {
                return $q
                    ->select([
                        'MajorEvents.id',
                        'employee_id',
                        'patient_id',
                        'event',
                        'content',
                        'date',
                        'time'
                    ])
                    ->order('MajorEvents.id DESC')
                    ->limit(1);
                }
            ])
            ->where([
                'id' => $patientId,
                'status' => 1
            ])
            ->first();
        
        $patients = [];
        if(!empty($result)) {
            
            $patients['id'] = $result->id;
            $patients['name'] = $result->full_name;
            $patients['photo'] =  Configure::read('DEFAULT_PATIENT_IMAGE_URL');
            $patients['mrn'] =  $result->mrn;
            $bedData = $this->PatientsBed->getPatientsBed($result->id);
            $roomBad = (!empty($bedData["room_number"])  && !empty($bedData["bed_number"])) ?  $bedData["room_number"].'-'.$bedData["bed_number"] : ( !empty($bedData["room_number"]) ? $bedData["room_number"] : (!empty($bedData["bed_number"]) ? $bedData["bed_number"] : ''));
            $patients['bed'] =  $roomBad;
            //$patients['bed'] =  $result->bed;
            $patients['pmh'] =  $result->pmh;
            $patients['age'] =  $this->getAgeFromBirthDate($result->birthdate);
            $patients['gender'] =  Configure::read('GENDERS')[$result->gender];
            $patients['admission_days'] = !empty($result->admission_date) ? $this->getDateDiff($result->admission_date) : 0;
            $patients['diagnosed_with'] =  $result->diagnosed_with;
            $patients['patient_status'] =  $result->patient_status;
            $signout_note = [];
            if(!empty($result->signout_notes[0])) {
                $signout_note['id'] = $result->signout_notes[0]->id;
                $signout_note['content'] = !empty($result->signout_notes[0]->content) && file_exists(Configure::read('UPLOAD_SIGNOUT_NOTE_PATH').$result->signout_notes[0]->content) ? Configure::read('UPLOAD_SIGNOUT_NOTE_URL').$result->signout_notes[0]->content : '';
                $signout_note['date'] = date('d-m-y', strtotime($result->signout_notes[0]->date));
                $signout_note['time'] = date('h:i a', strtotime($result->signout_notes[0]->time));
            }
            
            $signout_note = (object)[];
            if(!empty($result->signout_notes[0])) {
                $signout_note->id = $result->signout_notes[0]->id;
                $signout_note->content = !empty($result->signout_notes[0]->content) && file_exists(Configure::read('UPLOAD_SIGNOUT_NOTE_PATH').$result->signout_notes[0]->content) ? Configure::read('UPLOAD_SIGNOUT_NOTE_URL').$result->signout_notes[0]->content : '';
                $signout_note->date = date('d-m-y', strtotime($result->signout_notes[0]->date));
                $signout_note->time = date('h:i a', strtotime($result->signout_notes[0]->time));
            }
            
            $major_event = (object)[];
            if(!empty($result->major_events[0])) {
                $major_event->id = $result->major_events[0]->id;
                $major_event->content = !empty($result->major_events[0]->content) && file_exists(Configure::read('UPLOAD_MAJOR_EVENT_PATH').$result->major_events[0]->content) ? Configure::read('UPLOAD_MAJOR_EVENT_URL').$result->major_events[0]->content : '';
                $major_event->event = $result->major_events[0]->event;
                $major_event->date = date('d-m-y', strtotime($result->major_events[0]->date));
                $major_event->time = date('h:i a', strtotime($result->major_events[0]->time));
            }
            
            $followup = (object)[];
            if(!empty($result->followups[0])) {
                $followup->id = $result->followups[0]->id;
                $followup->content = $result->followups[0]->content;
                $followup->date = date('d-m-y', strtotime($result->followups[0]->date));
                $followup->time = date('h:i a', strtotime($result->followups[0]->time));
                $followup->status = $result->followups[0]->status;
                $followup->employee_name = !empty($result->followups[0]->employee) ? $result->followups[0]->employee->full_name : '';
                $followup->employee_photo =  !empty($result->followups[0]->employee) && !empty($result->followups[0]->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$result->signout_notes[0]->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $followup->employee_designation = !empty($result->followups[0]->employee) ? $result->followups[0]->employee->designation : '';
                $followup->employee_department =  !empty($result->followups[0]->employee) ? $result->followups[0]->employee->department : '';
                $followup->employee_role =  !empty($result->followups[0]->employee) ? $result->followups[0]->employee->employee_role : '';
                $followup->employee_role_short =  !empty($result->followups[0]->employee) ? $result->followups[0]->employee->employee_role_short : '';
             }
            
             $patients['followup'] = $followup;
             $patients['major_event'] = $major_event;
             $patients['signout_note'] = $signout_note;
        }
        
        return $patients;
    }
    
    public function getServiceTeamLists() {
        $result = $this->find('all')
        ->select([
            'id',
            'service_team_id',
            'employee_id',
            'firstname',
            'lastname',
            'room',
            'bed',
            'mrn'
        ])
        ->contain(['HospitalsEmployees.Employees' => [
            'fields' => [
                'id',
                'firstname',
                'lastname',
                'designation',
                'department',
                'employee_role',
                'employee_role_short',
            ]
        ]])
        ->where(['Patients.id' => $patientId])
        ->first();
    
    }
    
    public function getPatientsFollowupLists($employeeId, $hospitalId,$serviceteamId) {
    
        $result = $this->find('all')
            ->select([
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
            ])
            ->contain([
                'Followups' => function($q) {
                    return $q
                    ->select([
                        'Followups.id',
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
                                'Employees.id',
                                'firstname',
                                'lastname',
                                'designation',
                                'department',
                                'employee_role',
                                'employee_role_short'
                            ]
                        ]
                    ])
                    ->order('Followups.id DESC');
                }
                ])
                ->where([
                    'employee_id' => $employeeId,
                    'service_team_id' => $serviceteamId, 
                    'hospital_id' => $hospitalId,
                    'status' => 1
                ])
                ->toArray();
    
            $patients = [];
            if(!empty($result)) {
                $i = 0;
                foreach ($result as $key => $val) {
                    $patients[$i]['id'] = $val->id;
                    $patients[$i]['name'] = $val->full_name;
                    $patients[$i]['photo'] =  Configure::read('DEFAULT_PATIENT_IMAGE_URL');
                    $patients[$i]['mrn'] =  $val->mrn;
                    $roomBad = (!empty($val->room)  && !empty($val->bed)) ?  $val->room.'-'.$val->bed : ( !empty($val->room) ? $val->room : (!empty($val->bed) ? $val->bed : ''));
                    $patients[$i]['bed'] =  $roomBad;
                    //$patients[$i]['bed'] =  $val->bed;
                    $patients[$i]['pmh'] =  $val->pmh;
                    $patients[$i]['age'] =  $this->getAgeFromBirthDate($result->birthdate);
                    $patients[$i]['gender'] =  Configure::read('GENDERS')[$val->gender];
                    $patients[$i]['admission_days'] = !empty($val->admission_date) ? $this->getDateDiff($val->admission_date) : 0;
                    $patients[$i]['diagnosed_with'] =  $val->diagnosed_with;
                    $patients[$i]['patient_status'] =  $val->patient_status;
                    $followup = [];
                    if(!empty($val->followups)) {
                        $j = 0;
                        foreach ($val->followups as $f_key => $f_val) {
                            $followup[$j]['id'] = $f_val->id;
                            $followup[$j]['content'] = $f_val->content;
                            $followup[$j]['date'] = date('d-m-y', strtotime($f_val->date));
                            $followup[$j]['time'] = date('h:i a', strtotime($f_val->time));
                            $followup[$j]['employee_name'] = !empty($f_val->employee) ? $f_val->employee->full_name : '';
                            $followup[$j]['employee_photo'] =  !empty($f_val->employee) && !empty($f_val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$f_val->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                            $followup[$j]['employee_designation'] = !empty($f_val->employee) ? $f_val->employee->designation : '';
                            $followup[$j]['employee_department'] =  !empty($f_val->employee) ? $f_val->employee->department : '';
                            $followup[$j]['employee_role'] =  !empty($f_val->employee) ? $f_val->employee->employee_role : '';
                            $followup[$j]['employee_role_short'] =  !empty($f_val->employee) ? $f_val->employee->employee_role_short : '';
                            $j++;
                        }
                    }
                    $patients[$i]['followups'] = $followup;
                    $i++;
                }
            }
            
            return $patients;
    }
    
    public function getPatientDoctorLists($groupId) {
        $result = $this->find()
            ->select([
                'id',
                'employee_id',
                'hospital_id'
            ])
            ->contain([
                'PatientServiceTeams'
            ])
            ->where([
                'Patients.group_id' => $groupId
            ])
            ->first();
            $serviceTeam = [];
            $patientId = [];
            if(!empty($result)) {
                if(!empty($result->patient_service_teams)) {
                    foreach ($result->patient_service_teams as $pat_serv_key => $pat_serv_val) {
                        $serviceTeam[] = $pat_serv_val->service_team_id;
                    }
                }
                $patientId[] = $result->id;
            }
            
            $this->HospitalsEmployees = TableRegistry::get('HospitalsEmployees');
            $employee = $this->HospitalsEmployees->getPatientsEmployees($serviceTeam, "", "", $patientId);
            
            return $this->array_multi_unique($employee);
    }
    
    public function getDateDiff($date) {


        $now = time(); // or your date as well
        $your_date = strtotime($date);
        $datediff = $now - $your_date;
        
        return floor($datediff / (60 * 60 * 24));
    }
    
    public function savePatientHistory($data)
    {
        $this->PatientHistories = TableRegistry::get('PatientHistories');
        $patientHistory = $this->PatientHistories->newEntity($data);
        $this->PatientHistories->save($patientHistory);
    }
}
