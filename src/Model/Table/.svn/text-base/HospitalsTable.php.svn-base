<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

use App\Model\Table\AppTable;

/**
 * Hospitals Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $HospitalsEmployees
 *
 * @method \App\Model\Entity\Hospital get($primaryKey, $options = [])
 * @method \App\Model\Entity\Hospital newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Hospital[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Hospital|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Hospital patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Hospital[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Hospital findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HospitalsTable extends AppTable
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

        $this->hasMany('HospitalsEmployees', [
            'foreignKey' => 'hospital_id'
        ]);
        
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
}
