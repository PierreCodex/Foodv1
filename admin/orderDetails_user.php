<?php
include('./adminPartials/adminHeader.php');
ob_start();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Pedido no especificado o inválido');
}
$orderId = intval($_GET['id']);

// Obtener datos del pedido
$sqlOrder = "SELECT * FROM orders WHERE id = $orderId";
$resOrder = mysqli_query($conn, $sqlOrder);
if (!$resOrder || mysqli_num_rows($resOrder) !== 1) {
    die('Pedido no encontrado');
}
$order = mysqli_fetch_assoc($resOrder);

// Obtener productos del pedido con JOIN a food
$sqlItems = "
    SELECT oi.quantity, oi.price, f.food_name, f.image
    FROM order_items oi
    JOIN food f ON oi.food_id = f.id
    WHERE oi.order_id = $orderId
";
$resItems = mysqli_query($conn, $sqlItems);

$items = [];
$subTotal = 0;
if ($resItems && mysqli_num_rows($resItems) > 0) {
    while ($row = mysqli_fetch_assoc($resItems)) {
        $items[] = $row;
        $subTotal += $row['price'] * $row['quantity'];
    }
}
?>

<div class="adminPage flex">
    <?php include('./adminPartials/sideMenu.php'); ?>
    <div class="mainBody">
        <div class="topSection flex">
            <div class="title"><span><strong>Vista</strong> Previa</span></div>
            <?php include('./adminPartials/headerAdminAccount.php'); ?>
        </div>

        <div class="mainBodyContentContainer">

            <div class="heading flex">
                <span>#<?php echo $order['id']; ?> Detalles del Pedido</span>
                <button class="btn">
                    <a href="<?php echo SITEURL; ?>admin/orders.php" class="flex">Todos los Pedidos <i class="uil uil-arrow-right icon"></i></a>
                </button>
            </div>

            <div class="summarySection grid" style="grid-template-columns: repeat(2, 1fr); gap: 2rem; ">

                <!-- Card Datos del Cliente -->
                <div class="summaryCard" style="  height: 230px;
">
                    <span class="flex">
                        <img src="../Assests/customer.png" alt="Cliente Icono" style="width:32px; height:32px;">
                        <span class="cardTitle">Datos del Cliente</span>
                    </span><br>
                    <div class="clientInfo">
                        <p><strong>Nombre completo:</strong> <?php echo htmlspecialchars($order['cust_fname'] . ' ' . $order['cust_sname']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                        <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($order['contact']); ?></p>
                        <p><strong>Dirección:</strong> <?php echo htmlspecialchars($order['location'] . ', ' . $order['street'] . ', N° ' . $order['building']); ?></p>
                        <p><strong>Mensaje:</strong> <?php echo htmlspecialchars($order['message']); ?></p>
                    </div>
                </div>

                <!-- Card Notas del Pedido -->
                <div class="summaryCard">
                    <span class="flex">
                        <img src="../Assests/clock.png" alt="Notas Icono" style="width:32px; height:32px;">
                        <span class="cardTitle">Notas del Pedido</span>
                    </span>
                    <div class="orderNotes">
                        <p><strong>Última actualización por:</strong></p>
                        <p><strong>Administrador:</strong> <span style="text-transform: capitalize;"><?php echo htmlspecialchars($order['updated_by']); ?></span></p>
                        <p><strong>Fecha:</strong> <?php echo htmlspecialchars($order['updated_date']); ?></p>
                    </div>
                </div>

            </div>

            <div class="orderDetailsv flex">
                <style>
                    .orderDetailsv {
                        width: 100%;
                    }

                    .orderDiv {
                        width: 100%;
                        max-width: 900px;
                        overflow-x: auto;
                        /* para scroll horizontal si es necesario */
                    }

                    .table {
                        width: 100%;
                        min-width: 700px;
                    }

                    .table th,
                    .table td {
                        padding: 8px 12px;
                        border: 1px solid #ddd;
                    }
                </style>

                <!-- Productos en tabla usando clases consistentes -->
                <div class="orderDiv">
                    <table class="table">
                        <tr class="tblHeader">
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Metodo de Pago</th>
                            <th>Precio Total</th>
                        </tr>
                        <?php if (count($items) > 0): ?>
                            <?php foreach ($items as $item): ?>
                                <tr class="tblRow">
                                    <td>
                                        <?php if (!empty($item['image'])): ?>
                                            <img src="<?php echo SITEURL . 'databaseImages/food' . $item['image']; ?>" alt="<?php echo htmlspecialchars($item['food_name']); ?>" style="width:80px; height:80px; object-fit:cover; margin-right:18px;">
                                        <?php endif; ?>
                                        <?php echo htmlspecialchars($item['food_name']); ?>
                                    </td>

                                    <td><?php echo intval($item['quantity']); ?></td>

                                    <td>S/. <?php echo htmlspecialchars($order['payment']); ?></td>
                                    <td>S/. <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr class="tblRow">
                                <td colspan="3">No hay productos en este pedido.</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>

                <!-- Totales -->

            </div>

        </div>
    </div>
</div>

<?php include('./adminPartials/adminFooter.php'); ?>