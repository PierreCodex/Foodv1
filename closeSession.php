<?php
include('./config/config.php');

if (empty($_SESSION['user_id'])) {
    header('Location: ' . SITEURL);
    exit();
}

$user_id = $_SESSION['user_id'];

// Solo vaciar el carrito, no cerrar la sesión
$sql_clear_cart = "DELETE FROM cart WHERE user_id = '$user_id'";
mysqli_query($conn, $sql_clear_cart);

// Aquí puedes redirigir a una página de confirmación o historial, pero NO cierres la sesión
header('Location: ' . SITEURL . 'index.php'); // o la página que prefieras
exit();
