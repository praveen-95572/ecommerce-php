<?php
$email=json_decode(json_encode($_POST['email']));
$pwd=(json_encode($_POST['pwd']));
$pwd=md5(json_decode($pwd));

$conn=mysqli_connect('localhost','root','','ecommerce') or die("<script>alert('Loading');</script>");
$check=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$pwd'");

  $fetch=mysqli_fetch_array($check);
  
  if(is_array($fetch)){
    session_start();
    $_SESSION["USER_LOGIN"]='yes';
    $_SESSION["USER_ID"]=$fetch['id'];
    $_SESSION["USER_EMAIL"]=$fetch['email'];
    $_SESSION['USERNAME']=$fetch['firstname'];
    //echo "<script>alert('$email')</script>"; die();
     echo json_encode(array('status'=>1));
  }
  else{
    echo json_encode(array('status'=>0));
  }
?>