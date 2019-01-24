<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Table\AppTable;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

/**
 * ServiceTeams Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Hospitals
 * @property \Cake\ORM\Association\HasMany $HospitalsEmployees
 * @property \Cake\ORM\Association\HasMany $Patients
 *
 * @method \App\Model\Entity\ServiceTeam get($primaryKey, $options = [])
 * @method \App\Model\Entity\ServiceTeam newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ServiceTeam[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ServiceTeam|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ServiceTeam patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ServiceTeam[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ServiceTeam findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ServiceTeamsTable extends AppTable
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

        $this->table('service_teams');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Hospitals', [
            'foreignKey' => 'hospital_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('HospitalsEmployees', [
            'foreignKey' => 'service_team_id'
        ]);
        $this->hasMany('Patients', [
            'foreignKey' => 'service_team_id'
        ]);
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
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
        $rules->add($rules->existsIn(['hospital_id'], 'Hospitals'));

        return $rules;
    }

    public function isServiceTeamExist($hospital_id,$name){
        $query = $this->find()
            ->select([
                'name'
            ])
            ->where([
                'ServiceTeams.hospital_id' => $hospital_id,
                'ServiceTeams.name' => trim($name)
            ])
            ->first();

        if(!empty($query)){
            return true;
        } else{
            return false;
        }
    }
    
    public function getServiceTeam($hospital_id,$name){
        $query = $this->find()
            ->select([
                'id',
                'name'
            ])
            ->where([
                'ServiceTeams.hospital_id' => $hospital_id,
                'ServiceTeams.name' => trim($name)
            ])
            ->first();
    
        $result = [];
        
        if(!empty($query)){
            $result = $query->toArray();
        }
        return $result;
    }
    
    public function getServiceTeamEmployee($hospital_id, $name, $patientId){
    
        $this->EmployeesPatients = TableRegistry::get('EmployeesPatients');
        $employees = $this->EmployeesPatients->find('list', ['keyField' => 'id','valueField' =>'employee_id'])->where([ 'patient_id' => $patientId ])->toArray();
        
        $this->PatientServiceTeams = TableRegistry::get('PatientServiceTeams');
        $serviceTeamList = $this->PatientServiceTeams->find('list')->select(['service_team_id'])->where(['patient_id' => $patientId])->toArray();
        
        $result = $this->find('all')
            ->select([
                'id',
                'name'
            ])
            ->contain([
                'HospitalsEmployees.Employees' => function($q) use ($employees) {
                $condition = ['status' => 1];
                
                if(!empty($employees)) {
                    $condition += [ 'Employees.id NOT IN' => array_values($employees)];
                }
                
                return $q
                    ->select([
                        'Employees.id',
                        'firstname',
                        'lastname',
                        'designation',
                        'department',
                        'employee_role',
                        'employee_role_short',
                        'status'
                    ])
                    ->where($condition);
                }
            ])
            ->where([
                'ServiceTeams.hospital_id' => $hospital_id,
                'ServiceTeams.name LIKE' => '%'.$name.'%',
                'ServiceTeams.id NOT IN' => array_values($serviceTeamList)
            ])
            ->toArray();
        
        $employeeList = [];
        
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $employeeList[$i]['team_id'] = $val->id;
                $employeeList[$i]['team_name'] = $val->name;
                $employee = [];
                if(!empty($val->hospitals_employees)) {
                    $j = 0;
                    foreach ($val->hospitals_employees as $employee_key => $employee_val) {
                        $employee[$j]['employee_id'] = !empty($employee_val->employee) ? $employee_val->employee->id : 0;
                        $employee[$j]['employee_name'] = !empty($employee_val->employee) ? $employee_val->employee->full_name : '';
                        $employee[$j]['employee_photo'] =  !empty($employee_val->employee) && !empty($employee_val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$result->signout_notes[0]->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                        $employee[$j]['employee_designation'] = !empty($employee_val->employee) ? $employee_val->employee->designation : '';
                        $employee[$j]['employee_department'] =  !empty($employee_val->employee) ? $employee_val->employee->department : '';
                        $employee[$j]['employee_role'] =  !empty($employee_val->employee) ? $employee_val->employee->employee_role : '';
                        $employee[$j]['employee_role_short'] =  !empty($employee_val->employee) ? $employee_val->employee->employee_role_short : '';
                        $j++;
                    }
                }
                $employeeList[$i]['employees'] = $employee;
                $i++;
            }
        }
        return $employeeList;
    }
    
    public function saveNewServiceTeam($hospital_id,$name) {
        
        $result = $this->getServiceTeam($hospital_id, $name);
        
        if(empty($result)) {
            $data = [
                'hospital_id' => $hospital_id,
                'name' => $name,
            ];
            
            $serviceTeam = $this->newEntity($data);
            $result = $this->save($serviceTeam);
        }
        
        return $result;
    }
}
