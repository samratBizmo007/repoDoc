<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Table\AppTable;

/**
 * EmployeeRoles Model
 *
 * @method \App\Model\Entity\EmployeeRole get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmployeeRole newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmployeeRole[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeRole|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmployeeRole patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeRole[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmployeeRole findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeeRolesTable extends AppTable
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

        $this->table('employee_roles');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
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

    public function isRoleExist($name){
        $query = $this->find()
            ->select([
                'name'
            ])
            ->where(['EmployeeRoles.name' => $name])
            ->first();

        if(!empty($query)){
            return true;
        } else{
            return false;
        }
    }
    
    public function getEmployeeRole($name, $shortName = '') {
        
        $flag = $this->isRoleExist($name);
        
        if(!$flag) {
            $data = [
                'name' => $name,
                'short_name' => $shortName
            ];
            
            $employeeRole = $this->newEntity($data);
            $this->save($employeeRole);
            return true;
        }
        return $flag;
    }
}
