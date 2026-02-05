<?php
declare(strict_types=1);

namespace App\Model\Behavior;

use Cake\ORM\Behavior;


class FieldFinderBehavior extends Behavior {

	public function field($fieldName, int $id) : ?string {
		return $this->_table->find()->select($fieldName)->where(['id' => $id])->first()->{$fieldName};
	}
}