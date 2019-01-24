<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Table\AppTable;

/**
 * Messages Model
 *
 * @property \Cake\ORM\Association\HasMany $Followups
 * @property \Cake\ORM\Association\HasMany $SignoutNotes
 *
 * @method \App\Model\Entity\Message get($primaryKey, $options = [])
 * @method \App\Model\Entity\Message newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Message[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Message|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Message patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Message[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Message findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MessagesTable extends AppTable
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
        
        /* $this->belongsTo('SenderEmployees', [
            'className' => 'Employees',
            'foreignKey' => 'sender_id',
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
            ->requirePresence('actual_chat_id', 'create')
            ->notEmpty('actual_chat_id');
        
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
            ->requirePresence('message_id', 'create')
            ->notEmpty('message_id');
        
        $validator
            ->requirePresence('message', 'create')
            ->notEmpty('message');
            
        $validator
            ->requirePresence('doctor_name', 'create')
            ->notEmpty('doctor_name');
            
        $validator
            ->requirePresence('message_type', 'create')
            ->notEmpty('message_type');
            
        /* $validator
            ->requirePresence('chat_type', 'create')
            ->notEmpty('chat_type'); */
            
        return $validator;
    }
    
    public function sendMessageForEmergency($messageCont = 1) {
        
        return $this->find('all')
            ->contain([
                'Employees' => [
                    'fields' => [
                        'id',
                        'firstname',
                        'lastname',
                        'firebase_token',
                        'pager_number',
                        'device_token',
                        'device_type'
                    ]
                ]
            ])
            ->where(['Messages.message_count <' => $messageCont, 'DATE_ADD(Messages.created, INTERVAL 5 MINUTE) >=' => date('Y-m-d H:i:s') ])
            ->toArray();
    }
    
    public function sendPagerMessage() {
        
        return $this->find('all')
            ->contain([
                'Employees' => [
                    'fields' => [
                        'pager_number'
                    ]
                ]
            ])
            ->where(['message_count >=' => 3 ])
            ->toArray();
    }
}
