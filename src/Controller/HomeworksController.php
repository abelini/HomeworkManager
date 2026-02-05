<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;
use Cake\View\View;
use Cake\View\Helper\UrlHelper as URL;


class HomeworksController extends AppController {
	
	private const IMAGES_PATH = '/home/historia/public_html/webroot/img/docs';
	
	
    public function index() : Response {
		$sum = 0;
		$homeworks = $this->Homeworks
						->find()
						->where(['user_id' => $this->userID])
						->all();
		$papers = $this->fetchTable('Papers')
						->find()
						->where(['group_id' => $this->groupID])
						->all();
		$user = $this->Homeworks->Users->get($this->userID);
		$this->set(compact('homeworks', 'papers', 'user', 'sum'));
		return $this->render();
    }
    
	public function view($id = null) : Response {
		try {
			$homework = $this->Homeworks->get($id, [
				'contain' => [
					'Users' => [
						'fields' => ['id', 'nombres', 'apellidos', 'email', 'photo'],
						'Groups' => [
							'fields' => ['id', 'grupo', 'icon']
						]
					],
					'Papers' => [
						'fields' => ['id', 'name', 'slide', 'expiration'],
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
			if($homework->get('user_id') !== $this->userID){
				$this->Flash->error('La tarea solicitada no te pertenece...');
				return $this->redirect(['action' => 'index']);
			}
			$now = FrozenTime::now();
			$fullAccess = $this->fullAccessHomeworks;
			$this->set(compact('homework', 'comment', 'now', 'fullAccess'));
		} catch(RecordNotFoundException $e){
			$this->Flash->error('No inventes números... esa tarea ni siquiera existe...');
			return $this->redirect(['action' => 'index']);
		}
		return $this->render();
    }

	public function add() : Response {
		$homework = $this->Homeworks->newEmptyEntity();
		
		if ($this->request->is('post')) {
			$paperID = $this->request->getData('paper_id');
			$now = FrozenTime::now();
			$paper = $this->Homeworks->Papers->get($paperID);

			if($paper->expiration->lessThanOrEquals($now) && $this->fullAccessHomeworks === false){
				$this->Flash->error('Esta tarea ya expiró y no se puede subir...');
				return $this->redirect('/');
			}
			
			$data = $this->request->getParsedBody();
			
			if($this->request->getUploadedFile('slide.file')) {
				$file = $this->request->getUploadedFile('slide.file');
				if(str_contains($file->getClientMediaType(), 'powerpoint') || str_contains($file->getClientMediaType(), 'presentation')) {
					$ext = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);
					$fileName = $this->userID . '-' . md5((string) $now->timestamp) .'.'. $ext;
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
			return $this->redirect(['controller' => 'homeworks', 'action' => 'index']);
		}
		
		$action = 'Nueva tarea';
		$homework = $this->Homeworks->patchEntity($homework, ['paper_id' => $this->request->getQuery('PaperID'), 'user_id' => $this->userID]);
		$paper = $this->fetchTable('Papers')->get($this->request->getQuery('PaperID'));
		$this->set(compact('homework', 'paper', 'action'));
		return $this->render();
	}
	
	/***********************
	*
	public function save() : Response {
		$homework = $this->Homeworks->newEmptyEntity();
		
		if ($this->request->is('post')) {
			$paperID = $this->request->getData('paper_id');
			$now = FrozenTime::now();
			$paper = $this->Homeworks->Papers->get($paperID);
			
			$data = $this->request->getParsedBody();
			
			debug($this->request->getParsedBody());
			debug($this->request->getData());
			exit();
			$homework = $this->Homeworks->patchEntity($homework, $data);
			if($this->Homeworks->save($homework)) {
				$this->Flash->success('Tarea guardada');
			} else {
				$this->Flash->error('Error al guardar');
			}
			return $this->redirect(['controller' => 'homeworks', 'action' => 'index']);
		}
		
		$action = 'Nueva tarea';
		$homework = $this->Homeworks->patchEntity($homework, ['paper_id' => $this->request->getQuery('PaperID'), 'user_id' => $this->userID]);
		$paper = $this->fetchTable('Papers')->get($this->request->getQuery('PaperID'));
		$this->set(compact('homework', 'paper', 'action'));
		return $this->render();
	}

	/***********************
	*/

    public function edit($id = null) : Response {
        $homework = $this->Homeworks->get($id, [
            'contain' => [],
        ]);
		$paper = $this->fetchTable('Papers')->get($homework->paper_id);
		$action = 'Modificar tarea';
		
        if ($this->request->is(['patch', 'post', 'put'])) {
			$homework = $this->Homeworks->patchEntity($homework, $this->request->getData());
			$now = FrozenTime::now();
			$paper = $this->Homeworks->Papers
									->find()
									->where(['id' => $homework->paper_id])
									->first();

			if($paper->expiration->lessThanOrEquals($now) && $this->fullAccessHomeworks === false){
				$this->Flash->error('Esta tarea ya expiró y no se puede modificar...');
				return $this->redirect(['action' => 'index']);
			}
			
            if ($this->Homeworks->save($homework)) {
                $this->Flash->success('Tarea guardada');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The homework could not be saved. Please, try again.'));
        }
        $this->set(compact('homework', 'paper', 'action'));
		return $this->render('add');
    }
	
	public function imageUpload() : Response {
		if(empty($this->request->getQuery('uID'))){
			$error = json_decode('{"message": "uID lost..."}');
			$this->set(compact('error'));
			$this->viewBuilder()->setOption('serialize', ['error']);
		} 
		else {
			$image = $this->request->getData('upload');
			$time = FrozenTime::now();
			$ext = pathinfo($image->getClientFilename(), PATHINFO_EXTENSION);
			$fileName = $time->format('Y-m') .'_HW_uID'. $this->request->getQuery('uID') .'-pID'. $this->request->getQuery('pID') .'_'. $time->microsecond . rand(0, 9) .'.'. $ext;
			$path =  self::IMAGES_PATH . DS . $fileName;

			$image->moveTo($path);
			
			$urlHelper = new URL(new View());
			$url = $urlHelper->image('/img/docs/'. $fileName, ['fullBase' => true]);
			$this->set(compact('url'));

			$this->viewBuilder()->setOption('serialize', ['url']);
		}
		
		$this->viewBuilder()->setOption('jsonOptions', JSON_FORCE_OBJECT);
		$this->viewBuilder()->setClassName('Json');
		return $this->render();
	}

	/**
	 * This is for testing porpuses
	 *
	public function multipleImageUpload() : Response {
		if(empty($this->request->getQuery('uID'))){
			$error = json_decode('{"message": "No se puede generar el nombre del archivo. Por favor seleccione primero un alumno."}');
			$this->set(compact('error'));
			$this->viewBuilder()->setOption('serialize', ['error']);
		} 
		else {
			$image = $this->request->getData('upload');
			$time = FrozenTime::now();
			$ext = pathinfo($image->getClientFilename(), PATHINFO_EXTENSION);
			$fileName = $time->format('Y-m') .'_HW_uID'. $this->request->getQuery('uID') .'-pID'. $this->request->getQuery('pID') .'_'.$time->microsecond . rand(0, 9) .'.'. $ext;
			$image->moveTo('/home/historia/public_html/webroot/tmp/' . $fileName);
			$urlHelper = new URL(new View());
			$url = $urlHelper->image('/tmp/'. $fileName, ['fullBase' => true]);
			$this->set(compact('url'));
			$this->viewBuilder()->setOption('serialize', ['url']);
		}
		$this->viewBuilder()->setOption('jsonOptions', JSON_FORCE_OBJECT);
		$this->viewBuilder()->setClassName('Json');
		return $this->render();
	}
	*/
}