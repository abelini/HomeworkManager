<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Notecomment extends Entity {

    protected $_accessible = [
        'comment' => true,
        'user_id' => true,
        'paper_id' => true,
        'created' => true,
        'user' => true,
        'paper' => true,
    ];
    
	protected function _getComment($comment) {
		if($comment === null)
			return null;
		else
			return nl2br($comment);
	}
}
