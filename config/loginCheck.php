<?php 

if(!isset($_SESSION['username'])){

    $_SESSION['notLoggedIn'] = '<span class="fail" style="color: red;">Login Please!</span>';
    header('location:' .SITEURL.'login.php');
    
 }


?>