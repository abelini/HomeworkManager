<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class BooksTable extends Table {
	
	//private static $filepath;
	
	//private const HISTORIA_DE_MESOAMERICA = 1;
	
	//private const HISTORIA_DE_MEXICO = 2;

	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('books');
		$this->setDisplayField('name');
		$this->setPrimaryKey('id');

		$this->belongsTo('Subjects', [
		'foreignKey' => 'subject_id',
		'joinType' => 'INNER',
		]);
	}

	public function beforeDelete($event, $slide, $options){
		/*
		$filename = $this->field('path', ['Book.id' => $this->id]);
		$subject = $this->field('subject_id', ['Book.id' => $this->id]);
		$dir = match(intval($subject)){
			self::HISTORIA_DE_MESOAMERICA => 'Mesoamerica',
			self::HISTORIA_DE_MEXICO => 'Mexico1700-1821',
		};

		self::$filepath = getcwd(). DS .'files'. DS .'books'. DS . $dir . DS . $filename;
		*/
		return true;
	}
	
	public function afterDelete($event, $slide, $options) {
		/*
		$file = new File(self::$filepath);
		$file->delete();
		*/
	}
	
	public function validationDefault(Validator $validator): Validator {
		$validator
			->scalar('name')
			->maxLength('name', 255)
			->requirePresence('name', 'create')
			->notEmptyString('name');

		$validator
			->requirePresence('size', 'create')
			->notEmptyString('size');

		$validator
			->integer('subject_id')
			->notEmptyString('subject_id');

		$validator
			->scalar('path')
			->maxLength('path', 255)
			->requirePresence('path', 'create')
			->notEmptyString('path');

		return $validator;
	}

    public function buildRules(RulesChecker $rules): RulesChecker {
		$rules->add($rules->existsIn('subject_id', 'Subjects'), ['errorField' => 'subject_id']);
		return $rules;
	}
}
