<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;


class CommentsController extends AppController {

    public function index() {
        $this->paginate = [
            'contain' => ['Users', 'Homeworks'],
        ];
        $comments = $this->paginate($this->Comments);

        $this->set(compact('comments'));
    }

    public function view($id = null) {
        $comment = $this->Comments->get($id, [
            'contain' => ['Users', 'Homeworks'],
        ]);

        $this->set(compact('comment'));
    }

	public function add() {
		$comment = $this->Comments->newEmptyEntity();
		if ($this->request->is('post')) {
			$comment = $this->Comments->patchEntity($comment, $this->request->getData());
			if ($this->Comments->save($comment)) {
				$this->Flash->success('Comentario registrado', ['key' => 'comments']);
			} else {
				$this->Flash->error('Error al guardar el comentario', ['key' => 'comments']);
			}
		}
		return $this->redirect($this->referer() . '#comments');
	}

    public function edit($id = null) {
        $comment = $this->Comments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The comment could not be saved. Please, try again.'));
        }
        $users = $this->Comments->Users->find('list', ['limit' => 200])->all();
        $homeworks = $this->Comments->Homeworks->find('list', ['limit' => 200])->all();
        $this->set(compact('comment', 'users', 'homeworks'));
    }

	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$comment = $this->Comments->get($id);
		if ($this->Comments->delete($comment)) {
			$this->Flash->success('Comentario eliminado', ['key' => 'comments']);
		} else {
			$this->Flash->error('Error al eliminar el comentario', ['key' => 'comments']);
		}
		return $this->redirect($this->referer() . '#comments');
	}
}
