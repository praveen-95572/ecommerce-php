<?php
require 'connection.inc.php';

/*unset($_SESSION['USER_LOGIN']);

unset($_SESSION['USER_ID']);

unset($_SESSION['USER_NAME']);
*/session_start();
session_destroy();
header('location:index.php');

?>