<?php
require '../connection.inc.php';
require '../function.inc.php';
//insert into database
session_start();
if(!isset($_SESSION['USER_LOGIN'])){
	echo "Please Login!";
} 
else{

 $name = get_safe_val($conn,$_POST['name']);
 $email = get_safe_val($conn,$_POST['email']);
 $message = get_safe_val($conn,$_POST['message']); 
 $added_on=date('Y-m-d h:i:s');
 $mobile=get_safe_val($conn,$_POST['mobile']); 
 if(isset($_SESSION["USER_LOGIN"]) && $_SESSION["USER_EMAIL"]!=$email){
 	echo "Please enter the login email";
 	die();
 }
 mysqli_query($conn, "insert into contact (name, email, comment, mobile, added_on) values ('$name', '$email', '$message', '$mobile', '$added_on')"); 
 
 echo "THANK YOU !";
}
?>