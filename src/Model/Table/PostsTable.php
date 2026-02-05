<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class PostsTable extends Table {

    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('posts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Topics', [
            'foreignKey' => 'topic_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
    }

	public function validationDefault(Validator $validator): Validator {
		$validator
			->integer('topic_id')
			->notEmptyString('topic_id');

		$validator
			->scalar('content')
			//->requirePresence('content', 'create')
			->notEmptyString('content');

		$validator
			->integer('user_id')
			->notEmptyString('user_id');

		return $validator;
	}

	public function buildRules(RulesChecker $rules): RulesChecker {
		$rules->add($rules->existsIn('topic_id', 'Topics'), ['errorField' => 'topic_id']);
		$rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);

		return $rules;
	}
}