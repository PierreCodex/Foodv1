<?php 

if (session_status() == PHP_SESSION_NONE) {
  session_start(); // Iniciar sesión solo si no se ha iniciado previamente
}

date_default_timezone_set('America/Lima'); // Zona horaria de Perú

  // Definición de constantes con validación previa
if (!defined('SITEURL')) {
  define('SITEURL', 'http://localhost/PROYECTO-RESTAURANTE/');
}

if (!defined('LOCALHOST')) {
  define('LOCALHOST', 'localhost');
}

if (!defined('ROOT')) {
  define('ROOT', 'root');
}

if (!defined('PASSWORD')) {
  define('PASSWORD', '');
}

if (!defined('DATABASE')) {
  define('DATABASE', 'restaurante-morales');
}


  $conn =  mysqli_connect(LOCALHOST, ROOT, PASSWORD, DATABASE) or die();
  $db_select = mysqli_select_db($conn, DATABASE) or die();

?>