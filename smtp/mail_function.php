<?php
	function sendOTP($email,$otp){
		require('class.phpmailer.php');
		require('class.smtp.php');
		//require('PHPMailer/Exception.php');
		$message_body="One Time Password for authentication is:<br><br>".$otp;
		$mail=new PHPMailer();

		//smtp setting
		$mail->Host="smtp.gmail.com";
		$mail->SMTPAuth=true;
		$mail->Username="apnidukaan633@gmail.com";
		$mail->Password='Dehradun@123';
		$mail->Port=465;
		$mail->SMTPSecure="ssl";

		//email setting
		$mail->isHTML(true);
		//$mail->AddReplyTo('apnidukaan633@gmail.com','Apni Dukaan');
		$mail->SetFrom('apnidukaan633@gmail.com','Apni Dukaan');
		$mail->AddAddress($email);
		$mail->Subject="Apni Dukaan : OTP to Register";
		//$mail->MsgHTML($message_body);
		$mail->Body=$message_body;
		$result=$mail->Send();
		if(!$result)
			echo "Mailer Error: ".$mail->ErrorInfo;
		else
			return $result;
	}
?>