<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Subject extends Entity {

	protected $_accessible = [
		'name' => true,
		'books_path' => true,
		'program' => true,
		'books' => true,
	];
}
