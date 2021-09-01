<?php
include "mail_function.php";
include "../connection.inc.php";
include "../function.inc.php";
date_default_timezone_set("Asia/Kolkata");
$success="";
$error_message="";
$type=get_safe_val($conn,$_POST['type']); 
if($type=="email"){
	$email=get_safe_val($conn,$_POST['email']);
	$check=mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
	if(mysqli_num_rows($check)>0){
		echo "-1";
	}
	else{
		$otp=rand(100000,999999);
		$mail_status=sendOTP($email,$otp);
		if($mail_status==1){
			mysqli_query($conn,"INSERT INTO OTP(email,otp,expiry_date) VALUES('$email','$otp','".date("Y-m-d H:i:s")."')");
			$curr_id=mysqli_insert_id($conn);
			if(!empty($curr_id))
				echo $otp;
			$_SESSION['OTP']=$otp;
		}
		else{
			echo "0";
		}
	}
}
?>