<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class SubjectsTable extends Table {

	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('subjects');
		$this->setDisplayField('name');
		$this->setPrimaryKey('id');
		$this->addBehavior('FieldFinder');
		
		$this->hasMany('Books', [
			'foreignKey' => 'subject_id',
		]);
	}

	public function validationDefault(Validator $validator): Validator {
		$validator
			->scalar('name')
			->maxLength('name', 32)
			->requirePresence('name', 'create')
			->notEmptyString('name');

		return $validator;
	}
}