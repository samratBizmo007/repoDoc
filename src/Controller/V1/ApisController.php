<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller\v1;

use App\Controller\AppController; 
use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Network\Http\Auth;
use Cake\Utility\Security;
use Cake\Controller\Component\AuthComponent;
use \Firebase\JWT\JWT;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ApisController extends AppController
{
    public $header;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Firebase');
        
        header('Access-Control-Allow-Origin: *');
        
        $this->Auth->allow();
        $autharr = ['login', 'logout', 'staticPages', 'forgotPassword', 'getEmployeeLists', 'chatNotification', 'careChatNotification'];
        $this->header = apache_request_headers();

        if (!in_array($this->request->params['action'], $autharr)) {
            if (isset($this->header['Token'])) {
                if (!$this->_isEmployeeAuthenticated($this->header['Token'])) {
                    
                    $res['status'] = Configure::read('UNAUTHORIZED_CODE');
                    $res['message'] = Configure::read('UNAUTHORIZED');
                    $jwt = JWT::encode($res, Configure::read('JWT_KEY'));
                    echo json_encode(['encript' => $jwt]);
                    exit();
                }
            } else {
                $res['status'] = Configure::read('BAD_REQUEST_CODE');
                $res['message'] = Configure::read('INVALID_HEADER_PARAMETER');
                $jwt = JWT::encode($res, Configure::read('JWT_KEY'));
                echo json_encode(['encript' => $jwt]);
                exit();
            }
        }
        
        if(!empty($this->request->data['token'])) {
            $data = $this->decodeData($this->request->data['token']);
            if(!empty($data)) {
                foreach ($data as $key => $val) {
                    $this->request->data[$key] = $val; 
                }
            }
            unset($this->request->data['token']);
        }
    }
    
    public function login(){
        
        if($this->request->data){
            $data = $this->request->data;
            
            $mendatoryParameters = ['email','password','device_type','build_version'];
            if($this->_checkRequestData($mendatoryParameters,$data)){
                $this->Employees = TableRegistry::get('Employees');
                $employee = $this->Employees->doLogin($data['email'],$data['password']);
                if(!empty($employee)){

                    if(!empty($employee->hospitals_employees)) {

                        if($employee->status == 1){

                            $employee->device_token = !empty($data['device_token']) ? $data['device_token'] : "";
                            $employee->device_type = $data['device_type'];
                            $employee->build_version = $data['build_version'];
                            $employee->app_token = $this->_getKey();
                            
                            $this->Employees->save($employee);
                            
                            $result = $this->setEmployeeData($employee);
                            $response['data'] = $result;
                            
                            $response['status'] = Configure::read('SUCCESS_CODE');
                            $response['message'] = Configure::read('SUCCESS');
                        } else {
                            $response['status'] = Configure::read('SERVER_ERROR_CODE');
                            $response['message'] = Configure::read('INACTIVE_ACCOUNT');
                        }
                    } else {
                        $response['status'] = Configure::read('SERVER_ERROR_CODE');
                        $response['message'] = Configure::read('NO_SERVICE_TEAM');
                    }
                } else {
                    $response['status'] = Configure::read('UNAUTHORIZED_CODE');
                    $response['message'] = Configure::read('INVALID_CREDENTIALS');
                }

            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');  
            }

        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');  
        }
        $this->_serialize($response);
    }
    
    /*
     * Forgot password
     * Params: email
     */
    public function forgotPassword(){
    
       if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['email'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
                $this->Employees = TableRegistry::get('Employees');
                $userData = $this->Employees->find()->where(['email' => $data['email']])->first();
                if(!empty($userData)) {
                    $passkey = uniqid();
                    $timeout = time() + DAY;
                    $url = BASE_URL."users/change-password-employee/".$passkey;
                    
                    if ($this->Employees->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $userData->id])){
                    
                        $data['full_name'] = !empty($userData->full_name) ? $userData->full_name : '';
                        $data['email'] = $userData->email;
                        $data['url'] = $url;
                        $data['subject'] = 'Reset your password';
                        $data['logo_url'] = BASE_URL.'Admin/img/logos/logo.png';
                    
                        if($this->sendEmail('forgot_password',$data)) {
                            $response['status'] = Configure::read('SUCCESS_CODE');
                            $response['message'] = __('Email has been sent to your account, please check your email.');
                        } else {
                            $response['status'] = Configure::read('SERVER_ERROR_CODE');
                            $response['message'] = __('Unable to send email, please try after sometime.');
                        }
                    } else {
                        $response['status'] = Configure::read('SERVER_ERROR_CODE');
                        $response['message'] = __('Error saving reset passkey.');
                    }
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = __('There is no user registered with this email address');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = __('insufficient parameters');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = __('forbidden');
        }
    
        $this->_serialize($response);
    }
    
    /*
     * Change Password
     *
     * @method POST
     * @return Boolian  true or false response
     */
    public function changePassword() {
    
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['current_password', 'password', 'employee_id'];
            
            if($this->_checkRequestData($mendatoryParameters,$data)){
                
                if($data['current_password'] != $data['password']) {
                    $this->Employees = TableRegistry::get('Employees');
                    $employeeData = $this->Employees->find('all')->where(['id' => $data['employee_id']])->first();
        
                    if(!empty($employeeData)) {
                        // check old password is correct or not
                        if($this->Employees->checkPassword($this->request->data('current_password'), $employeeData->password)) {
                            $employeeData->password = $this->request->data('password');
                            if($this->Employees->save($employeeData)) {
                                $employeeData->change_password_date = date('Y-m-d H:i:s');
                                $employeeData->notification_date = null;
                                $this->Employees->save($employeeData);
                                $response['status'] = Configure::read('SUCCESS_CODE');
                                $response['message'] = __('Changed password successfully.');
                            } else {
                                $response['status'] = Configure::read('SERVER_ERROR_CODE');
                                $response['message'] = __('Unable to process your request, please try after sometime.');
                            }
                        } else {
                            $response['status'] = Configure::read('SERVER_ERROR_CODE');
                            $response['message'] = __('Please enter correct current password.');
                        }
                    }else {
                        $response['status'] = Configure::read('SERVER_ERROR_CODE');
                        $response['message'] = __('Unable to process your request, please try after sometime.');
                    }
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = __('New Password can not same as old password.');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = __('insufficient parameters');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = __('forbidden');
        }
    
        $this->_serialize($response);
    }
    
    public function getEmployeeDetail(){
        
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['employee_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
                $this->Employees = TableRegistry::get('Employees');
                $employee = $this->Employees->getEmployeeById($data['employee_id']);
                $result = $this->setEmployeeData($employee);
                if(!empty($result)) {
                    $response['data'] = $result;
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('SUCCESS');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('INVALID_USER');
                }
           } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function logout(){
    
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['employee_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
                $this->Employees = TableRegistry::get('Employees');
                $employee = $this->Employees->find('all')->where(['id' => $data['employee_id'], 'status' => 1])->first();
                if(!empty($employee)){
                    $employee->device_token = "";
                    $employee->device_type = "";
                    $employee->build_version = "";
                    $employee->app_token = "";
    
                    $this->Employees->save($employee);
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('LOGOUT');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('INVALID_USER');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function getPataientsLists() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['hospital_id','service_team_id', 'employee_id'];
        
            if($this->_checkRequestData($mendatoryParameters,$data)){
                
                $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');
                $sortParam = !empty($data['sort_param']) ? $data['sort_param'] : 1; 
                $patients = $this->PatientServiceTeams->getServiceTeamPatientLists($data['hospital_id'],$data['service_team_id'],$data['employee_id'], $sortParam);
                
                $response['data'] = $patients;
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        
        $this->_serialize($response);
    }
    
    public function getDepartmentLists() {
        $this->Departments = TableRegistry::get('Departments');

        $response['data'] = $this->Departments->find('all')->select(['id', 'name' => 'short_name'])->where(['is_active' => 1, 'short_name !=' => '', 'consult_department' => 1])->all()->toArray();
        $response['status'] = Configure::read('SUCCESS_CODE');
        $response['message'] = Configure::read('SUCCESS');
        $this->_serialize($response);
    }
    
    public function getEmployeeRoleLists() {
        $this->EmployeeRoles = TableRegistry::get('EmployeeRoles');
    
        $response['data'] = $this->EmployeeRoles->find('all')->select(['id', 'name' => 'short_name'])->where(['is_active' => 1, 'clinical_role' => 1, 'short_name !=' => ''])->all()->toArray();
        $response['status'] = Configure::read('SUCCESS_CODE');
        $response['message'] = Configure::read('SUCCESS');
        $this->_serialize($response);
    }
    
    public function searchProviderLists() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['hospital_id', 'employee_id'];
        
            if($this->_checkRequestData($mendatoryParameters,$data)){
        
                $this->Patients = TableRegistry::get('Patients');
                $this->Employees = TableRegistry::get('Employees');

                $provider_name = !empty($data['provider_name']) ? trim($data['provider_name']) : '';
                $room = !empty($data['room']) ? $data['room'] : '';
                $employee_role = !empty($data['department']) ? $data['department'] : '';
                
                if(!empty($room)) {
                    $employee = $this->Patients->getPatientsDoctorLists($data['hospital_id'],$data['employee_id'], $provider_name, $room, $employee_role);
                } else {
                    $employee = $this->Employees->getPatientsDoctorLists($data['hospital_id'],$data['employee_id'], $provider_name, $employee_role);
                }
        
                $response['data'] = $employee;
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        
        $this->_serialize($response);
    }
    
    public function searchEmployeeByTeam() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['hospital_id', 'team_name', 'patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->ServiceTeams = TableRegistry::get('ServiceTeams');
                
                $employee = $this->ServiceTeams->getServiceTeamEmployee($data['hospital_id'],$data['team_name'], $data['patient_id']);
                
                $response['data']['employee_lists'] = $employee;
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function findPataients() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['hospital_id', 'type'];
        
            if($this->_checkRequestData($mendatoryParameters,$data)){
        
                $this->Patients = TableRegistry::get('Patients');
        
                $patients = $this->Patients->findPataients($data);
        
                $response['data'] = $patients;
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        
        $this->_serialize($response);
    }

    public function searchPataients() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['name'];
        
            if($this->_checkRequestData($mendatoryParameters,$data)){
        
                $this->Patients = TableRegistry::get('Patients');
        
                $patients = $this->Patients->searchPataients($data);
        
                $response['data'] = $patients;
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        
        $this->_serialize($response);
    }
    
    public function patientHandoff() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Patients = TableRegistry::get('Patients');
    
                $patients = $this->Patients->getPatientReport($data['patient_id']);
    
                $response['data'] = $patients;
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function addEmployeePataients() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['employee_id', 'patient_id'];
                
            if($this->_checkRequestData($mendatoryParameters,$data)){
        
                $i = 0;
                $employeesIds = explode(',', $data['employee_id']);
                foreach ($employeesIds as $val) {
                    $insertData[$i]['patient_id'] = $data['patient_id'];
                    $insertData[$i]['employee_id'] = trim($val);
                    $insertData[$i]['is_menual'] = 1;
                    $i++;
                }
                
                $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
                
                $employeesPatients = $this->EmployeesPatients->newEntities($insertData);
                
                if($this->EmployeesPatients->saveMany($employeesPatients)) {
                    
                    /* $this->Patients = TableRegistry::get('Patients');
                    $patientDetail = $this->Patients->getPatientDetailById($data['patient_id']);
                    if(!empty($patientDetail) && !empty($patientDetail->group_id)) {
                        $newArr = [];
                        foreach ($insertData as $key => $val) {
                            $newArr[$val['employee_id']]['memberId'] = (string)$val['employee_id'];
                            $newArr[$val['employee_id']]['isAdmin'] = false;
                        }
                        
                        $rensponse = $this->Firebase->update('groups/'.$patientDetail->group_id.'/membersList/', $newArr);
                    } */
                    
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('PATIENT_SAVE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        
        $this->_serialize($response);
    }
    
    public function addPatientsOnDashboard() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['employee_id', 'patient_id'];
    
            $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
            
            if($this->_checkRequestData($mendatoryParameters,$data)){

                /* Filter Patietns */
                $employeesIds = $this->EmployeesPatients->getUniquePatients($data['employee_id'],$data['patient_id']);
                if(!empty($employeesIds)){

                    $i = 0;
                    foreach ($employeesIds as $val) {
                        
                        $patientsData = $this->EmployeesPatients->find('all')->where(['employee_id' => $data['employee_id'], 'patient_id' => trim($val)])->first();
                        
                        if(!empty($patientsData)) {
                            $patientsData->is_deleted = 0;
                        
                            if($this->EmployeesPatients->save($patientsData)) {
                                /* $this->Patients = TableRegistry::get('Patients');
                                $patientDetail = $this->Patients->getPatientDetailById($data['patient_id']);
                                if(!empty($patientDetail) && !empty($patientDetail->group_id)) {
                                    $newArr[$data['employee_id']]['memberId'] = (string)$data['employee_id'];
                                    $newArr[$data['employee_id']]['isAdmin'] = false;
                                    $rensponse = $this->Firebase->update('groups/'.$patientDetail->group_id.'/membersList/', $newArr);
                                } */
                            }
                        }else {
                            $insertData[$i]['employee_id'] = $data['employee_id'];
                            $insertData[$i]['patient_id'] = trim($val);
                            $insertData[$i]['is_menual'] = 1;
                            $i++;
                        }
                    }
        
                    if(!empty($insertData)) {
                        $employeesPatients = $this->EmployeesPatients->newEntities($insertData);
            
                        if($this->EmployeesPatients->saveMany($employeesPatients)) {
                            
                            $this->Patients = TableRegistry::get('Patients');
                            foreach ($insertData as $key => $val) {
                                $patientDetail = $this->Patients->getPatientDetailById($val['patient_id']);
                                if(!empty($patientDetail) && !empty($patientDetail->group_id)) {
                                    $newArr[$val['employee_id']]['memberId'] = (string)$val['employee_id'];
                                    $newArr[$val['employee_id']]['isAdmin'] = false;
                                    $rensponse = $this->Firebase->update('groups/'.$patientDetail->group_id.'/membersList/', $newArr);
                                }
                            }
                            
                            $response['status'] = Configure::read('SUCCESS_CODE');
                            $response['message'] = Configure::read('PATIENT_SAVE');
                        } else {
                            $response['status'] = Configure::read('SERVER_ERROR_CODE');
                            $response['message'] = Configure::read('SERVER_ERROR');
                        }
                    }  else {
                        $response['status'] = Configure::read('SUCCESS_CODE');
                        $response['message'] = Configure::read('PATIENT_SAVE');
                    }

                } else {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('PATIENT_SAVE');
                }

            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function removeEmployeePataients() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['employee_id', 'patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $insertData['patient_id'] = $data['patient_id'];
                $insertData['employee_id'] = $data['employee_id'];
                $insertData['is_deleted'] = 1;
    
                $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
    
                $patientsData = $this->EmployeesPatients->find('all')->where(['employee_id' => $data['employee_id'], 'patient_id' => $data['patient_id']])->first();
                
                if(!empty($patientsData)) {
                    $patientsData->is_deleted = 1;
    
                    if($this->EmployeesPatients->save($patientsData)) {
                        
                        $this->Patients = TableRegistry::get('Patients');
                        $patientDetail = $this->Patients->getPatientDetailById($data['patient_id']);
                        if(!empty($patientDetail) && !empty($patientDetail->group_id)) {
                            $rensponse = $this->Firebase->delete('groups/'.$patientDetail->group_id.'/membersList/'.$data['employee_id']);
                        }
                        
                        $response['status'] = Configure::read('SUCCESS_CODE');
                        $response['message'] = Configure::read('PATIENT_DELETE');
                    } else {
                        $response['status'] = Configure::read('SERVER_ERROR_CODE');
                        $response['message'] = Configure::read('SERVER_ERROR');
                    }
                } else {
                    
                    $employeesPatients = $this->EmployeesPatients->newEntity($insertData);
    
                    if($this->EmployeesPatients->save($employeesPatients)) {
                        $response['status'] = Configure::read('SUCCESS_CODE');
                        $response['message'] = Configure::read('PATIENT_SAVE');
                    } else {
                        $response['status'] = Configure::read('SERVER_ERROR_CODE');
                        $response['message'] = Configure::read('SERVER_ERROR');
                    }
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function deleteEmployeePataients() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['employee_id', 'patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
    
                $patientsData = $this->EmployeesPatients->find('all')->where(['employee_id' => $data['employee_id'], 'patient_id' => $data['patient_id']])->first();
                
                if(!empty($patientsData)) {
                    $patientsData->is_deleted = 1;
                    
                    if($this->EmployeesPatients->save($patientsData)) {
                        $response['status'] = Configure::read('SUCCESS_CODE');
                        $response['message'] = Configure::read('PATIENT_DELETE');
                    } else {
                        $response['status'] = Configure::read('SERVER_ERROR_CODE');
                        $response['message'] = Configure::read('SERVER_ERROR');
                    }
                } else {
                    $insertData['patient_id'] = $data['patient_id'];
                    $insertData['employee_id'] = $data['employee_id'];
                    $insertData['is_deleted'] = 1;

                    $employeesPatients = $this->EmployeesPatients->newEntity($insertData);
                
                    if($this->EmployeesPatients->save($employeesPatients)) {
                        $response['status'] = Configure::read('SUCCESS_CODE');
                        $response['message'] = Configure::read('PATIENT_DELETE');
                    } else {
                        $response['status'] = Configure::read('SERVER_ERROR_CODE');
                        $response['message'] = Configure::read('SERVER_ERROR');
                    }
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }

    public function getPatientServiceTeam() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id', 'hospital_id', 'employee_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Patients = TableRegistry::get('Patients');
                $this->HospitalsEmployees = TableRegistry::get('HospitalsEmployees');
                $patientDetail = $this->Patients->getPatientDetails($data['patient_id'], $data['employee_id']);
                $response['data']['patient_details'] = $patientDetail;
                $response['data']['employees'] = $this->HospitalsEmployees->getServiceTeamLists($patientDetail['hospital_id'], $patientDetail['patient_service_teams'], $data['patient_id']);
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        
        $this->_serialize($response);
    }

    public function patientViewNotes() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id', 'employee_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Reminders = TableRegistry::get('Reminders');
                $this->VoiceNotes = TableRegistry::get('VoiceNotes');
                
                $response['data']['notes'] = (object)$this->VoiceNotes->getEmployeeVoiceNotes($data);
                $response['data']['reminders'] = $this->Reminders->getReminders($data);
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function patientSignoutNotes() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id'];
        
            if($this->_checkRequestData($mendatoryParameters,$data)){
        
                $this->SignoutNotes = TableRegistry::get('SignoutNotes');
        
                $response['data'] = $this->SignoutNotes->getSignOutNotes($data['patient_id']);
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        
        $this->_serialize($response);
    }
    
    public function patientFollowups() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Followups = TableRegistry::get('Followups');
    
                $response['data'] = $this->Followups->getFollowups($data['patient_id']);
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function getEventLists() {
        $this->Events = TableRegistry::get('Events');
    
        $response['data'] = $this->Events->find('all')->select(['id', 'name'])->where(['is_active' => 1])->all()->toArray();
        $response['status'] = Configure::read('SUCCESS_CODE');
        $response['message'] = Configure::read('SUCCESS');
        $this->_serialize($response);
    }
    
    public function patientMajorEvents() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->MajorEvents = TableRegistry::get('MajorEvents');
    
                $response['data'] = $this->MajorEvents->getMajorEvents($data['patient_id']);
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function createFollowups() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = [ 'employee_id', 'patient_id', 'department_id', 'content', 'date', 'time', 'service_team_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Followups = TableRegistry::get('Followups');

                if(!empty($data['service_team_id'])  && $data['service_team_id'] < 0) {
                    unset($data['service_team_id']);
                }
                
                $followup = $this->Followups->newEntity($data);

                if($result = $this->Followups->save($followup)) {
                    $response['data'] = $this->Followups->getFollowupDetail($result->id);
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('FOLLOWUPS_SAVE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function createSignoutNote() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = [ 'employee_id', 'patient_id', 'department_id', 'content', 'duration', 'date', 'time' ];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
        
                $this->SignoutNotes = TableRegistry::get('SignoutNotes');
    
                if(!empty($data['content']) && !empty($data['content']['name'])) {
                    $data['content'] = $this->SignoutNotes->uploadAudio($data['content']);
                }
                
                $signoutNote = $this->SignoutNotes->newEntity($data);
                
                if($result = $this->SignoutNotes->save($signoutNote)) {
                    $response['data'] = $this->SignoutNotes->getSignoutNoteDetail($result->id);
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('SIGNOUT_NOTE_SAVE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function createMajorEvent() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = [ 'employee_id', 'patient_id', 'event', 'content', 'duration', 'date' ];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->MajorEvents = TableRegistry::get('MajorEvents');
    
                if(!empty($data['content']) && !empty($data['content']['name'])) {
                    $data['content'] = $this->MajorEvents->uploadAudio($data['content']);
                }
                
                $majorEvent = $this->MajorEvents->newEntity($data);
    
                if($result = $this->MajorEvents->save($majorEvent)) {
                    $response['data'] = $this->MajorEvents->getMajorEventDetail($result->id);
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('EVENT_SAVE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function createReminder() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = [ 'employee_id', 'patient_id', 'content', 'date', 'time' ];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Reminders = TableRegistry::get('Reminders');
    
                $reminder = $this->Reminders->newEntity($data);
    
                if($result = $this->Reminders->save($reminder)) {
                    $response['data'] = $this->Reminders->getReminderDetail($result->id);
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('REMINDER_SAVE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function createEmployeePlans() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id', 'place', 'discharge', 'employee_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Patients = TableRegistry::get('Patients');
                $data['discharge'] = !empty($data['discharge']) ? intval($data['discharge']) : 0;
                
                $patient = $this->Patients->get($data['patient_id']);
                
                $is_sendnot = 0;
                
                if(($patient->discharge == 1 ||  $data['discharge'] == 1) && $patient->discharge != $data['discharge']) {
                    $is_sendnot = 1;
                }
                
                unset($data['hospital_id']);
                $patient = $this->Patients->patchEntity($patient, $data);
                
                if($this->Patients->save($patient)) {
                    
                    if($is_sendnot) {
                        $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');
                        $this->HospitalsEmployees = TableRegistry::get('HospitalsEmployees');
                        $serviceTeamList = $this->PatientServiceTeams->find('all')->where(['patient_id' => $data['patient_id']])->toArray();
                        if(!empty($serviceTeamList)) {
                            foreach ($serviceTeamList as $key => $val) {
                                $employeeList = $this->HospitalsEmployees->find('all')
                                    ->select([
                                        'id',
                                        'employee_id',
                                        'hospital_id'
                                    ])
                                    ->contain([
                                        'Employees' => [
                                            'fields' => [
                                                'id',
                                                'firstname',
                                                'lastname',
                                                'device_token',
                                                'device_type'
                                            ]
                                        ]
                                    ])
                                    ->where([
                                        'HospitalsEmployees.hospital_id' => $patient->hospital_id,
                                        'HospitalsEmployees.service_team_id' => $val->service_team_id
                                    ])
                                    ->toArray();
                                
                                    if(!empty($employeeList)) {
                                        foreach ($employeeList as $e_key => $e_val) {
                                            if(!empty($e_val->employee->device_token)) {
                                                if($data['discharge'] == 1) {
                                                    $message = $patient->full_name." in Room ".$patient->room. " will be discharged today.";
                                                } else {
                                                    $message = "Discharge Cancelled on ".$patient->full_name." in Room ".$patient->room. ".";
                                                }
                                                
                                                if($e_val->employee_id != $data['employee_id']) {
                                                    $result = $this->Firebase->sendFCMMessage($e_val->employee->device_token, $message, $patient->full_name, ['discharge' => 1] ,'',$e_val->employee->device_type);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            
                            $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
                            
                            $patientsData = $this->EmployeesPatients->find('all')
                                ->select([
                                    'id',
                                    'employee_id',
                                    'patient_id'
                                ])
                                ->contain([
                                    'Employees' => [
                                        'fields' => [
                                            'id',
                                            'firstname',
                                            'lastname',
                                            'device_token',
                                            'device_type'
                                        ]
                                    ]
                                ])
                                ->find('all')
                                ->where([
                                    'EmployeesPatients.patient_id' => $data['patient_id'],
                                    'EmployeesPatients.is_deleted' => 0
                                ])
                                ->toArray();
                                
                                if(!empty($patientsData)) {
                                    foreach ($patientsData as $p_key => $p_val) {
                                        if(!empty($p_val->employee->device_token)) {
                                            if($data['discharge'] == 1) {
                                                $message = $patient->full_name." in Room ".$patient->room. " will be discharged today.";
                                            } else {
                                                $message = "Discharge Cancelled on ".$patient->full_name." in Room ".$patient->room. ".";
                                            }
                                            
                                            if($p_val->employee_id != $data['employee_id']) {
                                                $result = $this->Firebase->sendFCMMessage($p_val->employee->device_token, $message, $patient->full_name, ['discharge' => 1], '', $p_val->employee->device_type);
                                            }
                                        }
                                    }
                                }
                        }
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('PLANE_SAVE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function patientReminders() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Reminders = TableRegistry::get('Reminders');
    
                $response['data'] = $this->Reminders->getReminders($data);
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function editPatientDetail() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id', 'patient_status'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Patients = TableRegistry::get('Patients');
                
                $patient = $this->Patients->get($data['patient_id']);
                $patient->pmh = !empty($data['pmh']) ? $data['pmh'] : "";
                $patient->diagnosed_with = !empty($data['diagnosed_with']) ? $data['diagnosed_with'] : '';
                $patient->patient_status = $data['patient_status'];
                
                $patient = $this->Patients->patchEntity($patient, $this->request->data);
                
                if ($this->Patients->save($patient)) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('SUCCESS');
                }else{
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            }else{
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        }else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    
    public function editEmployeeProfilePic() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['employee_id', 'photo'];
            
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Employees = TableRegistry::get('Employees');
                
                if(!empty($this->request->data['photo']['name'])){
                    $old_image = !empty($data['old_photo']) ? $data['old_photo'] : ''; 
                    $data['photo'] = $this->Employees->uploadProfilePhoto($data['photo'], $old_image);
                }
                
                $employee = $this->Employees->get($data['employee_id']);
                $employee->photo = $data['photo'];
                
                //$employee = $this->Employees->patchEntity($employee, $this->request->data);
    
                if ($this->Employees->save($employee)) {
                    
                    $employee = $this->Employees->getEmployeeById($employee->id);
                    $result = $this->setEmployeeData($employee);
                    $response['data'] = $result;
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('SUCCESS');
                }else{
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            }else{
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        }else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function myPatientSignoutNotes() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['employee_id'];
            
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->SignoutNotes = TableRegistry::get('SignoutNotes');
    
                $response['data'] = $this->SignoutNotes->getEmployeeSignOutNotes($data['employee_id']);
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function myPatientFollowups() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['employee_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Followups = TableRegistry::get('Followups');
    
                $response['data'] = $this->Followups->getEmployeeFollowups($data['employee_id']);
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function getAllPatientFollowups() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['employee_id', 'hospital_id','service_team_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Followups = TableRegistry::get('Followups');
                $patients = $this->Followups->getPatientsFollowupLists($data['employee_id'], $data['hospital_id'],$data['service_team_id']);
                
    
                $response['data'] = $patients;
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function myPatientNotes() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['employee_id', 'service_team_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->VoiceNotes = TableRegistry::get('VoiceNotes');
    
                $response['data'] = $this->VoiceNotes->getEmployeeVoiceNotesLists($data['employee_id'], $data['service_team_id']);
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function getFirstCallAndAttendingLists() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['hospital_id', 'employee_id', 'type'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Employees = TableRegistry::get('Employees');
    
                $department = !empty($data['department']) ? $data['department'] : '';
                $sub_department = !empty($data['sub_department']) ? $data['sub_department'] : '';
    
                $employee = $this->Employees->getFirstCallLists($data);
    
                $response['data'] = $employee;
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    

    public function createNotes() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = [ 'employee_id', 'patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->VoiceNotes = TableRegistry::get('VoiceNotes');
    
                $this->VoiceNotes->deleteAll(['employee_id' => $data['employee_id'],'patient_id' => $data['patient_id']]);
                
                if (empty($data['content'])) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('NOTES_SAVE');
                } else {
                    
                    /* if(!empty($data['service_team_id'])  && $data['service_team_id'] < 0) {
                        unset($data['service_team_id']);
                    } */
                    
                    $voiceNote = $this->VoiceNotes->newEntity($data);
                    if($this->VoiceNotes->save($voiceNote)) {
                        $response['status'] = Configure::read('SUCCESS_CODE');
                        $response['message'] = Configure::read('NOTES_SAVE');
                    } else {
                        $response['status'] = Configure::read('SERVER_ERROR_CODE');
                        $response['message'] = Configure::read('SERVER_ERROR');
                    }    
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function editNotes() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = [ 'note_id', 'content'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->VoiceNotes = TableRegistry::get('VoiceNotes');
                
                $notes = $this->VoiceNotes->get($data['note_id']);
                $notes->content = $data['content'];
                if(!empty($data['timestamp'])) {
                    $notes->timestamp = $data['timestamp'];
                }
                if($this->VoiceNotes->save($notes)) {
                    $response['data'] = $this->VoiceNotes->getNotesDetail($data['note_id']);
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('NOTES_SAVE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function editFollowUps() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['follow_id', 'content', 'date', 'time'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Followups = TableRegistry::get('Followups');
    
                $followUp = $this->Followups->get($data['follow_id']);
                
                $data['content'] = $data['content'];
                $data['date'] = date("Y-m-d",strtotime($data['date']));
                $data['time'] = date("H:i", strtotime($data['time']));
                
                $followUp = $this->Followups->patchEntity($followUp, $data);
                
                if($this->Followups->save($followUp)) {
                    $response['data'] = $this->Followups->getFollowupDetail($data['follow_id']);
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('FOLLOWUPS_SAVE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function storeUrgentMessage() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['actual_chat_id', 'chat_id', 'sender_id', 'receiver_id', 'message_id', 'message', 'doctor_name', 'message_type'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Messages = TableRegistry::get('Messages');
                
                if(empty($data['patient_id'])) {
                    unset($data['patient_id']);
                }
                
                $insertData = [];
                $receiverIds = $data['receiver_id'];
                foreach ($receiverIds as $val) {
                    $data['receiver_id'] = $val;
                    $data['message_count'] = 1;
                    $data['next_message_time'] = time() + 30;
                    $insertData[] =$data;
                }
                
                $messageData = $this->Messages->newEntities($insertData);
                if($this->Messages->saveMany($messageData)) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('MESSAGE_SAVE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function changeUrgentMessageStatus() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['message_id', 'sender_id', 'receiver_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Messages = TableRegistry::get('Messages');
                
                $message = $this->Messages->find('all')->where(['message_id' => $data['message_id'], 'sender_id' => $data['sender_id'], 'receiver_id' => $data['receiver_id'] ])->first();
                
                if($this->Messages->delete($message)) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('MESSAGE_CHANGE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function storeScheduleMessage() {
       
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['chat_id', 'sender_id', 'message', 'date_time'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){

                $data['receiver_id'] = (!empty($data['receiver_id'])) ? $data['receiver_id'] : "";

                $this->ScheduleMessages = TableRegistry::get('ScheduleMessages');
                    
                $data['message_id'] = $this->Firebase->generateMessageToken();
                
                $messageData = $this->ScheduleMessages->newEntity($data);
    
                if($result = $this->ScheduleMessages->save($messageData)) {
                    $response['data'] = $result;
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('SCHEDULE_MESSAGE_SAVE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }

    public function getEmployeeSchedule() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['date', 'employee_id'/* , 'hospital_id' */];
        
            if($this->_checkRequestData($mendatoryParameters,$data)){
                
                $this->EmployeesSchedules = TableRegistry::get('EmployeesSchedules');
                $response['data'] = $this->EmployeesSchedules->getEmployeeSchedule($data);
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function getProviderDetail() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Patients = TableRegistry::get('Patients');
                
                $patient_detail = $this->Patients->get($data['patient_id']);
                
                $this->Employees = TableRegistry::get('Employees');
                $employee = $this->Employees->getEmployeeById($patient_detail->employee_id);
                $response['data'] = $employee;
                $response['data']['app_token']  = !empty($employee->app_token) ? $employee->app_token : '';
                $response['data']['photo']      = (!empty($employee->photo) && file_exists(Configure::read('UPLOAD_EMPLOYEE_ORIGINAL_IMAGE_PATH').$employee->photo)) ? Configure::read('UPLOAD_EMPLOYEE_ORIGINAL_IMAGE_URL').$employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $response['data']['photo_thumb']= (!empty($employee->photo)) ? $employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function deleteReminder() {
        
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['reminder_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Reminders = TableRegistry::get('Reminders');
                $reminder = $this->Reminders->get($data['reminder_id']);
               
                
                if ($this->Reminders->delete($reminder)) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('REMINDER_DELETE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function deleteSignoutNotes() {
    
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['signout_note_id'];
          
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->SignoutNotes = TableRegistry::get('SignoutNotes');
                $signoutNotes = $this->SignoutNotes->get($data['signout_note_id']);
                 
    
                if ($this->SignoutNotes->delete($signoutNotes)) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('SIGNOUT_NOTE_DELETE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function deleteMajorEvent() {
    
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['major_event_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->MajorEvents = TableRegistry::get('MajorEvents');
                $reminder = $this->MajorEvents->get($data['major_event_id']);
                 
    
                if ($this->MajorEvents->delete($reminder)) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('MAJOR_EVENT_DELETE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function deleteFollowups() {
    
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['followpu_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Followups = TableRegistry::get('Followups');
                $followup = $this->Followups->get($data['followpu_id']);
                 
    
                if ($this->Followups->delete($followup)) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('FOLLOWUP_DELETE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function setUserNotification() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['employee_id'];
        
            if($this->_checkRequestData($mendatoryParameters,$data)){
        
                $this->Employees = TableRegistry::get('Employees');
                $employee = $this->Employees->get($data['employee_id']);
                
                if(empty($data['is_notification'])) {
                    $data['is_notification'] = 0;
                }
                
                $employee = $this->Employees->patchEntity($employee, $data);
                
                if($this->Employees->save($employee)) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('NOTI_CHANGE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function changeReminderStatus() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['reminder_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Reminders = TableRegistry::get('Reminders');
                $reminder = $this->Reminders->get($data['reminder_id']);
    
                if(empty($data['status'])) {
                    $data['status'] = 0;
                }
    
                $reminder = $this->Reminders->patchEntity($reminder, $data);
    
                if($this->Reminders->save($reminder)) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('REMINDER_CHANGE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function changeFollowupStatus() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['follow_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Followups = TableRegistry::get('Followups');
                $followup = $this->Followups->get($data['follow_id']);
    
                if(empty($data['status'])) {
                    $data['status'] = 0;
                }
                
                $followup = $this->Followups->patchEntity($followup, $data);
    
                if($this->Followups->save($followup)) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('FOLLOWUP_CHANGE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function addPatientServiceTeamInFirebase() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Patients = TableRegistry::get('Patients');
                
                $patient = $this->Patients->get($data['patient_id'], ['contain' => ['PatientServiceTeams']]);
                
                $serviceTeam = [];
                if(!empty($patient->patient_service_teams)) {
                    foreach ($patient->patient_service_teams as $p_key => $p_val) {
                        $serviceTeam[] =  $p_val->service_team_id;
                    }
                }
                
                $hospitalsEmployees = TableRegistry::get('HospitalsEmployees');
                $employees = $hospitalsEmployees->getEmployees($patient->hospital_id, $serviceTeam);
                if(!empty($employees) && !empty($serviceTeam)) {
                    $addArr = [
                        'patientId' => (string)$patient->id,
                        'groupName' => $patient->firstname.' '. $patient->lastname,
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

                    
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('SUCCESS');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function getPatientServiceTeamLists() {
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Patients = TableRegistry::get('Patients');
                
                $patient = $this->Patients->get($data['patient_id'], ['contain' => ['PatientServiceTeams']]);
                
                if(empty($patient->group_id)) {
                    $patient->group_id = $this->Firebase->generateMessageToken();
                    $this->Patients->save($patient);
                }
                
                $serviceTeam = [];
                if(!empty($patient->patient_service_teams)) {
                    foreach ($patient->patient_service_teams as $p_key => $p_val) {
                        $serviceTeam[] =  $p_val->service_team_id;
                    }
                }
                
                $addArr = [];
                $employees = [];
                
                if(!empty($serviceTeam)) {
                    $hospitalsEmployees = TableRegistry::get('HospitalsEmployees');
                    $employees = $hospitalsEmployees->getEmployees($patient->hospital_id, $serviceTeam);
                }
                
                $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
                
                $patientsData = $this->EmployeesPatients->find('all')
                    ->select([
                        'id',
                        'employee_id',
                        'patient_id',
                        'is_primary'
                    ])
                    ->where([
                        'patient_id' => $data['patient_id'],
                        'is_deleted' => 0
                    ])
                    ->toArray();
                
                if(!empty($patientsData)) {
                    foreach ($patientsData as $key => $val) {
                        $employees[$val->employee_id]['memberId'] = (string)$val->employee_id;
                        $employees[$val->employee_id]['isAdmin'] = false;
                        $employees[$val->employee_id]['isPrimary'] = $val->is_primary;
                    }
                }

                if(!empty($employees)) {

                    $this->HospitalEmployees = TableRegistry::get('HospitalEmployees');
                    $result = $this->HospitalEmployees->find('all')->where(['service_team_id IN' => $serviceTeam, 'hospital_id'=>$patient->hospital_id])->toArray();
                    if(!empty($result)) {
                            foreach ($result as $key => $val) {
                                $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');
                                $patientdata = $this->PatientServiceTeams->find('all')->where(['patient_id' => $patient->id,'hospital_id'=>$patient->hospital_id,'service_team_id'=>$val->service_team_id])->first();
                                $employees[$val->employee_id]["isPrimary"] = $patientdata->is_primary;
                                
                            }
                    }
 
                    $addArr = [
                        'patientId' => (string)$patient->id,
                        'groupId' => $patient->group_id,
                        'groupName' => $patient->firstname.' '. $patient->lastname,
                        'membersList' => $employees
                    ];
                }
                $response['data'] = $addArr;
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function getAllDepartmentSubdepartmentLists() {
        $this->Departments = TableRegistry::get('Departments');
        $this->SubDepartments = TableRegistry::get('SubDepartments');
        
        $response['data']['department'] = $this->Departments->find('all')->select(['id', 'name'])->where(['is_active' => 1, 'consult_department' => 1])->all()->toArray();
        $response['data']['sub_department'] = $this->SubDepartments->find('all')->select(['id', 'department_id', 'name'])->where(['is_active' => 1])->all()->toArray();
        $response['status'] = Configure::read('SUCCESS_CODE');
        $response['message'] = Configure::read('SUCCESS');
        $this->_serialize($response);
    }
    
    /* send chatNotification to user */
    public function chatNotification() {
    
        $notificationData = file_get_contents("php://input");
        parse_str($notificationData, $notificationData);
        
        $this->Employees = TableRegistry::get('Employees');
        $this->Patients = TableRegistry::get('Patients');
        if(!empty($notificationData)) {
            if($notificationData['messageType'] == "11") {
                $notificationData['message'] = "Patient Card";
            }elseif($notificationData['messageType'] == "10") {
                $notificationData['message'] = "Contact Card";
            }else{
                $notificationData['message'] = base64_decode($notificationData['message']);
            }
            
            /* Log notification data */
            if($notificationData['chatType'] == "0") {
                $employeeData = $this->Employees->getEmployeeById($notificationData['receiverId']);
                if(!empty($employeeData->device_token) && $employeeData->is_notification == 1) {
                    $this->Firebase->sendFCMMessage($employeeData->device_token, $notificationData['senderName'].': '.$notificationData['message'], '', [], $notificationData['messageType'], $employeeData->device_type);
                }
            } elseif($notificationData['chatType'] == "1") {
                if($notificationData['messageType'] == "3" || $notificationData['messageType'] == "4") {
                    $employeeData = $this->Patients->getPatientDoctorLists($notificationData['chatId']);
                    //file_put_contents(TMP."device_tokens.txt", print_r($employeeData,true),FILE_APPEND);
                    if(!empty($employeeData)) {
                        foreach ($employeeData as $key => $val) {
                            if(!empty($val['device_token']) && $val['id'] !=  intval($notificationData['senderId']) && $val['is_notification'] == 1) {
                                $this->Firebase->sendFCMMessage($val['device_token'], $notificationData['senderName'].': '.$notificationData['message'], '', [], $notificationData['messageType'], $val['device_type'], $notificationData['chatType']);
                            }
                        }
                    }
                }
            }
        }
        exit;
    }
    
    /* send chatNotification to user */
    public function careChatNotification() {
        
        $notificationData = file_get_contents("php://input");
        parse_str($notificationData, $notificationData);
        
        $this->Employees = TableRegistry::get('Employees');
        $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');
        $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
        $this->HospitalsEmployees = TableRegistry::get('HospitalsEmployees');
        
        /* Log notification data */
        if(!empty($notificationData)) {
            if($notificationData['messageType'] == "11") {
                $notificationData['message'] = "Patient Card";
            }elseif($notificationData['messageType'] == "10") {
                $notificationData['message'] = "Contact Card";
            }else{
                $notificationData['message'] = base64_decode($notificationData['message']);
            }
            
            if($notificationData['chatType'] == "0") {
                $serviceTeam = $this->PatientServiceTeams->getPatientServiceTeamIds($notificationData['patientId']);
                $meanulyAdded = $this->EmployeesPatients->checkEmployeePatients($notificationData['receiverId'], $notificationData['patientId']);
                
                $sent_flag = 0;
                
                if(!empty($serviceTeam) && $this->HospitalsEmployees->checkEmployeeIsWorking($serviceTeam, $notificationData['receiverId'])) {
                    $sent_flag = 1;        
                }
                
                if($meanulyAdded) {
                    $sent_flag = 1;
                }
                
                if($sent_flag) {
                    $employeeData = $this->Employees->getEmployeeById($notificationData['receiverId']);
                    
                    if(!empty($employeeData->device_token) && $employeeData->is_notification == 1) {
                        $this->Firebase->sendFCMMessage($employeeData->device_token, $notificationData['senderName'].': '.$notificationData['message'], '', [], $notificationData['messageType'], $employeeData->device_type, $notificationData['chatType']);
                    }
                }
            }
        }
        exit;
    }
    
    /**
     * Get Static Page
     *
     */
    public function staticPages() {
        
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['page_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Pages = TableRegistry::get('Pages');
    
                $page = $this->Pages->findById($data['page_id'])->first();
    
                if(!empty($page)) {
                    $response['data']['title'] = $page->title;
                    $response['data']['content'] = $page->content;
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('SUCCESS');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] =Configure::read('FORBIDDEN');
        }
    
        $this->_serialize($response);
    }
    
    public function getEmployeeLists(){
        
        $data = $this->request->data;
        
        $this->Employees = TableRegistry::get('Employees');
        $date = !empty($data['date']) ? $data['date'] : '';
        
        $employee = $this->Employees->getEmployeeLists($date);
        
        $response['data']['employees'] = $employee;
        $response['data']['date'] = date('Y-m-d H:i:s');
        $response['status'] = Configure::read('SUCCESS_CODE');
        $response['message'] = Configure::read('SUCCESS');
        $this->_serialize($response);
    }

    public function changeStatus(){
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['employee_id','chat_status'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
        
                $this->Employees = TableRegistry::get('Employees');
                $employee = $this->Employees->get($data['employee_id']);
                
                $employee = $this->Employees->patchEntity($employee, $data);
                
                if($this->Employees->save($employee)) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('CHAT_STATUS_CHANGE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function changeRoomNumber(){
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id','hospital_bed_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){

                $this->PatientsBed = TableRegistry::get('PatientsBed');
                
                if($this->PatientsBed->isWaiting($data['hospital_bed_id'])){

                    $waitingDetails =  $this->PatientsBed->getDetails($data['hospital_bed_id']);
                    $response['status'] = Configure::read('BAD_REQUEST_CODE');
                    $response['message'] = "Patient ".$waitingDetails["patient_name"] . " is already waiting for this bed. Please try another bed";

                } else {
                        $beds =  $this->PatientsBed->getDetails($data['hospital_bed_id']);
                        $details =  $this->PatientsBed->get($data['patient_id']);
                        $data["status"]= (count($beds) > 0) ? "WAITING" : "OCCUPIED";
                        $patients = $this->PatientsBed->patchEntity($details, $data);
                
                        if($this->PatientsBed->save($patients)) {
                            $response['status'] = Configure::read('SUCCESS_CODE');
                            $response['message'] = Configure::read('ROOM_NUMBER_CHANGE');
                        } else {
                            $response['status'] = Configure::read('SERVER_ERROR_CODE');
                            $response['message'] = Configure::read('SERVER_ERROR');
                        }

                } 
            }else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }

    public function addPCP(){
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id','employee_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
        
                $this->Patients = TableRegistry::get('Patients');
                $patients = $this->Patients->get($data['patient_id']);
                
                $patients = $this->Patients->patchEntity($patients, $data);
                
                if($this->Patients->save($patients)) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('PCP_UPDATE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }


    public function getHospitals(){
        $this->Hospitals = TableRegistry::get('Hospitals');
        $response['data'] = $this->Hospitals->find('all')->select(['hospitalId'=>'id', 'hospitalName'=>'name',"logo"])->where(['is_active' => 1])->all()->toArray();
        $response['status'] = Configure::read('SUCCESS_CODE');
        $response['message'] = Configure::read('SUCCESS');
        $this->_serialize($response);
    }

    public function addMe(){
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['hospital_id','patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){

                if(isset($data['service_team_id']) && !empty($data['service_team_id'])){

                    $this->ServiceTeams = TableRegistry::get('ServiceTeams');
                    $serviceTeam = $this->ServiceTeams->get($data['service_team_id']);
                
                    if(!empty($serviceTeam)){

                        $patientIds = explode(',', $data['patient_id']);
                        $this->Patients = TableRegistry::get('Patients');
                        
                        $patients = $this->Patients->find('all')->where(['id IN' => $patientIds])->toArray();
                        $i=0;
                        $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');
                        foreach($patients as $key => $val){
                            $patientdata = $this->PatientServiceTeams->find('all')->where(['patient_id' => trim($val->id),'hospital_id'=>$val->hospital_id,'service_team_id'=>$serviceTeam["id"]])->first();
                            if(!empty($patientdata)){
                                $patientdata->is_primary = 1;
                                $this->PatientServiceTeams->save($patientdata);
                                continue;
                            }
                            $insertData[$i]['patient_id'] = trim($val->id);
                            $insertData[$i]['hospital_id'] = $val->hospital_id;
                            $insertData[$i]['service_team_id'] = $serviceTeam["id"];
                            $insertData[$i]['is_primary'] = 1;
                            $i++;
                        }

                        if(!empty($insertData)){
                            $patientService = $this->PatientServiceTeams->newEntities($insertData);
                            
                            if($this->PatientServiceTeams->saveMany($patientService)) {
                                $response['status'] = Configure::read('SUCCESS_CODE');
                                $response['message'] = Configure::read('PRIMARY_MARKED');
                            }else{
                                $response['status'] = Configure::read('SERVER_ERROR_CODE');
                                $response['message'] = Configure::read('SERVER_ERROR');
                            }
                        }else{
                            $response['status'] = Configure::read('SUCCESS_CODE');
                            $response['message'] = Configure::read('PRIMARY_MARKED');
                        }
                        
                    }else{
                        $response['status'] = Configure::read('SERVER_ERROR_CODE');
                        $response['message'] = Configure::read('INVALID_TEAM');
                    }

                } else {

                    $hospitalsEmployees = TableRegistry::get('HospitalsEmployees');
                    $employees = $hospitalsEmployees->find('all')->select(['service_team_id'])->where(['employee_id' =>$data['employee_id'], "hospital_id"=>$data["hospital_id"] ])->all()->toArray();
                    
                    if(isset($employees[0]->service_team_id) && !empty($employees[0]->service_team_id)){

                        $this->ServiceTeams = TableRegistry::get('ServiceTeams');
                        $this->Patients = TableRegistry::get('Patients');
                        $serviceTeam = $this->ServiceTeams->get($employees[0]->service_team_id);
                        $patientIds = explode(',', $data['patient_id']);
                        $patients = $this->Patients->find('all')->where(['id IN' => $patientIds])->toArray();
                        $i=0;
                        $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');
                        foreach($patients as $key => $val){
                            $patientdata = $this->PatientServiceTeams->find('all')->where(['patient_id' => trim($val->id),'hospital_id'=>$val->hospital_id,'service_team_id'=>$serviceTeam["id"]])->first();
                            if(!empty($patientdata)){
                                $patientdata->is_primary = 1;
                                $this->PatientServiceTeams->save($patientdata);
                                continue;
                            }
                            $insertData[$i]['patient_id'] = trim($val->id);
                            $insertData[$i]['hospital_id'] = $val->hospital_id;
                            $insertData[$i]['service_team_id'] = $serviceTeam["id"];
                            $insertData[$i]['is_primary'] = 1;
                            $i++;
                        }

                        if(!empty($insertData)){
                            $patientService = $this->PatientServiceTeams->newEntities($insertData);
                        
                            if($this->PatientServiceTeams->saveMany($patientService)) {

                                $this->Patients = TableRegistry::get('Patients');
                                
                                $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
                                foreach($patientIds as $val){
                                    $patientsData = $this->EmployeesPatients->find('all')->where(['employee_id' => $data['employee_id'], 'patient_id' => trim($val)])->first();
                                    
                                    if(!empty($patientsData)) {
                                        $patientsData->is_deleted = 0;
                                        $patientsData->is_primary = 1;
                                        $this->EmployeesPatients->save($patientsData);
                                    } 
                                }

                                $response['status'] = Configure::read('SUCCESS_CODE');
                                $response['message'] = Configure::read('PRIMARY_MARKED');

                            }else{
                                $response['status'] = Configure::read('SERVER_ERROR_CODE');
                                $response['message'] = Configure::read('SERVER_ERROR');
                            }    
                        }else{    
                            $response['status'] = Configure::read('SUCCESS_CODE');
                            $response['message'] = Configure::read('PRIMARY_MARKED');
                        }
                    }else{

                        $patientIds = explode(',', $data['patient_id']);
                        $i=0;

                        $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
                        foreach($patientIds as $val){
                                $patientsData = $this->EmployeesPatients->find('all')->where(['employee_id' => $data['employee_id'], 'patient_id' => trim($val)])->first();
                                
                                if(!empty($patientsData)) {
                                    $patientsData->is_deleted = 0;
                                    $patientsData->is_primary = 1;
                                    $this->EmployeesPatients->save($patientsData);
                                }else{
                                    $insertData[$i]['patient_id'] = trim($val);
                                    $insertData[$i]['employee_id'] = $data['employee_id'];
                                    $insertData[$i]['is_menual'] = 1;
                                    $insertData[$i]['is_primary'] = 1;
                                    $i++;
                                }

                        }

                        if(!empty($insertData)){
                            $employeesPatients = $this->EmployeesPatients->newEntities($insertData);
                            if($this->EmployeesPatients->saveMany($employeesPatients)) {
                                $response['status'] = Configure::read('SUCCESS_CODE');
                                $response['message'] = Configure::read('PRIMARY_MARKED');
                            }else{
                                $response['status'] = Configure::read('SERVER_ERROR_CODE');
                                $response['message'] = Configure::read('SERVER_ERROR');
                            }
                        } else{
                            $response['status'] = Configure::read('SUCCESS_CODE');
                            $response['message'] = Configure::read('PRIMARY_MARKED');
                        }
                        
                    }
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        
        $this->_serialize($response);
    }


    public function removePrimary(){
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['hospital_id','patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
                $patientIds = explode(',', $data['patient_id']);
                if(isset($data['service_team_id']) && !empty($data['service_team_id'])){
                    
                    $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');

                    foreach($patientIds as $val){
                        
                        $patientdata = $this->PatientServiceTeams->find('all')->where(['patient_id' => trim($val),'hospital_id'=>$data['hospital_id'],'service_team_id'=>$data['service_team_id']])->first();
                        
                        if(!empty($patientdata)){
                            $patientdata->is_primary = 0;
                            $this->PatientServiceTeams->save($patientdata);
                            continue;
                        }
                    }

                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('PRIMARY_REMOVED');

                } else {

                    $hospitalsEmployees = TableRegistry::get('HospitalsEmployees');
                    $employees = $hospitalsEmployees->find('all')->select(['service_team_id'])->where(['employee_id' =>$data['employee_id'], "hospital_id"=>$data["hospital_id"] ])->all()->toArray();
                    
                    if(isset($employees[0]->service_team_id) && !empty($employees[0]->service_team_id)){

                        $this->ServiceTeams = TableRegistry::get('ServiceTeams');
                        $serviceTeam = $this->ServiceTeams->get($employees[0]->service_team_id);
                        $patientIds = explode(',', $data['patient_id']);
                        $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');
                        foreach($patientIds as $val){
                            $patientdata = $this->PatientServiceTeams->find('all')->where(['patient_id' => trim($val),'hospital_id'=>$data["hospital_id"],'service_team_id'=>$serviceTeam["id"]])->first();
                            if(!empty($patientdata)){
                                $patientdata->is_primary = 0;
                                $this->PatientServiceTeams->save($patientdata);
                                continue;
                            }
                            
                        }

                        $response['status'] = Configure::read('SUCCESS_CODE');
                        $response['message'] = Configure::read('PRIMARY_REMOVED');
                        

                    } else{

                        $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
                        foreach($patientIds as $val){
                            $patientsData = $this->EmployeesPatients->find('all')->where(['employee_id' => $data['employee_id'], 'patient_id' => trim($val)])->first();
                            
                            if(!empty($patientsData)) {
                                $patientsData->is_primary = 0;
                                $this->EmployeesPatients->save($patientsData);
                            }    
                        }

                        $response['status'] = Configure::read('SUCCESS_CODE');
                        $response['message'] = Configure::read('PRIMARY_REMOVED');
                    }
                }

            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        $this->_serialize($response);
    }
    
    public function addConsultTeam(){
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['hospital_id','patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
        
                $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
                $patientIds = explode(',', $data['patient_id']);

                if(isset($data['service_team_id']) && !empty($data['service_team_id'])){
                    $this->ServiceTeams = TableRegistry::get('ServiceTeams');
                    $serviceTeam = $this->ServiceTeams->get($data['service_team_id']);
                
                    if(!empty($serviceTeam)){

                        $this->Patients = TableRegistry::get('Patients');
                        $patients = $this->Patients->find('all')->where(['id IN' => $patientIds])->toArray();
                        $i=0;
                        $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');
                        foreach($patients as $key => $val){
                            $patientdata = $this->PatientServiceTeams->find('all')->where(['patient_id' => trim($val->id),'hospital_id'=>$val->hospital_id,'service_team_id'=>$serviceTeam["id"]])->toArray();
                            if(!empty($patientdata)){
                                continue;
                            }
                            $insertData[$i]['patient_id'] = trim($val->id);
                            $insertData[$i]['hospital_id'] = $val->hospital_id;
                            $insertData[$i]['service_team_id'] = $serviceTeam["id"];
                            $i++;
                        }

                        if(!empty($insertData)){
                            $patientService = $this->PatientServiceTeams->newEntities($insertData);
                        
                            if($this->PatientServiceTeams->saveMany($patientService)) {
                                $response['status'] = Configure::read('SUCCESS_CODE');
                                $response['message'] = Configure::read('ADDED_CONSULT');
                            }else{
                                $response['status'] = Configure::read('SERVER_ERROR_CODE');
                                $response['message'] = Configure::read('SERVER_ERROR');
                            }
                        }else{
                            $response['status'] = Configure::read('SUCCESS_CODE');
                            $response['message'] = Configure::read('ADDED_CONSULT');
                        }

                    }else{
                        $response['status'] = Configure::read('SERVER_ERROR_CODE');
                        $response['message'] = Configure::read('INVALID_TEAM');
                    }

                } else {

                    $i=0;
                    $insertData = array();
                    foreach($patientIds as $val){
                            
                        if($this->EmployeesPatients->checkEmployeePatients($data['employee_id'],trim($val))){
                                continue;
                        }

                        $insertData[$i]['patient_id'] = trim($val);
                        $insertData[$i]['employee_id'] = $data['employee_id'];
                        $insertData[$i]['is_menual'] = 1;
                        $i++;
                    }

                    if(empty($insertData)){
                        $response['status'] = Configure::read('BAD_REQUEST_CODE');
                        $response['message'] = Configure::read('ALREADY_IN_CONSULT');
                    } else {
                        $employeesPatients = $this->EmployeesPatients->newEntities($insertData);
                        if($this->EmployeesPatients->saveMany($employeesPatients)) {
                            $response['status'] = Configure::read('SUCCESS_CODE');
                            $response['message'] = Configure::read('ADDED_CONSULT');
                        }else{
                            $response['status'] = Configure::read('SERVER_ERROR_CODE');
                            $response['message'] = Configure::read('SERVER_ERROR');
                        }
                    }
   
                }
                  
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
        
        $this->_serialize($response);
    }


    public function removeConsultTeam(){
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['hospital_id','patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){

                $patientIds = explode(',', $data['patient_id']);
                if(isset($data['service_team_id']) && !empty($data['service_team_id'])){
                    
                    $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');

                    foreach($patientIds as $val){
                        $this->PatientServiceTeams->deleteAll(
                            [
                                'service_team_id' => $data['service_team_id'], 
                                'patient_id' => trim($val),
                                'hospital_id' => $data['hospital_id']
                            ],
                            false
                        );
                    }

                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('CONSULT_TEAM_REMOVE');


                } else {
                    $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
                    foreach($patientIds as $val){
                        $patientsData = $this->EmployeesPatients->find('all')->where(['employee_id' => $data['employee_id'], 'patient_id' => trim($val)])->first();
                        
                        if(!empty($patientsData)) {
                            $patientsData->is_deleted = 1;
                            $this->EmployeesPatients->save($patientsData);
                        } else {
                            $insertData = array();                    
                            $insertData['patient_id'] = $data['patient_id'];
                            $insertData['employee_id'] = $data['employee_id'];
                            $insertData['is_deleted'] = 1;
                            $employeesPatients = $this->EmployeesPatients->newEntity($insertData);
                            $this->EmployeesPatients->save($employeesPatients);
                        }    
                    }

                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('CONSULT_TEAM_REMOVE');
                }
            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }

        $this->_serialize($response);
    }

    public function editPatientName(){
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id', 'firstname','lastname'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->Patients = TableRegistry::get('Patients');
                $patients = $this->Patients->get($data['patient_id']);
                
                $patients = $this->Patients->patchEntity($patients, $data);
                
                if($this->Patients->save($patients)) {
                    $response['status'] = Configure::read('SUCCESS_CODE');
                    $response['message'] = Configure::read('PATIENT_UPDATE');
                } else {
                    $response['status'] = Configure::read('SERVER_ERROR_CODE');
                    $response['message'] = Configure::read('SERVER_ERROR');
                }

            } else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
        }
       
        $this->_serialize($response);
    }


    public function dischargePatient(){
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['patient_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
                $patientIds = explode(',', $data['patient_id']);
                
                $this->Patients = TableRegistry::get('Patients');
                $this->Patients->updateAll(
                    ['discharge ' => 1 ],
                    ['id IN' =>  $patientIds]
                );
                
                $this->PatientsBed = TableRegistry::get('PatientsBed');
                foreach($patientIds as $val){
                    $patientsBedData = $this->PatientsBed->getPatientsBed(trim($val));
                    if(empty($patientsBedData)){
                        continue;
                    }else{
                        if($patientsBedData["status"]=="WAITING"){
                            $bedData = $this->PatientsBed->get($patientsBedData['id']);
                            $this->PatientsBed->delete($bedData);
                        }else{
                            $waitingData = $this->PatientsBed->getWaitingDetails($patientsBedData['hospital_bed_id']);

                            if(empty($waitingData)){
                                $bedData = $this->PatientsBed->get($patientsBedData['id']);
                                $this->PatientsBed->delete($bedData);
                            }else{
                                $bedData = $this->PatientsBed->get($patientsBedData['id']);
                                $this->PatientsBed->delete($bedData);

                                $waitData = $this->PatientsBed->get($waitingData['id']);
                                
                                $data =array();
                                $data['patient_id'] = $waitingData['patient_id'];
                                $data['hospital_bed_id'] = $waitingData['hospital_bed_id'];
                                $data['status'] = "OCCUPIED";

                                $patientsBed = $this->PatientsBed->patchEntity($waitData,$data);
                                $this->PatientsBed->save($patientsBed);
                            }
                        }
                    }
                }
                
                
                $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
                $this->EmployeesPatients->deleteAll(['patient_id IN' => $patientIds]);

                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('PATIENT_UPDATE');
            }  else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
                $response['status'] = Configure::read('FORBIDDEN_CODE');
                $response['message'] = Configure::read('FORBIDDEN');
        }
        
        $this->_serialize($response);
    }


    public function getBeds(){
        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['hospital_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
    
                $this->HospitalBeds = TableRegistry::get('HospitalBeds');
                $beds =  $this->HospitalBeds->getBedDetails($data['hospital_id']);
                
                $response['status'] = Configure::read('SUCCESS_CODE');
                $response['message'] = Configure::read('SUCCESS');
                $response['data'] = $beds;

            }  else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
                $response['status'] = Configure::read('FORBIDDEN_CODE');
                $response['message'] = Configure::read('FORBIDDEN');
        }
        
        $this->_serialize($response);
    }


    public function addPatient(){

        if($this->request->data){
            $data = $this->request->data;
            $mendatoryParameters = ['firstname','lastname','hospital_id','hospital_bed_id'];
    
            if($this->_checkRequestData($mendatoryParameters,$data)){
                
                $this->PatientsBed = TableRegistry::get('PatientsBed');
                
                if($this->PatientsBed->isWaiting($data['hospital_bed_id'])){

                    $waitingDetails =  $this->PatientsBed->getDetails($data['hospital_bed_id']);
                    $response['status'] = Configure::read('BAD_REQUEST_CODE');
                    $response['message'] = "Patient ".$waitingDetails["patient_name"] . " is already waiting for this bed. Please try another bed";

                } else {

                    $this->Patients = TableRegistry::get('Patients');

                    $insertData["firstname"]=$data["firstname"];
                    $insertData["lastname"]=$data["lastname"];
                    $insertData["hospital_id"]=$data["hospital_id"];

                    $patients = $this->Patients->newEntity($insertData);
                    $result = $this->Patients->save($patients);
                    if($result) {

                        $details =  $this->PatientsBed->getDetails($data['hospital_bed_id']);

                        $bedData = array();
                        
                        $bedData["patient_id"] = $result->id;
                        $bedData["hospital_bed_id"]=$data["hospital_bed_id"];
                        $bedData["status"]= (count($details) > 0) ? "WAITING" : "OCCUPIED";
 
                        $patientsBed = $this->PatientsBed->newEntity($bedData);
                        $this->PatientsBed->save($patientsBed);
                        $response['status'] = Configure::read('SUCCESS_CODE');
                        $response['message'] = Configure::read('PATIENT_SAVE');
                    } else {
                        $response['status'] = Configure::read('SERVER_ERROR_CODE');
                        $response['message'] = Configure::read('SERVER_ERROR');
                    }
  
                }

            }  else {
                $response['status'] = Configure::read('BAD_REQUEST_CODE');
                $response['message'] = Configure::read('INSUFFICIENT_PARAMETERS');
            }
        } else {
                $response['status'] = Configure::read('FORBIDDEN_CODE');
                $response['message'] = Configure::read('FORBIDDEN');
        }

        $this->_serialize($response);
    }

    public function _getEncodedSecureToken($key,$secret,$user_id = ''){
        $value = $secret.'_'.$key.'_'.$user_id.'_'.time();
        $result = Security::encrypt($value, base64_decode(Configure::read('SERVER_KEY')));
        return base64_encode($result);
    }

    public function _getDecodedSecureToken($cipher){
        $result = Security::decrypt(base64_decode($cipher), base64_decode(Configure::read('SERVER_KEY')));
        return $result;
    }
    
    public function setEmployeeData($employee) {
        if(!empty($employee)) {
            $employee->app_token  = $employee->app_token;
            $employee->photo_name = $employee->photo;
            $employee->photo      = (!empty($employee->photo) && file_exists(Configure::read('UPLOAD_EMPLOYEE_ORIGINAL_IMAGE_PATH').$employee->photo)) ? Configure::read('UPLOAD_EMPLOYEE_ORIGINAL_IMAGE_URL').$employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
            $employee->photo_thumb = (!empty($employee->photo)) ? $employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
            return $employee;
        }
        return [];
    }

    // ------------------------------------------------------------------------------------
    // LDAP Connectivity
    // ------------------------------------------------------------------------------------

    public function checkUserInLDAP($username, $password, $ldaphost = '')
    {
        // using ldap bind
        $ldaprdn = $username; // ldap rdn or dn
        $ldappass = $password; // associated password
        
        if ($ldaphost == '') {
            $ldaphost = 'ldap.forumsys.com';
            $ldaprdn = "uid=$username,dc=example,dc=com"; // ldap rdn or dn
        }
        // connect to ldap server
        // $ldapconn = ldap_connect(Configure::read('LADAP_HOST'));
        $ldapconn = ldap_connect($ldaphost);
        
        if (! $ldapconn)
            return false;
        
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
        
        // binding to ldap server
        // $ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass);
        return @ldap_bind($ldapconn, $ldaprdn, $ldappass);
    }


    //------------------------------------------------------------------------------------
    // Utility Functions
    // ------------------------------------------------------------------------------------
    public function _getGUID() {
        mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid = substr($charid, 0, 8)
                . substr($charid, 8, 4)
                . substr($charid, 12, 4)
                . substr($charid, 16, 4)
                . substr($charid, 20, 12)
                . time();

        return strtolower($uuid);
    }

    public function _checkRequestMethod()
    {
        // -- check if request is POST or PUT
        if (! $this->request->is('post') && ! $this->request->is('put')) {
            $response['status'] = Configure::read('FORBIDDEN_CODE');
            $response['message'] = Configure::read('FORBIDDEN');
            
            echo json_encode($response);
            die();
        }
    }

    public function _checkRequestData($requiredfields = array(), $request_data)
    {
        $flag = 0;
        foreach ($requiredfields as $requiredfield) {
            if (! in_array($requiredfield, array_keys($request_data)) || (empty($request_data[$requiredfield]))) {
                $flag = 1;
                break;
            }
        }
        
        if ($flag == 1) {
            return false;
        } else {
            return true;
        }
    }

    public function _isUserAuthenticated($userToken) {
        $decoded_string = $this->_getDecodedSecureToken($userToken);
        $plain_text = explode("_", $decoded_string);

        if(!empty($plain_text) && count($plain_text) >= 3){
            if(!empty($plain_text[0]) && !empty($plain_text[1])){
                if(!empty($plain_text[2]) && !is_numeric($plain_text[2]))
                    return false;

                $this->Users = TableRegistry::get('Users');
                if($this->Users->checkUserExistByCredentials($plain_text[0],$plain_text[1],$plain_text[2]))
                    return true;
                else
                    return false;
            }
        }
    }

    public function _isEmployeeAuthenticated($token){
        $this->Employees = TableRegistry::get('Employees');
        if($this->Employees->authenticatedByToken($token))
            return true;
        else 
            return false;
    }

    public function _isValidAssessmentAuthenticated($assessment){
        $this->Assessments = TableRegistry::get('Assessments');
        $result = $this->Assessments->validateAssessmentByName($assessment);
        if(!empty($result))
            return true;
        else
            return false;
    }

    public function _getIpAddress(){
        $ipaddress = '';
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(!empty($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(!empty($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(!empty($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
      
        return $ipaddress;
    }

    public function _getIpLocation($ip){
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
        if($query && $query['status'] == 'success') {
          return $query['country'];
        } else {
          return false;
        }
    }

    public function decodeData($data) {
        $result = JWT::decode($data, Configure::read('JWT_KEY'), array('HS256'));
        return json_decode(json_encode($result), True);
    }
    
    public function _serialize($response)
    {
        $token = [
            'status' => $response['status'],
            'message' => $response['message']
        ];
        
        if(isset($response['data'])) {
            $token['data'] = $response['data'];
        }
        
        $jwt = JWT::encode($token, Configure::read('JWT_KEY'));
        $this->set(array(
            'encript' => $jwt,
            '_serialize' => array(
                'encript'
            )
        ));
    }
}