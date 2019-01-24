<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

/**
 * ServiceTeams Controller
 *
 * @property \App\Model\Table\ServiceTeamsTable $ServiceTeams
 */
class ServiceTeamsController extends AppController
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

        if($this->Auth->user()['role_id'] == 3 || $this->Auth->user()['role_id'] == 4) {
            $conditions += ['ServiceTeams.hospital_id' => $this->Auth->user()['hospitals']['id']];
        }
        
        if($this->request->query){
            $search = !empty($this->request->query['search']) ? $this->request->query['search'] : "";
            $conditions += [
                'OR'=> [
                    "ServiceTeams.name LIKE '%".$search."%'",
                ]
            ];
        }

        try{
            $this->paginate = [
                'contain' => ['Hospitals'],
                'conditions' => $conditions
            ];
            $serviceTeams = $this->paginate($this->ServiceTeams,[
                'conditions' => $conditions,
                'order' => ['ServiceTeams.id' => 'desc'],
                'limit' => 10
            ]);
        }catch(NotFoundException $e){
            $serviceTeams = $this->ServiceTeams->newEntity();
        }


        $this->set(compact('serviceTeams','search'));
        $this->set('_serialize', ['serviceTeams']);
    }

    /**
     * View method
     *
     * @param string|null $id Service Team id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $serviceTeam = $this->ServiceTeams->get($id, [
            'contain' => ['Hospitals', 'HospitalsEmployees', 'Patients']
        ]);

        $this->set('serviceTeam', $serviceTeam);
        $this->set('_serialize', ['serviceTeam']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->layout(false);
        $serviceTeam = $this->ServiceTeams->newEntity();
        if ($this->request->is('post')) {
            $serviceTeam = $this->ServiceTeams->patchEntity($serviceTeam, $this->request->data);
            if ($this->ServiceTeams->save($serviceTeam)) {
                $this->Flash->success(__('The service team has been saved.'),['key' => 'positive']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The service team could not be saved. Please, try again.'),['key' => 'negative']);

            return $this->redirect(['action' => 'index']);
        }
        $hospitals = $this->ServiceTeams->Hospitals->find('list', ['limit' => 200]);
        $this->set(compact('serviceTeam', 'hospitals'));
        $this->set('_serialize', ['serviceTeam']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Service Team id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->layout(false);
        $serviceTeam = $this->ServiceTeams->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $serviceTeam = $this->ServiceTeams->patchEntity($serviceTeam, $this->request->data);
            if ($this->ServiceTeams->save($serviceTeam)) {
                $this->Flash->success(__('The service team has been saved.'),['key' => 'positive']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The service team could not be saved. Please, try again.'),['key' => 'negative']);

            return $this->redirect(['action' => 'index']);
        }
        $hospitals = $this->ServiceTeams->Hospitals->find('list', ['limit' => 200]);
        $this->set(compact('serviceTeam', 'hospitals'));
        $this->set('_serialize', ['serviceTeam']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Service Team id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $serviceTeam = $this->ServiceTeams->get($id);
        if ($this->ServiceTeams->delete($serviceTeam)) {
            $this->Flash->success(__('The service team has been deleted.'));
        } else {
            $this->Flash->error(__('The service team could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Check unique Service Team method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function checkUniqueServiceTeam()
    {
        $this->viewBuilder()->layout(false);
        if($this->request->is('post')) {
            $data = $this->request->data;
            $result = $this->ServiceTeams->isServiceTeamExist($this->current_user['hospitals']['id'],$data['name']);
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
                $result = $this->CSV->importCsvServiceTeam($data['csv']['tmp_name'], 'ServiceTeams');
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
        $serviceTeams = $this->ServiceTeams->find('all')
            ->contain(['Hospitals'])
            ->order('ServiceTeams.created DESC')
            ->toArray();
         
        $head = [
            'Hospital Name',
            'Service Team Name',
            'Status',
            'Created'
        ];
    
        $this->CSV->clear();
        $this->CSV->addRow($head);
        if(!empty($serviceTeams)) {
            foreach ($serviceTeams as $serviceTeam) {
                $line = [
                    'Hospital Name' => !empty($serviceTeam->hospital->name) ? $serviceTeam->hospital->name : '',
                    'Service Team Name' => $serviceTeam->name,
                    'Status' => $serviceTeam->status == 1 ? 'Active' : 'Inactive',
                    'Created' => $serviceTeam->created
                ];
    
                $this->CSV->addRow($line);
            }
        }
    
        echo  $this->CSV->render('service-team');
        die;
    }
    
    /**
     * Download CSV method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function downloadCsv()
    {
        $file_path = WWW_ROOT.'img/service-teams-sample.csv';
        $this->response->file($file_path, array(
            'download' => true,
        ));
        return $this->response;
    }
}
