<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsTo $Groups
 * @property \App\Model\Table\CommentsTable&\Cake\ORM\Association\HasMany $Comments
 * @property \App\Model\Table\HomeworksTable&\Cake\ORM\Association\HasMany $Homeworks
 * @property \App\Model\Table\NotecommentsTable&\Cake\ORM\Association\HasMany $Notecomments
 * @property \App\Model\Table\PostsTable&\Cake\ORM\Association\HasMany $Posts
 * @property \App\Model\Table\TopicsTable&\Cake\ORM\Association\HasMany $Topics
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table {
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('users');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('Groups', [
			'foreignKey' => 'group_id',
			'joinType' => 'INNER',
		]);
		$this->hasMany('Comments', [
			'foreignKey' => 'user_id',
			'dependent' => true,
		]);
		$this->hasMany('Homeworks', [
			'foreignKey' => 'user_id',
			'dependent' => true,
			'cascadeCallbacks' => true,
		]);
		$this->hasMany('Notecomments', [
			'foreignKey' => 'user_id',
			'dependent' => true,
		]);
		$this->hasMany('Posts', [
			'foreignKey' => 'user_id',
		]);
		$this->hasMany('Topics', [
			'foreignKey' => 'user_id',
		]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
	public function validationDefault(Validator $validator): Validator {
	    
		$validator->add('email', 'valid_email', [
			'rule' => 'email',
			'message' => 'Invalid email'
		]);
		/*
		$validator->add('nombres', 'custom', [
			'rule' => function ($value, $context) {
				return true;
			},
			'message' => 'The title is not valid'
		]);
		*/
		$validator
			->scalar('password')
			->maxLength('password', 32)
			->requirePresence('password', 'create')
			->notEmptyString('password');

		$validator
			->integer('group_id')
			->notEmptyString('group_id');

		$validator
			->scalar('nombres')
			->maxLength('nombres', 255)
			->requirePresence('nombres', 'create')
			->notEmptyString('nombres');

		$validator
			->scalar('apellidos')
			->maxLength('apellidos', 255)
			->requirePresence('apellidos', 'create')
			->notEmptyString('apellidos');

		$validator
			->email('email')
			->requirePresence('email', 'create')
			->notEmptyString('email');

		return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        //$rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
		$rules->add($rules->isUnique(['email'],  'Este correo ya se encuentra registrado.'));
        $rules->add($rules->existsIn('group_id', 'Groups'), ['errorField' => 'group_id']);

        return $rules;
    }
}
