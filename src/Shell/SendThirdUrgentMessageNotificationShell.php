<?php
namespace App\Shell;

use Cake\Console\Shell;

class SendThirdUrgentMessageNotificationShell extends Shell
{
    public $tasks = ['UrgentMessage'];

    public function main()
    {
        
        while(1){
            $result = $this->UrgentMessage->sendThirdMessageNotification();

	        if($result){
	            sleep(30);
	        	$this->out('Notification sent successfully.');
	        } else {
	        	sleep(3);
	        }
        }
    }
}
