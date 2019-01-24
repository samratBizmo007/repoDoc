<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * SubDepartments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Departments
 *
 * @method \App\Model\Entity\SubDepartment get($primaryKey, $options = [])
 * @method \App\Model\Entity\SubDepartment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SubDepartment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SubDepartment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SubDepartment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SubDepartment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SubDepartment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SubDepartmentsTable extends Table
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

        $this->table('sub_departments');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Departments', [
            'foreignKey' => 'department_id',
            'joinType' => 'INNER'
        ]);
        
        /* $this->belongsTo('Hospitals', [
            'foreignKey' => 'hospital_id',
            'joinType' => 'INNER'
        ]); */
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
            ->requirePresence('department_id', 'create')
            ->notEmpty('department_id');

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
        $rules->add($rules->existsIn(['department_id'], 'Departments'));

        return $rules;
    }

    public function isSubDepartmentExist($name){
        $query = $this->find()
            ->select([
                'name'
            ])
            ->where(['SubDepartments.name' => $name])
            ->first();

        if(!empty($query)){
            return true;
        } else{
            return false;
        }
    }
    
    public function saveNewSubDepartment($name, $department) {
        
        $flag = $this->isSubDepartmentExist($name);
        
        if(!$flag) {
            
            $departments = TableRegistry::get('Departments');
            $departmentData = $departments->getDepartment($department);
            $department_id = 0;
            
            if(!empty($departmentData)) {
                $department_id = $departmentData['id'];
            }
            
            $data = [
                'department_id' => $department_id,
                'name' => $name
            ];
        
            $subDepartment = $this->newEntity($data);
            $this->save($subDepartment);
            return true;
        }
        return $flag;
    }
}
