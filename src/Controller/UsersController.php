<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\I18n\FrozenTime;
use Cake\Http\Client;
use Cake\Http\Response;
use Cake\Filesystem\File;
use Cake\Mailer\MailerAwareTrait;


class UsersController extends AppController {
	
	use MailerAwareTrait;
	
	private const RECAPTCHA_REQUEST_ENDPOINT = 'https://www.google.com/recaptcha/api/siteverify';
	
	private const RECAPTCHA_SECRET = '6LfxQs4UAAAAAFty3CZVt5yz7jPSonKZVj6acs4n';
	
	private const MAXIMUM_IMAGE_SIZE = 2097152;
	
	private const CAPTCHA_MINIMUM_SCORE = 0.5;
	
	protected static string $layout = 'landing';
	
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);
		$this->Authentication->allowUnauthenticated(['login', 'register', 'retrieve']);
	}
	
	public function index() : Response {
		$this->Flash->error('No hay nada que ver ahí...');
		return $this->redirect('/');
	}
	
	public function password() : Response {
		$key = ['key' => 'password'];
		if($this->request->is('put')){
			$user = $this->Users->get($this->userID);
			$user->set('password', $this->request->getData('password'));
			$this->Users->save($user);
			$this->Flash->success('Contraseña cambiada', $key);
		}
		return $this->redirect(['action' => 'profile', '#' => 'password']);
	}
	
	public function profile() : Response {
		self::$layout = parent::$layout;
		$user = $this->Users->get($this->userID, ['contain' => ['Groups']]);
		if(parent::$admin){
			$grupos = $this->Users
							->Groups
								->find('list')
								->where(['id' => 999])
								->toArray();
		} else {
			$grupos = $this->Users
							->Groups
								->find('list')
								->limit(2)
								->toArray();
		}
		$this->set(compact('user', 'grupos'));
		return $this->render();
	}
	
	public function update() : Response {
		if($this->request->is('PUT')){
			$user = $this->Users->get($this->userID);
			$user = $this->Users->patchEntity($user, $this->request->getData());
			$this->Users->save($user);
			$this->Flash->success('Datos actualizados', ['key' => 'profile']);
		}
		return $this->profile(); //$this->setAction('profile');
	}
	
	public function thumbnail() : Response {
		$user = $this->Users->get($this->userID);
		$image = $this->request->getData('file');
		if(in_array($image->getClientMediaType(), ['image/png', 'image/jpeg', 'image/webp'])) {
			if($image->getSize() < self::MAXIMUM_IMAGE_SIZE){
				$filename = 'profileID-'.$this->userID.'-'.time().'.'.pathinfo($image->getClientFilename(), PATHINFO_EXTENSION);
				$path = PROFILE_PHOTOS_PATH . DS . $filename;
				$image->moveTo($path);
				if($user->hasValue('photo')) {
					$previousPhoto = new File(PROFILE_PHOTOS_PATH . DS . $user->photo);
					$previousPhoto->delete();
				}
				$user->set('photo', $filename);
				$this->Users->save($user);
				$response = 'Foto de perfil actualizada';
			} else {
				$response = 'Error. Archivo demasiado grande. El tamaño máximo debe ser 2MB.';
			}
		} else {
			$response = 'Tipo de imagen no válido. Los tipos permitidos son WEBP, JPG y PNG.';
		}
		$response = ['ServerResponse' => $response];
		$this->set(compact('response'));
		return $this->render();
	}
	
	public function login() : Response {
		if($this->request->is('post')) {
			$lock = $this->Options->get('lock')->get('expiration');
			if($lock->status === true && $lock->expiration->greaterThanOrEquals(Frozentime::now()) && parent::$admin === false){
				$this->Flash->error('Portal cerrado para todos los alumnos hasta el '. $lock->expiration->i18nFormat([\IntlDateFormatter::FULL, \IntlDateFormatter::SHORT]));
				$this->Authentication->logout();
				return $this->redirect('/');
			}
			// Check the ReCaptcha response of this login request
			/*
			$http = new Client();
			$response = $http->get(self::RECAPTCHA_REQUEST_ENDPOINT, [
										'secret' => self::RECAPTCHA_SECRET,
										'response' => $this->request->getData('recaptcha')
									])
									->getJson();
			if($response['success'] === false || $response['score'] <= self::CAPTCHA_MINIMUM_SCORE){
				$this->Authentication->logout();
				$this->Flash->error('Parece que no estás actuando como un ser humano...');
				return $this->redirect('/users/login');
			} */
		}

		$result = $this->Authentication->getResult();
		if($result->isValid()) {
			// If user has not been accepted, then log him out
			if($this->Authentication->getIdentity()->get('accepted') === false){
				$this->Flash->error('Todavía no has sido aceptado en la plataforma. No te desesperes.');
				$this->Authentication->logout();
			}
			// Save the IP from which the user is logging in
			$user = $this->Users->get($this->Authentication->getIdentity()->getIdentifier());
			$user->set('access_ip', $this->request->clientIp());
			$user->set('online', true);
			$this->Users->save($user);
			// Redirect to Home
			$target = $this->Authentication->getLoginRedirect() ?? '/';
			return $this->redirect($target);
		}
		// 
		if($this->request->is('post')) {
			$message = match($result->getStatus()){
				$result::FAILURE_IDENTITY_NOT_FOUND => 'Correo electrónico o contraseña incorrectos',
				$result::FAILURE_CREDENTIALS_MISSING => 'Por favor rellena los dos campos',
				default => $result->getStatus(),
			};
			$this->Flash->error($message);
	    }
	    return $this->render();
	}
	
	public function register() : Response {
		$user = $this->Users->newEmptyEntity();
		if(!$this->Authentication->getResult()->isValid() && $this->request->is('get')){
			$register = $this->Options->get('register')->get('allow');
			$grupos = $this->fetchTable('Groups')->find('list')->limit(2)->all()->toArray();
			$this->set(compact('user', 'register', 'grupos'));
		}
		else if($this->request->is('post')){
			$http = new Client();
			$response = $http->get(self::RECAPTCHA_REQUEST_ENDPOINT, [
									'secret' => self::RECAPTCHA_SECRET,
									'response' => $this->request->getData('recaptcha_response')
								])
								->getJson();
			if($response['score'] < self::CAPTCHA_MINIMUM_SCORE || $response['success'] === false){
				$this->Flash->error('Parece que no estás actuando como un ser humano...');
				return $this->redirect(['action' => 'register']);
			}

			if($this->request->getData('password.0') !== $this->request->getData('password.1')){
				$this->Flash->error('Las contraseñas no coinciden...');
				return $this->redirect(['action' => 'register']);
			}
			
			$data = $this->request->getData();
			$data['password'] = $this->request->getData('password.0');
			$data['accepted'] = false;
			$data['register_ip'] = $data['access_ip'] = $this->request->clientIp();
			
			$user = $this->Users->patchEntity($user, $data);
			
			if($this->Users->save($user)){
				$this->Flash->success('¡Haz sido registrado con éxito! Ahora hay que esperar a que el profesor acepte tu registro.');
				$this->getMailer('User')->register($user, parent::$title);
				return $this->redirect(['action' => 'login']);
			} else {
				if($user->hasErrors()){
					$error = ($user->getInvalidField('email'))? $user->getError('email')['_isUnique'] : 'Hay errores en la información enviada. Por favor revisa nuevamente.';
					$this->Flash->error($error);
				} else {
					$this->Flash->error('Ocurrió un error al guardar. Inténtalo de nuevo por favor.');
				}
				return $this->redirect(['action' => 'register']);
			}
		}
		return $this->render();
	}
	
	/**
	*/
	public function retrieve() : Response {
		if($this->request->is('post')) {
			$http = new Client();
			$response = $http->get(self::RECAPTCHA_REQUEST_ENDPOINT, [
										'secret' => self::RECAPTCHA_SECRET,
										'response' => $this->request->getData('recaptcha')
									])
									->getJson();
			if($response['success'] === false || $response['score'] <= self::CAPTCHA_MINIMUM_SCORE){
				$this->Flash->error('Parece que no estás actuando como un ser humano...');
				return $this->redirect('/users/login');
			}
			$user = $this->Users
						->find()
						->where(['email' => $this->request->getData('email')])
						->first();
			if($user === null){
				$this->Flash->error('El correo proporcionado no está registrado en la plataforma');
				return $this->render();
			}
			$password = $user->generateAndSetPassword();
			if($this->Users->save($user)){
				$this->getMailer('User')->resetPassword($user, $password, parent::$title);
				$this->Flash->success('Se te generó la contraseña: <code>'.$password.'</code><br>pero como ya te dije, el correo no pudo enviarse...' /*'Se te ha generado una nueva contraseña. Por favor revisa tu bandeja de entrada.'*/);
			} else {
				$this->Flash->error('Error. Por favor, intenta nuevamente en un momento.');
			}
			return $this->redirect(['action' => 'login']);
		}
		return $this->render();
	}

	public function logout() : Response {
		$user = $this->Users->get($this->Authentication->getIdentity()->getIdentifier());
		$user->set('online', false);
		$this->Users->save($user);
		$this->Authentication->logout();
		return $this->redirect('/');
	}
	
	public function beforeRender(EventInterface $e) : void {
		$this->viewBuilder()->setLayout(self::$layout);
		$background = match($this->subjectID) {
			1 => '/img/courses/bg/battle-tenochtitlan.webp',
			2 => '/img/courses/bg/mexico1700-1810.webp',
		};
		$cover = match($this->subjectID) {
			1 => '/img/courses/bg/tlatoani.webp',
			2 => '/img/courses/bg/landing.webp',
		};
		$this->set(compact('background', 'cover'));
	}
	
}