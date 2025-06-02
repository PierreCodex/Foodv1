<?php
include('clientPartials/clientHeader.php');
ob_start();
?>

<div class="section container loginPage flex">
    <div class="pageContent">
        <h1 class="title">Login Here!</h1>
        <p>Please be authentic!</p>

        <?php
        if (isset($_SESSION['noAdmin'])) {
            echo $_SESSION['noAdmin'];
            unset($_SESSION['noAdmin']);
        }
        if (isset($_SESSION['noUser'])) {
            echo $_SESSION['noUser'];
            unset($_SESSION['noUser']);
        }

        if (isset($_SESSION['notLoggedIn'])) {
            echo $_SESSION['notLoggedIn'];
            unset($_SESSION['notLoggedIn']);
        }

        if (isset($_SESSION['settings'])) {
            echo $_SESSION['settings'];
            unset($_SESSION['settings']);
        }

        if (isset($_SESSION['credentialsChanged'])) {
            echo $_SESSION['credentialsChanged'];
            unset($_SESSION['credentialsChanged']);
        }
        ?>

        <form method="POST">
            <div class="input">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Email" required>
            </div>
            <div class="input">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
            </div>
            <button class="btn flex" name="submit">Login <i class="uil uil-signin icon"></i></button>
        </form>

        <p class="text">
            Having Trouble Logging In? <br><br>
            <a href="registro.php">Create an Account</a>
        </p>

        <img src="./Assests/floating (2).png" alt="">
    </div>
    <img src="./Assests/floating (2).png" alt="" class="designImage1">
    <img src="./Assests/floating (1).png" alt="" class="designImage2">
</div>

<?php
include('clientPartials/clientFooter.php');
?>

<?php

session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $loginPassword = $_POST['password'];

    // --- Administrador ---
    $sql_admin = "SELECT * FROM admins WHERE email = ?";
    $stmt_admin = mysqli_prepare($conn, $sql_admin);
    mysqli_stmt_bind_param($stmt_admin, "s", $email);
    mysqli_stmt_execute($stmt_admin);
    $res_admin = mysqli_stmt_get_result($stmt_admin);
    $row_admin = mysqli_fetch_assoc($res_admin);

    if ($row_admin && $loginPassword === $row_admin['password']) {
        // Login exitoso admin
        $_SESSION['loginMessage'] = '<span class="success">Welcome Admin ' . htmlspecialchars($row_admin['name']) . '!</span>';
        $_SESSION['email']   = $email;
        $_SESSION['user_id'] = $row_admin['id'];
        $_SESSION['role'] = 'admin';  // Marca el rol admin
        $_SESSION['name'] = $row_admin['name'];  // <-- Agregado para mostrar nombre
        $_SESSION['username'] = $row_admin['username']; // <-- aquí lo agregas

     
        header('Location:' . SITEURL . 'admin/dashboard.php');
        exit();
    }

    // --- Cliente ---
    $sql_client = "SELECT * FROM users WHERE email = ?";
    $stmt_client = mysqli_prepare($conn, $sql_client);
    mysqli_stmt_bind_param($stmt_client, "s", $email);
    mysqli_stmt_execute($stmt_client);
    $res_client = mysqli_stmt_get_result($stmt_client);
    $row_client = mysqli_fetch_assoc($res_client);

    if ($row_client && password_verify($loginPassword, $row_client['password'])) {
        // Login exitoso cliente
        $_SESSION['loginMessage'] = '<span class="success">Welcome ' . htmlspecialchars($row_client['name']) . '!</span>';
        $_SESSION['email']   = $email;
        $_SESSION['user_id'] = $row_client['id'];

        // Migrar carrito de invitado al usuario
        $session_id = session_id();
        $stmtM = mysqli_prepare($conn, "
            UPDATE cart
               SET user_id = ?
             WHERE session_id = ?
        ");
        mysqli_stmt_bind_param($stmtM, "is", $_SESSION['user_id'], $session_id);
        mysqli_stmt_execute($stmtM);

        // Redirigir al destino guardado (checkout) o al dashboard
        $redirect = $_SESSION['after_login_redirect'] ?? 'dashboard.php';
        unset($_SESSION['after_login_redirect']);
        header('Location:' . SITEURL . $redirect);
        exit();
    }

    // Credenciales incorrectas
    $_SESSION['noUser'] = '<span class="fail" style="color: red;">Incorrect Credentials!</span>';
    header('Location:' . SITEURL . 'login.php');
    exit();
}
?>