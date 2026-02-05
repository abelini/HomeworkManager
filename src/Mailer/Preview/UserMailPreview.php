<?php

namespace App\Mailer\Preview;

use DebugKit\Mailer\MailPreview;


class UserMailPreview extends MailPreview {
	
	public function resetPassword(){
		$user = $this->fetchTable('Users')->get(1);
		return $this->getMailer('User')->resetPassword($user, '$o"#%mePas!/$%&sword.!', 'Historia de Mexico: 1700-1821');
	}
	
	public function welcome(){
		$user = $this->fetchTable('Users')->get(1);
		return $this->getMailer('User')->welcome($user, 'Teoría electromagnética');
	}
}