<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SubDepartments Controller
 *
 * @property \App\Model\Table\SubDepartmentsTable $SubDepartments
 */
class SubDepartmentsController extends AppController
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
    public function index()
    {   
        $search = "";
        $users = [];
        $conditions = [];

        if($this->request->query){
            $search = !empty($this->request->query['search']) ? $this->request->query['search'] : "";
            $conditions = [
                'OR'=> [
                    "SubDepartments.name LIKE '%".$search."%'",
                ]
            ];
        }

        try{
            $this->paginate = [
                'order' => ['SubDepartments.id' => 'desc'],
                'contain' => ['Departments'],
                'conditions' => $conditions
            ];
            $subDepartments = $this->paginate($this->SubDepartments);
            
        }catch(NotFoundException $e){
            $subDepartments = $this->SubDepartments->newEntity();
        }

        $this->set(compact('subDepartments','search'));
        $this->set('_serialize', ['subDepartments','search']);
    }

    /**
     * View method
     *
     * @param string|null $id Sub Department id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subDepartment = $this->SubDepartments->get($id, [
            'contain' => ['Departments']
        ]);

        $this->set('subDepartment', $subDepartment);
        $this->set('_serialize', ['subDepartment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->layout(false);
        $subDepartment = $this->SubDepartments->newEntity();
        if ($this->request->is('post')) {
            $subDepartment = $this->SubDepartments->patchEntity($subDepartment, $this->request->data);
            if ($this->SubDepartments->save($subDepartment)) {
                $this->Flash->success(__('The sub department has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sub department could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }
        $departments = $this->SubDepartments->Departments->find('list', ['limit' => 200]);
        $this->set(compact('subDepartment', 'departments'));
        $this->set('_serialize', ['subDepartment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sub Department id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->layout(false);
        $subDepartment = $this->SubDepartments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subDepartment = $this->SubDepartments->patchEntity($subDepartment, $this->request->data);
            if ($this->SubDepartments->save($subDepartment)) {
                $this->Flash->success(__('The sub department has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sub department could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }
        $departments = $this->SubDepartments->Departments->find('list', ['limit' => 200]);
        $this->set(compact('subDepartment', 'departments'));
        $this->set('_serialize', ['subDepartment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sub Department id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $subDepartment = $this->SubDepartments->get($id);
        if ($this->SubDepartments->delete($subDepartment)) {
            $this->Flash->success(__('The sub department has been deleted.'));
        } else {
            $this->Flash->error(__('The sub department could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

     /**
     * Check unique department method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function checkUniqueSubDepartment()
    {
        $this->viewBuilder()->layout(false);
        if($this->request->is('post')) {
            $data = $this->request->data;
            $result = $this->SubDepartments->isSubDepartmentExist($data['name']);
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
                $result = $this->CSV->importCsvDepartment($data['csv']['tmp_name'], 'SubDepartments');
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
        $subDepartments = $this->SubDepartments->find('all')
            ->contain(['Departments'])
            ->order('SubDepartments.created DESC')
            ->toArray();
         
        $head = [
            'Name',
            'Department Name',
            'Status',
            'Created'
        ];
    
        $this->CSV->clear();
        $this->CSV->addRow($head);
        if(!empty($subDepartments)) {
            foreach ($subDepartments as $subDepartment) {
                $line = [
                    'Name' => $subDepartment->name,
                    'Department Name' => !empty($subDepartment->department->name) ? $subDepartment->department->name : '',
                    'Status' => $subDepartment->is_active == 1 ? 'Active' : 'Inactive',
                    'Created' => $subDepartment->created
                ];
    
                $this->CSV->addRow($line);
            }
        }
    
        echo  $this->CSV->render('sub-department');
        die;
    }
    
    /**
     * Download CSV method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function downloadCsv()
    {
        $file_path = WWW_ROOT.'img/sub_departments-sample.csv';
        $this->response->file($file_path, array(
            'download' => true,
        ));
        return $this->response;
    }
}
