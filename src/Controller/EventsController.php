<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

/**
 * Events Controller
 *
 * @property \App\Model\Table\EventsTable $Events
 */
class EventsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->layout('Admin.default');
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
                    "Events.name LIKE '%".$search."%'",
                ]
            ];
        }
        try{
            
            $events = $this->paginate($this->Events,[
                'conditions' => $conditions,
                'order' => ['Events.name' => 'asc'],
                'limit' => 10
            ]);

        } catch(NotFoundException $e){
            $events = $this->Events->newEntity();
        }

        $this->set(compact('events','search'));
        $this->set('_serialize', ['events']);
    }

    /**
     * View method
     *
     * @param string|null $id Event id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $event = $this->Events->get($id, [
            'contain' => []
        ]);

        $this->set('event', $event);
        $this->set('_serialize', ['event']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->layout(false);
        $event = $this->Events->newEntity();
        if ($this->request->is('post')) {
            $event = $this->Events->patchEntity($event, $this->request->data);
            if ($this->Events->save($event)) {
                $this->Flash->success(__('The event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event could not be saved. Please, try again.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('event'));
        $this->set('_serialize', ['event']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Event id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->layout(false);
        $event = $this->Events->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $event = $this->Events->patchEntity($event, $this->request->data);
            if ($this->Events->save($event)) {
                $this->Flash->success(__('The event has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event could not be saved. Please, try again.'));

            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('event'));
        $this->set('_serialize', ['event']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Event id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $event = $this->Events->get($id);
        if ($this->Events->delete($event)) {
            $this->Flash->success(__('The event has been deleted.'));
        } else {
            $this->Flash->error(__('The event could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Check unique event method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function checkUniqueEvent()
    {
        $this->viewBuilder()->layout(false);
        if($this->request->is('post')) {
            $data = $this->request->data;
            $result = $this->Events->isEventExist($data['name']);
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
                $result = $this->CSV->import_csv($data['csv']['tmp_name'], 'Events');
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
        $events = $this->Events->find('all')
        ->order('created DESC')
        ->toArray();
         
        $head = [
            'Name',
            'Status',
            'Created'
        ];
    
        $this->CSV->clear();
        $this->CSV->addRow($head);
        if(!empty($events)) {
            foreach ($events as $event) {
                $line = [
                    'Name' => $event->name,
                    'Status' => $event->is_active == 1 ? 'Active' : 'Inactive',
                    'Created' => $event->created
                ];
    
                $this->CSV->addRow($line);
            }
        }
    
        echo  $this->CSV->render('events');
        die;
    }
}
