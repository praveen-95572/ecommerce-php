<?php
require '../connection.inc.php';
require '../function.inc.php';
//insert into database
session_start();
if(!isset($_SESSION['USER_LOGIN'])){
	echo "Please Login!";
} 
else{
if(!empty($_POST)) {
 $name = get_safe_val($conn,$_POST['name']);
 $email = get_safe_val($conn,$_POST['email']);
 $mobile=get_safe_val($conn,$_POST['mobile']); 
 mysqli_query($conn, "UPDATE users SET name='$name', email='$email' mobile='$mobile' WHERE id='".$_SESSION['USER_ID']."'"); 
 echo "Profile updated successfully !";
}}
?>