<?php
namespace App\Shell;

use Cake\Console\Shell;

class DischargePatientShell extends Shell
{
    public $tasks = ['DischargePatient'];

    public function main()
    {
        $result = $this->DischargePatient->deletePatients();
        $this->out('successfully.');
    }
}
