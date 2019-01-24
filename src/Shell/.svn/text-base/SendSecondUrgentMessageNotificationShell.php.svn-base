<?php
namespace App\Shell;

use Cake\Console\Shell;

class SendSecondUrgentMessageNotificationShell extends Shell
{
    public $tasks = ['UrgentMessage'];

    public function main()
    {
        while(1){
            sleep(15);
            $result = $this->UrgentMessage->sendSecondMessageNotification();
	        if($result){
	            $this->out('Notification sent successfully.');
	        } else {
	        	sleep(3);
	        }
        }
    }
}
