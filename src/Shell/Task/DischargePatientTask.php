<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;

class DischargePatientTask extends Shell
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Patients');
        $this->loadModel('Followups');
        $this->loadModel('EmployeesPatients');
        $this->loadModel('MajorEvents');
        $this->loadModel('Reminders');
        $this->loadModel('SignoutNotes');
    }

    public function deletePatients()
    {
        $patientLists = $this->Patients->find('all')->contain(['PatientServiceTeams'])->where(['discharge' => 1])->toArray();
        //if($this->Patients->deleteAll(['discharge' => 1])) {
        if(!empty($patientLists)) {
            foreach ($patientLists as $key => $val) {
                $patientDetail = $val;
                if($this->Patients->delete($val)) {
                    $this->Followups->deleteAll(['patient_id' => $patientDetail->id]);
                    $this->EmployeesPatients->deleteAll(['patient_id' => $patientDetail->id]);
                    $this->MajorEvents->deleteAll(['patient_id' => $patientDetail->id]);
                    $this->Reminders->deleteAll(['patient_id' => $patientDetail->id]);
                    $this->SignoutNotes->deleteAll(['patient_id' => $patientDetail->id]);
                    
                    /* $patientHistory['patient_id'] = $patientDetail->id;
                    $patientHistory['patient_name'] = $patientDetail->full_name;
                    $patientHistory['user_id'] = 0;
                    $patientHistory['hospital_id'] = 0;
                    $patientHistory['action'] = "Delete";
                    $this->Patients->savePatientHistory($patientHistory); */
                }
            }
        }
        //}
    }
}
?>