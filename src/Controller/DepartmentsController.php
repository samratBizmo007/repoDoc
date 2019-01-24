<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

/**
 * Departments Controller
 *
 * @property \App\Model\Table\DepartmentsTable $Departments
 */
class DepartmentsController extends AppController
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
    public function index($is_consult = 1)
    {
        $search = "";
        $users = [];        
        $conditions = ['consult_department' => $is_consult];

        /* if($this->Auth->user()['role_id'] == 3) {
            $conditions += ['Departments.hospital_id' => $this->Auth->user()['hospitals']['id']];
        } */
        
        if($this->request->query){
            $search = !empty($this->request->query['search']) ? $this->request->query['search'] : "";
            $conditions = [
                'OR'=> [
                    "Departments.name LIKE '%".$search."%'",
                ]
            ];
        }
        
        try{
            $departments = $this->paginate($this->Departments,[
                'conditions' => $conditions,
                /* 'contain' => ['Hospitals'], */
                'order' => ['Departments.id' => 'desc'],
                'limit' => 10
            ]);
        }catch(NotFoundException $e){
            $departments = $this->Departments->newEntity();
        }

        $this->set(compact('departments','search'));
        $this->set('_serialize', ['departments']);
    }

    /**
     * View method
     *
     * @param string|null $id Department id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $department = $this->Departments->get($id, [
            'contain' => ['Followups', 'SignoutNotes']
        ]);

        $this->set('department', $department);
        $this->set('_serialize', ['department']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->layout(false);
        $department = $this->Departments->newEntity();
        if ($this->request->is('post')) {
            $department = $this->Departments->patchEntity($department, $this->request->data);
            if ($this->Departments->save($department)) {
                $this->Flash->success(__('The department has been saved.'),['key' => 'positive']);

                return $this->redirect(['action' => 'index',$this->request->data['consult_department']]);
            }
            $this->Flash->error(__('The department could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index',$this->request->data['consult_department']]);
        }
        $this->set(compact('department'));
        $this->set('_serialize', ['department']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Department id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->layout(false);
        $department = $this->Departments->get($id, [
            'contain' => []
        ]);
        
        $consultDepartment = $department->consult_department;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $department = $this->Departments->patchEntity($department, $this->request->data);
            if ($this->Departments->save($department)) {
                $this->Flash->success(__('The department has been saved.'));

                return $this->redirect(['action' => 'index',$consultDepartment]);
            }
            $this->Flash->error(__('The department could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index',$consultDepartment]);
        }
        $this->set(compact('department'));
        $this->set('_serialize', ['department']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Department id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $department = $this->Departments->get($id);
        if ($this->Departments->delete($department)) {
            $this->Flash->success(__('The department has been deleted.'));
        } else {
            $this->Flash->error(__('The department could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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
                $result = $this->CSV->import_csv($data['csv']['tmp_name'], 'Departments');
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
     * Check unique department method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function checkUniqueDepartment()
    {
        $this->viewBuilder()->layout(false);
        if($this->request->is('post')) {
            $data = $this->request->data;
            $result = $this->Departments->isDepartmentExist($data['name']);
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
        $departments = $this->Departments->find('all')
            ->order('created DESC')
            ->toArray();
         
        $head = [
            'Name',
            'Status',
            'Created'
        ];
    
        $this->CSV->clear();
        $this->CSV->addRow($head);
        if(!empty($departments)) {
            foreach ($departments as $department) {
                $line = [
                    'Name' => $department->name,
                    'Status' => $department->is_active == 1 ? 'Active' : 'Inactive',
                    'Created' => $department->created
                ];
    
                $this->CSV->addRow($line);
            }
        }
    
        echo  $this->CSV->render('department');
        die;
    }
    
    /**
     * Download CSV method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function downloadCsv()
    {
        $file_path = WWW_ROOT.'img/departments-sample.csv';
        $this->response->file($file_path, array(
            'download' => true,
        ));
        return $this->response;
    }
}
