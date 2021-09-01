<?php
	$fname=json_decode(json_encode($_POST['firstname']));
	$lname=json_decode(json_encode($_POST['lastname']));
	$mob=json_decode(json_encode($_POST['mobile']));
	$email=json_decode(json_encode($_POST['email']));
	$pwd=(json_encode($_POST['pwd']));
	$pwd=md5(json_decode($pwd));
	$city=json_decode(json_encode($_POST['city']));
	$state=json_decode(json_encode($_POST['state']));
	$added_on= date('d-m-y h:M:s');
	$conn=mysqli_connect('localhost','root','','ecommerce') or die("<script>alert('Loading');</script>");

	$check=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' OR mobile='$mob'");
	if(mysqli_num_rows($check)>0){
		echo "Account already exist";
	}
	else{
		$sql="INSERT INTO users (firstname, lastname, mobile, password, email, city, state, added_on) VALUES ('$fname','$lname','$mob','$pwd','$email','$city','$state','$added_on')";
		mysqli_query($conn,$sql);
		echo "Account successfully created";
	}
?> 
