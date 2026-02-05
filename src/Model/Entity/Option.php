<?php
declare(strict_types=1);

namespace App\Model\Entity;

use \stdClass;
use Cake\ORM\Entity;
use Cake\I18n\FrozenTime;


class Option extends Entity {

	protected $_accessible = [
		'value' => true,
	];
	
	protected function _setValue(array $value) : string {
		return json_encode($value);
	}
	
	protected function getObject() : stdClass {
		return json_decode($this->value);
	}
	
	protected function _getAllow() : stdClass {
		return $this->getObject();
	}
	
	protected function _getExpiration() : ?stdClass {
		$lock = $this->getObject();
		$lock->expiration = new FrozenTime($lock->expiration);
		return $lock;
	}

	protected function _getCourseID() : int {
		return $this->getObject()->subjectID;
	}
	
	protected function _getYouTubeChannelID() : string {
		return $this->getObject()->id;
	}
	
	public function getfullAccessHomeworks() : bool {
		return $this->getObject()->fullAccess;
	}
	
	public function getNPScoreValue() : int {
		return $this->getObject()->NP;
	}
	
	public function getNVScoreValue() : int {
		return $this->getObject()->NV;
	}
}