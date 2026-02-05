<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Mailer\Office365Mailer;
use App\Model\Entity\Paper;


class PaperMailer extends Office365Mailer {
	
	public function notifyAll(Paper $paper, array $alumnos, string $materia) : Office365Mailer {
		$this
			->setTo($alumnos)
			
			->setBcc(parent::PROFESORES)
			
			->setEmailFormat('html')
			->setSubject("Tienes una tarea nueva que expira el " . $paper->expiration->i18nFormat("EEEE d 'a las' h:mm a"))
			->setViewVars([
				'paper' => $paper,
				'materia' => $materia,
			])
			->viewBuilder()
				->addHelpers(['Html', 'Url'])
				->setTemplate('new_paper');

		$this->deliver();
		return $this;
	}
}