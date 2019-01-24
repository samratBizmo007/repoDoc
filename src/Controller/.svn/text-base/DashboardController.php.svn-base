<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @author Virag shah
 */
class DashboardController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->viewBuilder()->layout('Admin.default');
        $this->accessUrl();
    }

    public function index() {
        $this->Users = TableRegistry::get('Users');
        $userId = $this->Auth->user('id');
        $role = $this->Auth->user('role_id');
        
        $hospitalId = !empty($this->Auth->user('hospitals')['id']) ? $this->Auth->user('hospitals')['id'] : 0;
        
        $userCondition = ['is_active' => 1];
        if($role == 3) {
            $userCondition += ['admin_user' => $userId];
        } else {
            $userCondition += ['role_id !=' => 1];
        }
        $totalUsers = $this->Users->find('all')->where($userCondition)->count();
        $this->set('totalUsers', $totalUsers);
        
        $empCondition = ['status' => 1];
        if($role == 3 && !empty($hospitalId)) {
            $empCondition += ['hospital_id' => $hospitalId];  
        }
        
        $this->Employees = TableRegistry::get('Employees');
        $totalEmployees = $this->Employees->find('all')->where($empCondition)->count();
        $this->set('totalEmployees', $totalEmployees);
        
        
        $this->Patients = TableRegistry::get('Patients');
        $totalPatients = $this->Patients->find('all')->where($empCondition)->count();
        $this->set('totalPatients', $totalPatients);
        
        $this->Hospitals = TableRegistry::get('Hospitals');
        $totalHospitals = $this->Hospitals->find('all')->where(['is_active' => 1])->count();
        $this->set('totalHospitals', $totalHospitals);
        
        $this->ServiceTeams = TableRegistry::get('ServiceTeams');
        $totalServiceTeams = $this->ServiceTeams->find('all')->where($empCondition)->count();
        $this->set('totalServiceTeams', $totalServiceTeams);
        
        $this->Departments = TableRegistry::get('Departments');
        $totalDepartments = $this->Departments->find('all')->where(['is_active' => 1])->count();
        $this->set('totalDepartments', $totalDepartments);
        
        $this->SubDepartments = TableRegistry::get('SubDepartments');
        $totalSubDepartments = $this->SubDepartments->find('all')->where(['is_active' => 1])->count();
        $this->set('totalSubDepartments', $totalSubDepartments);
        
        $this->set(compact('totalUsers','totalEmployees', 'totalPatients', 'totalServiceTeams', 'totalDepartments', 'totalSubDepartments', 'totalHospitals'));
    }

}
