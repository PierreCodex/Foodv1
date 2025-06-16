<?php
ob_start(); // Inicia el almacenamiento en búfer de salida

include('./config/config.php');
include('./clienteDashboard/adminHeader.php');
include('clientPartials/clientHeader.php');

// Verificar si el usuario está logueado y si se ha pasado un food_id
if (!isset($_SESSION['user_id']) || !isset($_GET['food_id'])) {
    header('Location: login.php'); // Redirigir si no está logueado o no hay food_id
    exit();
}

$food_id = $_GET['food_id'];
$user_id = $_SESSION['user_id'];

// Consultar la información del producto
$sql = "SELECT * FROM food WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $food_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "Producto no encontrado.";
    exit();
}

// Procesar la reseña si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Validar los datos
    if (empty($rating) || empty($comment)) {
        $error = "Por favor, califica el producto y escribe un comentario.";
    } else {
        // Insertar una nueva reseña
        $sql_insert = "INSERT INTO reviews (user_id, food_id, rating, content) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iiis", $user_id, $food_id, $rating, $comment);
        if ($stmt_insert->execute()) {
            $success = "¡Gracias por tu reseña!";
            header('Location: orders.php'); // Redirigir a la página de órdenes después de guardar
            exit();  // Detener la ejecución del script para asegurar la redirección
        } else {
            $error = "Hubo un problema al guardar tu reseña. Por favor, intenta de nuevo.";
        }
    }
}
?>

<section class="container section tableReservationPage">
    <div class="adminPage flex">
        <?php include('./clienteDashboard/sideMenu.php'); ?>

        <div class="mainBody">
            <div class="topSection flex">
                <div class="title">
                    <span><strong>Mis</strong> Reseñas</span>
                </div>
            </div>

            <div class="mainBodyContentContainer">
                <h1>Deja una Reseña para el Producto: <?= $product['food_name'] ?></h1>

                <!-- Formulario de reseña -->
                <form action="reviews.php?food_id=<?= $food_id ?>" method="POST">
                    <div class="form-group">
                        <label for="rating">Calificación:</label>
                        <div class="rating">
                            <input type="radio" id="star5" name="rating" value="5">
                            <label for="star5">★</label>
                            <input type="radio" id="star4" name="rating" value="4">
                            <label for="star4">★</label>
                            <input type="radio" id="star3" name="rating" value="3">
                            <label for="star3">★</label>
                            <input type="radio" id="star2" name="rating" value="2">
                            <label for="star2">★</label>
                            <input type="radio" id="star1" name="rating" value="1">
                            <label for="star1">★</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="comment">Comentario:</label>
                        <textarea id="comment" name="comment" rows="4" placeholder="Escribe tu comentario aquí..."></textarea>
                    </div>

                    <!-- Botón de envío con confirmación -->
                    <button type="button" class="btn-submit" onclick="showConfirmationMessage()">Enviar Reseña</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
// Función para mostrar el mensaje de confirmación antes de enviar la reseña
function showConfirmationMessage() {
    // Usar SweetAlert para mostrar un mensaje de confirmación
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Deseas enviar esta reseña?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, enviar',
        cancelButtonText: 'No, cancelar',
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, enviamos el formulario
            document.querySelector('form').submit();
        }
    });
}
</script>

<!-- Incluir SweetAlert desde el CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.27/dist/sweetalert2.min.js"></script>

<?php
ob_end_flush(); // Libera el búfer de salida
include('clientPartials/clientFooter.php');
?>
