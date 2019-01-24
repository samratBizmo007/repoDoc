<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Floors Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Hospitals
 *
 * @method \App\Model\Entity\Floor get($primaryKey, $options = [])
 * @method \App\Model\Entity\Floor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Floor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Floor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Floor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Floor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Floor findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FloorsTable extends Table
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

        $this->table('floors');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Hospitals', [
            'foreignKey' => 'hospital_id',
            'joinType' => 'INNER'
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

        /* $validator
            ->boolean('is_active')
            ->requirePresence('is_active', 'create')
            ->notEmpty('is_active'); */

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
    
    public function isFloorExist($hospital_id,$name, $id = 0){
        
        $conditions = [
            'Floors.hospital_id' => $hospital_id,
            'LOWER(Floors.name)' => strtolower(trim($name))
        ];
        
        if(!empty($id)) {
            $conditions += ['Floors.id != ' => $id];
        }
        $query = $this->find()
            ->select([
                'name'
            ])
            ->where($conditions)
            ->first();
    
        if(!empty($query)){
            return true;
        } else{
            return false;
        }
    }
    
    public function saveNewFloor($hospital_id, $name) {
    
        $query = $this->find('all')
            ->where([
                'Floors.hospital_id' => $hospital_id,
                'LOWER(Floors.name)' => strtolower(trim($name))
            ])
            ->first();
    
        if(empty($query)) {
            $data = [
                'hospital_id' => $hospital_id,
                'name' => $name
            ];
    
            $floor = $this->newEntity($data);
            if($result = $this->save($floor)) {
                return $result->id;
            }
        }
        return $query->id;
    }
}
