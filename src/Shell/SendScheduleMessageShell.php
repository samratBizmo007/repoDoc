<?php
namespace App\Shell;

use Cake\Console\Shell;

class SendScheduleMessageShell extends Shell
{
    public $tasks = ['ScheduleMessage'];

    public function main()
    {
        $result = $this->ScheduleMessage->sendMessageNotification();
        $this->out('Notification sent successfully.');
    }
}
