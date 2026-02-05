<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Table\PapersTable;
use App\Model\Table\UsersTable;
use Cake\I18n\FrozenTime;
use Cake\Database\Expression\QueryExpression;
use Cake\Http\Response;
use Cake\ORM\Query;


class PagesController extends AppController {
	
	protected PapersTable $papers;
	
	//protected UsersTable $Users;
	
	public function initialize(): void {
		$this->papers = $this->fetchTable('Papers');
		//$this->Users = $this->fetchTable('Users');
		parent::initialize();
	}
     
	public function display() : Response {
		if(parent::$admin) {
			return $this->redirect(['controller' => 'Pages', 'action' => 'home', 'prefix' => 'Admin']);
		} else {
			return $this->showStudentHomeContent();
		}
	}
    
	public function showStudentHomeContent() : Response {
		$now = FrozenTime::now();
		$welcomeMessage = false;
		$noteComment = $this->fetchTable('Notecomments')->newEmptyEntity();
		$user = $this->Users->get($this->userID); //$this->Authentication->getIdentity();
		$fullAccess = $this->fullAccessHomeworks;
		$expiration = $fullAccess ? null : 'expiration > NOW()';
		$group = $this->fetchTable('Groups')->get($this->groupID);
		$papers = $this->papers
					->find()
					->select(['id', 'name', 'slide', 'expiration'])
					->where([
						'group_id' => $this->groupID,
						$expiration
					])
					->where(function(QueryExpression $exp, Query $q) {
						return $exp->notIn('id', $this->fetchTable('Homeworks')->find()->select(['paper_id'])->where(['user_id' => $this->userID]));
					})
					->order(['expiration' => 'DESC'])
					->contain([])
					->all();

		if(!$papers->isEmpty()){
			$nextHw = $papers->last()->expiration;
			$dif = $now->diffInDays($nextHw);
			$notifColor = match($dif){
				0, 1, 2, 3 => 'w3-red w3-text-shadow w3-text-white',
				4, 5, 6, 7 => 'w3-amber w3-border w3-border-orange w3-leftbar w3-text-shadow w3-text-white',
				default => 'w3-pale-green w3-border-green w3-leftbar',
			};
			$this->set('showDays', ($dif > 0));
			$this->set('colorClass', $notifColor);
			$this->set('exp', $nextHw->format('c'));
		}
			
		$lastPaper = $this->papers
						->find()
						->where(['group_id' => $this->groupID])
						->contain([
							'Notecomments' => ['Users']
						])
						->order(['expiration' => 'DESC'])
						->first();
		if($lastPaper === null) {
			$welcomeMessage = true;
			$lastPaper = $this->fetchTable('Notes')
							->find()
							->where(['group_id' => $this->groupID])
							->contain(['Notecomments'])
							->first();
		} else {
			$noteComment->set('user_id', $this->userID);
			$noteComment->set('paper_id', $lastPaper->get('id')); // ?
		}
		
		$onlineUsers = $this->Users
							->find()
							->select(['nombres', 'email', 'photo'])
							->where([
								'online' => true,
								'group_id' => $this->groupID,
							])
							->all();	
		$profe = $this->Users->get(2);
		$this->set(compact('user', 'profe', 'group', 'papers', 'lastPaper', 'noteComment', 'onlineUsers', 'welcomeMessage', 'fullAccess'));
		return $this->render('home');
    }
}
