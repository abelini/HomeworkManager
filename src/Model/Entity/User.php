<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class User extends Entity {

	protected $_accessible = [
		'password' => true,
		'group_id' => true,
		'nombres' => true,
		'apellidos' => true,
		'email' => true,
		'photo' => true,
		'admin' => false,
		'online' => true,
		'created' => true,
		'modified' => true,
		'pr' => true,
		'accepted' => true,
		'register_ip' => true,
		'access_ip' => true,
		'starred' => true,
		'group' => true,
		'comments' => true,
		'homeworks' => true,
		'notecomments' => true,
		'posts' => true,
		'topics' => true,
    ];

    protected $_hidden = [
        'password',
    ];
    
    protected function _setPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
	protected function _getNombres($nombres){
		if($nombres === null) return null;
		else return mb_convert_case(mb_strtolower($nombres), MB_CASE_TITLE);
	}
	
    protected function _getNombre(){
        return mb_convert_case(mb_strtolower($this->nombres . ' ' . $this->apellidos), MB_CASE_TITLE);
    }
    
    protected function _getNombreCompleto(){
        return mb_convert_case(mb_strtolower($this->apellidos . ' ' . $this->nombres), MB_CASE_TITLE);
    }
    
    public function generateAndSetPassword() : string {
	    $password = substr(password_hash(strval(time()), PASSWORD_DEFAULT), 0, 10);
	    $this->password = $password;
	    return $password;
    }
}
