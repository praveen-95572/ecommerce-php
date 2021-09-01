<?php
require('../connection.inc.php');
require('../function.inc.php');

$email=get_safe_val($conn,$_POST['email']);
$res=mysqli_query($conn,"select * from users where email='$email'");
$check_user=mysqli_num_rows($res);

if($check_user>0){
	$row=mysqli_fetch_assoc($res);
	$pwd=$row['password'];
	$html="Your password is <strong>$pwd</strong>";
	include('../smtp/PHPMailerAutoload.php');
	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Port=587;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username="apnidukaan633@gmail.com";
	$mail->Password='Dehradun@123';
	$mail->SetFrom('apnidukaan633@gmail.com','Apni Dukaan');
	$mail->addAddress($email);
	$mail->IsHTML(true);
	$mail->Subject="Your Password";
	$mail->Body=$html;
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if($mail->send()){
		echo "Please check your email id for password";
	}else{
		//echo "Error occur";
	}
}else{
	echo "Email id not registered with us";
	die();
}
?>