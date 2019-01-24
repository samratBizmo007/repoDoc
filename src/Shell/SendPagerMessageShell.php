<?php
namespace App\Shell;

use Cake\Console\Shell;

class SendPagerMessageShell extends Shell
{
    public $tasks = ['UrgentMessage'];

    public function main()
    {
        $result = $this->UrgentMessage->sendPagerMessage();
        $this->out('Message sent successfully.');
    }
}
