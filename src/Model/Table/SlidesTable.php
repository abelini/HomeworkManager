<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Filesystem\File;


class SlidesTable extends Table {
	
	private static ?string $slideFile = null;
	
	public function initialize(array $config): void  {
		parent::initialize($config);

		$this->setTable('slides');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->belongsTo('Homeworks', [
			'foreignKey' => 'homework_id',
			'joinType' => 'INNER',
		]);
    }
	
	public function beforeDelete($event, $slide, $options){
		self::$slideFile = getcwd() . SLIDES_PATH . $slide->file;
		return true;
	}
	
	public function afterDelete($event, $slide, $options) {
		$file = new File(self::$slideFile);
		$file->delete();
	}
	
    public function validationDefault(Validator $validator): Validator {
        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker {
        $rules->add($rules->existsIn('homework_id', 'Homeworks'), ['errorField' => 'homework_id']);

        return $rules;
    }
}
