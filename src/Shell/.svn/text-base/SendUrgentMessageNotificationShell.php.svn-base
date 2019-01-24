<?php
namespace App\Shell;

use Cake\Console\Shell;

class SendUrgentMessageNotificationShell extends Shell
{
    public $tasks = ['UrgentMessage'];

    public function main()
    {
        
        while(1){
            
            $result = $this->UrgentMessage->sendMessageNotification();

	        if($result)
	        	$this->out('Notification sent successfully.');
	        else {
	        	sleep(3);
	        }
        }
    }
}
