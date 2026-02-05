<?php
declare(strict_types=1);

namespace App\Iterator;


class ImageFilter extends \FilterIterator {
	
	private static string $prefix;
	
	public function __construct(\Iterator $iterator, string $prefix) {
		parent::__construct($iterator);
		self::$prefix = $prefix;
	}
	
	public function accept() : bool {
		$filename = $this->getInnerIterator()->current()->getFilename();
		return str_starts_with($filename, self::$prefix);
    }
}