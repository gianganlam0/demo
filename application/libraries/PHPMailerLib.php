<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerLib extends PHPMailer{
	public function load(){
		$mail = new PHPMailer(true);
		return $mail;
	}
}
