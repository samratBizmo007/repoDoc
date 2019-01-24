<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * Employees Controller
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 */
class EmployeesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        
        $this->viewBuilder()->layout('Admin.default');
        $this->loadComponent('Firebase');
        $this->accessUrlOffice();
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($department = "")
    {
        $search = "";
        $users = [];
        $conditions = [];
        
        if($this->Auth->user()['role_id'] == 3 || $this->Auth->user()['role_id'] == 5) {
            $conditions += ['Employees.hospital_id' => $this->Auth->user()['hospitals']['id']];
        }
        
        if(!empty($this->Auth->user('users_departments'))) {
            $depNames = Hash::extract($this->Auth->user('users_departments'), '{n}.department.name');
            if(!empty($depNames)) {
                $conditions += ["Employees.department IN" =>  $depNames];
            }
        }
        
        
        if(!empty($department)) {
            $conditions += ["Employees.department LIKE" =>  '%'.$department.'%'];
        }
        
        if($this->request->query){
            $search = !empty($this->request->query['search']) ? $this->request->query['search'] : "";
            $conditions += [
                'OR'=> [
                    "Employees.firstname LIKE '%".$search."%'",
                    "Employees.lastname LIKE '%".$search."%'"
                ]
            ];
        }

        try{
           /*  $this->paginate = [
                'conditions' => $conditions,
                'order' => ['Employees.created' => 'desc'],
                'limit' => 10
            ];

            $employees = $this->paginate($this->Employees); */
            $employees = $this->paginate($this->Employees,[
                'contain' => 'EmployeesSchedules',
                'conditions' => $conditions,
                'limit' => 10,
                'order' => ['Employees.created' => 'desc']
            ]);

        }catch(NotFoundException $e){
            $employees = $this->Employees->newEntity();
        }

        $depConditions = [];
        if(!empty($this->Auth->user('users_departments'))) {
            $depIds = Hash::extract($this->Auth->user('users_departments'), '{n}.department.id');
            if(!empty($depIds)) {
                $depConditions += ['id IN' => $depIds];
            }
        }
        
        $this->Departments = TableRegistry::get('Departments');
        $departments = $this->Departments->find('list', ['keyField' => 'name','valueField' => 'name','limit' => 200])->where($depConditions);
        
        $this->set(compact('employees','search', 'departments', 'department'));
        $this->set('_serialize', ['employees','search']);
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->layout(false);
        
        $employee = $this->Employees->get($id, [
            'contain' => ['Patients', 'Diagnoses', 'Followups', 'HospitalsEmployees','HospitalsEmployees.Hospitals','HospitalsEmployees.ServiceTeams']
        ]);
        
        $this->set('employee', $employee);
        $this->set('_serialize', ['employee']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employee = $this->Employees->newEntity();
        if ($this->request->is('post')) {
            
            if(!empty($this->request->data['photo'])){
                $photo = $this->Employees->uploadProfilePhoto($this->request->data['photo']);
                $this->request->data['photo'] = $photo;
            }
        
            $department = TableRegistry::get('Departments');
            $subDepartment = TableRegistry::get('SubDepartments');
            $employeeRoles = TableRegistry::get('EmployeeRoles');
            
            if(!empty($this->request->data['department'])) {
                $departmentData = $department->get($this->request->data['department']);
            
                $this->request->data['department'] = $departmentData->name;
                $this->request->data['department_short'] = $departmentData->short_name;
            }
            
            if(!empty($this->request->data['employee_role'])) {
                $employeeRoleData = $employeeRoles->get($this->request->data['employee_role']);
            
                $this->request->data['employee_role'] = $employeeRoleData->name;
                $this->request->data['employee_role_short'] = $employeeRoleData->short_name;
            }
            
            if(!empty($this->request->data['sub_department'])) {
                $subDepartmentData = $subDepartment->get($this->request->data['sub_department']);
            
                $this->request->data['sub_department'] = $subDepartmentData->name;
            }
            
            if(empty($this->request->data['hospitals_employees']['0']['service_team_id'])) {
                unset($this->request->data['hospitals_employees']);
            }
            
            $employee = $this->Employees->patchEntity($employee, $this->request->data);
            
            if ($result = $this->Employees->save($employee, ['associated' => [ 'HospitalsEmployees']])) {
                    /* $addArr = [
                        'name' => $result->full_name,
                        'photo' => Configure::read('UPLOAD_EMPLOYEE_ORIGINAL_IMAGE_URL').$photo,
                        'employee_role' => $result->employee_role,
                        'employee_role_short' => $result->employee_role_short,
                        'userId' => (string)$result->id,
                    ];
                $this->Firebase->set('Users/'.$result->id,$addArr); */
                $this->Flash->success(__('The employee has been saved.'),['key' => 'positive']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'),['key' => 'negative']);
                
       }
        
        $this->EmployeeRoles = TableRegistry::get('EmployeeRoles');
        $employee_roles = $this->EmployeeRoles->find('list', ['keyField' => 'id','valueField' => 'name','limit' => 200]);
        $this->Designations = TableRegistry::get('Designations');
        $designations = $this->Designations->find('list', ['keyField' => 'name','valueField' => 'name','limit' => 200]);
        
        $depConditions = [];
        if(!empty($this->Auth->user('users_departments'))) {
            $depIds = Hash::extract($this->Auth->user('users_departments'), '{n}.department.id');
            if(!empty($depIds)) {
                $depConditions += ['id IN' => $depIds];
            }
        }
        
        $this->Departments = TableRegistry::get('Departments');
        $departments = $this->Departments->find('list', ['keyField' => 'id','valueField' => 'name','limit' => 200])->where($depConditions);
        $this->Titles = TableRegistry::get('Titles');
        $titles = $this->Titles->find('list', ['keyField' => 'name','valueField' => 'name','limit' => 200]);
        
        $serConditions = [];
        if($this->Auth->user()['role_id'] == 3 || $this->Auth->user()['role_id'] == 4) {
            $serConditions = ['hospital_id' => $this->Auth->user()['hospitals']['id']];
        }
        
        $this->ServiceTeams = TableRegistry::get('ServiceTeams');
        $serviceTeams = $this->ServiceTeams->find('list', ['limit' => 200])->where($serConditions);
        
        $this->set(compact('employee','employee_roles','designations','departments','titles', 'serviceTeams'));
        $this->set('_serialize', ['employee']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employee = $this->Employees->get($id,[ 'contain' => ['HospitalsEmployees']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if(!empty($this->request->data['photo']['name'])){
                $this->request->data['photo'] = $this->Employees->uploadProfilePhoto($this->request->data['photo'],$this->request->data['old_photo']);
            }
            else
                unset($this->request->data['photo']);

            if(empty($this->request->data['password']))
                unset($this->request->data['password']);
            
            if(empty($this->request->data['hospitals_employees']['0']['service_team_id'])) {
                unset($this->request->data['hospitals_employees']);
            } else {
                $current_user = $this->Auth->user();
                if(!empty($current_user['hospitals']['id'])) {
                    $this->request->data['hospitals_employees']['0']['hospital_id'] = $current_user['hospitals']['id'];
                }
            }
            
            if(!empty($this->request->data['employee_role'])) {
                $employeeRoles = TableRegistry::get('EmployeeRoles');
                $employeeRoleData = $employeeRoles->get($this->request->data['employee_role']);
            
                $this->request->data['employee_role'] = $employeeRoleData->name;
                $this->request->data['employee_role_short'] = $employeeRoleData->short_name;
            }
            
            $employee = $this->Employees->patchEntity($employee, $this->request->data);
            
            if ($this->Employees->save($employee, ['associated' => [ 'HospitalsEmployees']])) {
                $this->Flash->success(__('The employee has been saved.'),['key' => 'positive']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'),['key' => 'negative']);
        }

        $this->EmployeeRoles = TableRegistry::get('EmployeeRoles');
        $employee_roles = $this->EmployeeRoles->find('list', ['keyField' => 'id','valueField' => 'name','limit' => 200]);
        $this->Designations = TableRegistry::get('Designations');
        $designations = $this->Designations->find('list', ['keyField' => 'name','valueField' => 'name','limit' => 200]);
        
        $depConditions = [];
        if(!empty($this->Auth->user('users_departments'))) {
            $depIds = Hash::extract($this->Auth->user('users_departments'), '{n}.department.id');
            if(!empty($depIds)) {
                $depConditions += ['id IN' => $depIds];
            }
        }
        
        $this->Departments = TableRegistry::get('Departments');
        $departments = $this->Departments->find('list', ['keyField' => 'name','valueField' => 'name','limit' => 200])->where($depConditions);
        $this->SubDepartments = TableRegistry::get('SubDepartments');
        $departmentDetail = $this->Departments->findByName($employee['department'])->first();
        $sub_departments = [];
        if(!empty($departmentDetail)) {
            $sub_departments = $this->SubDepartments->find('list', ['keyField' => 'name','valueField' => 'name'])->where(['department_id' => $departmentDetail->id]);
        }
        $employeeRole = $this->EmployeeRoles->find('all')->select(['id'])->where(['EmployeeRoles.name' => $employee->employee_role])->first();
        
        $employee_role =''; 
        if(!empty($employeeRole)) {
            $employee_role = $employeeRole->id; 
        }
        $this->Titles = TableRegistry::get('Titles');
        $titles = $this->Titles->find('list', ['keyField' => 'name','valueField' => 'name','limit' => 200]);
        
        $serConditions = [];
        if($this->Auth->user()['role_id'] == 3 || $this->Auth->user()['role_id'] == 4) {
            $serConditions = ['hospital_id' => $this->Auth->user()['hospitals']['id']];
        }
        $this->ServiceTeams = TableRegistry::get('ServiceTeams');
        $serviceTeams = $this->ServiceTeams->find('list', ['limit' => 200])->where($serConditions);
        
        $this->set(compact('employee','employee_roles','designations','departments', 'sub_departments', 'titles', 'serviceTeams','employee_role'));
        $this->set('_serialize', ['employee']);
    }

    public function getSubDepartment() {
        
        $optionStr = "<option value=''>Please select Sub department</option>";
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->SubDepartments = TableRegistry::get('SubDepartments');
            
            $departments = $this->SubDepartments->find('list', ['keyField' => 'id','valueField' => 'name','limit' => 200])->where(['department_id' => $this->request->data['department']])->toArray();
            
            if(!empty($departments)) {
                foreach ($departments as $key => $val) {
                    //echo "<option value='".$key."'>".$val."</option>"; die;
                    $optionStr .= "<option value='".$key."'>".$val."</option>";
                }
            }
        }
        
        echo $optionStr; 
        exit;
    }
    
    public function getSubDepartmentEdit() {
        $optionStr = "<option value=''>Please select Sub department</option>";
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->SubDepartments = TableRegistry::get('SubDepartments');
            $this->Departments = TableRegistry::get('Departments');
            $departmentDetail = $this->Departments->findByName($this->request->data['department'])->first();
            $sub_departments = $this->SubDepartments->find('list', ['keyField' => 'name','valueField' => 'name'])->where(['department_id' => $departmentDetail->id]);
            
          if(!empty($sub_departments)) {
                foreach ($sub_departments as $key => $val) {
                    //echo "<option value='".$key."'>".$val."</option>"; die;
                    $optionStr .= "<option value='".$key."'>".$val."</option>";
                }
            }
        }
    
        echo $optionStr;
        exit;
    }

    /**
     * Change status method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function changeStatus()
    {   
        $this->viewBuilder()->layout(false);
        if($this->request->data){
            $data = $this->request->data;
            $user = $this->Employees->get($data['id']);
            $user->status = ($data['state'] == 'true') ? 1 : 0;
            if ($this->Employees->save($user)) {
                echo true;
            } else {
                echo false;
            }
        } else {
            echo false;
        }
        die;
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $employee = $this->Employees->get($id);
        
        if ($this->Employees->delete($employee)) {
            if(!empty($employee->photo) && file_exists(Configure::read('UPLOAD_EMPLOYEE_ORIGINAL_IMAGE_PATH').$employee->photo))
                unlink(Configure::read('UPLOAD_EMPLOYEE_ORIGINAL_IMAGE_PATH').$employee->photo);

            if(!empty($employee->photo) && file_exists(Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_PATH').$employee->photo))
                unlink(Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_PATH').$employee->photo);

            $this->Firebase->set('DeletUsers/'.$id,['userId' => $id]);
            $this->Flash->success(__('The employee has been deleted.'),['key' => 'positive']);
        } else {
            $this->Flash->error(__('The employee could not be deleted. Please, try again.'),['key' => 'negative']);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Check unique employee method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function checkUniqueEmployeeByEmail($id = 0)
    {
        $this->viewBuilder()->layout(false);
        if($this->request->is('post')) {
            $data = $this->request->data;
            $result = $this->Employees->isEmployeeExist($data['email'], $id);
            if(!empty($result)){
                echo "false";
            } else {
                echo "true";
            }
        }
        die;
    }
    
    /**
     * Import CSV method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function importCsv()
    {
        $this->viewBuilder()->layout(false);
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if(!empty($data['csv']) && !empty($data['csv']['name'])){
                $result = $this->CSV->employee_import_csv($data['csv']['tmp_name'], 'Employees');
                
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
        $employees = $this->Employees->find('all')
        ->order('created DESC')
        ->toArray();
         
        $head = [
            'Name',
            'Email',
            'Employee Role',
            'Designation',
            'Status',
            'Created'
        ];
    
        $this->CSV->clear();
        $this->CSV->addRow($head);
        if(!empty($employees)) {
            foreach ($employees as $employee) {
                $line = [
                    'Name' => $employee->full_name,
                    'Email' => $employee->email,
                    'Employee Role' => $employee->employee_role,
                    'Designation' => $employee->designation,
                    'Status' => $employee->is_active == 1 ? 'Active' : 'Inactive',
                    'Created' => $employee->created
                ];
    
                $this->CSV->addRow($line);
            }
        }
    
        echo  $this->CSV->render('employees');
        die;
    }
    
    /**
     * Download CSV method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function downloadCsv()
    {
        $file_path = WWW_ROOT.'img/employees-sample.csv';
        $this->response->file($file_path, array(
            'download' => true,
        ));
        return $this->response;
    }
    
    public function resetPassword($id)
    {
        $user = $this->Employees->findById($id)->first();
        if (empty($user)) {
            $this->Flash->success(__('The Employee does not exist. Please try again'), ['key' => 'negative']);
        } else {
            $passkey = uniqid();
            $url = BASE_URL."users/change-password-employee/".$passkey;
            $timeout = time() + DAY;
            if ($this->Employees->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $user->id])){
    
                $data['full_name'] = !empty($user->full_name) ? $user->full_name : '';
                $data['email'] = $user->email;
                $data['url'] = $url;
                $data['subject'] = 'Reset your password';
                $data['logo_url'] = BASE_URL.'Admin/img/logos/logo.png';
    
                $result = $this->sendEmail('forgot_password',$data);
    
                $this->Flash->success(__('The email has been sent successfully.'),['key' => 'positive']);
            } else {
                $this->Flash->success(__('Error saving reset passkey/timeout'), ['key' => 'negative']);
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
