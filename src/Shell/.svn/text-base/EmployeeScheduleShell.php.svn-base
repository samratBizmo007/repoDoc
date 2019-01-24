<?php
namespace App\Shell;

use Cake\Console\Shell;

class EmployeeScheduleShell extends Shell
{
    public $tasks = ['EmployeeSchedule'];

    public function main()
    {
        $result = $this->EmployeeSchedule->changeEmployeeTeams();
        $this->out('successfully.');
    }
}
