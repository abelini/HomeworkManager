<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\DisplayedPaper;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use Cake\Collection\Collection;
use Cake\ORM\Table;

class PagesController extends AppController {
	
	private const PROFESOR_TITULAR_ID = 2;
	
	//private const PROFESOR_ADJUNTO_ID = 402;
	
	public function home(){
		if(parent::$admin) {
			$this->showAdminContent();
		} else {
			//$this->setAction('showStudentHomeContent');
		}
    }
    
	public function showAdminContent(){
		$welcome = false;
		$grupos = $this->fetchTable('Groups')
						->find('list', [
							'keyField' => 'id',
							'valueField' => 'grupo'
						])
						->limit(2)
						->all()
						->toArray();

		foreach($grupos as $id => $name){
			$paper = $this->fetchTable('Papers')->find()
						->where(['group_id' => $id])
						->contain(['Groups', 'Notecomments' => ['Users']])
						->order(['expiration' => 'DESC'])
						->limit(1)
						->first();
			if($paper === null){
				$paper = $this->fetchTable('Notes')
							->find()
							->where(['group_id' => $id])
							->contain(['Groups', 'Notecomments'])
							->first();
				$welcome = true;
			}
			$grupos[$paper->group_id] = new DisplayedPaper($grupos, $paper, $this->userID);
		}
		$unacceptedStudents = $this->Users
								->find()
								->where(['accepted' => false])
								->all();

		$this->set('fullAccess', $this->fullAccessHomeworks);
		$this->set('grupos', $grupos);
		$this->set('comment', null);
		$this->set('unacceptedStudents', $unacceptedStudents);
		$this->set('user', $this->Users->get($this->Authentication->getIdentity()->getIdentifier()));
		$this->set('profe', $this->Users->get(self::PROFESOR_TITULAR_ID));
		//$this->set('profe', $this->Users->get($this->Authentication->getIdentity()->getIdentifier()));
		//$this->set('profeAdjunto', $this->Users->get(self::PROFESOR_ADJUNTO_ID));
    }
}