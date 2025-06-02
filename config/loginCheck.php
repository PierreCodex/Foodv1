<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Verifica que el usuario esté logueado y sea admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['notLoggedIn'] = '<span class="fail" style="color: red;">Please login as Admin!</span>';
    header('Location:' . SITEURL . 'login.php');
    exit();
}
?>
