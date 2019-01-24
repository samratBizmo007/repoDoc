<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\FirebaseComponent;

class RemindChangePasswordTask extends Shell
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Employees');
        $this->Firebase = new FirebaseComponent(new ComponentRegistry());
    }
    
    public function sendMessageNotification()
    {
        $employees = $this->Employees->getEmployeesWhoChangePassword();
        
        if(!empty($employees)) {
            foreach ($employees as $key => $val) {
                if(!empty($val->device_token)) {
                    $this->Firebase->sendFCMMessage($val->device_token, "Please change your password.", "", ['reset_password' => 1], '', $val->device_type);
                }
                $val->notification_date = date('Y-m-d');
                $val->dirty('modified', true);
                $result = $this->Employees->save($val);
            }
        }
    }
}
?>