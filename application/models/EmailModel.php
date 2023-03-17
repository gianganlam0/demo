<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailModel extends CI_Model{
	
	public $mailPayload;

	public function sendEmail($to, $subject='', $body='',$fromEmail='',$fromName='', $Callback='sendEmailCallback', $charSet='UTF-8'){
		// SMTP configuration
		$this->mailPayload = new stdClass();
		$this->mailPayload->isHTML	 = true;
		$this->mailPayload->Callback = $Callback;
		$this->mailPayload->Host     = 'smtp.gmail.com';
		$this->mailPayload->SMTPSecure = 'ssl';
		$this->mailPayload->Port     = 465;
		$this->mailPayload->SMTPAuth = true;
		$this->mailPayload->Username = 'vios.tee97@gmail.com';
		$this->mailPayload->Password = 'ahggelkkbxwzvslw';
		$this->mailPayload->CharSet = $charSet;
		if(is_string($to)) $to = [$to];
		$this->mailPayload->To = $to;
        $this->mailPayload->Subject = $subject;
        $this->mailPayload->FromEmail = $fromEmail;
		$this->mailPayload->FromName = $fromName;
        // $this->mailPayload->addReplyTo('info@example.com', 'CodexWorld');

        // $this->mailPayload->addCC('cc@example.com');
        // $this->mailPayload->addBCC('bcc@example.com');

        $this->mailPayload->Body = $body;
        // Send email
        try{
			$queue = new Pheanstalk\Pheanstalk('127.0.0.1:11300');
			$queue->useTube('EmailWorker')->put(json_encode($this->mailPayload));
			return ['code' => 200, 'message' => 'Đã gửi mail'];
		}
		catch(Exception $exception){
			return ['code' => 500, 'message' =>'Gửi mail thất bại, '. $exception->getMessage()];
		}
	}
}
