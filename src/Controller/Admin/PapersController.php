<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\i18n\FrozenTime;
use Cake\Http\Response;
use Cake\ORM\Query;
use Cake\Mailer\MailerAwareTrait;
use App\Controller\AppController;
use App\Model\Entity\Paper;


class PapersController extends AppController {
	
	use MailerAwareTrait;
	
	private const G_MATUTINO = 1;
	
	private const G_VESPERTINO = 2;
	
	private const G_NERDS = 99;
	
	private static string $submit = 'Registrar tarea';
	
	private static string $legend = 'Crear nueva tarea';
	
	private static ?Paper $paper = null;

	public function index() : Response {
		$this->set('formSubmit', self::$submit);
		$this->set('formLegend', self::$legend);
		$this->set('groups', $this->Papers
									->Groups
										->find()
										->order(['id' => 'ASC'])
										->limit(2)
										->contain([
											'Papers' => function(Query $query){
												return $query->order(['expiration' => 'ASC']);
											}
										])
										->all()
		);

		if(self::$paper === null) {
			if($this->request->getQuery('duplicate') !== null) {
				$duplicate = $this->request->getQuery('duplicate');
				self::$paper = $this->Papers->get($duplicate);
				self::$paper->set('expiration', (new FrozenTime())->tomorrow());
				self::$paper->set('group_id', self::G_MATUTINO);
				self::$paper->set('id', null);
				self::$paper->setNew(true);
			} else {
				self::$paper = $this->Papers->newEmptyEntity();
			}
		}
		$this->set('paper', self::$paper);
		return $this->render();
	}

    public function add() : Response {
		$paper = $this->Papers->newEmptyEntity();
		if ($this->request->is('post')) {
			$paper = $this->Papers->patchEntity($paper, $this->request->getData());
			if($this->Papers->save($paper)) {
				$alumnos = $this->fetchTable('Users')
								->find('list', [
								    'keyField' => 'email',
								    'valueField' => function($user) {
										return $user->get('nombre');
									}
								])
								->where(['group_id' => $paper->group_id])
								->toArray();
				$this->getMailer('Paper')->notifyAll($paper, $alumnos, parent::$title);
				$this->Flash->success('Tarea guardada');
			} else {
				$this->Flash->error('Error al guardar');
			}
		} else if($this->request->is('put')) {
			$paper = $this->Papers->get($this->request->getData('id'));
			$paper = $this->Papers->patchEntity($paper, $this->request->getData());
			if($this->Papers->save($paper)) {
				$this->Flash->success('Tarea modificada');
			} else {
				$this->Flash->error('Error al guardar');
			}
		}
        return $this->redirect(['action' => 'index']);
    }

	public function edit() : Response {
		$id = $this->request->getQuery('id');
		self::$paper = $this->Papers->get($id);

		if($this->request->is(['get'])) {	
			$this->set('edit', true);
			self::$submit = 'Guardar cambios';
			self::$legend = 'Modificar tarea';
		}
		$this->viewBuilder()->setTemplate('index');
		return $this->index();
    }
    
    public function browse() : Response {
	    $this->set('groups', $this->Papers
									->Groups
										->find()
										->select()
										->order(['id' => 'ASC'])
										->limit(2)
										->contain([
											'Papers' => [
												'sort' => ['expiration' => 'ASC'],
												'fields' => ['id', 'name', 'slide', 'group_id'],
												'Homeworks' => [
													'fields' => ['paper_id'],
													'queryBuilder' => function(Query $query){
														return $query->select([
																	'total' => $query->func()->count('*'),
																	'unrated' => $query->func()->count(
																		$query->newExpr()->case()->when(['score' => 0])->then(1)
																	)
																])->group('paper_id');
													},
												]
											],
											'Users' => [
												'fields' => ['group_id'],
												'queryBuilder' => function(Query $query){
													return $query->select([
																	'total' => $query->func()->count('*')
																])->group('group_id');
												},
											]
										])
										->all()
		);
		return $this->render();
    }
    
    public function itemize($id = null) : Response {
		$paper = $this->Papers->find()
							->select(['id', 'name', 'group_id'])
							->where(['Papers.id' => $id])
							->contain([
								'Homeworks' => function(Query $query){
									return $query->contain([
										'Users' => function(Query $query){
											return $query->select(['id', 'nombres', 'apellidos', 'email', 'photo']);
										}
									]);
								},
								'Groups' => function(Query $query){
									return $query->select(['id', 'grupo', 'icon']);
								}
							])
							->first();
							
		$totalAlumnos = $this->fetchTable('Users')->find()
												->where(['group_id' => $paper->group_id])
												->count();
												
		$this->set('paper', $paper);
		$this->set('buttonDisable', !(count($paper->homeworks) < $totalAlumnos));
		return $this->render();
    }
	
	public function archive() : Response {
		$this->set('papers', $this->Papers
									->find()
									->where(['group_id' => self::G_NERDS])
									->contain([
										'Homeworks' => [
											'fields' => ['paper_id'],
											'queryBuilder' => function(Query $query){
												return $query->select(['total' => $query->func()->count('*')])->group('paper_id');
											},
										]
									])
									->all()
		);
		return $this->render();
	}


    public function delete($id = null) : Response {
		$this->request->allowMethod(['post', 'delete']);
		$paper = $this->Papers->get($this->request->getData('id'));
		if($this->Papers->delete($paper)) {
			$this->Flash->success('Tarea eliminada');
		} else {
			$this->Flash->error('Error al eliminar la tarea');
		}
		return $this->redirect(['action' => 'index']);
    }
}
