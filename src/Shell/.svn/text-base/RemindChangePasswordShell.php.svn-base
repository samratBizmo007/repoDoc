<?php
namespace App\Shell;

use Cake\Console\Shell;

class RemindChangePasswordShell extends Shell
{
    public $tasks = ['RemindChangePassword'];

    public function main()
    {
        
        $result = $this->RemindChangePassword->sendMessageNotification();
        $this->out('Notification sent successfully.');
    }
}
