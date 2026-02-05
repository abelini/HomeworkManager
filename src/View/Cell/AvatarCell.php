<?php
declare(strict_types=1);

namespace App\View\Cell;

use App\Model\Entity\User;
use Cake\View\Cell;
use Cake\View\View;
use Cake\View\Helper\UrlHelper;


class AvatarCell extends Cell {
	
	private const PROFILE_PHOTOS_DIR = 'profile_photos';
	
	private const FALLBACK_AVATARS = ['mp', 'identicon', 'monsterid', 'wavatar', 'retro', 'robohash'];
	
	private const ORIGINAL_MASTER_EMAIL = 'tlatoanyz@hotmail.com';
	
	public function display(User $user, string $class, int $size = 60) {
		$hash = md5(mb_strtolower($user->email));
		if($user->has('photo')) {
			$url = new UrlHelper(new View());
			$default = $url->image(self::PROFILE_PHOTOS_DIR . DS . $user->photo, ['fullBase' => true]);
			// Sometimes stupid Gravatar fails at rendering self-hosted images.. So, we use it randomly (Only at 25% of probability or less)
			if((mt_rand() / mt_getrandmax()) > 0.75) {
				$src = 'https://www.gravatar.com/avatar/' .$hash. '?d='. urlencode($default).'&s='.$size.'&r=g&f=y';
			} else {
				$src = $default;
			}
			/**
			 * Only for Master's profile picture:
			 */
			if(($user->email === 'willfridoibarra@uas.edu.mx')) {
				$hash = md5(mb_strtolower(self::ORIGINAL_MASTER_EMAIL));
				$src = 'https://www.gravatar.com/avatar/' .$hash. '?s='.$size.'&r=g';
			}
		} else {
			$src = 'https://www.gravatar.com/avatar/' .$hash. '?d='.self::FALLBACK_AVATARS[mt_rand(0, 5)].'&s='.$size.'&r=g';
		}
		$this->set(compact('src', 'size', 'class'));
	}
}