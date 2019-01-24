<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UsersOpts Model
 *
 * @method \App\Model\Entity\UsersOpt get($primaryKey, $options = [])
 * @method \App\Model\Entity\UsersOpt newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UsersOpt[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UsersOpt|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UsersOpt patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UsersOpt[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UsersOpt findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersOptsTable extends Table
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

        $this->table('users_opts');
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
            ->integer('time')
            ->requirePresence('time', 'create')
            ->notEmpty('time');

        $validator
            ->requirePresence('otp', 'create')
            ->notEmpty('otp');

        return $validator;
    }
}
