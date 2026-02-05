<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Paper extends Entity {
	
	private const SLIDE_ICON = '<i class="fa-regular fa-file-powerpoint"></i>';
	
	private const HW_ICON = '<i class="fa-regular fa-file-word"></i>';
	
	protected $_accessible = [
		'group_id' => true,
		'name' => true,
		'slide' => true,
		'description' => true,
		'created' => true,
		'modified' => true,
		'expiration' => true,
		'group' => true,
		'homeworks' => true,
		'notecomments' => true,
	];
    
    	public function isExpirable() : bool {
		return true;
	}
	
	protected function _setName($title) : string {
		return $title;
	}
	
	public function icon() : string {
		return $this->requireSlide()?  self::SLIDE_ICON : self::HW_ICON;
	}
	
	public function getUndone(int $unrated) : string {
		$undone = '';
		if ($unrated > 0 && $unrated < 10)
			$undone = ' <span class="unrated lt10">'.$unrated.'</span>';
		else if ($unrated >= 10)
			$undone = ' <span class="unrated">'.$unrated.'</span>';
		
		return $undone;
	}
	
	protected function _getName($name) : ?string {
		if($name === null){
			return null;
		}
		if(strcmp(mb_strtoupper($name), $name) == 0) {
			$name = mb_convert_case(mb_strtolower($name), MB_CASE_TITLE);
		}
		return $name;
	}
	
	protected function _getDescription($d) : ?string {
		if($d === null)
			return null;
		else
			return preg_replace("/<p[^>]*>(?:\s|&nbsp;)*<\/p>/", '', $d); 
	}
	
	public function summary() : string {
		return mb_substr(strip_tags($this->description, '<br>'), 0, 250) . "\n[...]";
	}
	
	public function getName() : string {
		$name = $this->name;
		if(strcmp(mb_strtoupper($name), $name) == 0) {
			$name = mb_convert_case(mb_strtolower($name), MB_CASE_TITLE);
		} 
		if(str_contains(mb_strtolower($name), 'video')) {
			$name = '<i class="fa-solid fa-video"></i> ' . $name;
		}
		if($this->slide) {
			$name = '<i class="fa-regular fa-file-powerpoint"></i> ' . $name;
		}
		return $name;
	}
	
	public function requireSlide() : bool {
		return (bool) $this->get('slide');
	}
}