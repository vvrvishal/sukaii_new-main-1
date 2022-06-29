<?php

use GuzzleHttp\Client;
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/PHPMailer/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/PHPMailer/src/SMTP.php';

require_once './vendor/autoload.php';

class SmsModel extends CI_Model
{

	/*
	 * @param number, message
	 */

	public function sendSMS($number,$templateData,$template,$templateID=1){
		$username="bharatmishra1";
		$password ="bharat@100";
		$sender="GLDBRZ";
		$message="";
		$postData = array(
			'user' => "bharatmishra1",
			'password'=>"bharat@100",
			'mobile' =>$number,
			'sender' => $sender,
			'type' => '3'
		);
		switch ($templateID){
			case 1:
				$postData["template_id"]=$template;
				$postData['message'] = "".$templateData['name']." has been admitted in the ".$templateData['center']." and has been allotted ".$templateData['bed']." in ".$templateData['room']." -Gold Berries";
				break;
			case 2:
				$postData["template_id"]=$template;
				$postData['message'] = "".$templateData['name']." has been transferred to ".$templateData['center']." in ".$templateData['bed']." in ".$templateData['room']." -Gold Berries";
				break;
			case 3:
				$postData["template_id"]=$template;
				$postData['message'] = "Treatment has been started for ".$templateData['otp']." -Gold Berries";
				$postData['message'] = "OTP for Login Transaction on ".$templateData['company']." is ".$templateData['otp']." and valid till ".$templateData['time'].".Do not share this OTP to anyone for security reasons -Gold Berries";
				break;
		}

		$client = new Client();
		$response = $client->request('GET', 'http://api.bulksmsgateway.in/sendmessage.php', array(
			'query' =>$postData
		));
		return $response->getBody();

	}

	public function sendMail($to,$subject,$body)
	{
		$mail = new PHPMailer(true);

		try {
			$mail->isSMTP();
			$mail->Host = "mail.gbtech.in";
			$mail->SMTPAuth = true;
			$mail->Username = "narendra@gbtech.in";
			$mail->Password = "narendra@123#";
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
			$mail->Port = 587;
			$mail->AllowEmpty = true;
//                $mail->SMTPDebug  = 2;
//			$mail->Debugoutput = function ($str, $level) {
//				echo "debug level $level; message: $str";
//			};
// ------------------- smtp configuration done --------

			$mail->setFrom("narendra@gbtech.in", "Sukaii");
			$mail->addAddress(trim($to));
			$mail->Body = $body;
			$mail->isHTML(true);
			$mail->Subject = $subject;
			$mail->AddReplyTo("narendra@gbtech.in");
			$mail->send();
			if ($mail->ErrorInfo == null) {
				$response['status'] = 200;
				$response['body'] = 'Successfully send';
			} else {
				$response['status'] = 201;
				$response['body'] = 'Got an error';
			}
			return $response;
		} catch (PHPMailer\PHPMailer\src\Exception $ex) {
			return null;
		}

	}
}
