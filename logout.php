<?php
include('clientPartials/clientHeader.php');  // trae $conn y session_start()

// 1) Borrar solo los ítems de invitado (user_id IS NULL)
$oldSession = session_id();
$stmt = mysqli_prepare($conn, "
    DELETE FROM cart
     WHERE session_id = ?
       AND user_id IS NULL
");
mysqli_stmt_bind_param($stmt, "s", $oldSession);
mysqli_stmt_execute($stmt);

// 2) Destruir la sesión
session_unset();
session_destroy();

// 3) Iniciar una sesión nueva limpia
session_start();
session_regenerate_id(true);

// 4) Redirigir al login
header('Location: login.php');
exit();