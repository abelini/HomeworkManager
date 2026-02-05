<?php
declare(strict_types=1);

namespace App\Mailer;

use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;


class Office365Mailer extends Mailer {
	
	private const TRANSPORT = 'Office365';
	
	private const PROFE = [
		'willyibarra@ms.uas.edu.mx' => 'MC Wilfrido Ibarra'
	];
	
	private const WILLY = [
		'tlatoanyz@hotmail.com' => 'MC Wilfrido Ibarra'
	];
	
	protected const PROFESORES = [
		//'abel@uas.edu.mx' => 'Ing. Abel Bottello',
		'tlatoanyz@hotmail.com' => 'MC Wilfrido Ibarra',
	];
	
	protected const CONFIG = [
		'host' => 'smtp.office365.com',
		'port' => 587,
		'username' => 'willyibarra@ms.uas.edu.mx',
		'password' => 'JUBILEo2023',
		'transport' => 'Smtp',
		'client' => null,
		'tls' => true,
		'className' => 'Smtp',
		'SMTPSecure' => 'STARTTLS',
	];
	
	public function __construct() {
		parent::__construct();
		
		TransportFactory::setConfig(self::TRANSPORT, self::CONFIG);

		$this->setTransport(self::TRANSPORT);
		$this->setFrom(self::PROFE);
		$this->setSender(self::PROFE);
		$this->viewBuilder()->setLayout(null);
	}
	
	/**
	 * Override parent function to do nothing until
	 * problem with STMP connection gets fixed
	 */
	public function deliver(string $content = '') {
		//
	}
}