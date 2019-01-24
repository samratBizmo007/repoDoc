<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Mailer\MailerAwareTrait;
use Cake\Mailer\Email;
use Cake\Network\Exception\SocketException;

/**
 * Sites Controller
 *
 * @property \App\Model\Table\SitesTable $Sites
 */
class SitesController extends AppController {

    use MailerAwareTrait;

    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->layout('Website.default');

        $this->Auth->allow();
    }
    
     /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $aboutUs = TableRegistry::get('Pages')->get(1);
        
        $this->set(compact('aboutUs'));
        $this->set('_serialize', ['aboutUs']);
    }

    /**
     * Privacy method
     *
     * @return \Cake\Network\Response|null
     */
    public function privacyPolicy() {

        $page = TableRegistry::get('Pages')->get(2);

        $this->set(compact('page'));
        $this->set('_serialize', ['page']);
    }

    /**
     * Contact method
     *
     * @return \Cake\Network\Response|null
     */
    public function contact() {
        if ($this->request->is('post')) {            
            try {
                $email = new Email('default');
                $email->from($this->request->data['email'], Configure::read('Theme.title'))
                    ->transport('default')
                    ->to(Configure::read('ADMIN_EMAIL'))
                    ->emailFormat('html')
                    ->subject('Contact Us')
                    ->template('contact-us')
                    ->viewVars(['data' => $this->request->data])
                    ->send();
                $this->Flash->success(__('Email has been sent successfully.'));
            } catch(SocketException $e) {
                $this->Flash->error(__('Email could not be sent. Please try again.'));
            }

            return $this->redirect('/');
        }
    }
}
