<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;

class StaticPagesController extends AppController {
	
	public function beforeFilter($event) {
		parent::beforeFilter($event);
		$this->Authentication->allowUnauthenticated(['privacyPolicy', 'termsAndConditions']);
	}
	
	public function privacyPolicy(){
		$this->set('dt', \Cake\I18n\FrozenTime::now());
	}
	
	public function termsAndConditions(){
	}
	
	public function beforeRender($event){
		$this->viewBuilder()->setLayout('landing');
		$background = match($this->subjectID) {
			1 => '/img/courses/bg/battle-tenochtitlan.webp',
			2 => '/img/courses/bg/mexico1700-1810.webp',
		};
		$cover = match($this->subjectID) {
			1 => '/img/courses/bg/tlatoani.webp',
			2 => '/img/courses/bg/landing.webp',
		};
		$this->set(compact('background', 'cover'));
	}
}