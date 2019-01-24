<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

/**
 * Titles Controller
 *
 * @property \App\Model\Table\TitlesTable $Titles
 */
class TitlesController extends AppController
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
                    "Titles.name LIKE '%".$search."%'",
                ]
            ];
        }
        
        try{
            $titles = $this->paginate($this->Titles,[
                'conditions' => $conditions,
                'order' => ['Titles.id' => 'desc'],
                'limit' => 10
            ]);
        }catch(NotFoundException $e){
            $titles = $this->Titles->newEntity();
        }

        $this->set(compact('titles','search'));
        $this->set('_serialize', ['titles']);
    }

    /**
     * View method
     *
     * @param string|null $id Title id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $title = $this->Titles->get($id, [
            'contain' => []
        ]);

        $this->set('title', $title);
        $this->set('_serialize', ['title']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->layout(false);
        $title = $this->Titles->newEntity();
        if ($this->request->is('post')) {
            $title = $this->Titles->patchEntity($title, $this->request->data);
            if ($this->Titles->save($title)) {
                $this->Flash->success(__('The title has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The title could not be saved. Please, try again.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('title'));
        $this->set('_serialize', ['title']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Title id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->layout(false);
        $title = $this->Titles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $title = $this->Titles->patchEntity($title, $this->request->data);
            if ($this->Titles->save($title)) {
                $this->Flash->success(__('The title has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The title could not be saved. Please, try again.'));

            return $this->redirect(['action' => 'index']);
        }
        $this->set(compact('title'));
        $this->set('_serialize', ['title']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Title id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $title = $this->Titles->get($id);
        if ($this->Titles->delete($title)) {
            $this->Flash->success(__('The title has been deleted.'));
        } else {
            $this->Flash->error(__('The title could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Check unique title method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function checkUniqueTitle()
    {
        $this->viewBuilder()->layout(false);
        if($this->request->is('post')) {
            $data = $this->request->data;
            $result = $this->Titles->isTitleExist($data['name']);
            if(!empty($result)){
                echo "false";
            } else {
                echo "true";
            }
        }
        die;
    }
    
    /**
     * Import csv method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function importCsv()
    {
        $this->viewBuilder()->layout(false);
        if ($this->request->is('post')) {
            $data = $this->request->data;
            if(!empty($data['csv']) && !empty($data['csv']['name'])){
                $result = $this->CSV->import_csv($data['csv']['tmp_name'], 'Titles');
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
        $titles = $this->Titles->find('all')
            ->order('created DESC')
            ->toArray();
       
        $head = [
            'Name',
            'Status',
            'Created'
        ];
        
        $this->CSV->clear(); 
        $this->CSV->addRow($head);
        if(!empty($titles)) {
            foreach ($titles as $title) {
                $line = [
                    'Name' => $title->name,
                    'Status' => $title->is_active == 1 ? 'Active' : 'Inactive',
                    'Created' => $title->created
                ];
        
                $this->CSV->addRow($line);
            }
        }
        
       echo  $this->CSV->render(true);
       die;
    }
    
    /**
     * Download CSV method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function downloadCsv()
    {
        $file_path = WWW_ROOT.'img/titles-sample.csv';
        $this->response->file($file_path, array(
            'download' => true,
        ));
        return $this->response;
    }
}
