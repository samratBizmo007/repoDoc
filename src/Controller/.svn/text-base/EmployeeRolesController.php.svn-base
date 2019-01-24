<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

/**
 * EmployeeRoles Controller
 *
 * @property \App\Model\Table\EmployeeRolesTable $EmployeeRoles
 */
class EmployeeRolesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        
        $this->viewBuilder()->layout('Admin.default');
        $this->accessAdminUrl();
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index($is_clinical = 1)
    {
        $search = "";
        $users = [];
        $conditions = ['clinical_role' => $is_clinical];

        if($this->request->query){
            $search = !empty($this->request->query['search']) ? $this->request->query['search'] : "";
            $conditions += [
                'OR'=> [
                    "EmployeeRoles.name LIKE '%".$search."%'",
                ]
            ];
        }

        try{
            $employeeRoles = $this->paginate($this->EmployeeRoles,[
                'conditions' => $conditions,
                'order' => ['EmployeeRoles.id' => 'desc'],
                'limit' => 10
            ]);
        } catch(NotFoundException $e){
            $employeeRoles = $this->EmployeeRoles->newEntity();
        }

        $this->set(compact('employeeRoles','search'));
        $this->set('_serialize', ['employeeRoles']);
    }

    /**
     * View method
     *
     * @param string|null $id Employee Role id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employeeRole = $this->EmployeeRoles->get($id);

        $this->set('employeeRole', $employeeRole);
        $this->set('_serialize', ['employeeRole']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->layout(false);
        $employeeRole = $this->EmployeeRoles->newEntity();
        if ($this->request->is('post')) {
            $employeeRole = $this->EmployeeRoles->patchEntity($employeeRole, $this->request->data);
            if ($this->EmployeeRoles->save($employeeRole)) {
                $this->Flash->success(__('The employee role has been saved.'));

                return $this->redirect(['action' => 'index', $this->request->data['clinical_role']]);
            }
            $this->Flash->error(__('The employee role could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index', $this->request->data['clinical_role']]);
        }
        $this->set(compact('employeeRole'));
        $this->set('_serialize', ['employeeRole']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee Role id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->layout(false);
        $employeeRole = $this->EmployeeRoles->get($id, [
            'contain' => []
        ]);
        
        $clinicalRole = $employeeRole->clinical_role;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employeeRole = $this->EmployeeRoles->patchEntity($employeeRole, $this->request->data);
            if ($this->EmployeeRoles->save($employeeRole)) {
                $this->Flash->success(__('The employee role has been saved.'));

                return $this->redirect(['action' => 'index', $clinicalRole]);
            }
            $this->Flash->error(__('The employee role could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index', $clinicalRole]);
        }
        $this->set(compact('employeeRole'));
        $this->set('_serialize', ['employeeRole']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee Role id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $employeeRole = $this->EmployeeRoles->get($id);
        if ($this->EmployeeRoles->delete($employeeRole)) {
            $this->Flash->success(__('The employee role has been deleted.'));
        } else {
            $this->Flash->error(__('The employee role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index', $employeeRole->clinical_role]);
    }

    /**
     * Check unique role method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function checkUniqueRole()
    {
        $this->viewBuilder()->layout(false);
        if($this->request->is('post')) {
            $data = $this->request->data;
            $result = $this->EmployeeRoles->isRoleExist($data['name']);
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
                $result = $this->CSV->employeeRoleImportCsv($data['csv']['tmp_name'], 'EmployeeRoles');
                if(!empty($result['error'])) {
                    $this->Flash->error($result['messages'],'success');
                }
    
                if(!empty($result['error'])) {
                    $this->Flash->error($result['error'],'warning');
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
        $employeeRoles = $this->EmployeeRoles->find('all')
            ->order('created DESC')
            ->toArray();
         
        $head = [
            'Name',
            'Status',
            'Created'
        ];
    
        $this->CSV->clear();
        $this->CSV->addRow($head);
        if(!empty($employeeRoles)) {
            foreach ($employeeRoles as $employeeRole) {
                $line = [
                    'Name' => $employeeRole->name,
                    'Status' => $employeeRole->is_active == 1 ? 'Active' : 'Inactive',
                    'Created' => $employeeRole->created
                ];
    
                $this->CSV->addRow($line);
            }
        }
    
        echo  $this->CSV->render('employee-roles');
        die;
    }
    
    /**
     * Download CSV method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function downloadCsv()
    {
        $file_path = WWW_ROOT.'img/employee_roles-sample.csv';
        $this->response->file($file_path, array(
            'download' => true,
        ));
        return $this->response;
    }
}
