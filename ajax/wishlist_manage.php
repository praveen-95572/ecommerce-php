<?php
include '../connection.inc.php';
include '../function.inc.php';	
include '../add_to_cart.inc.php';
$pid=get_safe_val($conn,$_GET['id']);
$type=get_safe_val($conn,$_GET['type']);
$added_on=date('y-m-d h:i:s');
session_start();
if(isset($_SESSION['USER_LOGIN'])){
	$uid=$_SESSION['USER_ID'];
	if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM wishlist WHERE u_id='$uid' AND p_id='$pid'"))>0)
		{}
	else
	mysqli_query($conn,"INSERT INTO wishlist (u_id,p_id,added_on) VALUES ('$uid','$pid','$added_on')");
		echo mysqli_num_rows(mysqli_query($conn,"SELECT * FROM wishlist WHERE u_id='$uid'")); 
}
else{
	echo "0";;
}
?>