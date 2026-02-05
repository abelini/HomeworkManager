<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;


class NotecommentsController extends AppController {

    public function add() : Response {
		$notecomment = $this->Notecomments->newEmptyEntity();
		if($this->request->is('post')) {
			$notecomment = $this->Notecomments->patchEntity($notecomment, $this->request->getData());
			if($this->Notecomments->save($notecomment)) {
				$this->Flash->success('Comentario guardado', ['key' => 'Paper-'.$this->request->getData('paper_id')]);
			} else {
				$this->Flash->error('Error al guardar...', ['key' => 'Paper-'.$this->request->getData('paper_id')]);
			}
		}
		return $this->redirect($this->referer() . '#PaperID-' . $this->request->getData('paper_id'));
	}

	public function delete($id = null) : Response {
		$this->request->allowMethod(['post', 'delete']);
		$notecomment = $this->Notecomments->get($id);
		$paperID = $notecomment->get('paper_id');
		if ($this->Notecomments->delete($notecomment)) {
			$this->Flash->success('Comentario eliminado');
		} else {
			$this->Flash->error('Error al intentar eliminar...');
		}
		return $this->redirect($this->referer() . '#PaperID-' . $paperID);
	}
}
