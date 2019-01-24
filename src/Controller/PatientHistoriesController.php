<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PatientHistories Controller
 *
 * @property \App\Model\Table\PatientHistoriesTable $PatientHistories
 */
class PatientHistoriesController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    
        $this->viewBuilder()->layout('Admin.default');
        $this->loadComponent('Firebase');
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
        $conditions = [];
        if($this->request->query){
            $search = !empty($this->request->query['search']) ? $this->request->query['search'] : "";
            $conditions += [
                "PatientHistories.patient_name LIKE '%".$search."%'"
            ];
        }
        
        if(!empty($this->Auth->user('hospitals')['id'])) {
            $conditions += ['hospital_id' => $this->Auth->user('hospitals')['id']];
        }
        
        $this->paginate = [
            'contain' => ['Users.Roles', 'Hospitals'],
            'conditions' => $conditions,
            'order' => ['PatientHistories.created' => 'desc'],
            'limit' => 10
        ];
        
        $patientHistories = $this->paginate($this->PatientHistories);
        
        $this->set(compact('patientHistories', 'search'));
        $this->set('_serialize', ['patientHistories']);
    }

    /**
     * View method
     *
     * @param string|null $id Patient History id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $patientHistory = $this->PatientHistories->get($id, [
            'contain' => ['Patients', 'Employees', 'Users', 'Hospitals']
        ]);

        $this->set('patientHistory', $patientHistory);
        $this->set('_serialize', ['patientHistory']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $patientHistory = $this->PatientHistories->newEntity();
        if ($this->request->is('post')) {
            $patientHistory = $this->PatientHistories->patchEntity($patientHistory, $this->request->data);
            if ($this->PatientHistories->save($patientHistory)) {
                $this->Flash->success(__('The patient history has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The patient history could not be saved. Please, try again.'));
        }
        $patients = $this->PatientHistories->Patients->find('list', ['limit' => 200]);
        $employees = $this->PatientHistories->Employees->find('list', ['limit' => 200]);
        $users = $this->PatientHistories->Users->find('list', ['limit' => 200]);
        $hospitals = $this->PatientHistories->Hospitals->find('list', ['limit' => 200]);
        $this->set(compact('patientHistory', 'patients', 'employees', 'users', 'hospitals'));
        $this->set('_serialize', ['patientHistory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Patient History id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $patientHistory = $this->PatientHistories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $patientHistory = $this->PatientHistories->patchEntity($patientHistory, $this->request->data);
            if ($this->PatientHistories->save($patientHistory)) {
                $this->Flash->success(__('The patient history has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The patient history could not be saved. Please, try again.'));
        }
        $patients = $this->PatientHistories->Patients->find('list', ['limit' => 200]);
        $employees = $this->PatientHistories->Employees->find('list', ['limit' => 200]);
        $users = $this->PatientHistories->Users->find('list', ['limit' => 200]);
        $hospitals = $this->PatientHistories->Hospitals->find('list', ['limit' => 200]);
        $this->set(compact('patientHistory', 'patients', 'employees', 'users', 'hospitals'));
        $this->set('_serialize', ['patientHistory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Patient History id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $patientHistory = $this->PatientHistories->get($id);
        if ($this->PatientHistories->delete($patientHistory)) {
            $this->Flash->success(__('The patient history has been deleted.'));
        } else {
            $this->Flash->error(__('The patient history could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    public function exportLists()
    {
        $patientHistories = $this->PatientHistories->find('all')
            ->contain(['Users.Roles', 'Hospitals'])
            ->order('PatientHistories.created DESC')
            ->toArray();
         
        $head = [
            'Patient Name',
            'User Name',
            'User Role',
            'Hospital',
            'Created',
            'Action'
        ];
    
        $this->CSV->clear();
        $this->CSV->addRow($head);
        if(!empty($patientHistories)) {
            foreach ($patientHistories as $patientHistory) {
                $line = [
                    'Patient Name' => $patientHistory->patient_name,
                    'User Name' => $patientHistory->user->full_name,
                    'User Role' => $patientHistory->user->role->name,
                    'Hospital' => $patientHistory->hospital->name,
                    'Created' => $patientHistory->created,
                    'Status' => $patientHistory->action
                ];
    
                $this->CSV->addRow($line);
            }
        }
    
        echo  $this->CSV->render('patients');
        die;
    }
}
