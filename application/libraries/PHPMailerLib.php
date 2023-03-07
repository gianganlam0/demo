<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerLib{
	public function __construct(){
		log_message('Debug', 'PHPMailer class is loaded.');
	}
	public function load(){
		$mail = new PHPMailer(true);
		return $mail;
	}
}
