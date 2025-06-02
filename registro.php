<?php
include('clientPartials/clientHeader.php');
ob_start(); // Inicia el buffer de salida
?>

<div class="section container registerPage flex"> <!-- Cambié el nombre de loginPage a registerPage -->
    <div class="registerContent"> <!-- Cambié el nombre de pageContent a registerContent -->
        <h1 class="title">¡Regístrate aquí!</h1>
        <p>Complete los datos para crear una nueva cuenta.</p>

        <?php 
        // Mostrar mensajes de error o éxito
        if (isset($_SESSION['registrationMessage'])) {
            echo $_SESSION['registrationMessage'];
            unset($_SESSION['registrationMessage']);
        }
        ?>

        <form method="POST">
            <div class="input-container">
                <div class="input">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Ingresa tu nombrre" required>
                </div>
                <div class="input">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Ingresa tu Email" required>
                </div>
                <div class="input">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Ingresa Password" required>
                </div>
                <div class="input">
                    <label for="confirm_password">Confirmar contraseña</label>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirmar Password" required>
                </div>
                <div class="input">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Ingresa tu numero" required>
                </div>
              
            </div>
            <button class="btn flex" name="submit">Registrar <i class="uil uil-signin icon"></i></button>
        </form>

        <p class="text">¿Ya tiene una cuenta? <br> <a href="login.php">Iniciar Sesion</a></p>

        <img src="./Assests/floating (2).png" alt="">
    </div>
    <img src="./Assests/floating (2).png" alt="" class="designImage1">
    <img src="./Assests/floating (1).png" alt="" class="designImage2">
</div>

<?php
include('clientPartials/clientFooter.php');
?>

<?php
// Lógica de registro de usuario
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = $_POST['phone'];  // Obtener el teléfono
    $address = '';  // Obtener la dirección

    // Verificar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        $_SESSION['registrationMessage'] = '<span class="fail" style="color: red;">Las contraseñas no coinciden.</span>';
        header('location: registro.php');
        exit();
    }

   // Verificar si el correo electrónico ya está registrado
   $sql_check_email = "SELECT * FROM users WHERE email = ?";
   $stmt_check_email = mysqli_prepare($conn, $sql_check_email);
   mysqli_stmt_bind_param($stmt_check_email, "s", $email);
   mysqli_stmt_execute($stmt_check_email);
   $result_check_email = mysqli_stmt_get_result($stmt_check_email);

   if (mysqli_num_rows($result_check_email) > 0) {
       $_SESSION['registrationMessage'] = '<span class="fail" style="color: red;">El correo electrónico ya existe.</span>';
       header('location: registro.php');
       exit();
   }

   // Insertar el nuevo usuario en la base de datos
   $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Encriptar la contraseña
   $sql_register = "INSERT INTO users (name, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
   $stmt_register = mysqli_prepare($conn, $sql_register);
   mysqli_stmt_bind_param($stmt_register, "sssss", $name, $email, $hashed_password, $phone, $address);

   if (mysqli_stmt_execute($stmt_register)) {
       $_SESSION['registrationMessage'] = '<span class="success" style="color: green;">Registro exitoso! Por favor inicia sesión.</span>';
       header('location: login.php'); // Redirigir al login
       exit();
   } else {
       $_SESSION['registrationMessage'] = '<span class="fail" style="color: red;">Registro fallido. ¡Intenta de nuevo!</span>';
       header('location: registro.php');
       exit();
   }
}
?>