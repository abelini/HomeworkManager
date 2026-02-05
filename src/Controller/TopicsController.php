<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;


class TopicsController extends AppController {

	public function index() : Response {
		$topics = $this->paginate($this->Topics->find()->contain(['Users', 'Posts']));
		$this->set(compact('topics'));
		return $this->render();
	}

	public function view($id = null) : Response {
		$topic = $this->Topics->get($id, [
			'contain' => [
				'Users' => [
					'Groups'
				]
			],
		]);
		$replies = $this->paginate($this->Topics->Posts->find()->where(['topic_id' => $id])->contain(['Users' => ['Groups']]));
		$reply = $this->Topics->Posts->newEntity([
			'user_id' => $this->userID,
			'topic_id' => $id,
			'quoted' => 0,
		]);
		$this->set(compact('topic', 'replies', 'reply'));
		return $this->render();
	}

	public function add() : Response {
		$topic = $this->Topics->newEmptyEntity();
		if($this->request->is('post')) {
			$topic = $this->Topics->patchEntity($topic, $this->request->getData());
			if ($this->Topics->save($topic)) {
				$this->Flash->success(__('The topic has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The topic could not be saved. Please, try again.'));
		}
		$topic->set('user_id', $this->userID);
		$this->set(compact('topic'));
		return $this->render();
	}

    /**
     * Edit method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $topic = $this->Topics->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $topic = $this->Topics->patchEntity($topic, $this->request->getData());
            if ($this->Topics->save($topic)) {
                $this->Flash->success(__('The topic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The topic could not be saved. Please, try again.'));
        }
        $users = $this->Topics->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('topic', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Topic id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $topic = $this->Topics->get($id);
        if ($this->Topics->delete($topic)) {
            $this->Flash->success(__('The topic has been deleted.'));
        } else {
            $this->Flash->error(__('The topic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
