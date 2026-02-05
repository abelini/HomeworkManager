<?php
declare(strict_types=1);

namespace App\Mailer;

use App\Mailer\Office365Mailer;
use App\Model\Entity\Homework;


class HomeworkMailer extends Office365Mailer {
	
	public function score(Homework $hw, string $materia) : Office365Mailer {
        $this
			->setTo($hw->user->email, $hw->user->nombres)
			->setEmailFormat('html')
			->setSubject("Tu tarea «{$hw->paper->name}» ha sido calificada")
			->setViewVars([
				'hw' => $hw,
				'materia' => $materia,
			])
			->viewBuilder()
				->addHelpers(['Html', 'Url'])
				->setTemplate('score');

		$this->deliver();
		return $this;
	}
}