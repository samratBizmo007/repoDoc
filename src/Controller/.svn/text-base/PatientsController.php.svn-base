<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use DateTime;
use Cake\Utility\Hash;

/**
 * Patients Controller
 *
 * @property \App\Model\Table\PatientsTable $Patients
 */
class PatientsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        
        $this->viewBuilder()->layout('Admin.default');
        $this->loadComponent('Firebase');
        $this->accessUrlSubAdmin();
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($floor = 0)
    {
        $search = "";
        $users = [];
        $conditions = [];
        $floorName = '';
        $floorIds = [];
        if(!empty($this->Auth->user('users_floors'))) {
            $floorNames = Hash::extract($this->Auth->user('users_floors'), '{n}.floor.name');
            $floorName = implode(', ', $floorNames);
            $floorIds = Hash::extract($this->Auth->user('users_floors'), '{n}.floor.id');
            if(!empty($floorIds)) {
                $conditions += ["Patients.floor_id IN " =>  $floorIds];
            }             
        }
        
        if(!empty($floor)) {
            $conditions += ["Patients.floor_id" =>  $floor];
        }
        
        if($this->Auth->user()['role_id'] == 3 || $this->Auth->user()['role_id'] == 4 || $this->Auth->user()['role_id'] == 5) {
            $conditions += ['Patients.hospital_id' => $this->Auth->user()['hospitals']['id']];
        }
        
        if($this->request->query){
            $search = !empty($this->request->query['search']) ? $this->request->query['search'] : "";
            $conditions += [
                'OR'=> [
                    "Patients.firstname LIKE '%".$search."%'",
                    "Patients.lastname LIKE '%".$search."%'"
                ]
            ];
        }
        
        try{
            $this->paginate = [
                'contain' => ['Hospitals', 'ServiceTeams', 'Floors'],
                'conditions' => $conditions,
                'order' => ['Patients.room' => 'asc', 'Patients.bed' => 'asc'],
                'limit' => 10
            ];

            $patients = $this->paginate($this->Patients);

        }catch(NotFoundException $e){
            $patients = $this->Patients->newEntity();
        }

        $serConditions = [];
        if(!empty($this->Auth->user()['hospitals']['id'])) {
            $serConditions = ['hospital_id' => $this->Auth->user()['hospitals']['id']];
        }
        
        if(!empty($floorIds)) {
            $serConditions += ['id IN' => $floorIds];
        }
        
        $this->Floors = TableRegistry::get('Floors');
        $floors = $this->Floors->find('list', ['keyField' => 'id','valueField' => 'name', 'limit' => 200])->where($serConditions);
        
        $this->set(compact('patients','search', 'floors', 'floor', 'floorName'));
        $this->set('_serialize', ['patients']);
    }

    /**
     * View method
     *
     * @param string|null $id Patient id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->layout('');
        $patient = $this->Patients->get($id, [
            'contain' => ['Hospitals', 'PatientServiceTeams.ServiceTeams', 'Employees', 'Floors']
        ]);
        
        $this->set('patient', $patient);
        $this->set('_serialize', ['patient']);
    }

    public function patientServiceTeam($patientId, $hospitalId) {
        
        $this->viewBuilder()->layout('');
        
        $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');
        
        $serviceTeamLists = $this->PatientServiceTeams->find('all')->where(['patient_id' => $patientId])->toArray();
        
        $hospitalEmployee = TableRegistry::get('HospitalsEmployees');        
        $hospitalEmployeeData = $hospitalEmployee->getServiceTeamLists($hospitalId, $serviceTeamLists, $patientId);
        
        $this->set('hospitalEmployeeData', $hospitalEmployeeData);
        $this->set('_serialize', ['hospitalEmployeeData']);
    }
    
    public function patientFollowups($id) {
        $this->viewBuilder()->layout('');
        $patient = $this->Patients->get($id, [
            'contain' => ['Followups', 'Followups.Employees']
        ]);
        $this->set('patient', $patient);
        $this->set('_serialize', ['patient']);
    }
    
    public function patientSignoutNotes($id) {
        $this->viewBuilder()->layout('');
        $patient = $this->Patients->get($id, [
            'contain' => ['SignoutNotes', 'SignoutNotes.Employees']
        ]);
        
        $this->set('patient', $patient);
        $this->set('_serialize', ['patient']);
    }
    
    public function patientMajorEvents($id) {
        $this->viewBuilder()->layout('');
        $patient = $this->Patients->get($id, [
            'contain' => ['MajorEvents', 'MajorEvents.Employees']
        ]);
    
        $this->set('patient', $patient);
        $this->set('_serialize', ['patient']);
    }
    
    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $patient = $this->Patients->newEntity();
        if ($this->request->is('post')) {
            
            if(!empty($this->request->data['photo']['name'])){
                $photo = $this->Patients->uploadProfilePhoto($this->request->data['photo']);
                $this->request->data['photo'] = $photo;
            } 
            
            if(!empty($this->request->data['service_team_id'])){
                $i =0;
                foreach ($this->request->data['service_team_id'] as $val) {
                    $this->request->data['patient_service_teams'][$i]['hospital_id'] = $this->request->data['hospital_id'];
                    $this->request->data['patient_service_teams'][$i]['service_team_id'] = $val;
                    $i++;
                }
            }

            /* Change Date Format */
            if(!empty($this->request->data['birthdate'])) {
                $date = new DateTime($this->request->data['birthdate']);
                $this->request->data['birthdate'] = $date->format('Y-m-d');
            }

            if(!empty($this->request->data['admission_date'])) {
                $date = new DateTime($this->request->data['admission_date']);
                $this->request->data['admission_date'] = $date->format('Y-m-d');
            }
            
            $patient = $this->Patients->patchEntity($patient, $this->request->data);
            
            if ($data = $this->Patients->save($patient,['associated' => ['PatientServiceTeams']])) {
                
                $patientHistory['patient_id'] = $data->id;
                $patientHistory['patient_name'] = $data->full_name;
                $patientHistory['user_id'] = $this->Auth->user()['id'];
                $patientHistory['hospital_id'] = $this->Auth->user()['hospitals']['id'];
                $patientHistory['action'] = "Add";
                $this->Patients->savePatientHistory($patientHistory);
                
                if(!empty($this->request->data['service_team_id'])){
                    $hospitalsEmployees = TableRegistry::get('HospitalsEmployees');
                    $employees = $hospitalsEmployees->getEmployees($this->request->data['hospital_id'], $this->request->data['service_team_id']);
                    
                    if(!empty($employees)) {
                        $addArr = [
                            'patientId' => (string)$data->id,
                            'groupName' => $this->request->data['firstname'].' '. $this->request->data['lastname'],
                            'membersList' => $employees
                        ];
                        
                        $rensponse = $this->Firebase->push('groups/', $addArr);
                        if(!empty($rensponse)) {
                            $rensponse = json_decode($rensponse, true);
                            $update = [
                                'groupId' => $rensponse['name']
                            ];
                            $this->Firebase->update('groups/'.$rensponse['name'], $update);
                    
                            $data->group_id = $rensponse['name'];
                            $this->Patients->save($data);
                        }
                    }
                }
                $this->Flash->success(__('The patient has been saved.'),['key' => 'positive']);

                return $this->redirect(['action' => 'index']);
            }
            
            $this->Flash->error(__('The patient could not be saved. Please, try again.'),['key' => 'negative']);
        }

        $hospitals = $this->Patients->Hospitals->find('list', ['limit' => 200]);
        $conditions = [];
        $serConditions = [];
        $floorConditions = [];
        if($this->Auth->user()['role_id'] == 3 || $this->Auth->user()['role_id'] == 4) {
            $conditions = ['Employees.hospital_id' => $this->Auth->user()['hospitals']['id']];
            $serConditions = ['hospital_id' => $this->Auth->user()['hospitals']['id']];
            $floorConditions = ['hospital_id' => $this->Auth->user()['hospitals']['id']];
        }
        
        if(!empty($this->Auth->user('users_floors'))) {
            $floorIds = Hash::extract($this->Auth->user('users_floors'), '{n}.floor.id');
            if(!empty($floorIds)) {
                $floorConditions += ['id IN' => $floorIds];
            }
        }
        
        $serviceTeams = $this->Patients->ServiceTeams->find('list', ['limit' => 200])->where($serConditions);
        $this->Floors = TableRegistry::get('Floors');
        $floors = $this->Floors->find('list', ['limit' => 200])->where($floorConditions);
        
        $employees = $this->Patients->Employees->find('list', ['keyField' => 'id','valueField' => function ($row) {
            return $row['firstname'] . ' ' . $row['lastname'];
        }])->where($conditions);
        $this->set(compact('patient', 'hospitals', 'serviceTeams', 'employees', 'floors'));
        $this->set('_serialize', ['patient']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Patient id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $patient = $this->Patients->get($id, [
            'contain' => ['Employees', 'PatientServiceTeams']
        ]);
        $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');
        if ($this->request->is(['patch', 'post', 'put'])) {

            if(!empty($this->request->data['photo']['name'])){
                $this->request->data['photo'] = $this->Patients->uploadProfilePhoto($this->request->data['photo'],$this->request->data['old_photo']);
            }
            else
                unset($this->request->data['photo']);

            /* Change Date Format */
            if(!empty($this->request->data['birthdate'])) {
                $date = new DateTime($this->request->data['birthdate']);
                $this->request->data['birthdate'] = $date->format('Y-m-d');
            }

            if(!empty($this->request->data['service_team_id'])){
                $i =0;
                
                $this->PatientServiceTeams->deleteAll(['patient_id' => $patient->id,'hospital_id' => $patient->hospital_id]);
                $this->Firebase->delete('groups/'.$patient->group_id.'/membersList');
                
                foreach ($this->request->data['service_team_id'] as $val) {
                    //$serviceTeamData = Hash::extract($patient->patient_service_teams, '{n}[service_team_id = ' . $val . ']');
                    //if(empty($serviceTeamData)) {
                    //foreach ($serviceTeamData as $val) {
                        $hospitalsEmployees = TableRegistry::get('HospitalsEmployees');
                        $employees = $hospitalsEmployees->getEmployees($patient->hospital_id, $val);
                        if(!empty($employees)) {
                            $addArr = [
                                'patientId' => (string)$patient->id,
                                'groupName' => $this->request->data['firstname'].' '. $this->request->data['lastname'],
                                'membersList' => $employees
                            ];
                    
                            if(!empty($patient->group_id)) {
                                $rensponse = $this->Firebase->set('groups/'.$patient->group_id.'/', $addArr);
                            } else {
                                $rensponse = $this->Firebase->push('groups/', $addArr);
                                if(!empty($rensponse)) {
                                    $rensponse = json_decode($rensponse, true);
                                    $update = [
                                        'groupId' => $rensponse['name']
                                    ];
                                    $this->Firebase->update('groups/'.$rensponse['name'], $update);
                            
                                    $patient->group_id = $rensponse['name'];
                                    $this->Patients->save($patient);
                                }
                            }
                        //}
                    }
                    $this->request->data['patient_service_teams'][$i]['service_team_id'] = $val;
                    $this->request->data['patient_service_teams'][$i]['hospital_id'] = $this->request->data['hospital_id'];
                    $i++;
                }
            }
            
            if(!empty($this->request->data['admission_date'])) {
                $date = new DateTime($this->request->data['admission_date']);
                $this->request->data['admission_date'] = $date->format('Y-m-d');
            }

            $patient = $this->Patients->patchEntity($patient, $this->request->data);
            
            if ($data = $this->Patients->save($patient,['associated' => ['PatientServiceTeams']])) {
                
                $patientHistory['patient_id'] = $data->id;
                $patientHistory['patient_name'] = $data->full_name;
                $patientHistory['user_id'] = $this->Auth->user()['id'];
                $patientHistory['hospital_id'] = $this->Auth->user()['hospitals']['id'];
                $patientHistory['action'] = "Edit";
                $this->Patients->savePatientHistory($patientHistory);
                
                $this->Flash->success(__('The patient has been saved.'),['key' => 'positive']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The patient could not be saved. Please, try again.'),['key' => 'negative']);
        }
        
        $conditions = [];
        $serConditions = [];
        $floorConditions = [];
        if($this->Auth->user()['role_id'] == 3 || $this->Auth->user()['role_id'] == 4) {
            $conditions = ['Employees.hospital_id' => $this->Auth->user()['hospitals']['id']];
            $serConditions = ['hospital_id' => $this->Auth->user()['hospitals']['id']];
            $floorConditions = ['hospital_id' => $this->Auth->user()['hospitals']['id']];
        }
        
        $hospitals = $this->Patients->Hospitals->find('list', ['limit' => 200]);
        $serviceTeams = $this->Patients->ServiceTeams->find('list', ['limit' => 200])->where($serConditions);
        $employees = $this->Patients->Employees->find('list', ['keyField' => 'id','valueField' => function ($row) {
            return $row['firstname'] . ' ' . $row['lastname'];
        }])->where($conditions);
        
        $selectServiceTeam = [];
        
        if(!empty($patient->patient_service_teams)) {
            foreach ($patient->patient_service_teams as $key => $val) {
                $selectServiceTeam[] = $val->service_team_id;
            }
        }
        
        $this->Floors = TableRegistry::get('Floors');
        $floors = $this->Floors->find('list', ['limit' => 200])->where($floorConditions);
        
        $this->set(compact('patient', 'hospitals', 'serviceTeams', 'employees', 'selectServiceTeam', 'floors'));
        $this->set('_serialize', ['patient']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Patient id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $patient = $this->Patients->get($id);
        $patientName = $patient->full_name; 
        if ($this->Patients->delete($patient)) {
            $patientHistory['patient_id'] = $id;
            $patientHistory['patient_name'] = $patientName;
            $patientHistory['user_id'] = $this->Auth->user()['id'];
            $patientHistory['hospital_id'] = $this->Auth->user()['hospitals']['id'];
            $patientHistory['action'] = "Delete";
            $this->Patients->savePatientHistory($patientHistory);
            
            if(!empty($patient->photo)) {
                if(file_exists(Configure::read('UPLOAD_PATIENT_ORIGINAL_IMAGE_PATH').$patient->photo))
                    unlink(Configure::read('UPLOAD_PATIENT_ORIGINAL_IMAGE_PATH').$patient->photo);
    
                if(file_exists(Configure::read('UPLOAD_PATIENT_THUMB_IMAGE_PATH').$patient->photo))
                    unlink(Configure::read('UPLOAD_PATIENT_THUMB_IMAGE_PATH').$patient->photo);
            }
            $this->Flash->success(__('The patient has been deleted.'),['key' => 'positive']);
        } else {
            $this->Flash->success(__('The patient could not be deleted. Please, try again.'),['key' => 'negative']);
        }

        return $this->redirect(['action' => 'index']);
    }


    /**
     * Check unique patient method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function checkUniquePatientByMRN()
    {
        $this->viewBuilder()->layout(false);
        if($this->request->is('post')) {
            $data = $this->request->data;
            $result = $this->Patients->isPatientExist($data['mrn']);
            if(!empty($result)){
                echo "false";
            } else {
                echo "true";
            }
        }
        die;
    }
    
    /**
     * Import scv method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function importCsv()
    {
        $this->viewBuilder()->layout(false);
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if(!empty($data['csv']) && !empty($data['csv']['name'])){
                $result = $this->CSV->importCsvPatient($data['csv']['tmp_name'], 'Patients');
                
                if(!empty($result['errors'])) {
                    $this->Flash->error($result['errors'],['key' => 'negative']);
                }
                
                if(!empty($result['messages'])) {
                    $this->Flash->error($result['messages'],['key' => 'positive']);
                }
            }
            return $this->redirect(['action' => 'index']);
        }
    }
    
    /**
     * Export csv method
     *
     * @return download csv file of all data
     */
    public function exportLists()
    {
        $patients = $this->Patients->find('all')
            ->contain('Hospitals')
            ->order('Patients.created DESC')
            ->toArray();
         
        $head = [
            'Hospital',
            'Name',
            'Gender',
            'Admission Date',
            'Patient Status',
            'Status',
            'Created'
        ];
    
        $this->CSV->clear();
        $this->CSV->addRow($head);
        if(!empty($patients)) {
            foreach ($patients as $patient) {
                $line = [
                    'Hospital' => $patient->hospital->name,
                    'Name' => $patient->full_name,
                    'Gender' => Configure::read('GENDERS.'.$patient->gender),
                    'Admission Date' => $patient->admission_date,
                    'Patient Status' => Configure::read('PATIENT_STATUS.'.$patient->patient_status),
                    'Status' => $patient->is_active == 1 ? 'Active' : 'Inactive',
                    'Created' => $patient->created
                ];
    
                $this->CSV->addRow($line);
            }
        }
    
        echo  $this->CSV->render('patients');
        die;
    }
    
    public function getEmployees() {
        $optionStr = "<option value=''>Please select primary doctor</option>";
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->HospitalsEmployees = TableRegistry::get('HospitalsEmployees');
            $employees = $this->HospitalsEmployees->find('all')
                ->contain(['Employees'=>[
                    'fields' => [
                        'id',
                        'firstname',
                        'lastname'
                    ]
                ]])
                ->where(['service_team_id' => $this->request->data['service_team_id']])
                ->toArray();
            
            if(!empty($employees)) {
                foreach ($employees as $key => $val) {
                    if(!empty($val->employee)) {
                        $optionStr .= "<option value='".$val->employee->id."'>".$val->employee->firstname.' '.$val->employee->lastname."</option>";
                    }
                }
            }
        }
        echo $optionStr;
        exit;
    }
    
    /**
     * Download CSV method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function downloadCsv()
    {
        $file_path = WWW_ROOT.'img/patients-sample.csv';
        $this->response->file($file_path, array(
            'download' => true,
        ));
        return $this->response;
    }
}
