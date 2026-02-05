<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Datasource\FactoryLocator;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\I18n\FrozenTime;


class Homework extends Entity {
	
	protected $_accessible = [
        'user_id' => true,
        'paper_id' => true,
        'titulo' => true,
        'texto' => true,
        'created' => true,
        'modified' => true,
        'score' => true,
        'user' => true,
        'paper' => true,
        'comments' => true,
        'slide' => true,
    ];
	
	public function getScoreValue() : string {
		if(ctype_alpha((string) $this->score)) {
			$method = match($this->score) {
				'NV' => 'getNVScoreValue',
				'NP' => 'getNPScoreValue'
			};
			$sc = FactoryLocator::get('Table')->get('Options')->get('scoreConfig')->$method();
			return "{$this->score} ({$sc})";
		} else if((int) $this->score == 0) {
			return 'No se ha calificado...';
		}
		return "{$this->score}";
	}
	
	public function getScoreINTValue() : int {
		if(ctype_alpha((string) $this->score)) {
			$method = match($this->score){
				'NV' => 'getNVScoreValue',
				'NP' => 'getNPScoreValue'
			};
			$sc = FactoryLocator::get('Table')->get('Options')->get('scoreConfig')->$method();
			return $sc;
		}
		return intval($this->score);
	}
	
	protected function _getScore($rating){
		if(ctype_digit($rating))
			return (int) $rating;
		else
			return $rating;
	}
	
	public function getHTMLSource() : string {
		return $this->texto ?? '<p>null</p>';
	}
	
	public function getImagePrefix(int $uid = 0) : string {
		if($uid != 0)
			return $this->created->format('Y-m').'_HW_uID'.$uid.'-pID'.$this->paper_id.'_';
		else
			return $this->created->format('Y-m').'_HW_uID'.$this->user_id.'-pID'.$this->paper_id.'_';
	}
}