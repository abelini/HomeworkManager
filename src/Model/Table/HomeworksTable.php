<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Iterator\ImageFilter;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Filesystem\File;


class HomeworksTable extends Table {
	
	private static $images = [];

	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('homeworks');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
			'joinType' => 'INNER',
		]);
		$this->belongsTo('Papers', [
			'foreignKey' => 'paper_id',
			'joinType' => 'INNER',
		]);
		$this->hasMany('Comments', [
			'foreignKey' => 'homework_id',
		]);
		$this->hasOne('Slides')
			->setForeignKey('homework_id')
			->setDependent(true)
			->setCascadeCallbacks(true);
	}
    
	public function beforeDelete(EventInterface $event, EntityInterface $homework, \ArrayObject $options) {
		$content = $homework->get('texto');
		if(!empty($content)){
			$dom = new \DOMDocument();
			$dom->loadHTML($content, LIBXML_NOERROR);
			$imageTags = $dom->getElementsByTagName('img');
			foreach($imageTags as $image){
				self::$images[] = str_replace(DOMAIN, getcwd(), $image->getAttribute('src'));
			}
			$dom = null;
		}
		return true;
	}
    
	public function afterDelete(EventInterface $event, EntityInterface $homework, \ArrayObject$options) {
	    foreach(self::$images as $image){
			$file = new File($image); 
			$file->delete();
		}
	}
    
	public function afterSave(EventInterface $event, EntityInterface $homework, \ArrayObject $options) {
		$imagesInText = [];
		$usedImages = [];

		$dom = new \DOMDocument();
		$dom->loadHTML($homework->getHTMLSource(), LIBXML_NOERROR);
		$imageTags = $dom->getElementsByTagName('img');
		
		foreach ($imageTags as $image) {
			if ($image->getAttribute('src') !== '') {
				$imagesInText[] = str_replace(WWW_DOMAIN, getcwd(), $image->getAttribute('src'));
			}
		}

		foreach (array_filter($imagesInText) as $image) {
			$usedImages[] = (new \SplFileObject($image))->getFilename();
		}
		$dir = new \DirectoryIterator(TEST_IMAGES_PATH);
		$imageIterator = new ImageFilter($dir, $homework->getImagePrefix());

		foreach ($imageIterator as $image) {
			if (in_array($image->getFilename(), $usedImages)) {
			} else {
				@unlink($image->getPathname());
			}
		}
    }
    
	public function findUnrated(Query $query, array $options) : Query {
		return $query->where(['score' => 0]);
	}
    
    
    public function validationDefault(Validator $validator): Validator {
        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

        $validator
            ->integer('paper_id')
            ->notEmptyString('paper_id');

        $validator
            ->scalar('titulo')
            ->maxLength('titulo', 255)
            ->allowEmptyString('titulo');

        $validator
            ->scalar('texto')
            ->maxLength('texto', 4294967295)
            ->allowEmptyString('texto');

        $validator
            ->scalar('score')
            ->maxLength('score', 2)
            ->notEmptyString('score');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker {
        $rules->add($rules->existsIn('user_id', 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn('paper_id', 'Papers'), ['errorField' => 'paper_id']);

        return $rules;
    }
}
