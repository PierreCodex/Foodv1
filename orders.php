<?php
include('./config/config.php');
include('./clienteDashboard/adminHeader.php');
include('clientPartials/clientHeader.php');

$user_id = $_SESSION['user_id']; // Usuario logueado

// Consulta para obtener las órdenes y productos relacionados
$sql = "
    SELECT o.id AS order_id, o.updated_date,o.street, o.order_status, o.total_cost,
           oi.food_id, oi.quantity, oi.price, oi.subtotal,
           f.food_name, f.image
    FROM orders o
    LEFT JOIN order_items oi ON o.id = oi.order_id
    LEFT JOIN food f ON oi.food_id = f.id
    WHERE o.user_id = $user_id
    ORDER BY o.updated_date DESC, o.id DESC
";

$res = mysqli_query($conn, $sql);
$orders = [];

if ($res && mysqli_num_rows($res) > 0) {
    // Organizar datos: cada orden con su lista de productos
    while ($row = mysqli_fetch_assoc($res)) {
        $oid = $row['order_id'];
        if (!isset($orders[$oid])) {
            $orders[$oid] = [
                'updated_date' => $row['updated_date'],
                'order_status' => $row['order_status'],
                'street' => $row['street'],
                'total_cost' => $row['total_cost'],
                'items' => []
            ];
        }
        if ($row['food_id']) { // Si tiene productos
            $orders[$oid]['items'][] = [
                'food_name' => $row['food_name'],
                'image' => $row['image'],
                'quantity' => $row['quantity'],
                'price' => $row['price'],
                'subtotal' => $row['subtotal'],
                'food_id' => $row['food_id']  // Asegúrate de que food_id esté aquí
            ];
        }
    }
} else {
    $orders = null; // No hay órdenes
}



?>
<section class="container section tableReservationPage">
    <div class="adminPage flex">
        <?php include('./clienteDashboard/sideMenu.php'); ?>

        <div class="mainBody">
            <div class="topSection flex">
                <div class="title">
                    <span><strong>Mis</strong> Ordenes</span>
                </div>
                <?php
                if (isset($_SESSION['orderUpdated'])) {
                    echo $_SESSION['orderUpdated'];
                    unset($_SESSION['orderUpdated']);
                }
                ?>
            </div>

            <div class="mainBodyContentContainer">
                <?php if ($orders): ?>
                    <?php foreach ($orders as $order_id => $order): ?>
                        <div class="orderCard">
                            <div class="orderHeader">
                                <h3>Orden #<?= $order_id ?> - Fecha: <?= $order['updated_date'] ?></h3>
                            </div>

                            <div class="orderDetails">
                                <div class="orderDetailItem">
                                    <strong>Dirección:</strong>
                                    <p><?= $order['street'] ?></p>
                                </div>
                                <div class="orderDetailItem">
                                    <strong>Estado:</strong>
                                    <span class="status <?= strtolower($order['order_status']) ?>"><?= $order['order_status'] ?></span>
                                </div>
                                <div class="orderDetailItem">
                                    <strong>Total:</strong>
                                    <p class="total">S/. <?= number_format($order['total_cost'], 2) ?></p>
                                </div>
                            </div>

                            <!-- Mostrar los productos de la orden con un botón de reseña por producto -->
                            <!-- Mostrar los productos de la orden con un botón de reseña por producto -->
                            <table class="orderItemsTable">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                        <th>Reseña</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order['items'] as $item): ?>
                                        <?php
                                        // Verificar si el usuario ya dejó una reseña para este producto
                                        $sql_check_review = "
                                            SELECT * FROM reviews 
                                            WHERE user_id = $user_id AND food_id = {$item['food_id']}
                                        ";
                                        $res_check_review = mysqli_query($conn, $sql_check_review);
                                        $review_exists = mysqli_num_rows($res_check_review) > 0;
                                        ?>
                                        <tr>
                                            <td>
                                                <?php if ($item['image']): ?>
                                                    <img src="<?= SITEURL ?>databaseImages/foodie<?= $item['image'] ?>" alt="<?= htmlspecialchars($item['food_name']) ?>" width="50" />
                                                <?php endif; ?>
                                                <?= htmlspecialchars($item['food_name']) ?>
                                            </td>
                                            <td><?= $item['quantity'] ?></td>
                                            <td>S/. <?= number_format($item['price'], 2) ?></td>
                                            <td>S/. <?= number_format($item['subtotal'], 2) ?></td>

                                            <td class="action">
                                                &nbsp;|&nbsp;
                                                <?php if ($order['order_status'] == 'Entregado'): ?>
                                                    <?php if (!$review_exists): ?>
                                                        <!-- Solo mostrar ícono si no hay reseña -->
                                                        <a href="reviews.php?food_id=<?= $item['food_id']; ?>" class="btn btn-small" title="Deja una Reseña">
                                                            ⭐
                                                        </a>
                                                    <?php else: ?>
                                                        <!-- Mostrar mensaje si ya dejó una reseña -->
                                                        <span>Ya dejaste una reseña</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span>No disponible</span>
                                                <?php endif; ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No tienes órdenes registradas.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php
include('clientPartials/clientFooter.php');
?>