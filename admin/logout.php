<?php
session_start();
unset($_SESSION['admin_name']);
unset($_SESSION['admin_pwd']);
header('location:index.php');
die();

?>