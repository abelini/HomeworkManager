<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Table\BooksTable;
use App\Model\Table\SubjectsTable;

class MaterialController extends AppController {
    
    private BooksTable $books;
    
    private SubjectsTable $subjects;
    
    public function initialize(): void {
	    parent::initialize();
	    $this->books = $this->fetchTable('Books');
	    //$this->subjects = $this->fetchTable('Subjects');
    }
    
	public function index() {
		$subjects = $this->Subjects
						->find('list')
						->toArray();
		$book = $this->books->newEmptyEntity();
		$subjects = $this->Subjects->find()
							->contain(['Books'])
							->all();
		$youtube = $this->Options->get('youtube')->get('value');
		$channel = (json_decode($youtube))->id;
		
		$this->set(compact('subjects', 'book', 'subjects', 'channel'));
	}

    public function view($id = null)    {
        $materiale = $this->Materiales->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('materiale'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $materiale = $this->Materiales->newEmptyEntity();
        if ($this->request->is('post')) {
            $materiale = $this->Materiales->patchEntity($materiale, $this->request->getData());
            if ($this->Materiales->save($materiale)) {
                $this->Flash->success(__('The materiale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The materiale could not be saved. Please, try again.'));
        }
        $this->set(compact('materiale'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Materiale id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $materiale = $this->Materiales->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $materiale = $this->Materiales->patchEntity($materiale, $this->request->getData());
            if ($this->Materiales->save($materiale)) {
                $this->Flash->success(__('The materiale has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The materiale could not be saved. Please, try again.'));
        }
        $this->set(compact('materiale'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Materiale id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $materiale = $this->Materiales->get($id);
        if ($this->Materiales->delete($materiale)) {
            $this->Flash->success(__('The materiale has been deleted.'));
        } else {
            $this->Flash->error(__('The materiale could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
