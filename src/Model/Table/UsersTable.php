<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\Event\Event;
use ArrayObject;
use Cake\Datasource\EntityInterface;

use App\Model\Table\AppTable;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Roles
 * @property \Cake\ORM\Association\BelongsToMany $Hospitals
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends AppTable
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsToMany('Hospitals', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'hospital_id',
            'joinTable' => 'users_hospitals'
        ]);

        $this->hasOne('UsersHospitals', [
            'foreignKey' => 'user_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        
        $this->hasMany('UsersDepartments', [
            'foreignKey' => 'user_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        
        $this->hasMany('UsersFloors', [
            'foreignKey' => 'user_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
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
            ->notEmpty('password');

        $validator
            ->requirePresence('firstname', 'create')
            ->notEmpty('firstname');

        $validator
            ->requirePresence('lastname', 'create')
            ->notEmpty('lastname');

        return $validator;
    }

    public function validEmailFormat($value,$context){
        if (!preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/",$value)) {
            return false;
        } else {
            return true;
        }
    }

    public function lettersonly($value,$context){
        if (!preg_match("/^[a-z]+$/i",$value)) {
            return false;
        } else {
            return true;
        }
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
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }

    public function isEmailExist($email, $user_id = 0){
        
        $condition['Users.email'] = $email;
        if(!empty($user_id)) {
            $condition['Users.id != '] = $user_id;
        }
        
        $query = $this->find()
            ->select([
                'email'
            ])
            ->where($condition)
            ->first();

        if(!empty($query)){
            return true;
        } else{
            return false;
        }
    }

    public function uploadProfilePhoto($photo,$old_photo = ''){
        $uploads_original_path = Configure::read('UPLOAD_ORIGNAL_IMAGE_PATH');
        $uploads_thumb_path = Configure::read('UPLOAD_THUMB_IMAGE_PATH');
        $allowed_exntentions = Configure::read('ALLOWED_IMAGE_EXTENSIONS');
        return  $this->_uploadImage($photo,$uploads_original_path,$allowed_exntentions,$uploads_thumb_path,$old_photo);
    }

    /*
     * Delete file from server after delete from database also
     */
    public function afterDeleteCommit(Event $event, EntityInterface $entity, ArrayObject $options) {
        // Delete media from directory
        if(!empty($entity->photo)) {
        
            $profile_image = $this->behaviors()
                ->get('File')
                ->deleteFile($entity->photo, Configure::read('UPLOAD_ORIGNAL_IMAGE_PATH'), Configure::read('UPLOAD_THUMB_IMAGE_PATH'), $entity->photo);
            
        }
    }
}
