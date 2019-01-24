<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Table\AppTable;

/**
 * Departments Model
 *
 * @property \Cake\ORM\Association\HasMany $Followups
 * @property \Cake\ORM\Association\HasMany $SignoutNotes
 *
 * @method \App\Model\Entity\Department get($primaryKey, $options = [])
 * @method \App\Model\Entity\Department newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Department[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Department|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Department patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Department[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Department findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DepartmentsTable extends AppTable
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

        $this->table('departments');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Followups', [
            'foreignKey' => 'department_id'
        ]);
        
        $this->hasMany('SignoutNotes', [
            'foreignKey' => 'department_id'
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
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }

    public function isDepartmentExist($name){
        $query = $this->find()
            ->select([
                'name'
            ])
            ->where(['Departments.name' => $name])
            ->first();

        if(!empty($query)){
            return true;
        } else{
            return false;
        }
    }
    
    public function getDepartment($name){
        $query = $this->find()
        ->select([
            'id',
            'name',
            'short_name'
        ])
        ->where(['Departments.name' => $name])
        ->first();
    
        if(!empty($query)){
            return $query->toArray();
        } else{
            return [];
        }
    }
    
    public function saveNewDepartment($name) {
        
        $flag = $this->isDepartmentExist($name);
        
        if(!$flag) {
            $data = [
                'name' => $name
            ];
        
            $department = $this->newEntity($data);
            $this->save($department);
            return true;
        }
        return $flag;
    }
}
