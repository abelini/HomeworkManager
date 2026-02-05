<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\Response;
use Cake\ORM\Query;
use Cake\Mailer\MailerAwareTrait;


class UsersController extends AppController {
	
	use MailerAwareTrait;

    public function index() : Response {
		$groups = $this->fetchTable('Groups')->find()
										->contain('Users', function(Query $query){
											return $query
													->select(['id', 'nombres', 'apellidos', 'photo', 'email', 'group_id', 'starred', 'created'])
													->order(['apellidos' => 'ASC']);
										})
										->limit(4)
										->all();
		$starredUsersNotInHoF = $this->Users->find()
										->select(['id', 'nombres', 'apellidos', 'email', 'group_id', 'starred', 'created'])
										->where([
											'group_id !=' => 99,
											'starred' => true,
										])
										->all()
										->toList();
		$groups->last()->users = array_merge($groups->last()->users , $starredUsersNotInHoF);
		$this->set(compact('groups'));
		return $this->render();
    }
	
	public function star($id) : Response {
		$user = $this->Users->get($id);
		$user->set('starred', !$user->starred);
		$this->Users->save($user);
		$this->Flash->success('Alumno actualizado.');
		return $this->redirect($this->referer()); 
	}
	
    public function statistics($id = null) : Response {
		$user = $this->Users->get($id, [
			'contain' => ['Groups', 'Homeworks', 'Homeworks.Papers'],
		]);
		$papers = $this->fetchTable('Papers')->find()
										->where(['group_id' => $user->group_id])
										->all();
		$sum = 0;
		$totalHws = ($user->group_id == 99)? count($user->homeworks) : $papers->count();
		$this->set(compact('user', 'papers', 'totalHws', 'sum'));
		return $this->render();
    }
	
	public function accept($id) : Response {
		$user = $this->Users->get($id, ['contain' => ['Groups']]);
		$this->set('user', $user);
		
		if($this->request->getQuery('_') !== null) {
			$accept = match($this->request->getQuery('_')){
				'YES' => true,
				'NO' => false,
				default => false,
			};
			
			if($accept){
				$user->set('accepted', $accept);
				if($this->Users->save($user)) {
					$this->Flash->success('Alumno aceptado');
					$this->getMailer('User')->welcome($user, parent::$title);
					return $this->redirect('/');
				} else {
					$this->Flash->error('Error al actualizar al alumno. Por favor intente nuevamente.');
					return $this->render(); 
				}
			} else {
				$this->Flash->success('Alumno <strong>NO</strong> aceptado. Se eliminará su registro.');
				$this->Users->delete($user);
				return $this->redirect('/');
			}
		}
		return $this->render(); 
	}
	
	public function pr() : Response {
		$alumno = $this->Users->get($this->request->getQuery('a'));
		$prValues = [0 => 'Seleccione', 1 => '+1 punto', 2 => '+2 puntos', 3 => '+3 puntos'];
		$this->set(compact('alumno', 'prValues'));
		return $this->render();
	}
	
	public function edit($id = null) : Response {
		$user = $this->Users->get($id);
		if($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			$updatedPR = $user->isDirty('pr');
			if($this->Users->save($user)) {
				 
				if($updatedPR) {
					$this->Flash->success('El índice P/R del alumno ha sido establecido.');
					return $this->redirect(['controller' => 'groups', 'action' => 'kardex', $user->group_id]);
				} else {
					$this->Flash->success('Alumno modificado...');
					return $this->redirect(['action' => 'index']);
				}
			}debug($user->getErrors()); 
			$this->Flash->error(__('The user could not be saved. Please, try again.'));
		}
		$groups = $this->Users->Groups->find('list')->limit(6)->all();
		$this->set(compact('user', 'groups'));
		return $this->render();
	}

	public function delete($id = null) : Response {
        $this->request->allowMethod(['delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
	}
}
