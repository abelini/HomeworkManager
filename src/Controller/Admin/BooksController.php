<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;


class BooksController extends AppController {
 
    public function index() {
        $this->paginate = [
            'contain' => ['Subjects'],
        ];
        $books = $this->paginate($this->Books);

        $this->set(compact('books'));
    }

    public function view($id = null) {
        $book = $this->Books->get($id, [
            'contain' => ['Subjects'],
        ]);

        $this->set(compact('book'));
    }

    public function add() {
        $book = $this->Books->newEmptyEntity();
        if ($this->request->is('post')) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $subjects = $this->Books->Subjects->find('list', ['limit' => 200])->all();
        $this->set(compact('book', 'subjects'));
    }

    public function edit($id = null) {
        $book = $this->Books->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $subjects = $this->Books->Subjects->find('list', ['limit' => 200])->all();
        $this->set(compact('book', 'subjects'));
    }

	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$book = $this->Books->get($id);
		if (true /*$this->Books->delete($book)*/) {
			$this->Flash->success('Primero hay que implementar el borrado de archivos despues del borrado del registro... Libro NO eliminado.', ['key' => 'books-list']);
		} else {
			$this->Flash->error(__('The book could not be deleted. Please, try again.'));
		}
		
		return $this->redirect(['controller' => 'material', 'action' => 'index']);
	}
}
