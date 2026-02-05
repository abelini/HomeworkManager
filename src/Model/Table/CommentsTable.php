<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class CommentsTable extends Table {

    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('comments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Homeworks', [
            'foreignKey' => 'homework_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator {
	    
        $validator
            ->scalar('comment')
            ->notEmptyString('comment');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker {
        return $rules;
    }
}
