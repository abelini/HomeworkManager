<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Filesystem\File;

/**
 * Slide Entity
 *
 * @property int $id
 * @property int $homework_id
 * @property string $file
 *
 * @property \App\Model\Entity\Homework $homework
 */
class Slide extends Entity {
	
	private int $size;
	
	protected $_accessible = [
		'homework_id' => true,
		'file' => true,
		'homework' => true,
	];
	
	public function getSize() : int {
		$file = new File(getcwd() . SLIDES_DIRECTORY . $this->file);
		return $file->size();
	}
	
	public function getDownloadableUri() : string {
		return SLIDES_PATH . $this->file;
	}
}
