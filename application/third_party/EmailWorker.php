<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once '../../vendor/autoload.php';

$WATCHTUBE = "EmailWorker";
$queue = new Pheanstalk\Pheanstalk("127.0.0.1:11300"); // OR IP Address of Server running beanstalkd
$PIDFILE = __DIR__ . "/EmailWorker.pid";
touch($PIDFILE);
echo "Worker " . __FILE__ . " have started. To exit, delete pid file  " .  $PIDFILE . PHP_EOL;

while (file_exists($PIDFILE)) {
    while ($job = $queue->reserveFromTube($WATCHTUBE, 15)) {
        try {
            $mailPayload = json_decode($job->getData(), false);
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = $mailPayload->Host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = $mailPayload->SMTPAuth;                               // Enable SMTP authentication
            $mail->Username = $mailPayload->Username;                 // SMTP username
            $mail->Password = $mailPayload->Password;                           // SMTP password
            $mail->SMTPSecure = $mailPayload->SMTPSecure;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $mailPayload->Port;                                    // TCP port to connect to
			$mail->CharSet = $mailPayload->CharSet;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->setFrom($mailPayload->FromEmail, $mailPayload->FromName);

            foreach ($mailPayload->To as $email) {
                $mail->addAddress($email);
            }
            // Name is optional
            $mail->isHTML($mailPayload->isHTML);                                  // Set email format to HTML
            $mail->Subject = $mailPayload->Subject;
            $mail->Body = $mailPayload->Body;
            
            /** Test queue and send email */
            $mailPayload->SendResult = $mail->send();
            if (!$mailPayload->SendResult) {
                $mailPayload->ErrorInfo = $mail->ErrorInfo;
            }
            $mailPayload->SendTimestamp = time();
            $mail->smtpClose();
            /*
             */
            
            //Excute Callback function
            if (function_exists($mailPayload->Callback)) {
                call_user_func($mailPayload->Callback, $mailPayload);
            }
            //End Callback function  
            $queue->delete($job);
        } catch (Exception $e) {
            $jobData = $job->getData();
            $queue->delete($job);
            var_dump($e);
            //If day job vao lai
            $queue->useTube($WATCHTUBE)->put($jobData);
            exit();
        }
        if(!file_exists($PIDFILE)){
            exit();
        }
    }
}
function sendEmailCallback($mailPayload) {
    echo PHP_EOL . "At " . date('c',time()) . PHP_EOL;
    echo json_encode($mailPayload, JSON_PRETTY_PRINT) . PHP_EOL;
    /*
     * Muon xu ly gi voi $mailPayload thi xu ly.
     */
    echo "----------------" . PHP_EOL ;
}


