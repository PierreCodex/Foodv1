<?php
include('./adminPartials/adminHeader.php');
ob_start();

// Validar id pedido
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
$sqlItems = "SELECT oi.quantity, oi.price, f.food_name, f.image
             FROM order_items oi
             JOIN food f ON oi.food_id = f.id
             WHERE oi.order_id = $orderId";
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
            <div class="title"><span><strong>Detalle de </strong> Orden</span></div>
            <?php include('./adminPartials/headerAdminAccount.php'); ?>
        </div>

        <div class="mainBodyContentContainer">

            <div class="heading flex">
                <span>#<?php echo $order['id']; ?> Detalle de Orden</span>
                <button class="btn">
                    <a href="<?php echo SITEURL; ?>admin/orders.php" class="flex">Todas las Ordenes <i class="uil uil-arrow-right icon"></i></a>
                </button>
            </div>

            <div class="orderDetails flex">
                <div class="cartDiv grid">
                    <?php if (count($items) > 0): ?>
                        <?php foreach ($items as $item): ?>
                            <div class="singleCart flex">
                                <?php if (!empty($item['image'])): ?>
                                    <img src="<?php echo SITEURL . 'databaseImages/foodie' . $item['image']; ?>" alt="<?php echo htmlspecialchars($item['food_name']); ?>">
                                <?php else: ?>
                                    <span class="fail" style="color:red; margin: 0px 10px;">No Image</span>
                                <?php endif; ?>
                                <div class="foodDetails">
                                    <span class="name_closeIcon flex"><?php echo htmlspecialchars($item['food_name']); ?><i class="uil uil-check-circle icon"></i></span>
                                    <span class="qty_price flex">
                                        <span>Cantidad: <?php echo intval($item['quantity']); ?></span>
                                        <span>S./<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No se han encontrado productos para este pedido.</p>
                    <?php endif; ?>
                </div>

                <div class="amountDiv">
                    <h3 class="title flex">Detalle de  Pdido: <img src="../Assests/order.png" alt="Icon"></h3>
                    <span class="cartList flex">
                        <span class="subTitle">Subtotal:</span>
                        <span class="cost">S./<?php echo number_format($subTotal, 2); ?></span>
                    </span>
                    <span class="cartList flex">
                        <span class="subTitle">Total:</span>
                        <span class="gradCost">S./<?php echo number_format(floatval($order['total_cost']), 2); ?></span>
                    </span>
                    <span class="cartList flex">
                        <span class="subTitle">Metodo de Envio:</span>
                        <span class="gradCost"><?php echo htmlspecialchars($order['payment']); ?></span>
                    </span>

                    <div class="updateOrderDiv">
                        <h3 class="updateOrderTitle flex">Estado de Orden</h3>
                        <form method="post">
                            <div class="inputDiv flex">
                                <label>Estado</label>
                                <select name="status" required>
                                    <?php
                                    $statuses = ['Pendiente', 'Entregado', 'Cancelado', 'En camino'];
                                    foreach ($statuses as $status) {
                                        $selected = ($order['order_status'] === $status) ? 'selected' : '';
                                        echo "<option value=\"$status\" $selected>$status</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <input type="hidden" name="updated" value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
                            <input type="hidden" name="dateTime" value="<?php echo date("Y-m-d H:i:s"); ?>">
                            <button name="submit" class="btn">Actualizar Order</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="customerDetails grid">
                <div class="heading flex"><span>Customer Details</span></div>
                <?php
                $fields = [
                    'First Name' => 'cust_fname',
                    'Second Name' => 'cust_sname',
                    'Email' => 'email',
                    'Phone' => 'contact',
                    'Location' => 'location',
                    'Street' => 'street',
                    'Building' => 'building',
                    'Message' => 'message',
                ];
                foreach ($fields as $label => $field) {
                    echo '<div class="singleDetail flex"><span class="dTitle">' . $label . ':-</span> <span class="detail">' . htmlspecialchars($order[$field]) . '</span></div>';
                }
                ?>
            </div>

            <div class="customerDetails grid">
                <div class="heading flex"><span>Order Notes</span></div>
                <div class="singleDetail flex"><span class="detail">This order was last updated by:</span></div>
                <div class="singleDetail flex"><span class="dTitle">Admin Name:-</span> <span class="detail" style="text-transform: capitalize;"><?php echo htmlspecialchars($order['updated_by']); ?></span></div>
                <div class="singleDetail flex"><span class="dTitle">Date:-</span> <span class="detail"><?php echo htmlspecialchars($order['updated_date']); ?></span></div>
            </div>
        </div>
    </div>
</div>

<?php
include('./adminPartials/adminFooter.php');

if (isset($_POST['submit'])) {
    $allowed_status = ['Pendiente', 'Entregado', 'Cancelado', 'En camino'];
    $status = $_POST['status'];
    if (!in_array($status, $allowed_status)) {
        $status = $order['order_status'];
    }
    $updated = $_POST['updated'];
    $dateTime = $_POST['dateTime'];

    $sqlUpdate = "UPDATE orders SET
        order_status = '$status',
        updated_by = '$updated',
        updated_date = '$dateTime'
        WHERE id = $orderId";

    $result = mysqli_query($conn, $sqlUpdate);

    if ($result) {
        $_SESSION['orderUpdated'] = '<span class="success">Order Updated Successfully!</span>';
        header('Location: ' . SITEURL . 'admin/orders.php');
        exit();
    } else {
        die('Failed to update order: ' . mysqli_error($conn));
    }
}
?>
