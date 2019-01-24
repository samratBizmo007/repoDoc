<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Floors Controller
 *
 * @property \App\Model\Table\FloorsTable $Floors
 */
class FloorsController extends AppController
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
            $conditions += ['Floors.hospital_id' => $this->Auth->user()['hospitals']['id']];
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
                'contain' => ['Hospitals'],
                'conditions' => $conditions
            ];
            $floors = $this->paginate($this->Floors,[
                'conditions' => $conditions,
                'order' => ['Floors.id' => 'desc'],
                'limit' => 10
            ]);
        }catch(NotFoundException $e){
            $floors = $this->Floors->newEntity();
        }


        $this->set(compact('floors','search'));
        $this->set('_serialize', ['floors']);
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
        $floor = $this->Floors->newEntity();
        if ($this->request->is('post')) {
            $floor = $this->Floors->patchEntity($floor, $this->request->data);
            if ($this->Floors->save($floor)) {
                $this->Flash->success(__('The floor has been saved.'),['key' => 'positive']);
                return $this->redirect(['action' => 'index']);
            }
            
            $this->Flash->error(__('The floor could not be saved. Please, try again.'),['key' => 'negative']);
        
            return $this->redirect(['action' => 'index']);
        }
        $hospitals = $this->Floors->Hospitals->find('list', ['limit' => 200]);
        $this->set(compact('floor', 'hospitals'));
        $this->set('_serialize', ['floor']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Floor id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->layout(false);
        $floor = $this->Floors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $floor = $this->Floors->patchEntity($floor, $this->request->data);
            if ($this->Floors->save($floor)) {
                $this->Flash->success(__('The floor has been saved.'),['key' => 'positive']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The floor could not be saved. Please, try again.'),['key' => 'negative']);

            return $this->redirect(['action' => 'index']);
        }
        $hospitals = $this->Floors->Hospitals->find('list', ['limit' => 200]);
        $this->set(compact('floor', 'hospitals'));
        $this->set('_serialize', ['floor']);
    }

    /**
     * Check unique Service Team method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function checkUniqueFloor()
    {
        $this->viewBuilder()->layout(false);
        if($this->request->is('post')) {
            $data = $this->request->data;
            $floorId = !empty($data['floor_id']) ? $data['floor_id'] : 0; 
            $result = $this->Floors->isFloorExist($this->current_user['hospitals']['id'],$data['name'], $floorId);
            if(!empty($result)){
                echo "false";
            } else {
                echo "true";
            }
        }
        die;
    }
    
    /**
     * Delete method
     *
     * @param string|null $id Floor id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $floor = $this->Floors->get($id);
        if ($this->Floors->delete($floor)) {
            $this->Flash->success(__('The floor has been deleted.'));
        } else {
            $this->Flash->error(__('The floor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    /**
     * Download CSV method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function downloadCsv()
    {
        $file_path = WWW_ROOT.'img/floor-sample.csv';
        $this->response->file($file_path, array(
            'download' => true,
        ));
        return $this->response;
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
                $result = $this->CSV->importCsvServiceTeam($data['csv']['tmp_name'], 'Floors');
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
        $serviceTeams = $this->Floors->find('all')
        ->contain(['Hospitals'])
        ->order('Floors.created DESC')
        ->toArray();
         
        $head = [
            'Hospital Name',
            'Floor Name',
            'Status',
            'Created'
        ];
    
        $this->CSV->clear();
        $this->CSV->addRow($head);
        if(!empty($serviceTeams)) {
            foreach ($serviceTeams as $serviceTeam) {
                $line = [
                    'Hospital Name' => !empty($serviceTeam->hospital->name) ? $serviceTeam->hospital->name : '',
                    'Floor Name' => $serviceTeam->name,
                    'Status' => $serviceTeam->is_active == 1 ? 'Active' : 'Inactive',
                    'Created' => $serviceTeam->created
                ];
    
                $this->CSV->addRow($line);
            }
        }
    
        echo  $this->CSV->render('floor');
        die;
    }
}
