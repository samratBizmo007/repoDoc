<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use App\Model\Table\AppTable;

/**
 * SignoutNotes Model
 *
 * @method \App\Model\Entity\SignoutNote get($primaryKey, $options = [])
 * @method \App\Model\Entity\SignoutNote newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SignoutNote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SignoutNote|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SignoutNote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SignoutNote[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SignoutNote findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SignoutNotesTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->primaryKey('id');
        
        $this->addBehavior('Timestamp');
        
        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['patient_id'], 'Patients'));
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));
        $rules->add($rules->existsIn(['department_id'], 'Departments'));
    
        return $rules;
    }
    
    public function uploadAudio($audio,$old_photo = ''){
        $uploads_original_path = Configure::read('UPLOAD_SIGNOUT_NOTE_PATH');
        $allowed_exntentions = Configure::read('ALLOWED_IMAGE_EXTENSIONS');
        return  $this->file($audio, $uploads_original_path);
    }
    
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('employee_id', 'create')
            ->notEmpty('employee_id');

        $validator
            ->requirePresence('patient_id', 'create')
            ->notEmpty('patient_id');

        $validator
            ->requirePresence('department_id', 'create')
            ->notEmpty('department_id');
        
        $validator
            ->requirePresence('content', 'create')
            ->notEmpty('content');
            
        $validator
            ->requirePresence('date', 'create')
            ->notEmpty('date');
            
        $validator
            ->requirePresence('time', 'create')
            ->notEmpty('time');

        return $validator;
    }
    
    public function getSignOutNotes($patientId) {
        $result = $this->find('all')
            ->select([
                'id',
                'employee_id',
                'patient_id',
                'department_id',
                'content',
                'duration',
                'date',
                'time'
            ])
            ->contain([
                'Employees' => [
                    'fields' => [
                        'id',
                        'firstname',
                        'lastname',
                        'designation',
                        'department',
                        'employee_role',
                        'employee_role_short'
                    ]
                ]
            ])
            ->where([
                'SignoutNotes.is_active' => 1,
                'SignoutNotes.patient_id' => $patientId
            ])
            ->order(['SignoutNotes.id DESC'])
            ->all()
            ->toArray();
        
        $signoutNotes = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $signoutNotes[$i]['id'] = $val->id;
                $signoutNotes[$i]['employee_id'] = $val->employee->id;
                $signoutNotes[$i]['content'] = !empty($val->content) && file_exists(Configure::read('UPLOAD_SIGNOUT_NOTE_PATH').$val->content) ? Configure::read('UPLOAD_SIGNOUT_NOTE_URL').$val->content : '';
                $signoutNotes[$i]['duration'] = !empty($val->duration) ? $val->duration : '';
                $signoutNotes[$i]['date'] = !empty($val->date) ? date('d-m-y', strtotime($val->date)) : '';
                $signoutNotes[$i]['time'] = !empty($val->time) ? date('h:i a', strtotime($val->time)) : '';
                $signoutNotes[$i]['name'] = !empty($val->employee->full_name) ? $val->employee->full_name : '';
                $signoutNotes[$i]['photo'] =  !empty($val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$val->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $signoutNotes[$i]['designation'] =  !empty($val->employee->designation) ? $val->employee->designation : '';
                $signoutNotes[$i]['department'] =  !empty($val->employee->department) ? $val->employee->department : '';
                $signoutNotes[$i]['employee_role'] =  !empty($val->employee->employee_role) ? $val->employee->employee_role : '';
                $signoutNotes[$i]['employee_role_short'] =  !empty($val->employee->employee_role_short) ? $val->employee->employee_role_short : '';
                $i++;
            }
        }
        return $signoutNotes;
    }
    
    public function getEmployeeSignOutNotes($employeeId) {
        $this->PatientsBed = TableRegistry::get('PatientsBed');
        $result = $this->find('all')
            ->select([
                'id',
                'employee_id',
                'patient_id',
                'department_id',
                'content',
                'duration',
                'date',
                'time'
            ])
            ->contain([
                'Patients' => [
                    'fields' => [
                        'id',
                        'firstname',
                        'lastname',
                        'photo',
                        'mrn',
                        'room',
                        'bed'
                    ]
                ]
            ])
            ->where([
                'SignoutNotes.is_active' => 1,
                'SignoutNotes.employee_id' => $employeeId
            ])
            ->order(['SignoutNotes.id DESC'])
            ->all()
            ->toArray();
    
        $signoutNotes = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $signoutNotes[$i]['id'] = $val->id;
                $signoutNotes[$i]['content'] = !empty($val->content) && file_exists(Configure::read('UPLOAD_SIGNOUT_NOTE_PATH').$val->content) ? Configure::read('UPLOAD_SIGNOUT_NOTE_URL').$val->content : '';
                $signoutNotes[$i]['duration'] = !empty($val->duration) ? $val->duration : '';
                $signoutNotes[$i]['date'] = !empty($val->date) ? date('d-m-y', strtotime($val->date)) : '';
                $signoutNotes[$i]['time'] = !empty($val->time) ? date('h:i a', strtotime($val->time)) : '';
                $signoutNotes[$i]['patient_id'] = $val->patient->id;
                $signoutNotes[$i]['name'] = !empty($val->patient) && !empty($val->patient->full_name) ? $val->patient->full_name : '';
                $signoutNotes[$i]['photo'] =  Configure::read('DEFAULT_PATIENT_IMAGE_URL');
                $signoutNotes[$i]['mrn'] =  !empty($val->patient) && !empty($val->patient->mrn) ? $val->patient->mrn : '';
                $bedData = $this->PatientsBed->getPatientsBed($val->patient->id);
                $roomBad = (!empty($bedData["room_number"])  && !empty($bedData["bed_number"])) ?  $bedData["room_number"].'-'.$bedData["bed_number"] : ( !empty($bedData["room_number"]) ? $bedData["room_number"] : (!empty($bedData["bed_number"]) ? $bedData["bed_number"] : ''));
                $signoutNotes[$i]['bed'] =  $roomBad;
                //$signoutNotes[$i]['bed'] =  !empty($val->patient) && !empty($val->patient->bed) ? $val->patient->bed : '';
                $i++;
            }
        }
        return $signoutNotes;
    }
    
    public function getSignoutNoteDetail($id) {
        $result = $this->find('all')
        ->select([
            'id',
            'employee_id',
            'patient_id',
            'department_id',
            'content',
            'duration',
            'date',
            'time'
        ])
        ->contain([
            'Employees' => [
                'fields' => [
                    'id',
                    'firstname',
                    'lastname',
                    'designation',
                    'department',
                    'employee_role',
                    'employee_role_short',
                ]
            ]
        ])
        ->where([
            'SignoutNotes.is_active' => 1,
            'SignoutNotes.id' => $id
        ])
        ->order(['SignoutNotes.id DESC'])
        ->first();
        
        $signoutNotes = [];
        if(!empty($result)) {
            $signoutNotes['id'] = $result->id;
            $signoutNotes['employee_id'] = $result->employee->id;
            $signoutNotes['content'] = !empty($result->content) && file_exists(Configure::read('UPLOAD_SIGNOUT_NOTE_PATH').$result->content) ? Configure::read('UPLOAD_SIGNOUT_NOTE_URL').$result->content : '';
            $signoutNotes['duration'] = !empty($result->duration) ? $result->duration : '';
            //$signoutNotes['content'] = !empty($result->content) && file_exists(Configure::read('UPLOAD_SIGNOUT_NOTE_PATH').$result->content) ? $this->getDuration(Configure::read('UPLOAD_SIGNOUT_NOTE_PATH').$result->content) : 0;
            $signoutNotes['date'] = !empty($result->date) ? date('d-m-y', strtotime($result->date)) : '';
            $signoutNotes['time'] = !empty($result->time) ? date('h:i a', strtotime($result->time)) : '';
            $signoutNotes['name'] = !empty($result->employee->full_name) ? $result->employee->full_name : '';
            $signoutNotes['photo'] =  !empty($result->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$result->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
            $signoutNotes['designation'] =  !empty($result->employee->designation) ? $result->employee->designation : '';
            $signoutNotes['department'] =  !empty($result->employee->department) ? $result->employee->department : '';
            $signoutNotes['employee_role'] =  !empty($result->employee->employee_role) ? $result->employee->employee_role : '';
            $signoutNotes['employee_role_short'] =  !empty($result->employee->employee_role_short) ? $result->employee->employee_role_short : '';
        }
        return $signoutNotes;
    }
    
    /* //Read entire file, frame by frame... ie: Variable Bit Rate (VBR)
    public function getDuration($filename, $use_cbr_estimate=false)
    {
        $fd = fopen($filename, "rb");
    
        $duration=0;
        $block = fread($fd, 100);
        $offset = $this->skipID3v2Tag($block);
        fseek($fd, $offset, SEEK_SET);
        while (!feof($fd))
        {
            $block = fread($fd, 10);
            if (strlen($block)<10) { break; }
            //looking for 1111 1111 111 (frame synchronization bits)
            else if ($block[0]=="\xff" && (ord($block[1])&0xe0) )
            {
                $info = self::parseFrameHeader(substr($block, 0, 4));
                if (empty($info['Framesize'])) { return $duration; } //some corrupt mp3 files
                fseek($fd, $info['Framesize']-10, SEEK_CUR);
                $duration += ( $info['Samples'] / $info['Sampling Rate'] );
            }
            else if (substr($block, 0, 3)=='TAG')
            {
                fseek($fd, 128-10, SEEK_CUR);//skip over id3v1 tag size
            }
            else
            {
                fseek($fd, -9, SEEK_CUR);
            }
            if ($use_cbr_estimate && !empty($info))
            {
                return $this->estimateDuration($info['Bitrate'],$offset);
            }
        }
        return round($duration);
    }
    
    private function estimateDuration($bitrate,$offset)
    {
        $kbps = ($bitrate*1000)/8;
        $datasize = filesize($this->filename) - $offset;
        return round($datasize / $kbps);
    } */
    
}
