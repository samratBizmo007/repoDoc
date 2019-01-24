<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * UsersFloors Controller
 *
 * @property \App\Model\Table\UsersFloorsTable $UsersFloors
 */
class UsersFloorsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $usersFloors = $this->paginate($this->UsersFloors);

        $this->set(compact('usersFloors'));
        $this->set('_serialize', ['usersFloors']);
    }

    /**
     * View method
     *
     * @param string|null $id Users Floor id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usersFloor = $this->UsersFloors->get($id, [
            'contain' => []
        ]);

        $this->set('usersFloor', $usersFloor);
        $this->set('_serialize', ['usersFloor']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usersFloor = $this->UsersFloors->newEntity();
        if ($this->request->is('post')) {
            $usersFloor = $this->UsersFloors->patchEntity($usersFloor, $this->request->data);
            if ($this->UsersFloors->save($usersFloor)) {
                $this->Flash->success(__('The users floor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users floor could not be saved. Please, try again.'));
        }
        $this->set(compact('usersFloor'));
        $this->set('_serialize', ['usersFloor']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Users Floor id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usersFloor = $this->UsersFloors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usersFloor = $this->UsersFloors->patchEntity($usersFloor, $this->request->data);
            if ($this->UsersFloors->save($usersFloor)) {
                $this->Flash->success(__('The users floor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users floor could not be saved. Please, try again.'));
        }
        $this->set(compact('usersFloor'));
        $this->set('_serialize', ['usersFloor']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Users Floor id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usersFloor = $this->UsersFloors->get($id);
        if ($this->UsersFloors->delete($usersFloor)) {
            $this->Flash->success(__('The users floor has been deleted.'));
        } else {
            $this->Flash->error(__('The users floor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
