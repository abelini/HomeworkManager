<?php
declare(strict_types=1);

namespace App\View\Cell;

use Cake\View\Cell;
use Cake\Datasource\Exception\RecordNotFoundException;


class QuoteCell extends Cell {
	
	public function display(int $postID) {
		$posts = $this->fetchTable('Posts');
		try {
			$quote = $posts->get($postID, ['contain' => ['Users']]);
		}
		catch(RecordNotFoundException $e){
			$user = $this->fetchTable('Users')->newEntity(['nombres' => 'Alguien']);
			$quote = $posts->newEntity([
				'content' => '<span class="w3-text-gray">[Esta respuesta fue eliminada...]</span>'
			]);
			$quote->set('user', $user);
		}
		$this->set(compact('quote'));
	}
}