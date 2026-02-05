<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;
//use App\Model\Entity\Paper;
use App\Model\Entity\NoteComment;


class DisplayedPaper {
	
	public string $grupo;
	
	public object $HW;
	
	public NoteComment $comment;
	
	public function __construct(array $groups, $paper, int $userID) {
		$this->grupo = $groups[$paper->group_id];
		$this->HW = $paper;
		$this->comment = TableRegistry::getTableLocator()->get('Notecomments')->newEmptyEntity();
		$this->comment->set([
			'user_id' => $userID,
			'paper_id' => $paper->id
		]);
	}
}