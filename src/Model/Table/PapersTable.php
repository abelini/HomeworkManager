<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Entity\Paper;

class PapersTable extends Table {

    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('papers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Groups', [
            'foreignKey' => 'group_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Homeworks', [
            'foreignKey' => 'paper_id',
        ]);
        $this->hasMany('Notecomments', [
            'foreignKey' => 'paper_id',
        ]);
    }
    
    /*
    public function beforeSave(EventInterface $event, Paper $entity, \ArrayObject $options){
	    return true; //debug($event); debug($entity); debug($options);exit();return false;
    }
    */

    public function validationDefault(Validator $validator): Validator {

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', true)
            ->notEmptyString('name');

        $validator
            ->dateTime('expiration')
            ->requirePresence('expiration', true)
            ->notEmptyDateTime('expiration');
		
        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker {
        $rules->add($rules->existsIn('group_id', 'Groups'), ['errorField' => 'group_id']);
        return $rules;
    }
}
