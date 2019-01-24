<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Table\AppTable;

/**
 * ScheduleMessages Model
 *
 * @property \Cake\ORM\Association\HasMany $Followups
 * @property \Cake\ORM\Association\HasMany $SignoutNotes
 *
 * @method \App\Model\Entity\ScheduleMessage get($primaryKey, $options = [])
 * @method \App\Model\Entity\ScheduleMessage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ScheduleMessage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ScheduleMessage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScheduleMessage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ScheduleMessage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ScheduleMessage findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ScheduleMessagesTable extends AppTable
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
            'foreignKey' => 'receiver_id',
            'joinType' => 'INNER'
        ]);
        
        $this->belongsTo('SenderEmployees', [
            'className' => 'Employees',
            'foreignKey' => 'sender_id',
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
            ->requirePresence('chat_id', 'create')
            ->notEmpty('chat_id');
            
        $validator
            ->requirePresence('sender_id', 'create')
            ->notEmpty('sender_id');
            
        $validator
            ->requirePresence('receiver_id', 'create')
            ->notEmpty('receiver_id');
            
        $validator
            ->requirePresence('message', 'create')
            ->notEmpty('message');
            
        return $validator;
    }
    
    public function sendScheduleMessage() {
        return $this->find('all')
            ->contain(['SenderEmployees' => [
                'fields' => [
                    'firstname',
                    'lastname'
                ]
            ]])
            ->where([
                'DATE_FORMAT(date_time, "%Y-%m-%d %H:%i") = "'.date('Y-m-d H:i').'"'
            ])
            ->toArray();
    }
}
