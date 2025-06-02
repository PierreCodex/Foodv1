<?php 
include('../config/config.php');
session_destroy(); //remove all sessions and more importantly  $_SESSION['username'] for authentication purposes!
header('location:' .SITEURL. 'login.php')
?>