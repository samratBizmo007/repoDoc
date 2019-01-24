<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\Auth\DefaultPasswordHasher;

use App\Model\Table\AppTable;
use Cake\ORM\TableRegistry;

/**
 * Employees Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\HasMany $Diagnoses
 * @property \Cake\ORM\Association\HasMany $Followups
 * @property \Cake\ORM\Association\HasMany $HospitalsEmployees
 * @property \Cake\ORM\Association\HasMany $MajorEvents
 * @property \Cake\ORM\Association\HasMany $Reminders
 * @property \Cake\ORM\Association\HasMany $SignoutNotes
 * @property \Cake\ORM\Association\HasMany $VoiceNotes
 * @property \Cake\ORM\Association\BelongsToMany $Patients
 *
 * @method \App\Model\Entity\Employee get($primaryKey, $options = [])
 * @method \App\Model\Entity\Employee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Employee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Employee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employee findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeesTable extends AppTable
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

        $this->table('employees');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Diagnoses', [
            'foreignKey' => 'employee_id'
        ]);
        $this->hasMany('Followups', [
            'foreignKey' => 'employee_id'
        ]);
        $this->hasMany('HospitalsEmployees', [
            'foreignKey' => 'employee_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('MajorEvents', [
            'foreignKey' => 'employee_id'
        ]);
        $this->hasMany('Reminders', [
            'foreignKey' => 'employee_id'
        ]);
        $this->hasMany('SignoutNotes', [
            'foreignKey' => 'employee_id'
        ]);
        
        $this->belongsTo('VoiceNotes', [
            'foreignKey' => 'employee_id'
        ]);
        
        $this->hasOne('EmployeesSchedules', [
            'foreignKey' => 'employee_id'
        ]);
        
        $this->belongsToMany('Patients', [
            'foreignKey' => 'employee_id',
            'targetForeignKey' => 'patient_id',
            'joinTable' => 'employees_patients'
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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');
        
        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password')
            ->add('password', 'validFormat',[
                    'rule' => array('custom', '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{6,}$/'),
                    'message' => 'Minimum 6 character long. It should have alpha, numeric and special character combination.'
            ]);

        $validator
            ->requirePresence('firstname', 'create')
            ->notEmpty('firstname');

        $validator
            ->requirePresence('lastname', 'create')
            ->notEmpty('lastname');

        $validator
            ->requirePresence('employee_role', 'create')
            ->notEmpty('employee_role');

        $validator
            ->requirePresence('designation', 'create')
            ->notEmpty('designation');

        $validator
            ->requirePresence('department', 'create')
            ->notEmpty('department');

        /* $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title'); */

        $validator
            ->requirePresence('qualification', 'create')
            ->notEmpty('qualification');

        /* $validator
            ->requirePresence('photo', 'create')
            ->notEmpty('photo','Please upload image','create'); */

       /*  $validator
            ->requirePresence('office_number', 'create')
            ->notEmpty('office_number');

        $validator
            ->requirePresence('cell_number', 'create')
            ->notEmpty('cell_number'); */

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
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }

    public function isEmployeeExist($email, $id = 0){
        $conditions = ['Employees.email' => $email];
        
        if(!empty($id)) {
            $conditions += ['Employees.id !=' => $id ];
        }
        
        $query = $this->find()
            ->select([
                'email'
            ])
            ->where($conditions)
            ->first();

        if(!empty($query)){
            return true;
        } else{
            return false;
        }
    }
    
    public function getEmployee($name){
        $query = $this->find()
            ->select([
                'id',
                'firstname',
                'lastname'
            ])
            ->where(['Employees.firstname like ' => '%'.$name.'%'])
            ->orWhere(['Employees.lastname like ' => '%'.$name.'%'])
            ->first();
    
        $result = [];     
        if(!empty($query)){
            $result = $query->toArray(); 
        }
        
        return $result;
        
    }

    public function getEmployeeByEmail($email, $password){
        $query = $this->find()
            ->select(['id', 'hospital_id', 'password', 'email','firstname','lastname','employee_role','designation','employee_role', 'employee_role_short', 'department','title','qualification','photo','office_number','cell_number','fax_number','pager_number', 'working_time','app_token','is_working' => 'availability_status','status', 'is_notification', 'expire_days' => 'DATEDIFF(CURDATE(), DATE(change_password_date))','chat_status'])
            ->contain(['HospitalsEmployees' => ['fields' => ['employee_id','hospital_id','service_team_id']]])
            ->where(['Employees.email' => $email])
            ->first();
        
        if(!empty($query) && (new DefaultPasswordHasher)->check($password, $query->password)){
            $department = TableRegistry::get('Departments');
            if(empty($query->hospitals_employees)) {
                $query['hospitals_employees'][0]['employee_id'] = $query->id;
                $query['hospitals_employees'][0]['hospital_id'] = -1;
                $query['hospitals_employees'][0]['service_team_id'] = -1;
            }
            $departmentId = $department->find('all')
                ->select(['id'])
                ->where(['name' => $query->department ])
                ->first();
            $query->password_expired = false;
            if($query->expire_days >= Configure::read('PASSWORD_EXPIRE_DAYS')) {
                $query->password_expired = true;
            }
            unset($query->expire_days);
            $query->department_id = !empty($departmentId->id) ? $departmentId->id : 0; 
            $query->employee_id = $query->id;
            return $query;
        } else{
            return false;
        }
    }
    
    public function getEmployeeById($id){
        $query = $this->find()
            ->select([
                'id',
                'hospital_id',
                'password',
                'email',
                'firstname',
                'lastname',
                'employee_role',
                'designation',
                'employee_role',
                'employee_role_short',
                'department',
                'title',
                'qualification',
                'photo',
                'office_number',
                'cell_number',
                'fax_number',
                'pager_number',
                'working_time',
                'app_token',
                'is_working' => 'availability_status',
                'device_token',
                'device_type',
                'build_version',
                'status',
                'is_notification',
                'expire_days' => 'DATEDIFF(CURDATE(), DATE(change_password_date))'
            ])
            ->contain([
                'HospitalsEmployees' => [
                    'fields' => [
                        'employee_id',
                        'hospital_id',
                        'service_team_id'
                    ]
                ],
                'HospitalsEmployees.ServiceTeams' => [
                    'fields' => [
                        'id',
                        'name'
                    ]
                ]
            ])
            ->where(['Employees.id' => $id ])
            ->first();
        if(!empty($query)){
            $query->password_expired = false;
            if($query->expire_days >= Configure::read('PASSWORD_EXPIRE_DAYS')) {
                $query->password_expired = true;
            }
            unset($query->expire_days);
            $department = TableRegistry::get('Departments');
            
            if(empty($query->hospitals_employees)) {
                $query['hospitals_employees'][0]['employee_id'] = $query->id;
                $query['hospitals_employees'][0]['hospital_id'] = -1;
                $query['hospitals_employees'][0]['service_team_id'] = -1;
            }
            
            $departmentId = $department->find('all')
            ->select(['id'])
            ->where(['name' => $query->department ])
            ->first();
            
            $query->department_id = !empty($departmentId->id) ? $departmentId->id : 0;
            $query->employee_id = $query->id;
            
            return $query;
        } else{
            return false;
        }
    }

    public function authenticatedByToken($token){
        $query = $this->find()
            ->where(['Employees.app_token' => $token,'Employees.status' => 1])
            ->count();
        
        if(!empty($query)){
            return true;
        } else{
            return false;
        }
    }

    public function uploadProfilePhoto($photo,$old_photo = ''){
        $uploads_original_path = Configure::read('UPLOAD_EMPLOYEE_ORIGINAL_IMAGE_PATH');
        $uploads_thumb_path = Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_PATH');
        $allowed_exntentions = Configure::read('ALLOWED_IMAGE_EXTENSIONS');
        return  $this->_uploadImage($photo,$uploads_original_path,$allowed_exntentions,$uploads_thumb_path,$old_photo);
    }
    
    public function validationOnlyCheck(Validator $validator) {
        $validator = $this->validationDefault($validator);
        $validator->remove('photo');
        return $validator;
    }

    public function doLogin($email,$password){
            $result = $this->getEmployeeByEmail($email, $password);
            if(!empty($result)){
                return $result;
            } else {
                return false;
            }
    }

    public function checkUserInLDAP($username, $password, $ldaphost = '')
    {   
        
        // using ldap bind
        $ldaprdn = $this->getUsernameForLDAP($username); // ldap rdn or dn
        $ldappass = $password; // associated password
        if(!empty($ldaprdn)){
            if ($ldaphost == '') {
                $ldaphost = 'ldap.forumsys.com';
                $ldaprdn = "uid=$ldaprdn,dc=example,dc=com"; // ldap rdn or dn
            }
            
            // connect to ldap server
            // $ldapconn = ldap_connect(Configure::read('LADAP_HOST'));
            $ldapconn = ldap_connect($ldaphost);
            
            if (!$ldapconn)
                return false;
            
            ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
            
            // binding to ldap server
            //$ldapbind = @ldap_bind($ldapconn, $ldaprdn, $ldappass);
            return @ldap_bind($ldapconn, $ldaprdn, $ldappass);  
                      
        } else {
            return false;
        }

    }

    public function getUsernameForLDAP($username)
    {
        if (strpos($username, '@') !== false) {
            $username = substr($username, 0, strpos($username, '@'));
        }
        
        if (strpos($username, '\\') !== false) {
            $username = substr($username, strpos($username, '\\') + 1);
        }
        
        return $username;
    }
    
    public function getFirstCallLists($data)
    {
        $conditions['AND']['id !='] = $data['employee_id'];
        $conditions['AND']['status'] = 1;
        $conditions['AND']['consult_availability_status'] = 1;
        
        if($data['type'] == 1) {
            $conditions['AND']['is_first_call'] = 1;
        } else {
            $conditions['AND']['is_attending'] = 1;
        }
    
        if(!empty($data['department'])) {
            $conditions['AND']['department'] = $data['department'];
        }
    
        if(!empty($data['sub_department'])) {
            $conditions['AND']['sub_department LIKE'] = '%'.$data['sub_department'].'%';
        }
        
        $result = $this->find('all')
            ->select([
                'id',
                'firstname',
                'lastname',
                'photo',
                'designation',
                'employee_role',
                'employee_role_short',
                'working_time',
                'consult_working_time',
            ])
            ->contain(['HospitalsEmployees' => function ($q) use ($data) {
                   return $q
                        ->select(['id', 'employee_id', 'hospital_id', 'service_team_id'])
                        ->where(['HospitalsEmployees.hospital_id' => $data['hospital_id']]);
                }
             ])
            ->where($conditions)
            ->order('Employees.id DESC')
            ->all()
            ->toArray();
        
        $employee = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $employee[$i]['id'] = $val->id;
                $employee[$i]['name'] = !empty($val->full_name) ? $val->full_name : '';
                $employee[$i]['photo'] =  !empty($val->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$val->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $employee[$i]['designation'] =  !empty($val->designation) ? $val->designation : '';
                $employee[$i]['department'] =  !empty($val->department) ? $val->department : '';
                $employee[$i]['employee_role'] =  $val->employee_role;
                $employee[$i]['employee_role_short'] =  $val->employee_role_short;
                $employee[$i]['working_time'] =  !empty($val->consult_working_time) ? $val->consult_working_time : '';
                $i++;
            }
        }
        
        return $employee;
    }
    
    public function getPatientsDoctorLists($hospital_id, $employee_id, $provider_name, $employee_role) {
    
        $conditions['AND']['Employees.id !='] = $employee_id;
        $conditions['AND']['Employees.hospital_id'] = $hospital_id;
        if(!empty($provider_name)) {
            $provider_name = explode(' ', $provider_name);
            $firstname = '';
            $lastname = '';
            if(!empty($provider_name[0])) {
                $firstname = $provider_name[0];
            }
            
            if(!empty($provider_name[1])) {
                $lastname = $provider_name[1];
            } else {
                $lastname = $firstname;
            }
            
            $conditions['OR']['Employees.firstname LIKE'] = '%'.$firstname.'%';
            $conditions['OR']['Employees.lastname LIKE'] = '%'.$lastname.'%';
        }
    
        if(!empty($employee_role)) {
            $conditions['AND']['Employees.employee_role_short'] = $employee_role;
        }
        
        $result = $this->find('all')
            ->select([
                'id',
                'firstname',
                'lastname',
                'photo',
                'department',
                'designation',
                'employee_role',
                'employee_role_short'
                
            ])->contain([
                
                'HospitalsEmployees.ServiceTeams' => [
                    'fields' => [
                        'id',
                        'name'
                    ]
                ]
                
            ])->where($conditions)
            ->all()
            ->toArray();
        
        $employee = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $employee[$i]['id'] = $val->id;
                $employee[$i]['name'] = $val->full_name;
                $employee[$i]['photo'] =  !empty($val->employee->photo) &&  file_exists(Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_PATH').$val->employee->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$val->employee->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $employee[$i]['designation'] =  $val->designation;
                $employee[$i]['department'] =  $val->department;
                $employee[$i]['employee_role'] =  $val->employee_role;
                $employee[$i]['employee_role_short'] =  $val->employee_role_short;
                $employee[$i]['service_team_id'] =  !empty($val->hospitals_employees)  && !empty($val->hospitals_employees[0]->service_team) ? $val->hospitals_employees[0]->service_team->id : '';;
                $employee[$i]['service_team'] =  !empty($val->hospitals_employees)  && !empty($val->hospitals_employees[0]->service_team) ? $val->hospitals_employees[0]->service_team->name : '';;
                $i++;
            }
        }
        return $employee;
    }
    
    public function getEmployeeLists($date = '') {
        
        $conditions = ['status' => 1 ];
        
        if(!empty($date)) {
            $conditions += ['modified >=' => $date];
        }
        
        $result = $this->find('all')
            ->select([
                'id',
                'firstname',
                'lastname',
                'photo',
                'designation',
                'department',
                'employee_role',
                'employee_role_short'
            
            ])
            ->where($conditions)
            ->all()
            ->toArray();
        
        $employee = [];
        if(!empty($result)) {
            $i = 0;
            foreach ($result as $key => $val) {
                $employee[$i]['userId'] = (string)$val->id;
                $employee[$i]['name'] = $val->full_name;
                $employee[$i]['photo'] =  !empty($val->photo) ? Configure::read('UPLOAD_EMPLOYEE_THUMB_IMAGE_URL').$val->photo : Configure::read('DEFAULT_USER_IMAGE_URL');
                $employee[$i]['designation'] =  $val->designation;
                $employee[$i]['department'] =  $val->department;
                $employee[$i]['employee_role'] =  $val->employee_role;
                $employee[$i]['employee_role_short'] =  $val->employee_role_short;
                $i++;
            }
        }
        return $employee;
    }
    
    public function getEmployeesWhoChangePassword() {
        $result = $this->find('all')
            ->where([
                'change_password_date IS NOT NULL',
                'date(notification_date) != CURDATE()',
                'DATEDIFF(CURDATE(), DATE(change_password_date)) >=' => Configure::read('PASSWORD_EXPIRE_DAYS')
            ])
            ->toArray();
        
        return $result;
    }
    
    /*
     * check user password is correct or not
     */
    public function checkPassword($password, $hash) {
        if((new DefaultPasswordHasher)->check($password, $hash)) {
            return true;
        }
        return false;
    }
}
