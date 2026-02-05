<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Mailer\Office365Mailer;
use App\Model\Entity\User;


class UserMailer extends Office365Mailer {
	
	public function register(User $user, string $materia): Office365Mailer {
        $this
			->setTo($user->email, $user->nombres)
			->setEmailFormat('html')
			->setSubject('Has sido registrado con éxito: '. $materia)
			->setViewVars([
				'user' => $user,
				'materia' => $materia
			])
			->viewBuilder()
				->setTemplate('register');

		$this->deliver();
		return $this;
    }

    public function welcome(User $user, string $materia) : Office365Mailer {
        $this
			->setTo($user->email, $user->nombres)
			->setEmailFormat('html')
			->setSubject('Bienvenido a la plataforma de: '. $materia)
			->setViewVars([
				'user' => $user,
				'materia' => $materia
			])
			->viewBuilder()
				->setTemplate('welcome');

		$this->deliver();
		return $this;
    }


    public function resetPassword(User $user, string $password, string $materia) : Office365Mailer {
        $this
			->setTo($user->email, $user->nombres)
			->setEmailFormat('html')
			->setSubject('Recuperación de contraseña')
			->setViewVars([
				'user' => $user,
				'password' => $password,
				'materia' => $materia
			])
			->viewBuilder()
				->setTemplate('reset_password');
				
		$this->deliver();
		return $this;
    }
	
	
	
}