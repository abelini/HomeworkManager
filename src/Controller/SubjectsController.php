<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;


class SubjectsController extends AppController {

	public function index() {
		$this->Flash->warning('No seas metiche');
		return $this->redirect('/');
    }


	public function view($id = null) {
		try {
			$subject = $this->Subjects->get($id);
			$this->set(compact('subject'));
		}
		catch(RecordNotFoundException $e){
			$this->Flash->warning('No existe ese programa');
			return $this->redirect('/');
		}
	}
}
