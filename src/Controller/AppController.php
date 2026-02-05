<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Database\Expression\QueryExpression;
use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\i18n\FrozenTime;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Utility\Inflector;


class AppController extends Controller {

	protected int $userID;
	
	protected int $groupID;
	
	protected int $subjectID;
	
	protected bool $fullAccessHomeworks;
	
	protected static string $layout;
	
	protected static string $title = '';
	
	protected static bool $admin = false;
	
	protected static bool $lockedSite = false;
	
	protected Table $Options;
	
	protected Table $Homeworks;
	
	protected Table $Topics;
	
	protected Table $Subjects;
	
	protected Table $Users;
	
	public function initialize() : void {
		parent::initialize();

		$this->loadComponent('RequestHandler');
		$this->loadComponent('Flash');
		$this->loadComponent('Authentication.Authentication');

		$this->Options = $this->fetchTable('Options');
		$this->Homeworks = $this->fetchTable('Homeworks');
		$this->Topics = $this->fetchTable('Topics');
		$this->Subjects = $this->fetchTable('Subjects');
		$this->Users = $this->fetchTable('Users');
	}
    
	protected function adminViewAsStudent(int $id, int $gid) : void {
		if($this->userID == 1) {
			$this->userID = $id;
			$this->groupID = $gid;
			self::$admin = false;
		}
	}
    
	protected function willyViewAsStudent(int $id) : void {
		if($this->userID == $id) {
			$this->groupID = 1;
		}
    }
    
    public function beforeFilter(EventInterface $event) {
		/**
		 * Validar que el usuario haya iniciado correctamente la sesión
		 */
	    if($this->Authentication->getResult()->isValid()) {
			$this->userID = $this->Authentication->getIdentity()->getIdentifier();
			$this->groupID = $this->Authentication->getIdentity()->get('group_id');
			self::$admin = $this->Authentication->getIdentity()->get('admin');
			
			/**
			 *	Perspectiva de alumno
			 */
			//$this->adminViewAsStudent(388, 2);
			$this->willyViewAsStudent(398);
		}
		
		/**
		 * Establecer el <layout> en base a los permisos del usuario...
		 */
		self::$layout = self::$admin ? 'admin' : 'student';
		$this->viewBuilder()->setLayout(self::$layout);
		
		/**
		 * Evitar que alumnos naveguen en páginas de /<admin>
		 */
		if($this->Authentication->getResult()->isValid() && $this->request->getParam('prefix') != null && self::$admin === false){
			$this->Flash->error('No tienes permiso para ver este contenido', ['key' => 'AccessDenied']);
			return $this->redirect('/');
		}
		
		/**
		 * Contabilizar si hay o no tareas sin calificar...
		 */
		if(self::$admin) {
			$this->set('unrated', $this->Homeworks->find('unrated')->count());
		}
		
		/**
		 * Revisar posts sin respuestas en el foro... (excepto el Post#1)
		 */
		$unansweredTopics = $this->Topics
								->find()
								->where(function (QueryExpression $exp, Query $q) {
									return $exp->notIn('Topics.id', [1]);
								})
								->notMatching('Posts')
								->count();
		$this->set('unansweredTopics', $unansweredTopics);
		
		/**
		 * Revisar si las tareas estan desbloqueadas o abiertas...
		 */
		$this->fullAccessHomeworks = $this->Options->get('homeworks')->getfullAccessHomeworks();
		
		/**
		 * Obtener el nombre de la materia
		 */
		if(empty(self::$title)) {
			$this->subjectID = $this->Options->get('course')->get('CourseID');
			self::$title = $this->Subjects->field('name', $this->subjectID);
		}
		
		$this->set('today', FrozenTime::now());
		$this->set('materia', self::$title);
		$this->set('subjectID', $this->subjectID);
		$this->set('headerIMG', str_replace(['é', ':'], ['e', ''], Inflector::camelize(self::$title)) . '.jpg');
		$this->set('isMobile', $this->request->isMobile());
    }
}
