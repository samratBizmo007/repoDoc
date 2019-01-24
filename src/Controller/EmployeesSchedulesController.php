<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * EmployeesSchedules Controller
 *
 * @property \App\Model\Table\EmployeesSchedulesTable $EmployeesSchedules
 */
class EmployeesSchedulesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        
        $this->viewBuilder()->layout('Admin.default');
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
        
        $conditions = [
            'EmployeesSchedules.schedule !=' => ''
        ];
        
        if($this->Auth->user()['role_id'] == 3 || $this->Auth->user()['role_id'] == 4 || $this->Auth->user()['role_id'] == 5) {
            $conditions += ['EmployeesSchedules.hospital_id' => $this->Auth->user()['hospitals']['id']];
        }
        
        $departmentName = '';
        if(!empty($this->Auth->user('users_departments'))) {
            $departmentNames = Hash::extract($this->Auth->user('users_departments'), '{n}.department.name');
            if(!empty($departmentNames)) {
                $conditions += ["Employees.department IN" =>  $departmentNames ];
            }
            $departmentName = implode(', ', $departmentNames);
        }
        
        if(!empty($department)) {
            $conditions += ["Employees.department LIKE" =>  '%'.$department.'%'];
        }

        if($this->request->query){
            $search = !empty($this->request->query['search']) ? $this->request->query['search'] : "";
            $conditions += [
                'OR'=> [
                    "Employees.firstname LIKE '%".$search."%'",
                    "Employees.lastname LIKE '%".$search."%'",
                ]
            ];
        }

        try{
            $this->paginate = [
                'contain' => ['Employees'],
                'conditions' => $conditions,
                'order' => ['EmployeesSchedules.created' => 'desc'],
                'limit' => 10
            ];

            $employeesSchedules = $this->paginate($this->EmployeesSchedules);

        }catch(NotFoundException $e){
            $employeesSchedules = $this->EmployeesSchedules->newEntity();
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
        
        $this->set(compact('employeesSchedules','search', 'departments', 'department', 'departmentName'));
        $this->set('_serialize', ['employeesSchedules','search']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function consult($department = "")
    {
        $search = "";
        $users = [];
        $conditions = [
            'EmployeesSchedules.is_consult' => 1
        ];
        
        if($this->Auth->user()['role_id'] == 3 || $this->Auth->user()['role_id'] == 4 || $this->Auth->user()['role_id'] == 5) {
            $conditions += ['EmployeesSchedules.hospital_id' => $this->Auth->user()['hospitals']['id']];
        }
        
        $departmentName = '';
        if(!empty($this->Auth->user('users_departments'))) {
            $departmentNames = Hash::extract($this->Auth->user('users_departments'), '{n}.department.name');
            if(!empty($departmentNames)) {
                $conditions += ["Employees.department IN" =>  $departmentNames ];
            }
            $departmentName = implode(', ', $departmentNames);
        }
        
        $order = ['EmployeesSchedules.created' => 'desc'];
        if(!empty($department)) {
            $conditions += ["Employees.department LIKE" =>  '%'.$department.'%'];
            $order = ['Employees.subdepartment' => 'desc'];
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
            $this->paginate = [
                'contain' => ['Employees'],
                'conditions' => $conditions,
                'order' => $order,
                'limit' => 10
            ];
    
            $employeesSchedules = $this->paginate($this->EmployeesSchedules);
    
        }catch(NotFoundException $e){
            $employeesSchedules = $this->EmployeesSchedules->newEntity();
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
        
        
        $this->set(compact('employeesSchedules','search', 'departments', 'department', 'departmentName'));
        $this->set('_serialize', ['employeesSchedules','search']);
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
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employee = $this->EmployeesSchedules->get($id);
            $scheduleData = [];
            $i = 0;
            foreach ($this->request->data['date'] as $val) {
                $scheduleData[$val][] = [
                    'service_team' => $this->request->data['service_team'][$i],
                    'time' => $this->request->data['time'][$i]
                ];
                $i++;
            }
            
            $employee->schedule = json_encode($scheduleData, true);
            
            //$employee = $this->EmployeesSchedules->patchEntity($employee, $this->request->data);
    
            if ($this->EmployeesSchedules->save($employee)) {
                $this->Flash->success(__('The employee schedule has been saved.'),['key' => 'positive']);
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee schedule could not be saved. Please, try again.'),['key' => 'negative']);
        }
    }
    
    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function editConsult($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employee = $this->EmployeesSchedules->get($id);
            $scheduleData = [];
            $i = 0;
            
            foreach ($this->request->data['date'] as $val) {
                $scheduleData[$val][] = [
                    'department' => $this->request->data['department'][$i],
                    'subdepartment' => $this->request->data['subdepartment'][$i],
                    'time' => $this->request->data['time'][$i],
                    'is_first_call' => $this->request->data['is_first_call'][$i],
                    'is_attending' => $this->request->data['is_attending'][$i]
                ];
                $i++;
            }
    
            $employee->consult_schedule = json_encode($scheduleData, true);
    
            //$employee = $this->EmployeesSchedules->patchEntity($employee, $this->request->data);
    
            if ($this->EmployeesSchedules->save($employee)) {
                $this->Flash->success(__('The employee schedule has been saved.'),['key' => 'positive']);
                return $this->redirect(['action' => 'consult']);
            }
            $this->Flash->error(__('The employee schedule could not be saved. Please, try again.'),['key' => 'negative']);
        }
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
        $employee = $this->EmployeesSchedules->get($id, [
            'contain' => ['Employees']
        ]);
        
        $search = "";
        $schedule = json_decode($employee->schedule, true);
        
        if(!empty($employee->consult_schedule)) {
            $schedule += json_decode($employee->consult_schedule, true);
        }
       
        if($this->request->query && !empty($this->request->query['search'])){
            $search = $this->request->query['search'];
            $dates = explode(' - ', $search);
            $rangeStart = strtotime($dates[0]);
            $rangeEnd = strtotime($dates[1]);
            
            $result = array_filter($schedule, function($val) use ($rangeStart, $rangeEnd) {
                $utime = strtotime($val);
                return $utime <= $rangeEnd && $utime >= $rangeStart;
            }, ARRAY_FILTER_USE_KEY);
            
            $schedule = $result;
        }
        
        $page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
        $total = count( $schedule ); //total items in array
        $limit = 10; //per page
        $totalPages = ceil( $total/ $limit ); //calculate total pages
        $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
        $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
        $offset = ($page - 1) * $limit;
        if( $offset < 0 ) $offset = 0;
        
        $schedule = array_slice( $schedule, $offset, $limit );
        
        $this->set('employee', $employee);
        $this->set('schedules', $schedule);
        $this->set('current_page', $page);
        $this->set('total_pages', $totalPages);
        $this->set('total_record', $total);
        $this->set('search', $search);
        $this->set('_serialize', ['employee', 'schedules']);
    }
    
    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function consultView($id = null)
    {
        $employee = $this->EmployeesSchedules->get($id, [
            'contain' => ['Employees']
        ]);
    
        $search = "";
        $schedule = json_decode($employee->consult_schedule, true);
    
        if($this->request->query && !empty($this->request->query['search'])){
            $search = $this->request->query['search'];
            $dates = explode(' - ', $search);
            $rangeStart = strtotime($dates[0]);
            $rangeEnd = strtotime($dates[1]);
    
            $result = array_filter($schedule, function($val) use ($rangeStart, $rangeEnd) {
                $utime = strtotime($val);
                return $utime <= $rangeEnd && $utime >= $rangeStart;
            }, ARRAY_FILTER_USE_KEY);
    
                $schedule = $result;
        }
    
        $page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
        $total = count( $schedule ); //total items in array
        $limit = 10; //per page
        $totalPages = ceil( $total/ $limit ); //calculate total pages
        $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
        $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
        $offset = ($page - 1) * $limit;
        if( $offset < 0 ) $offset = 0;
    
        $schedule = array_slice( $schedule, $offset, $limit );
    
        $this->set('employee', $employee);
        $this->set('schedules', $schedule);
        $this->set('current_page', $page);
        $this->set('total_pages', $totalPages);
        $this->set('total_record', $total);
        $this->set('search', $search);
        $this->set('_serialize', ['employee', 'schedules']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($schedule_type = null,$id = null)
    {
        if(empty($schedule_type) || empty($id)){
            $this->Flash->error(__('Invalid arguments have been passed. Please try again'),['key' => 'negative']);
            return $this->redirect(['action' => 'index']);
        }
       
        $schedule = $this->EmployeesSchedules->get($id);
        $schedule->is_consult  = 0;
        $schedule->consult_schedule  = '';

        if ($this->EmployeesSchedules->save($schedule)) {
            $this->Flash->success(__('The schedule has been deleted.'),['key' => 'positive']);
        } else {
            $this->Flash->error(__('The schedule could not be deleted. Please, try again.'),['key' => 'negative']);
        }

        return $this->redirect(['action' => $schedule_type]);
    }

    /*public function delete($id = null)
    {
        $employee = $this->Employees->get($id);
        if ($this->Employees->delete($employee)) {
            if(file_exists(Configure::read('UPLOAD_EMPLOYEE_ORIGINAL_IMAGE_PATH').$employee->photo))
                unlink(Configure::read('UPLOAD_EMPLOYEE_ORIGINAL_IMAGE_PATH').$employee->photo);

            if(file_exists(Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_PATH').$employee->photo))
                unlink(Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_PATH').$employee->photo);

            $this->Flash->success(__('The employee has been deleted.'),['key' => 'positive']);
        } else {
            $this->Flash->error(__('The employee could not be deleted. Please, try again.'),['key' => 'negative']);
        }

        return $this->redirect(['action' => 'index']);
    }
*/

    /**
     * Check unique employee method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function checkUniqueEmployeeByEmail()
    {
        $this->viewBuilder()->layout(false);
        if($this->request->is('post')) {
            $data = $this->request->data;
            $result = $this->Employees->isEmployeeExist($data['email']);
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
                $result = $this->CSV->importCsvEmployeeSchedules($data['csv']['tmp_name'], 'EmployeesSchedules');
                
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
     * Import CSV method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function consultImportCsv()
    {
        $this->viewBuilder()->layout(false);
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if(!empty($data['csv']) && !empty($data['csv']['name'])){
                $result = $this->CSV->importCsvConsultSchedules($data['csv']['tmp_name'], 'EmployeesSchedules');
    
                if(!empty($result['errors'])) {
                    $this->Flash->error($result['errors'],['key' => 'negative']);
                }
    
                if(!empty($result['messages'])) {
                    $this->Flash->error($result['messages'],['key' => 'positive']);
                }
            }
            return $this->redirect(['action' => 'consult']);
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
    public function downloadConsultCsv()
    {
        $file_path = WWW_ROOT.'img/consult_schedule.csv';
        $this->response->file($file_path, array(
            'download' => true,
        ));
        return $this->response;
    }
    
    /**
     * Download CSV method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function downloadCsv()
    {
        $file_path = WWW_ROOT.'img/schedule_example.csv';
        $this->response->file($file_path, array(
            'download' => true,
        ));
        return $this->response;
    }
}
