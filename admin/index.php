<?php
include '../connection.inc.php';
include 'function.inc.php';

	 $msg=""; 
if(isset($_POST['submit'])){
	$name=get_safe_val($conn,$_POST['username']);
	$pwd=md5(get_safe_val($conn,($_POST['password'])));
	$sql="SELECT * FROM admin_users WHERE name='$name' AND password='$pwd'";
	$query=mysqli_query($conn,$sql) or die("no");
	$count=mysqli_num_rows($query);
	
	if($count>0)
	{	session_start();
		$querydata=mysqli_fetch_assoc($query);
		if($querydata['status']==0){
			$msg="Account Deactivated";
		}
		else{
		$_SESSION['ADMIN_ID']=$querydata['id'];
		$_SESSION['ADMIN_USERNAME']=$querydata['name'];
		$_SESSION['ADMIN_ROLE']=$querydata['role'];
		header('location:dashboard.php');
		}
	}
	else
	{
		$msg="! Please enter correct login details";
		
	}


}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Admin Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<?php include '../link.inc.php';	?>
	<style type="text/css">
		#game{
		animation-name: game;
		animation-duration: 4s;
		animation-direction: alternate;
		animation-iteration-count: infinite;
	}
	@keyframes game{
		0%{transform: scale3d(1,1,1);}
		25%{transform: scale3d(1.5,1.5,1.5);}
		100%{transform: rotate(360deg);}
	}
	</style>
</head>
<body style="background-color: rgba(0,0,0,0.8);">

<section id="admin" style="justify-content: center;	align-items: center;	flex-direction: column; display: flex; margin-top: 10%;">
	<div style="background-color: white; padding: 10px; width: 40%;">
		<form method="post" style=" color: black; align-content: center; ">
			<div align="center" class="jumbotron" style="background-color: white;"><img src="../img/dice.png" alt="play game" height="60" id="game"></div>
			<center>
			<div class="form-group">
				<label for="name" style="float: left; font-size: 1.3em;">Username : </label><input type="text" name="username" class="form-control" placeholder="username or email" style="width: 70%;" required>
			</div></center>
			<center>
			<div class="form-group">
				<label for="pwd"  style="float: left; font-size: 1.3em;">Password : </label><input type="password" name="password" placeholder="******" class="form-control" style="width: 70%;" required>
			</div></center>
			<center>
			<button type="submit" name="submit" style="width: 80%; background-color: black; color: white; font-size: 1.5em;">Sign in</button></center>
		</form>
		<div style="color: red; margin-top: 10px; font-size: 1.1em;"><?php echo $msg; ?></div>
	</div>
</section>


</body>
</html>