<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

/**
 * Hospitals Controller
 *
 * @property \App\Model\Table\HospitalsTable $Hospitals
 */
class HospitalsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        
        $this->viewBuilder()->layout('Admin.default');
        $this->accessUrl();
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
                    "Hospitals.name LIKE '%".$search."%'",
                ]
            ];
        }
        
        try{
            $hospitals = $this->paginate($this->Hospitals,[
                'conditions' => $conditions,
                'order' => ['Hospitals.id' => 'desc'],
                'limit' => 10
            ]);
        }catch(NotFoundException $e){
            $hospitals = $this->Hospitals->newEntity();
        }

        $this->set(compact('hospitals','search'));
        $this->set('_serialize', ['hospitals']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->layout(false);
        $hospital = $this->Hospitals->newEntity();
        if ($this->request->is('post')) {
            $hospital = $this->Hospitals->patchEntity($hospital, $this->request->data);
            if ($this->Hospitals->save($hospital)) {
                $this->Flash->success(__('The hospital has been saved.'),['key' => 'positive']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hospital could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('hospital'));
        $this->set('_serialize', ['hospital']);
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
        $hospital = $this->Hospitals->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $hospital = $this->Hospitals->patchEntity($hospital, $this->request->data);
            if ($this->Hospitals->save($hospital)) {
                $this->Flash->success(__('The hospital has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The hospital could not be saved. Please, try again.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('hospital'));
        $this->set('_serialize', ['hospital']);
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
        $hospital = $this->Hospitals->get($id);
        if ($this->Hospitals->delete($hospital)) {
            $this->Flash->success(__('The hospital has been deleted.'));
        } else {
            $this->Flash->error(__('The hospital could not be deleted. Please, try again.'));
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
                $result = $this->CSV->import_csv($data['csv']['tmp_name'], 'Hospitals');
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
        $hospitals = $this->Hospitals->find('all')
            ->order('created DESC')
            ->toArray();
         
        $head = [
            'Name',
            'Status',
            'Created'
        ];
    
        $this->CSV->clear();
        $this->CSV->addRow($head);
        if(!empty($hospitals)) {
            foreach ($hospitals as $hospital) {
                $line = [
                    'Name' => $hospital->name,
                    'Status' => $hospital->is_active == 1 ? 'Active' : 'Inactive',
                    'Created' => $hospital->created
                ];
    
                $this->CSV->addRow($line);
            }
        }
    
        echo  $this->CSV->render('hospital');
        die;
    }
}
