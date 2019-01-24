<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Pages Controller
 *
 * @property \App\Model\Table\PagesTable $Pages
 */
class PagesController extends AppController {

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
    public function index() {
        
        $conditions = [];
        $search = '';
        if($this->request->query){
            $search = !empty($this->request->query['search']) ? $this->request->query['search'] : "";
            $conditions = [
                'OR'=> [
                    "Pages.title LIKE '%".trim(strtolower($search))."%'",
                    "Pages.slug LIKE '%".$search."%'"
                ]
            ];
        }
        
        $pages = $this->paginate($this->Pages,[
            'conditions' => $conditions,
            'limit' => 10,
            'order' => ['pages.created' => 'desc']
        ]);
        
        $this->set('search',$search);
        $this->set(compact('pages'));
        $this->set('_serialize', ['pages']);
    }

    /**
     * View method
     *
     * @param string|null $id Page id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $this->viewBuilder()->layout('Admin.ajax');
        
        $page = $this->Pages->get($id, [
            'contain' => []
        ]);

        $this->set('page', $page);
        $this->set('_serialize', ['page']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $page = $this->Pages->newEntity();
        if ($this->request->is('post')) {
            $page = $this->Pages->patchEntity($page, $this->request->data);
            
            if ($this->Pages->save($page)) {
                $this->Flash->success(__('The page has been saved.'),['key' => 'positive']);
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The page could not be saved. Please, try again.'),['key' => 'negative']);
            }
        }
        $this->set(compact('page'));
        $this->set('_serialize', ['page']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Page id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $page = $this->Pages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $page = $this->Pages->patchEntity($page, $this->request->data);
            if ($this->Pages->save($page)) {
                $this->Flash->success(__('The page has been saved.'),['key' => 'positive']);
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The page could not be saved. Please, try again.'),['key' => 'negative']);
            }
        }
        $this->set(compact('page'));
        $this->set('_serialize', ['page']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Page id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['get','post', 'delete']);
        $page = $this->Pages->get($id);
        if ($this->Pages->delete($page)) {
            $this->Flash->success(__('The page has been deleted.'),['key' => 'positive']);
        } else {
            $this->Flash->error(__('The page could not be deleted. Please, try again.'),['key' => 'negative']);
        }
        return $this->redirect(['action' => 'index']);
    }

}
