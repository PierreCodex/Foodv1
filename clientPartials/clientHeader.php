<?php

include('./config/config.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <title>Foodie Project</title>

    <!-- Link to css -->
    <link rel="stylesheet" href="./main.css">

    <!-- Link to swiper css -->
    <link rel="stylesheet" href="./swiper-bundle.min.css">

    <!-- Link to icons -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://kit.fontawesome.com/c93511b22d.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- Header/NavBar -->
    <header class="header flex" id="header">
        <div class="logoDiv">
            <a href="index.php" class="logo">
                FOODIE.
            </a>
        </div>

        <!-- Navbar -->
        <div class="navBar" id="navBar">
            <ul class="navLists flex">
                <li class="navItem">
                    <a href="index.php" class="navLink">Home</a>
                </li>

                <li class="navItem">
                    <a href="menu.php" class="navLink">Menu</a>
                </li>

                <li class="navItem">
                    <a href="menu.php" class="navLink">Reparto</a>
                </li>

                <li class="navItem">
                    <a href="tableReservation.php" class="navLink">Contacto
                    </a>
                </li>


                <div class="navBarText">
                    <p>Eat Anything, At anywhere, By Anytime.</p>
                </div>

                <!-- Toggle-Off navBar Icon -->
                <div class="closeNavbar" id="closeBtn">
                    <i class='bx bxs-x-circle icon'></i>
                </div>
            </ul>
        </div>



        <!-- HeaderIcons -->
        <!-- HeaderIcons -->
        <div class="headerIcons flex">
        <?php
// Calcular total de ítems en carrito: invitado (session_id) + usuario (user_id)
$session_id = session_id();
$user_id    = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

$stmt = mysqli_prepare($conn, "
    SELECT COALESCE(SUM(qty),0) AS totalItems
      FROM cart
     WHERE session_id = ?
        OR user_id = ?
");
mysqli_stmt_bind_param($stmt, "si", $session_id, $user_id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
$itemCount = $row['totalItems'];

?>
            <div class="notDiv">
                <a href="cart.php"><i class="uil uil-shopping-bag icon"></i></a>
                <span class="count"><?php echo $itemCount ?></span>
            </div>

            <div class="contactNumber">
                <i class="uil uil-phone icon phoneIcon"></i>
                <div class="phoneCard flex">
                    <i class='bx bxs-phone'></i>
                    <h3>Contact</h3>
                </div>
            </div>

            <div class="userMenu">
                <div class="userIconContainer flex">
                    <i class="uil uil-user icon userIcon"></i>
                    <!-- Mostrar el nombre del cliente solo si está logueado -->
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        // Si el cliente está logueado, obtener su nombre desde la base de datos
                        $user_id = $_SESSION['user_id']; // Obtener el ID del cliente desde la sesión
                        $sql_user = "SELECT name FROM users WHERE id = '$user_id'";
                        $res_user = mysqli_query($conn, $sql_user);
                        if ($res_user && mysqli_num_rows($res_user) > 0) {
                            $row_user = mysqli_fetch_assoc($res_user);
                            $user_name = $row_user['name'];
                            // Mostrar el nombre del cliente junto al ícono
                            echo "<span class='userName'>Hola</br> $user_name!</span>";
                        }
                    }
                    ?>
                </div>

                <div class="userSubMenu flex">
                    <i class='bx bxs-user'></i>
                    <!-- Mostrar "Iniciar Sesión" si el usuario NO está logueado -->
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="login.php">
                            <h3>Iniciar Sesión</h3>
                        </a>
                    <?php else: ?>
                        <!-- Mostrar "Salir" si el usuario ESTÁ logueado -->
                        <a href="dashboard.php">
                            <h3>Dashboard</h3>
                        </a>
                        <a href="logout.php">
                            <h3>Salir</h3>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
     

    


        <!-- Toggle-On navBar Icon -->
        <div class="toggleNavbar" id="toggler">
            <i class="uil uil-align-justify icon"></i>
        </div>
    </header>
    <!-- Header/NavBar Ends -->