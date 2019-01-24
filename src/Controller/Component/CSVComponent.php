<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * Graph component
 */
class CSVComponent extends Component
{
    var $delimiter = ',';
    var $enclosure = '"';
    var $filenameExp = 'Export.csv';
    var $line = array ();
    var $buffer;
    
    // The other component your component uses
    public $components = ['Auth', 'Firebase'];
    
    public function initialize(array $config) {
        parent::initialize($config);
    
        ini_set("auto_detect_line_endings", true);
    }
    
    public function import_csv($filename, $model) {
        
        $modelTable = TableRegistry::get($model);
        
        // open the file
        $handle = fopen($filename, "r");
        	
        // read the 1st row as headings
        $header = fgetcsv($handle);
        	
        // create a message container
        $return = [
            'messages' => [],
            'errors' => [],
        ];
        
        $i = 0;
        // read each data row in the file
        while (($row = fgetcsv($handle)) !== FALSE) {
            $i++;
            $data = [];
            
            // for each header field
            foreach ($header as $k=>$head) {
                
                // get the data field from Model.field
                if (strpos($head,'.')!==false) {
                    $h = explode('.',$head);
                    $data[$h[0]][$h[1]]=(isset($row[$k])) ? $row[$k] : '';
                }
                // get the data field from field
                else {
                    $data[$head]=(isset($row[$k])) ? $row[$k] : '';
                }
            }
    
            //pr($data); die;
            if(isset($data['photo'])) {
                $model = $modelTable->newEntity($data, [
                    'validate' => 'OnlyCheck'
                ]);
            } else {
                $current_user = $this->Auth->user();
                $data['hospital_id'] = !empty($current_user['hospitals']['id']) ? $current_user['hospitals']['id'] : 0;
                $model = $modelTable->newEntity($data);
            }
            
            if (!empty($model->errors())) {
                $return['errors'][] = __(sprintf('Data of Row %d failed to validate.',$i), true);
            }
    
            // save the row
            if ($modelTable->save($model)) {
                $return['messages'][] = __(sprintf('Data of Row %d was saved.',$i), true);
            } else {
                $return['errors'][] = __(sprintf('Data of Row %d failed to save.',$i), true);
            }
    
        }
        
        // close the file
        fclose($handle);
        	
        // return the messages
        return $return;
        	
    }
    
    public function employeeRoleImportCsv($filename, $model) {
    
        $modelTable = TableRegistry::get($model);
    
        // open the file
        $handle = fopen($filename, "r");
         
        // read the 1st row as headings
        $header = fgetcsv($handle);
         
        // create a message container
        $return = [
            'messages' => [],
            'errors' => [],
        ];
    
        $i = 0;
        // read each data row in the file
        while (($row = fgetcsv($handle)) !== FALSE) {
            $i++;
            $data = [];
    
            // for each header field
            foreach ($header as $k=>$head) {
    
                // get the data field from Model.field
                if (strpos($head,'.')!==false) {
                    $h = explode('.',$head);
                    $data[$h[0]][$h[1]]=(isset($row[$k])) ? $row[$k] : '';
                }
                // get the data field from field
                else {
                    $data[$head]=(isset($row[$k])) ? $row[$k] : '';
                }
            }
    
            //pr($data); die;
            $data['clinical_role'] = !empty($data['clinical_role']) && ($data['clinical_role'] == 'Yes' || $data['clinical_role'] == 'Y') ? 1 : 0;
            
            $model = $modelTable->newEntity($data);
            
            if (!empty($model->errors())) {
                $return['errors'][] = __(sprintf('Data of Row %d failed to validate.',$i), true);
            }
    
            // save the row
            if ($modelTable->save($model)) {
                $return['messages'][] = __(sprintf('Data of Row %d was saved.',$i), true);
            } else {
                $return['errors'][] = __(sprintf('Data of Row %d failed to save.',$i), true);
            }
    
        }
    
        // close the file
        fclose($handle);
         
        // return the messages
        return $return;
         
    }
    
    public function employee_import_csv($filename, $model) {
        
        $modelTable = TableRegistry::get($model);
    
        // open the file
        $handle = fopen($filename, "r");
         
        // read the 1st row as headings
        $header = fgetcsv($handle);
        
         
        // create a message container
        $return = [
            'messages' => [],
            'errors' => [],
        ];
        
        $i = 0;
        // read each data row in the file
        while (($row = fgetcsv($handle)) !== FALSE) {
            
            $i++;
            $data = [];
    
            // for each header field
            foreach ($header as $k=>$head) {
    
                // get the data field from Model.field
                if (strpos($head,'.')!==false) {
                    $h = explode('.',$head);
                    $data[$h[0]][$h[1]]=(isset($row[$k])) ? $row[$k] : '';
                }
                // get the data field from field
                else {
                    $data[$head]=(isset($row[$k])) ? $row[$k] : '';
                }
            }
            
            $serviceTable = TableRegistry::get('ServiceTeams');
            $current_user = $this->Auth->user();
            
            $data['hospital_id'] = !empty($current_user['hospitals']['id']) ? $current_user['hospitals']['id'] : 0;
            
            if(!empty($data['service_team'])) {
                $service = $serviceTable->saveNewServiceTeam($current_user['hospitals']['id'], $data['service_team']);
                if(!empty($service)) {
                    $data['hospitals_employees'][0]['hospital_id'] = $current_user['hospitals']['id'];
                    $data['hospitals_employees'][0]['service_team_id'] = $service['id'];
                }    
            }
            
            if(!empty($data['employee_role'])) {
                $employeeRole = TableRegistry::get('EmployeeRoles');
                $employeeRoleShort = !empty($data['employee_role_short']) ? $data['employee_role_short'] : '';
                $employeeRole->getEmployeeRole($data['employee_role'], $employeeRoleShort);
            }
            
            if(!empty($data['designation'])) {
                $designation = TableRegistry::get('Designations');
                $designation->getDesignation($data['designation']);
            }
            
            if(!empty($data['department'])) {
                $department = TableRegistry::get('Departments');
                $department->saveNewDepartment($data['department']);
            }
            
            if(!empty($data['sub_department'])) {
                $subDepartments = TableRegistry::get('SubDepartments');
                $subDepartments->saveNewSubDepartment($data['sub_department'], $data['department']);
            }
            
            if(!empty($data['title'])) {
                $title = TableRegistry::get('Titles');
                $title->setAndGetTitle($data['title']);
            }
            
            //pr($data); die;
            if(isset($data['photo'])) {
                $model = $modelTable->newEntity($data, [
                    'validate' => 'OnlyCheck'
                ]);
            } else {
                $model = $modelTable->newEntity($data);
            }
            
            if (!empty($model->errors())) {
                $return['errors'][] = __(sprintf('Data of Row %d failed to validate.',$i), true);
            }
            
            // save the row
            if ($result = $modelTable->save($model, ['associated' => [ 'HospitalsEmployees']])) {
                
                /* $addArr = [
                    'name' => $result->full_name,
                    'photo' => Configure::read('DEFAULT_USER_IMAGE_URL'),
                    'employee_role' => $result->employee_role,
                    'employee_role_short' => $result->employee_role_short,
                    'userId' => (string)$result->id,
                ];
                $this->Firebase->set('Users/'.$result->id,$addArr); */
                $return['messages'][] = __(sprintf('Data of Row %d was saved.',$i), true);
            } else {
                
                $return['errors'][] = __(sprintf('Data of Row %d failed to save.',$i), true);
            }
        }
        // close the file
        fclose($handle);
        //pr($return); die;
        // return the messages
        return $return;
         
    }
    
    
    public function importCsvServiceTeam($filename, $model) {
    
        $modelTable = TableRegistry::get($model);
    
        // open the file
        $handle = fopen($filename, "r");
         
        // read the 1st row as headings
        $header = fgetcsv($handle);
         
        // create a message container
        $return = [
            'messages' => [],
            'errors' => [],
        ];
    
        $i = 0;
        // read each data row in the file
        while (($row = fgetcsv($handle)) !== FALSE) {
            $i++;
            $data = [];
    
            // for each header field
            foreach ($header as $k=>$head) {
                // get the data field from Model.field
                if (strpos($head,'.')!==false) {
                    $h = explode('.',$head);
                    $data[$h[0]][$h[1]]=(isset($row[$k])) ? $row[$k] : '';
                }
                // get the data field from field
                else {
                    $data[$head]=(isset($row[$k])) ? $row[$k] : '';
                }
            }
            
            $current_user = $this->Auth->user();
            $data['hospital_id'] = $current_user['hospitals']['id'];
            
            $model = $modelTable->newEntity($data);
            
            if (!empty($model->errors())) {
                $return['errors'][] = __(sprintf('Data of Row %d failed to validate.',$i), true);
            }
    
            // save the row
            if ($modelTable->save($model)) {
                $return['messages'][] = __(sprintf('Data of Row %d was saved.',$i), true);
            } else {
                $return['errors'][] = __(sprintf('Data of Row %d failed to save.',$i), true);
            }
    
        }
    
        // close the file
        fclose($handle);
         
        // return the messages
        return $return;
         
    }
    
    public function importCsvDepartment($filename, $model) {
    
        $modelTable = TableRegistry::get($model);
        
        $departmentTable = TableRegistry::get('Departments');
    
        // open the file
        $handle = fopen($filename, "r");
         
        // read the 1st row as headings
        $header = fgetcsv($handle);
         
        // create a message container
        $return = [
            'messages' => [],
            'errors' => [],
        ];
    
        $i = 0;
        // read each data row in the file
        while (($row = fgetcsv($handle)) !== FALSE) {
            $i++;
            $data = [];
    
            // for each header field
            foreach ($header as $k=>$head) {
                // get the data field from Model.field
                if (strpos($head,'.')!==false) {
                    $h = explode('.',$head);
                    $data[$h[0]][$h[1]]=(isset($row[$k])) ? $row[$k] : '';
                }
                // get the data field from field
                else {
                    $data[$head]=(isset($row[$k])) ? $row[$k] : '';
                }
            }
    
            if(!empty($data['department_name'])) {
                $departmentArr = $departmentTable->getDepartment($data['department_name']);
                if(!empty($departmentArr))
                    $data['department_id'] = $departmentArr['id'];
            }
            
            $data['name'] = $data['subdepartment_name'] ? $data['subdepartment_name'] : '';  
            $current_user = $this->Auth->user();
            $data['hospital_id'] = !empty($current_user['hospitals']['id']) ? $current_user['hospitals']['id'] : 0;
            
            $model = $modelTable->newEntity($data);
    
            if (!empty($model->errors())) {
                $return['errors'][] = __(sprintf('Data of Row %d failed to validate.',$i), true);
            }
    
            // save the row
            if ($modelTable->save($model)) {
                $return['messages'][] = __(sprintf('Data of Row %d was saved.',$i), true);
            } else {
                $return['errors'][] = __(sprintf('Data of Row %d failed to save.',$i), true);
            }
    
        }
    
        // close the file
        fclose($handle);
         
        // return the messages
        return $return;
    }
    
    public function importCsvPatient($filename, $model) {
        
        $modelTable = TableRegistry::get($model);
        
        $serviceTable = TableRegistry::get('ServiceTeams');
        
        $employeeTable = TableRegistry::get('Employees');
        
        // open the file
        $handle = fopen($filename, "r");
         
        // read the 1st row as headings
        $header = fgetcsv($handle);
         
        // create a message container
        $return = [
            'messages' => [],
            'errors' => [],
        ];
        
        $i = 0;
        // read each data row in the file
        while (($row = fgetcsv($handle)) !== FALSE) {
            $i++;
            $data = [];
        
            // for each header field
            foreach ($header as $k=>$head) {
                // get the data field from Model.field
                if (strpos($head,'.')!==false) {
                    $h = explode('.',$head);
                    $data[$h[0]][$h[1]]=(isset($row[$k])) ? $row[$k] : '';
                }
                // get the data field from field
                else {
                    $data[$head]=(isset($row[$k])) ? $row[$k] : '';
                }
            }
           
            $current_user = $this->Auth->user();
            $data['hospital_id'] = $current_user['hospitals']['id'];
            
            /* if(!empty($data['service_team'])) {
                $service = $serviceTable->getServiceTeam($data['hospital_id'], $data['service_team']);
                if(!empty($service))
                    $data['service_team_id'] = $service['id'];
            } */
            
            $serviceIds = [];
            if(!empty($data['service_team'])){
                $i =0;
                $serviceTeam = explode(',', $data['service_team']);
                foreach ($serviceTeam as $val) {
                    $service = $serviceTable->getServiceTeam($data['hospital_id'], trim($val));
                    if(!empty($service))
                    {
                        $serviceIds [] = $service['id'];
                        $data['patient_service_teams'][$i]['hospital_id'] = $data['hospital_id'];
                        $data['patient_service_teams'][$i]['service_team_id'] = $service['id'];
                        $i++;
                    }
                }
            }
            
            if(!empty($data['floor'])) {
                $floor = TableRegistry::get('Floors');
                $data['floor_id'] = $floor->saveNewFloor($data['hospital_id'], $data['floor']);
            }
            
            if(!empty($data['employee_name'])) {
                $employee = $employeeTable->getEmployee($data['employee_name']);
                if(!empty($employee))
                    $data['employee_id'] = $employee['id'];
            }
            
            if(!empty($data['birthdate'])) {
                $date = \DateTime::createFromFormat('m/d/Y', $data['birthdate']);
                $data['birthdate'] = $date->format('Y-m-d');
            }
            
            if(!empty($data['admission_date'])) {
                $date = \DateTime::createFromFormat('m/d/Y', $data['admission_date']);
                $data['admission_date'] = $date->format('Y-m-d');
            }
            
            //$data['birthdate'] = !empty($data['birthdate']) ? date('Y-m-d',  strtotime(str_replace('/', '-', $data['birthdate']))) : '';
            //$data['admission_date'] = !empty($data['admission_date']) ? date('Y-m-d',  strtotime(str_replace('/', '-', $data['admission_date']))) : '';
            //pr($data['birthdate']); die;
            $data['gender'] = !empty($data['gender']) && ($data['gender'] == 'Male' || $data['gender'] == 'M') ? 1 : 2;
            
            //$data['patient_status'] = !empty($data['patient_status']) && $data['patient_status'] == 'Active Inpatient' ? 1 : 2;
        
            $model = $modelTable->newEntity($data, [
                    'validate' => 'OnlyCheck'
            ]);
            
            if (!empty($model->errors())) {
                $return['errors'][] = __(sprintf('Data of Row %d failed to validate.',$i), true);
            }
        
            // save the row
            if ($result = $modelTable->save($model,['associated' => ['PatientServiceTeams']])) {
                if(!empty($serviceIds)){
                    $hospitalsEmployees = TableRegistry::get('HospitalsEmployees');
                    $employees = $hospitalsEmployees->getEmployees($data['hospital_id'], $serviceIds);
                    if(!empty($employees)) {
                        $addArr = [
                            'patientId' => (string)$result->id,
                            'groupName' => $result['firstname'].' '. $result['lastname'],
                            'membersList' => $employees
                        ];
                        
                        $rensponse = $this->Firebase->push('groups/', $addArr);
                        if(!empty($rensponse)) {
                            $rensponse = json_decode($rensponse, true);
                            $update = [
                                'groupId' => $rensponse['name']
                            ];
                            $this->Firebase->update('groups/'.$rensponse['name'], $update);
                    
                            $result->group_id = $rensponse['name'];
                            $modelTable->save($result);
                        }
                    }
                }
                
                $patientHistory['patient_id'] = $result->id;
                $patientHistory['patient_name'] = $result->full_name;
                $patientHistory['user_id'] = $this->Auth->user()['id'];
                $patientHistory['hospital_id'] = $this->Auth->user()['hospitals']['id'];
                $patientHistory['action'] = "Add";
                $modelTable->savePatientHistory($patientHistory);
                
                $return['messages'][] = __(sprintf('Data of Row %d was saved.',$i), true);
            } else {
                $return['errors'][] = __(sprintf('Data of Row %d failed to save.',$i), true);
            }
        }
        
        // close the file
        fclose($handle);
        
        // return the messages
        return $return;
    }
    
    public function importCsvEmployeeSchedules($filename, $model) {
    
        $modelTable = TableRegistry::get($model);
        
        $employee = TableRegistry::get('Employees');
    
        // open the file
        $handle = fopen($filename, "r");
         
        // read the 1st row as headings
        $header = fgetcsv($handle);
        
        // create a message container
        $return = [
            'messages' => [],
            'errors' => [],
        ];
        
        $insertData = [];
    
        $i = 0;
        
        // read each data row in the file
        while (($row = fgetcsv($handle)) !== FALSE) {
            $i++;
            $data = [];
           
            // for each header field
            foreach ($header as $k=>$head) {
    
                // get the data field from Model.field
                if (strpos($head,'.')!==false) {
                    $h = explode('.',$head);
                    $data[$h[0]][$h[1]]=(isset($row[$k])) ? $row[$k] : '';
                }
                // get the data field from field
                else {
                    $data[$head]=(isset($row[$k])) ? $row[$k] : '';
                }
            }
            $insertData[] = $data;
    
        }
        
        $newData = [];
        $i = 0;
        $doctor_name = '';
        $date = '';
        $email = '';
        $contact = '';
        $service_team = '';
        $timezone = '';
        
        $newData = [];
        foreach ($insertData as $key => $val) {
            
            //$contact = $val['Contact'];
            $service_team = $val['Service Team'];
            $timezone = !empty($val['Timezone']) ? $val['Timezone'] : Configure::read('TIMEZONE');
            $time = $val['Time'];
            
            foreach ($val as $v_key => $v_val) {
                if(!in_array($v_key, ['Contact','Service Team', 'Department', 'Time', 'Timezone'])) {
                    $newData[] = [
                        'doctor_name' => $doctor_name,
                        'date' => date('m-d-Y', strtotime(str_replace('/', '-', $v_key))),
                        'time' => $time,
                        //'service' => !empty($val['Service']) ? $val['Service'] : '',
                        //'content' => $contact,
                        'email' => trim(strtolower($v_val)),
                        'service_team' => $service_team,
                        'timezone' => $timezone,
                        //'department' => $department,
                    ];
                }
            }
        }
        
       $formatedData = [];
       
       foreach ($newData as $key => $val) { 
           
           $formatedData[trim($val['email'])]['timezone'] = $val['timezone'];
           $formatedData[trim($val['email'])][$val['date']][] = [
               'service_team' => $val['service_team'],
               'time' => $val['time'],
               //'service' => $val['service']
           ]; 
       }
       
       $sch = 0;
       
       $serviceTable = TableRegistry::get('ServiceTeams');
       $current_user = $this->Auth->user();
       $hospitals_id = $current_user['hospitals']['id'];
       
       foreach ($formatedData as $key => $val) {
           $query = $employee->find()
                ->select(['id'])
                ->contain(['HospitalsEmployees' => ['fields' => ['employee_id','hospital_id','service_team_id']]])
                ->where(['Employees.email' => $key])
                ->first();
          $scheduleData = [];
          if(!empty($query)) {
              $updateSchedule = $modelTable->find('all')->where(['employee_id' => $query->id])->first();
              if(!empty($updateSchedule)) {
                  $model = $updateSchedule;
                  $model->timezone = $val['timezone'];
                  unset($val['timezone']);
                  $model->schedule = json_encode($val, true);
              } else {
                  $scheduleData['employee_id'] = $query->id;
                  $scheduleData['hospital_id'] = !empty($query->hospitals_employees) && !empty($query->hospitals_employees[0]->hospital_id) ? $query->hospitals_employees[0]->hospital_id : $hospitals_id;
                  $scheduleData['service_team_id'] = !empty($query->hospitals_employees) && !empty($query->hospitals_employees[0]->service_team_id) ? $query->hospitals_employees[0]->service_team_id : 0;
                  $scheduleData['timezone'] = $val['timezone'];
                  unset($val['timezone']);
                  $scheduleData['schedule'] = json_encode($val, true);
                  $model = $modelTable->newEntity($scheduleData);
              }
              
              if (!empty($model->errors())) {
                  $return['errors'][] = __(sprintf('Data of Row %d failed to validate.',$sch), true);
              }
              
              // save the row
              if ($modelTable->save($model)) {
                  $return['messages'][] = __(sprintf('Data of Row %d was saved.',$sch), true);
              } else {
                  $return['errors'][] = __(sprintf('Data of Row %d failed to save.',$sch), true);
              }
              $sch++;
          } else {
              $return['errors'][] = __('Email '.$key.' not exists.');
          }
       }
       // close the file
       fclose($handle);
         
        // return the messages
        return $return;
         
    }
    
    public function importCsvConsultSchedules($filename, $model) {
    
         
        $modelTable = TableRegistry::get($model);
    
        $employee = TableRegistry::get('Employees');
    
        // open the file
        $handle = fopen($filename, "r");
         
        // read the 1st row as headings
        $header = fgetcsv($handle);
    
        // create a message container
        $return = [
            'messages' => [],
            'errors' => [],
        ];
    
        $insertData = [];
    
        $i = 0;
    
        // read each data row in the file
        while (($row = fgetcsv($handle)) !== FALSE) {
            $i++;
            $data = [];
             
            // for each header field
            foreach ($header as $k=>$head) {
    
                // get the data field from Model.field
                if (strpos($head,'.')!==false) {
                    $h = explode('.',$head);
                    $data[$h[0]][$h[1]]=(isset($row[$k])) ? $row[$k] : '';
                }
                // get the data field from field
                else {
                    $data[$head]=(isset($row[$k])) ? $row[$k] : '';
                }
            }
            $insertData[] = $data;
    
        }
    
        $newData = [];
        $i = 0;
        $department = '';
        $date = '';
        $email = '';
        $subDepartment = '';
        $time= '';
        $timezone = '';
        
        $newData = [];
        
        foreach ($insertData as $key => $val) {
            $is_first_call = 0;
            $is_attending = 0;
            
            $department = $val['department'];
            $subDepartment = $val['subdepartment'];
            $timezone = !empty($val['Timezone']) ? $val['Timezone'] : Configure::read('TIMEZONE');
            
            if(!empty($val['department'])) {
                $departments = TableRegistry::get('Departments');
                $departments->saveNewDepartment($val['department']);
            }
            
            if(!empty($val['subdepartment'])) {
                $subDepartments = TableRegistry::get('SubDepartments');
                $subDepartments->saveNewSubDepartment($val['subdepartment'], $val['department']);
            }
            
            if(strtolower($val['is_first_call_attending']) == 'first call')
                $is_first_call = 1;
            else 
                $is_attending = 1;
            
            $time = $val['Time'];
            
            foreach ($val as $v_key => $v_val) {
                
                if(!in_array($v_key, ['department','subdepartment', 'is_first_call_attending', 'Time','Timezone'])) {
                    if(!empty($v_val)) {
                        $newData[] = [
                            'department' => $department,
                            'subdepartment' => $subDepartment,
                            'date' => date('m-d-Y', strtotime(str_replace('/', '-', $v_key))),
                            'time' => $time,
                            'is_first_call' => $is_first_call,
                            'is_attending' => $is_attending,
                            'email' => trim(strtolower($v_val)),
                            'timezone' => $timezone,
                        ];
                    }
                }
            }
        }
        
        $formatedData = [];
        
        foreach ($newData as $key => $val) {
            $formatedData[trim($val['email'])]['timezone'] = $val['timezone'];
            $formatedData[trim($val['email'])][$val['date']][] = [
                'department' => $val['department'],
                'subdepartment' => $val['subdepartment'],
                'time' => $val['time'],
                'is_first_call' => $val['is_first_call'],
                'is_attending' => $val['is_attending'],
            ];
        }
         
        $sch = 0;
        
        $serviceTable = TableRegistry::get('ServiceTeams');
        $current_user = $this->Auth->user();
        $hospitals_id = $current_user['hospitals']['id'];
        
        foreach ($formatedData as $key => $val) {
            $query = $employee->find()
                ->select(['id'])
                ->contain(['HospitalsEmployees' => ['fields' => ['employee_id','hospital_id','service_team_id']]])
                ->where(['Employees.email' => trim($key)])
                ->first();
            
            $scheduleData = [];
            
            if(!empty($query)) {
                
                $updateSchedule = $modelTable->find('all')->where(['employee_id' => $query->id])->first();
                if(!empty($updateSchedule)) {
                    $model = $updateSchedule;
                    $model->timezone = $val['timezone'];
                    unset($val['timezone']);
                    $model->consult_schedule = json_encode($val, true);
                    $model->is_consult = 1;
                } else {
                    $scheduleData['employee_id'] = $query->id;
                    $scheduleData['hospital_id'] = !empty($query->hospitals_employees) && !empty($query->hospitals_employees[0]->hospital_id) ? $query->hospitals_employees[0]->hospital_id : $hospitals_id;
                    $scheduleData['service_team_id'] = !empty($query->hospitals_employees) && !empty($query->hospitals_employees[0]->service_team_id) ? $query->hospitals_employees[0]->service_team_id : 0;
                    $scheduleData['timezone'] = $val['timezone'];
                    unset($val['timezone']);
                    $scheduleData['consult_schedule'] = json_encode($val, true);
                    $scheduleData['is_consult'] = 1;
                    $model = $modelTable->newEntity($scheduleData);
                }
                if (!empty($model->errors())) {
                    $return['errors'][] = __(sprintf('Data of Row %d failed to validate.',$sch), true);
                }
    
                // save the row
                if ($modelTable->save($model)) {
                    $return['messages'][] = __(sprintf('Data of Row %d was saved.',$sch), true);
                } else {
                    $return['errors'][] = __(sprintf('Data of Row %d failed to save.',$sch), true);
                }
                $sch++;
            } else {
                $return['errors'][] = __('Email '.$key.' not exists.');
            }
        }
        
        // close the file
        fclose($handle);
         
        // return the messages
        return $return;
         
    }
    
    public function clear() {
        $this->line = array ();
        $this->buffer = fopen ( 'php://temp/maxmemory:' . (5 * 1024 * 1024), 'r+' );
    }
    
    public function render($outputHeaders = true, $to_encoding = null, $from_encoding = "auto") {
        if ($outputHeaders) {
            if (is_string ( $outputHeaders )) {
                $this->setFilename ( $outputHeaders . '-' .date('Y-m-d'));
            } else {
                $this->setFilename ( $this->request->controller . '-' .date('Y-m-d'));
            }
            $this->renderHeaders ();
        }
        rewind ( $this->buffer );
        $output = stream_get_contents ( $this->buffer );
        if ($to_encoding) {
            $output = mb_convert_encoding ( $output, $to_encoding, $from_encoding );
        }
        return $output;
    }
    
    public function addRow($row) {
         
        fputcsv ( $this->buffer, $row, $this->delimiter, $this->enclosure );
    }
    
    public function renderHeaders() {
        header ( 'Content-Type: text/csv' );
        header ( "Content-type:application/vnd.ms-excel" );
        header ( "Content-disposition:attachment;filename=" . $this->filenameExp );
    }
    
    public function setFilename($filename) {
        $this->filenameExp = $filename;
        if (strtolower ( substr ( $this->filenameExp, - 4 ) ) != '.csv') {
            $this->filenameExp .= '.csv';
        }
    }
}
