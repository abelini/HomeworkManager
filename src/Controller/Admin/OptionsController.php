<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Database\Expression\QueryExpression;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Http\Response;
use Cake\ORM\Query;


class OptionsController extends AppController {
	
	private const IMAGES_PATH = '/home/historia/public_html/webroot/img/docs/';
	
	private const SLIDES_PATH = '/home/historia/public_html/webroot/files/slides/';

	public function index() : Response {
		$options = $this->Options
						->find('list', [
							'keyField' => 'name',
							'valueField' => function($option){
								return json_decode($option->value);
							},
						])
						->all()
						->toArray();
		$scores = [0, 1, 2, 3, 4, 5, 6];
		$subjects = $this->Subjects->find('list')->toArray();
		$this->set(compact('options', 'scores', 'subjects'));
		return $this->render();
    }

	public function setCourse() : Response {
		if($this->request->is('PUT')) {	
			$option = $this->Options->get('course');
			$option->set('value', ['subjectID' => (int) $this->request->getData('value')]);
			$this->Options->save($option);
			
			$this->Flash->success('Nombre actualizado', ['key' => 'config-name']);
		}
		return $this->redirect(['action' => 'index']);
    }
    
    public function setLockHomeworks() : Response {
		if($this->request->is('PUT')) {
			$option = $this->Options->get('homeworks');
			$option->set('value', ['fullAccess' => (bool) $this->request->getData('Homeworks.fullAccess')]);
			$this->Options->save($option);

			$this->Flash->success('Configuración actualizada', ['key' => 'config-homeworks']);
		}
		return $this->redirect(['action' => 'index']);
    }

    public function setPlatformLock() : Response {
		if($this->request->is('PUT')) {
			$lockConfig = $this->request->getData('Lock');
			$lockConfig['status'] = (bool) $this->request->getData('Lock.status');
						
			$option = $this->Options->get('lock');
			$option->set('value', $lockConfig);
			$this->Options->save($option);
			
			$this->Flash->success('Configuración actualizada', ['key' => 'config-lock']);
		}
		return $this->redirect(['action' => 'index']);
    }
    
	public function setAllowSignup() : Response {
		if($this->request->is('PUT')) {	
			$option = $this->Options->get('register');
			$option->set('value', ['allow' => (bool) $this->request->getData('Register.allow')]);
			$this->Options->save($option);
			
			$this->Flash->success('Configuración actualizada', ['key' => 'config-signup']);
		}
		return $this->redirect(['action' => 'index']);
    }
    
    public function setScoreValues() : Response {
	    if($this->request->is('PUT')) {		
			$option = $this->Options->get('scoreConfig');
			$option->set('value', [
				'NP' => (int) $this->request->getData('scoreConfig.NP'),
				'NV' => (int) $this->request->getData('scoreConfig.NV'),
			]);
			$this->Options->save($option);
			
			$this->Flash->success('Configuración actualizada', ['key' => 'config-score']);
		}
		return $this->redirect(['action' => 'index']);
	}

	public function view($id = null) : Response {
		$option = $this->Options->get();
		$this->set(compact('option'));
		return $this->render();
	}

	public function add() : Response {
		$option = $this->Options->newEmptyEntity();
		if ($this->request->is('post')) {
			$option = $this->Options->patchEntity($option, $this->request->getData());
			if ($this->Options->save($option)) {
				$this->Flash->success(__('The option has been saved.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The option could not be saved. Please, try again.'));
		}
		$this->set(compact('option'));
		return $this->render();
    }
	
	/**
	 * DO NOT EXECUTE UNTIL SEMESTER IS OVER
	 *
	 * @method
	 * @info Commented for security porpuses
	 */
	/*
	public function startOver() {
		if($this->request->is('post')) {
			// Eliminar alumnos que no tengan estrellas y sus tareas
			$notStarredUsers = $this->Users->find()
										->where(['starred' => false, 'admin' => false, 'group_id IN' => [1, 2]])
										->all();					
			$notStarredUsersNO = $notStarredUsers->count();
			$this->Users->deleteMany($notStarredUsers);
			
			// Eliminar comentarios de las tareas
			$this->fetchTable('Notecomments')->deleteAll([1 => 1]);
			$this->fetchTable('Comments')->deleteAll([1 => 1]);
			
			// Pasar a los alumnos que no se borraron al Salon de la Fama
			$this->Users->query()
						->update()
						->set(['group_id' => 99])
						->where(['starred' => true, 'admin' => false])
						->execute();
			
			// Poner todas las tareas en el grupo 99
			$this->fetchTable('Papers')->query()
									->update()
									->set(['group_id' => 99])
									->where([1 => 1])
									->execute();
			
			// Eliminar las tareas que hayan quedado y que no tengan trabajos
			$papersWithNoHws = $this->fetchTable('Papers')->find()
														->notMatching('Homeworks')
														->all();
			$papersWithNoHwsNO = $papersWithNoHws->count();
			if($papersWithNoHws->count() > 0) {
				$this->fetchTable('Papers')->deleteMany($papersWithNoHws);
			}
			
			$this->set(compact('notStarredUsersNO','papersWithNoHwsNO'));
			
			//
			
			$imagesDeletedCount = 0;
			$orphanedPics = array();
			$moreThanOneParent = array();
			$directory = new Folder(self::IMAGES_PATH);
			$files = $directory->find('.*\.*', true);
			
			foreach($files as $file) {
				$results = $this->Homeworks
								->find()
								->where(function(QueryExpression $exp, Query $q) use ($file) {
									return $exp->like('texto', "%{$file}%");
								})
								->count();
				if($results == 0) {
					$picture = new File(self::IMAGES_PATH . $file);
					$picture->delete();
					$picture->close();
					$imagesDeletedCount++;
				} else if($results > 1) {
					array_push($moreThanOneParent, $file);
				}
			}
			$this->set(compact('imagesDeletedCount', 'orphanedPics', 'moreThanOneParent'));
		
			$orphanSlides = $this->fetchTable('Slides')
								->find()
								->notMatching('Homeworks')
								->all();
			
			foreach($orphanSlides as $slide) {
				$this->fetchTable('Slides')->delete($slide);
			}
			
			$this->set(compact('orphanSlides'));
			
			$orphanHws = $this->Homeworks
								->find()
								->notMatching('Users')
								->all();
			
			if($orphanHws->count() > 0) {
				// Eliminar las tareas que no pertenezcan a nadie...
				$this->Flash->success('Hay '.$orphanHws->count().' tareas huérfanas');
			}
			
			// FALTA IMPLEMENTAR:
			//	- Los topics y posts del foro que hayan quedado huerfanos deben pasar a ser del UserID 3 (Exalumno)
			
		}

		$this->Flash->success('Todo el sistema se ha restablecido');
		return $this->render();
	}
	*/
}