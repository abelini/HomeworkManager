<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Http\Response;
use Cake\I18n\FrozenTime;
use Cake\ORM\Query;
use Cake\Database\Expression\QueryExpression;
use Cake\Mailer\MailerAwareTrait;
use Cake\Datasource\Exception\RecordNotFoundException;
use App\Controller\AppController;


class HomeworksController extends AppController {
	
	use MailerAwareTrait;
	
	private static $images = [];
	
    public function index() {
        $this->paginate = [
            'contain' => ['Users', 'Papers'],
        ];
        $homeworks = $this->paginate($this->Homeworks);

        $this->set(compact('homeworks'));
    }

	public function view($id = null) {
		$homework = $this->Homeworks->get($id, [
			'contain' => [
				'Users' => [
					'fields' => ['id', 'nombres', 'apellidos', 'photo', 'email'],
					'Groups' => [
						'fields' => ['id', 'grupo', 'icon']
					]
				],
				'Papers' => [
					'fields' => ['id', 'name', 'slide'],
				],
				'Comments' => [
					'Users'
				],
				'Slides' => [
					'fields' => ['id', 'homework_id', 'file']
				]
			],
		]);
		$comment = $this->Homeworks->Comments->newEntity([
			'user_id' => $this->userID,
			'homework_id' => $id,
		]);
		$scoreValues = ['NP' => '- No Presentado', 'NV' => '- No Valorable', 6 => ' 6 (D)', 7 => ' 7 (C)', 8 => ' 8 (B)', 9 => ' 9 (A)', 10 => ' 10 (A+)'];
		$this->set(compact('homework', 'comment', 'scoreValues'));
		//$this->filter($homework);
    }

    public function add() {
		$homework = $this->Homeworks->newEmptyEntity();
		if ($this->request->is(['post', 'get'])) {
			$homework = $this->Homeworks->patchEntity($homework, $this->request->getData());
			$paper = $this->Homeworks->Papers->get($this->request->getData('paper_id'));
			$subquery = $this->Homeworks
							->find('all')
							->select(['user_id'])
							->where(['paper_id' => $paper->id]);
			$alumnos = $this->fetchTable('Users')
							->find('list',  [
								'keyField' => 'id',
								'valueField' => 'nombres'
							])
							->where(['group_id' => $paper->group_id])
							->where(function(QueryExpression $exp) use($subquery){
								return $exp->notIn('id', $subquery);
							})
							->toArray();

			$this->set(compact('homework', 'paper', 'alumnos'));
			return $this->render();
		} else if($this->request->is('put')){
			/* real save
			if ($this->Homeworks->save($homework)) {
				$this->Flash->success(__('The homework has been saved.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The homework could not be saved. Please, try again.'));
			*/
		}
		$this->set(compact('homework', 'users', 'papers'));
    }
	
	public function score(){
		if ($this->request->is(['patch', 'post', 'put'])) {
			$id = $this->request->getData('id');
			$homework = $this->Homeworks->patchEntity($this->Homeworks->get($id, ['contain' => ['Users', 'Papers']]), $this->request->getData());
			if ($this->Homeworks->save($homework)) {
				$this->Flash->success('Tarea calificada', ['key' => 'score']);
				$this->getMailer('Homework')->score($homework, parent::$title);
			} else {
				$this->Flash->error('Error al calificar', ['key' => 'score']);
			}
		}
		return $this->redirect($this->referer() . '#score');
	}
	
	public function save() : Response {
		if ($this->request->is('post')) {
			$homework = $this->Homeworks->newEmptyEntity();
			$data = $this->request->getParsedBody();
			$paperID = $this->request->getData('paper_id');
			
			if($this->request->getUploadedFile('slide.file')) {
				$file = $this->request->getUploadedFile('slide.file');
				if(str_contains($file->getClientMediaType(), 'powerpoint') || str_contains($file->getClientMediaType(), 'presentation')) {
					$ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
					$fileName = $this->userID . '-' . md5((string) FrozenTime::now()->timestamp) .'.'. $ext;
					$path = getcwd() . SLIDES_DIRECTORY . $fileName;
					$file->moveTo($path);
					$data['slide'] = ['file' => $fileName];
				} else {
					$this->Flash->error('No es un archivo de Power Point&reg;');
					return $this->redirect($this->referer());
				}
			}
			
			$homework = $this->Homeworks->patchEntity($homework, $data);
			
			if($this->Homeworks->save($homework)) {
				$this->Flash->success('Tarea guardada');
			} else {
				$this->Flash->error('Error al guardar');
			}
			return $this->redirect(['controller' => 'papers', 'action' => 'itemize', $paperID]);
		} else {
			return $this->redirect(['controller' => 'papers', 'action' => 'browse']);
		}
	}
	
	public function untimely() : Response {
		try {
			$alumno = $this->fetchTable('Users')->get($this->request->getQuery('a'));
			$paper = $this->fetchTable('Papers')->get($this->request->getQuery('hw'));
		} catch(RecordNotFoundException $e) {
			$this->Flash->error('Alumno y/o Tarea no existen. Por favor no modifiques manualmente la URI.');
			return $this->redirect(['controller' => 'groups', 'action' => 'kardex', $this->request->getQuery('g')]);
		}
		$calificaciones = [6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10];
		$tarea = $this->Homeworks->newEntity([
			'user_id' => $alumno->id,
			'paper_id' => $paper->id
		]);
		$this->set(compact('calificaciones', 'alumno', 'paper', 'tarea'));
		return $this->render();
	}
	
	public function edit($id = null) {
		$homework = $this->Homeworks->get($id, ['contain' => ['Slides']]);
		if ($this->request->is('PUT')) {
			$homework = $this->Homeworks->patchEntity($homework, $this->request->getData());
			if ($this->Homeworks->save($homework)) {
				$this->Flash->success(__('The homework has been modified.'));
				return $this->redirect(['controller' => 'papers', 'action' => 'browse']);
			}
			$this->Flash->error(__('The homework could not be saved. Please, try again.'));
		}
		$user = $this->Homeworks->Users->find()->where(['id' => $homework->user_id])->first();
		$papers = $this->Homeworks->Papers->find()->where(['group_id' => $user->group_id])->all();
		$this->set(compact('homework', 'user', 'papers'));
	}
	
	
    public function delete($id = null) : Response {
		$this->request->allowMethod(['post', 'delete']);
		$homework = $this->Homeworks->get($id);
		$paperID = $homework->paper_id;
		if ($this->Homeworks->delete($homework)) {
			$this->Flash->success('Tarea eliminada');
		} else {
			$this->Flash->error('Error al eliminar la tarea');
		}
		return $this->redirect(['controller' => 'papers', 'action' => 'itemize', $paperID]);
    }
}