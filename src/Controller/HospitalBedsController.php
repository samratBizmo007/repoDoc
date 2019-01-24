<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 *  HospitalBeds Controller
 *
 * @property \App\Model\Table\HospitalBedsTable $HospitalBeds
 */
class HospitalBedsController extends AppController
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
        if($this->Auth->user()['role_id'] == 3) {
            $conditions += ['HospitalBeds.hospital_id' => $this->Auth->user()['hospitals']['id']];
        }
        
        if($this->request->query){
            $search = !empty($this->request->query['search']) ? $this->request->query['search'] : "";
            $conditions += [
                'OR'=> [
                    "Floors.name LIKE '%".$search."%'",
                ]
            ];
        }

        try{
            $this->paginate = [
                'contain' => ['Floors'],
            ];
            $hospitalBeds = $this->paginate($this->HospitalBeds,[
                'conditions' => $conditions,
                'limit' => 10
            ]);
        }catch(NotFoundException $e){
            $floors = $this->HospitalsBeds->newEntity();
        }

        // print_r($hospitalBeds);exit;
        $this->set(compact('hospitalBeds','search'));
        $this->set('_serialize', ['hospitalBeds']);
    }

    /**
     * View method
     *
     * @param string|null $id Floor id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $floor = $this->Floors->get($id, [
            'contain' => ['Hospitals']
        ]);

        $this->set('floor', $floor);
        $this->set('_serialize', ['floor']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->layout(false);
        $hospitalBeds = $this->HospitalBeds->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $result = $this->HospitalBeds->isBedExist($this->current_user['hospitals']['id'],$data['room_number'],$data['bed_number'], $data['floor_id']);
            if(empty($result)){
                $hospitalBeds = $this->HospitalBeds->patchEntity($hospitalBeds, $this->request->data);
                if ($this->HospitalBeds->save($hospitalBeds)) {
                    $this->Flash->success(__('The bed has been saved.'),['key' => 'positive']);
                }else{
                    $this->Flash->error(__('The bed could not be saved. Please, try again.'),['key' => 'negative']);  
                }
            } else {
                $this->Flash->error(__('The bed is already exists.'),['key' => 'negative']);
            }
            return $this->redirect(['action' => 'index']);
            
        }

        $floors = $this->HospitalBeds->Floors->find('list');
        $this->set(compact('floors','hospitalBeds'));
        $this->set('_serialize', ['hospitalBeds']);
    }


    /**
     * Check unique 
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function checkUniqueBed()
    {
        $this->viewBuilder()->layout(false);
        if($this->request->is('post')) {
            
            $data = $this->request->data;
            $floorId = !empty($data['floor_id']) ? $data['floor_id'] : 0; 
            $result = $this->HospitalBeds->isBedExist($this->current_user['hospitals']['id'],$data['room_number'],$data['bed_number'], $floorId);
            if(!empty($result)){
                echo "false";
            } else {
                echo "true";
            }
        }
        die;
    }
    
    /**
     * Edit method
     *
     * @param string|null $id Hospital Bed id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->layout(false);
        $hospitalBeds = $this->HospitalBeds->get($id, [
            'contain' => ['Floors']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $result = $this->HospitalBeds->isBedExist($this->current_user['hospitals']['id'],$data['room_number'],$data['bed_number'], $data['floor_id']);
            if(empty($result)){
                $hospitalBeds = $this->HospitalBeds->patchEntity($hospitalBeds, $this->request->data);
                if ($this->HospitalBeds->save($hospitalBeds)) {
                    $this->Flash->success(__('The bed has been saved.'),['key' => 'positive']);
                }else{
                    $this->Flash->error(__('The bed could not be saved. Please, try again.'),['key' => 'negative']);  
                }
            } else {
                $this->Flash->error(__('The bed is already exists.'),['key' => 'negative']);
            }
            return $this->redirect(['action' => 'index']);
            
        }
        $floors = $this->HospitalBeds->Floors->find('list');
        $this->set(compact('floors','hospitalBeds'));
        $this->set('_serialize', ['hospitalBeds']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Hospital Bed id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $bed = $this->HospitalBeds->get($id);
        if ($this->HospitalBeds->delete($bed)) {
            $this->Flash->success(__('The bed has been deleted.'));
        } else {
            $this->Flash->error(__('The bed could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    /**
     * Export csv method
     *
     * @return download csv file of all data
     */
    public function exportLists()
    {
        $hospitalBeds = $this->HospitalBeds->find('all')
        ->contain(['Hospitals','Floors'])
        ->toArray();
         
        $head = [
            'Hospital Name',
            'Floor Name',
            'Room Number',
            'Bed Number'
        ];
    
        $this->CSV->clear();
        $this->CSV->addRow($head);
        if(!empty($hospitalBeds)) {
            foreach ($hospitalBeds as $beds) {
                $line = [
                    'Hospital Name' => !empty($beds->hospital->name) ? $beds->hospital->name : '',
                    'Floor Name' => $beds->floor->name,
                    'Room Number' => $beds->room_number,
                    'Bed Number' => $beds->bed_number
                ];
    
                $this->CSV->addRow($line);
            }
        }
    
        echo  $this->CSV->render('hospitalBeds');
        die;
    }
}
