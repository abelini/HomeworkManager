<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class OptionsTable extends Table {

	public function initialize(array $config): void {
		parent::initialize($config);
		
		$this->setTable('options');
		$this->setDisplayField('name');
		$this->setPrimaryKey('name');
		$this->addBehavior('FieldFinder');
		//$this->getSchema()->setColumnType('value', 'json') : array;
	}

	public function validationDefault(Validator $validator): Validator {
		$validator
			->scalar('value')
			->maxLength('value', 255)
			->requirePresence('value', 'create')
			->notEmptyString('value');

		return $validator;
	}
}
