<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Hash;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->layout('Admin.default');
        $this->loadComponent('Twilio');
    }
    
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['login', 'forgotPassword', 'changePassword', 'changePasswordEmployee', 'logout', 'sendOtp', 'resendOtp']);
    }

    /**
     * Login method
     *
     * @return \Cake\Network\Response|null
     */
    public function login()
    {
        if($this->Auth->user())
            return $this->redirect($this->Auth->redirectUrl());
        
        $this->viewBuilder()->layout('Admin.login');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $otp = $this->_generateString(6);
                $this->Users->updateAll(['otp' => $otp], ['id' => $user['id']]);
                if(!empty($user['country_code']) && !empty($user['phone_number'])) {
                    //$this->Twilio->sendSms($user['country_code'].$user['phone_number'], $otp);
                }
                
                $data['full_name'] = $user['firstname'].' '.$user['lastname'];
                $data['email'] = $user['email'];
                $data['otp'] = $otp;
                $data['subject'] = 'One Time Password';
                $data['logo_url'] = BASE_URL.'Admin/img/logos/logo.png';
                
                $result = $this->sendEmail('one_time_password',$data);
                
                $this->Flash->success(__('We have sent One Time Password to your email and mobile number.'));
                return $this->redirect(['action' => 'sendOtp', base64_encode($user['id'])]);
            }
            $this->Flash->loginError(__('Invalid username or password, try again'));
        }
    }
    
    /**
     * Login method
     *
     * @return \Cake\Network\Response|null
     */
    public function sendOtp($id=null)
    {
        if(!empty($id)) {
            $id = base64_decode($id);
            $this->viewBuilder()->layout('Admin.login');
           
            if ($this->request->is('post')) {
                $user = $this->Users->find('all')->contain(['UsersHospitals.Hospitals', 'UsersFloors.Floors', 'UsersDepartments.Departments' ])->where(['Users.id' => $id])->hydrate(false)->first();
                if ($user & $user['otp'] == $this->request->data['otp']) {
                    $this->Users->updateAll(['otp' => ''], ['id' => $user['id']]);
                    $user['hospitals'] = [];
                    if($user['role_id'] == 3 || $user['role_id'] == 4 || $user['role_id'] == 5){
                        if(!empty($user['users_hospital']['hospital']))
                        {
                            $user['hospitals'] = $user['users_hospital']['hospital'];
                            unset($user['users_hospital']);
                        }
                    }
                    if($user['role_id'] == 4) {
                        $this->redirect("/patients");
                    }
                    if($user['role_id'] == 5) {
                        $this->redirect("/EmployeesSchedules");
                    }
    
                    $this->Auth->setUser($user);
                    return $this->redirect($this->Auth->redirectUrl());
                }
                $this->Flash->loginError(__('Invalid opt you have entered, try again'));
            }
            $this->set(compact('id'));
        } else {
            return $this->redirect($this->Auth->redirectUrl());
        }
    }
    
    public function resendOtp($id) {
        if(!empty($id)) {
            $id = base64_decode($id);
            $user = $this->Users->find('all')->where(['Users.id' => $id])->hydrate(false)->first();
            if(!empty($user)) {
                $otp = $this->_generateString(6);
                $this->Users->updateAll(['otp' => $otp], ['id' => $user['id']]);
                if(!empty($user['country_code']) && !empty($user['phone_number'])) {
                    //$this->Twilio->sendSms($user['country_code'].$user['phone_number'], $otp);
                }
                
                $data['full_name'] = $user['firstname'].' '.$user['lastname'];
                $data['email'] = $user['email'];
                $data['otp'] = $otp;
                $data['subject'] = 'One Time Password';
                $data['logo_url'] = BASE_URL.'Admin/img/logos/logo.png';
                
                $result = $this->sendEmail('one_time_password',$data);
                
                $this->Flash->success(__('We have sent One Time Password to your email and mobile number.'));
                return $this->redirect(['action' => 'sendOtp', base64_encode($user['id'])]);
            } else {
                $this->Flash->loginError(__('We can not find user information, try again'));
            }
        } else {
            return $this->redirect('/sendOtp/'.base64_encode($id));
        }
    }
    
    /**
     * Login method
     *
     * @return \Cake\Network\Response|null
     */
    public function forgotPassword($id = null)
    {
        $this->viewBuilder()->layout('Admin.forgot_password');
        
        $this->Employees = TableRegistry::get('Employees');
        
        $employee = $this->Employees->get($this->decrypt($id));
        
        if(empty($id) || $employee->forgot_password == 0){
            throw new NotFoundException(__('You can not access this url.'));
        }
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->request->data['forgot_password'] = 0;
            $employee = $this->Employees->patchEntity($employee, $this->request->data);
            
            if ($this->Employees->save($employee)) {
                $this->Flash->forgotSuccess(__('Your password has been changed successfully.'));
                return $this->redirect(['action' => 'login']);
            }
            
            $this->Flash->loginError(__('The password could not be saved. Please, try again.'));
        }
        
        $this->set(compact('employee'));
        $this->set('_serialize', ['employee']);
    }

    /**
     * Logout method
     *
     * @return \Cake\Network\Response|null
     */
    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->accessUrl();
        $search = "";
        $users = [];
        $conditions = [];

        if($this->Auth->user()['role_id'] == 3) {
           $conditions += [
               'Users.role_id IN' => [3, 4, 5],
               'OR'=> [
                   'Users.id' => $this->Auth->user()['id'],
                   'Users.admin_user' => $this->Auth->user()['id'],
               ]
           ];
        } elseif($this->Auth->user()['role_id'] == 4) {
            $conditions += ['Users.role_id' => 4];
        } elseif($this->Auth->user()['role_id'] == 1 || $this->Auth->user()['role_id'] == 2) {
            $conditions += ['Users.role_id IN' => [1, 2, 3]];
        }
        
        if($this->request->query){
            $search = !empty($this->request->query['search']) ? $this->request->query['search'] : "";
            $conditions += [
                'OR'=> [
                    "Users.email LIKE '%".trim(strtolower($search))."%'",
                    "Users.firstname LIKE '%".$search."%'",
                    "Users.lastname LIKE '%".$search."%'"
                ]
            ];
        }
        
        //$this->UsersHospitals = TableRegistry::get('UsersHospitals');
        $this->paginate = [
            'conditions' => [
                $conditions
            ],
            'contain' => [
                'Roles'
            ],
            'limit' => 10,
            'sortWhitelist' => ['Users.email', 'Users.firstname', 'Users.role_id' ]
        ];
        try{
            $users = $this->paginate($this->Users);
        } catch(NotFoundException $e){
            $user = $this->Users->newEntity();
        }

        $this->set(compact('users','search'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->accessUrl();
        $this->viewBuilder()->layout(false);
        $user = $this->Users->get($id, [
            'contain' => ['Roles', 'UsersHospitals.Hospitals', 'UsersDepartments.Departments', 'UsersFloors.Floors']
        ]);
        
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->accessUrl();
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            if($this->request->data['role_id'] == 4) {
                unset($this->request->data['departments']);
            }
            
            if($this->request->data['role_id'] == 5) {
                unset($this->request->data['floors']);
            }
            
            if(!empty($this->request->data['floors'])) {
                foreach ($this->request->data['floors'] as $val) {
                    $this->request->data['users_floors'][]['floor_id'] = $val;
                }
            }
            
            if(!empty($this->request->data['departments'])) {
                foreach ($this->request->data['departments'] as $val) {
                    $this->request->data['users_departments'][]['department_id'] = $val;
                }
            }
            
            $user = $this->Users->patchEntity($user, $this->request->data);
            
            if ($this->Users->save($user,['associated' => ['UsersHospitals', 'UsersDepartments', 'UsersFloors']])) {
                $this->Flash->success(__('The user has been saved.'),['key' => 'positive']);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'),['key' => 'negative']);
         }
        
        if($this->Auth->user()['role_id'] == 1) {
            $roles = $this->Users->Roles->find('list', ['keyField' => 'id','valueField' => 'name', 'conditions' => ['Roles.id ' => 3 ], 'limit' => 20])->toArray();
        } else { 
            $roles = $this->Users->Roles->find('list', ['keyField' => 'id','valueField' => 'name', 'conditions' => ['Roles.id >' => 3 ],'limit' => 20])->toArray();
        }
        
        $this->Hospitals = TableRegistry::get('Hospitals');
        $hospitals = $this->Hospitals->find('list', ['keyField' => 'id','valueField' => 'name','limit' => 200]);
        
        $condition = [];
        if(!empty($this->Auth->user()['hospitals']['id'])) {
            $condition = ['hospital_id' => $this->Auth->user()['hospitals']['id']];
        }
        
        $this->Departments = TableRegistry::get('Departments');
        $departments = $this->Departments->find('list', ['keyField' => 'id','valueField' => 'name','limit' => 200]);
        
        $this->Floors = TableRegistry::get('Floors');
        $floors = $this->Floors->find('list', ['keyField' => 'id','valueField' => 'name','limit' => 200])->where($condition);
        
        
        $this->set(compact('user', 'roles', 'hospitals', 'departments', 'floors'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if($id != $this->Auth->user()['id']) {
            $this->accessUrl();
        }
        $user = $this->Users->find('all')->contain(['UsersHospitals', 'UsersDepartments', 'UsersFloors'])->where(['Users.id' => $id])->first();
        /* $user = $this->Users->get($id, [
            'contain' => ['UsersHospitals', 'UsersDepartments']
        ]); */
        //pr($user); die;
        if ($this->request->is(['patch', 'post', 'put'])) {
            
           if(empty($this->request->data['password']))
                unset($this->request->data['password']);

            if(!empty($this->request->data['floors'])) {
                $this->UsersFloors = TableRegistry::get('UsersFloors');
                $this->UsersFloors->deleteAll(['user_id' => $user->id]);
                foreach ($this->request->data['floors'] as $val) {
                    $this->request->data['users_floors'][]['floor_id'] = $val;
                }
            }
            
            
            if($this->Auth->user()['role_id'] == 4 || $this->Auth->user()['role_id'] == 5) {
                unset($this->request->data['phone_number']);
            } 
            
            if(!empty($this->request->data['departments'])) {
                $this->UsersDepartments = TableRegistry::get('UsersDepartments');
                $this->UsersDepartments->deleteAll(['user_id' => $user->id]);
                foreach ($this->request->data['departments'] as $val) {
                    $this->request->data['users_departments'][]['department_id'] = $val;
                }
            }
            $user = $this->Users->patchEntity($user, $this->request->data);
            
            if ($this->Users->save($user,['associated' => ['UsersDepartments', 'UsersFloors']])) {
                $this->Flash->success(__('The user has been saved.'),['key' => 'positive']);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'),['key' => 'negative']);
        }

        if($this->Auth->user()['role_id'] == 1) {
            $roles = $this->Users->Roles->find('list', ['limit' => 20]);
        } else { 
            $roles = $this->Users->Roles->find('list', ['conditions' => ['Roles.id >' => 3],'limit' => 20]);
        }
        
        $condition = [];
        if(!empty($this->Auth->user()['hospitals']['id'])) {
            $condition = ['hospital_id' => $this->Auth->user()['hospitals']['id']];
        }
        
        $this->Departments = TableRegistry::get('Departments');
        $departments = $this->Departments->find('list', ['keyField' => 'id','valueField' => 'name','limit' => 200]);
        
        $this->Hospitals = TableRegistry::get('Hospitals');
        $hospitals = $this->Hospitals->find('list', ['keyField' => 'id','valueField' => 'name','limit' => 200]);
        
        $this->Floors = TableRegistry::get('Floors');
        $floors = $this->Floors->find('list', ['keyField' => 'id','valueField' => 'name','limit' => 200])->where($condition);
        
        $userDepartments = !empty($user['users_departments']) ? Hash::extract($user['users_departments'], '{n}.department_id') : [];
        $userFloors = !empty($user['users_floors']) ? Hash::extract($user['users_floors'], '{n}.floor_id') : [];
        
        $this->set(compact('user', 'roles', 'hospitals', 'departments', 'userDepartments', 'floors', 'userFloors'));
        $this->set('_serialize', ['user']);
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
        $this->accessUrl();
        $this->viewBuilder()->layout(false);
        if($this->request->data){
            $data = $this->request->data;
            $user = $this->Users->get($data['id']);
            $user->is_active = ($data['state'] == 'true') ? 1 : 0;
            if ($this->Users->save($user)) {
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
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->accessUrl();
        $user = $this->Users->get($id, [
            'contain' => ['UsersHospitals', 'UsersDepartments', 'UsersFloors']
        ]);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'),['key' => 'positive']);
        } else {
            $this->Flash->success(__('The user could not be deleted. Please, try again.'),['key' => 'positive']);
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Check unique email method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function checkUniqueEmail()
    {
        $this->accessUrl();
        $this->viewBuilder()->layout(false);
        if($this->request->is('post')) {
            $data = $this->request->data;
            $userId = !empty($data['user_id']) ? $data['user_id'] : 0; 
            $result = $this->Users->isEmailExist($data['email'], $userId);
            if(!empty($result)){
                echo "false";
            } else {
                echo "true";
            }
        }
        die;
    }
    
/**
     * Export csv method
     *
     * @return download csv file of all data
     */
    public function exportLists()
    {
        $this->accessUrl();
        $users = $this->Users->find('all')
            ->contain('Roles')
            ->where(['Users.role_id IN' => [0 => 3, 1 => 4]])
            ->order('Users.created DESC')
            ->toArray();
         
        $head = [
            'Name',
            'Email',
            'Role',
            'Status',
            'Created'
        ];
    
        $this->CSV->clear();
        $this->CSV->addRow($head);
        if(!empty($users)) {
            foreach ($users as $user) {
                $line = [
                    'Name' => $user->full_name,
                    'Email' => $user->email,
                    'Role' => $user->role->name,
                    'Status' => $user->is_active == 1 ? 'Active' : 'Inactive',
                    'Created' => $user->created
                ];
    
                $this->CSV->addRow($line);
            }
        }
    
        echo  $this->CSV->render('users');
        die;
    }
    
    public function resetPassword($id)
    {
        $user = $this->Users->findById($id)->first();
        if (empty($user)) {
            $this->Flash->success(__('The User does not exist. Please try again'), ['key' => 'negative']);
        } else {
            $passkey = uniqid();
            $url = BASE_URL."users/change-password/".$passkey;
            $timeout = time() + DAY;
            if ($this->Users->updateAll(['passkey' => $passkey, 'timeout' => $timeout], ['id' => $user->id])){
                
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
    
    public function changePassword($passkey = null) {
    
        $this->viewBuilder()->layout('Admin.login');
        if ($passkey) {
            $query = $this->Users->find('all', ['conditions' => ['passkey' => $passkey, 'timeout >' => time()]]);
            $user = $query->first();
            if ($user) {
                if (!empty($this->request->data)) {
                    // Clear passkey and timeout
                    $this->request->data['passkey'] = null;
                    $this->request->data['timeout'] = null;
                    $user = $this->Users->patchEntity($user, $this->request->data);
                    if ($this->Users->save($user)) {
                        $type = 1;
                        $message = __('You have successfully updated your password.');
                    } else {
                        $type = 2;
                        $message = __('The password could not be updated. Please, try again.');
                    }
                    $this->set(compact('type', 'message'));
                    $this->viewBuilder()->template('/Users/reset_password_message');
                }
            }/*  else {
                $type = 2;
                $message = __('Invalid or expired token. Please check your email or try again');
                $this->set(compact('type', 'message'));
                $this->viewBuilder()->template('/Users/reset_password_message');
            } */
            unset($user->password);
            $this->set(compact('user'));
        } else {
            $type = 2;
            $message = __('Invalid or expired token. Please check your email or try again');
            $this->set(compact('type', 'message'));
            $this->viewBuilder()->template('/Users/reset_password_message');
        }
    }
    
    public function changePasswordEmployee($passkey = null) {
    
        $this->Employees = TableRegistry::get('Employees');
        $this->viewBuilder()->layout('Admin.login');
        if ($passkey) {
            $employee = $this->Employees->find('all', ['conditions' => ['passkey' => $passkey, 'timeout >' => time()]])->first();
            if ($employee) {
                if (!empty($this->request->data)) {
                    // Clear passkey and timeout
                    $this->request->data['passkey'] = null;
                    $this->request->data['timeout'] = null;
                    $employee = $this->Employees->patchEntity($employee, $this->request->data);
                    if ($this->Employees->save($employee)) {
                        $type = 1;
                        $message = __('You have successfully updated your password.');
                    } else {
                        $type = 2;
                        $message = __('The password could not be updated. Please, try again.');
                    }
                    $this->set(compact('type', 'message'));
                    $this->viewBuilder()->template('/Users/reset_password_message');
                }
            } else {
                $type = 2;
                $message = __('Invalid or expired token. Please check your email or try again');
                $this->set(compact('type', 'message'));
                $this->viewBuilder()->template('/Users/reset_password_message');
            }
            unset($employee->password);
            $this->set(compact('employee'));
        } else {
            $type = 2;
            $message = __('Invalid or expired token. Please check your email or try again');
            $this->set(compact('type', 'message'));
            $this->viewBuilder()->template('/Users/reset_password_message');
        }
    }
}
