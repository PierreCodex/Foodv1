<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('./clientPartials/clientHeader.php');
ob_start();

if (empty($_SESSION['user_id'])) {
    $_SESSION['after_login_redirect'] = 'checkout.php';
    $_SESSION['loginMessage'] = '<span class="fail">Por favor, inicia sesión para finalizar tu pedido.</span>';
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
    // Datos del formulario
    $fName       = $_POST['fName'];
    $LName       = $_POST['LName'];
    $phone       = $_POST['phone'];
    $email       = $_POST['email'];
    $town        = $_POST['town'];
    $street      = $_POST['street'];
    $buildingNo  = $_POST['buildingNo'];
    $message     = $_POST['message'];
    $payment     = $_POST['payment'];
    $subTotal    = $_POST['subTotal'];
    $orderStatus = 'Pendiente';
    $updated_date= date('Y-m-d H:i:s');

    // 1) Insertar la orden (sin cart_ID)
    $sql_order = "
      INSERT INTO `orders`
        (`user_id`, `admin_id`, `cust_fname`, `cust_sname`,
         `contact`, `location`, `email`, `street`, `building`,
         `message`, `total_cost`, `order_status`, `payment`,
         `updated_by`, `updated_date`)
      VALUES
        ('$user_id', NULL, '$fName', '$LName',
         '$phone', '$town', '$email', '$street', '$buildingNo',
         '$message', '$subTotal', '$orderStatus', '$payment',
         NULL, '$updated_date')
    ";

    if (!mysqli_query($conn, $sql_order)) {
        die("Error al guardar la orden: " . mysqli_error($conn));
    }

    // Obtener el ID de la orden insertada
    $order_id = mysqli_insert_id($conn);

    // 2) Obtener productos del carrito
    $sql_cart = "SELECT * FROM cart WHERE user_id = '$user_id'";
    $res_cart = mysqli_query($conn, $sql_cart);

    while ($item = mysqli_fetch_assoc($res_cart)) {
        $food_id = $item['food_id'];
        $qty = $item['qty'];

        // Obtener precio actual del producto
        $sql_food = "SELECT price FROM food WHERE id = $food_id";
        $res_food = mysqli_query($conn, $sql_food);
        if ($res_food && mysqli_num_rows($res_food) > 0) {
            $food = mysqli_fetch_assoc($res_food);
            $price = floatval($food['price']);
            $subtotal = $qty * $price;

            // Insertar detalle en order_items
            $sql_item = "INSERT INTO order_items (order_id, food_id, quantity, price, subtotal)
                         VALUES ('$order_id', '$food_id', '$qty', '$price', '$subtotal')";
            mysqli_query($conn, $sql_item);
        }
    }

    // 3) Vaciar carrito
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");

    // 4) Mensaje y redirección
    $_SESSION['OrderAdded'] = '
      <div class="messageConatainerHome flex">
        <span class="messageCard">
          <img src="./Assests/checkIcon.png" class="checkIconHome">
          <small>¡Tu orden se ha enviado con éxito!<br>¡Gracias por tu preferencia!</small>
        </span>
      </div>';
    header('Location: ' . SITEURL . 'closeSession.php');
    exit();
}
?>
<!-- Check Out Page -->
<section class="section container checkOut">
    <div class="secTitle">
        <h2 class="title flex">
            Checkout <img src="./Assests/trolley.png" alt="Icon">
        </h2>
    </div>
    <div class="secContent">
        <form method="POST">
            <div class="mainContent grid">
                <div class="rightDiv grid">
                    <!-- Personal Information -->
                    <div class="personalInfo">
                        <h3 class="title flex">Personal Information: <img src="./Assests/details.png" alt="Icon"></h3>
                        <div class="inputDiv">
                            <div class="input">
                                <label for="fName">First Name</label>
                                <input type="text" name="fName" placeholder="Enter First Name" required>
                            </div>
                            <div class="input">
                                <label for="LName">Last Name</label>
                                <input type="text" name="LName" placeholder="Enter Last Name" required>
                            </div>
                            <div class="input">
                                <label for="phone">Phone</label>
                                <input type="number" name="phone" placeholder="Enter Phone Number" required>
                            </div>
                            <div class="input">
                                <label for="email">Email</label>
                                <input type="email" name="email" placeholder="Enter Your Email" required>
                            </div>
                        </div>
                    </div>
                    <!-- Delivery Details -->
                    <div class="deliveryAddress">
                        <h3 class="title flex">Delivery Details: <img src="./Assests/house.png" alt="Icon"></h3>
                        <div class="inputDiv">
                            <div class="input">
                                <label for="town">Location</label>
                                <select name="town" required>
                                    <option value="London">London</option>
                                    <option value="Liverpool">Liverpool</option>
                                    <option value="Shefield">Shefield</option>
                                    <option value="Leicester">Leicester</option>
                                </select>
                            </div>
                            <div class="input">
                                <label for="street">Street</label>
                                <input type="text" name="street" placeholder="Enter Your Street" required>
                            </div>
                            <div class="input">
                                <label for="buildingNo">Building Number</label>
                                <input type="text" name="buildingNo" placeholder="Enter Building Number" required>
                            </div>
                            <div class="input">
                                <label for="message">Message (Optional)</label>
                                <textarea name="message" placeholder="Any Message"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Payment Option -->
                    <div class="paymentOption">
                        <h3 class="title flex">Payment: <img src="./Assests/debit-card.png" alt="Icon"></h3>
                        <div class="optionDiv">
                            <div class="input flex">
                                <div class="radio">
                                    <input type="radio" name="payment" id="cod" value="C.O.D" required>
                                </div>
                                <label for="cod">Pago contra entrega: (Delivery: S/.5)</label>
                            </div>
                            <div class="input flex">
                                <div class="radio">
                                    <input type="radio" name="payment" id="mobile" value="Dining">
                                </div>
                                <label for="mobile">Recoger en Restaurante</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="leftDiv grid">
                    <!-- Cart Overview -->
                    <div class="cartDiv grid">
                        <h3 class="title flex">Your order: <img src="./Assests/cart.png" alt="Icon"></h3>
                        <?php
                        if (isset($_SESSION['deletedCartItem'])) {
                            echo $_SESSION['deletedCartItem'];
                            unset($_SESSION['deletedCartItem']);
                        }
                        // Listado de items en el carrito
                        $sql = "SELECT * FROM cart WHERE user_id = '$user_id'";
                        $res = mysqli_query($conn, $sql);
                        $subTotal = 0;
                        if ($res && mysqli_num_rows($res) > 0) {
                            while ($eachRow = mysqli_fetch_assoc($res)) {
                                $cartID   = $eachRow['id'];
                                $foodID   = $eachRow['food_id'];
                                $qty      = $eachRow['qty'];
                                $totalCost= $eachRow['total_cost'];
                                $subTotal += $totalCost;

                                $foodRes = mysqli_query($conn, "SELECT * FROM food WHERE id = $foodID");
                                if ($foodRes && mysqli_num_rows($foodRes) > 0) {
                                    $food = mysqli_fetch_assoc($foodRes);
                                    ?>
                                    <div class="singleCart flex">
                                        <?php if ($food['image'] != ""): ?>
                                            <img src="<?= SITEURL ?>databaseImages/foodie<?= $food['image'] ?>" alt="Online Food Order">
                                        <?php else: ?>
                                            <span class="fail" style="color:red; margin:0 10px;">No Image</span>
                                        <?php endif; ?>
                                        <div class="foodDetails">
                                            <span class="name_closeIcon flex">
                                                <?= $food['food_name'] ?>
                                                <a href="<?= SITEURL ?>deleteCartItem.php?id=<?= $cartID ?>" class="deleteCartItem">
                                                    <i class='bx bx-x icon'></i>
                                                </a>
                                            </span>
                                            <span class="qty_price flex">
                                                <span>Quantity: <?= $qty ?></span>
                                                <span>$<?= $totalCost ?></span>
                                            </span>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                    <!-- Totales y envío del formulario -->
                    <div class="amountDiv">
                        <h3 class="title flex">Order Fees: <img src="./Assests/order.png" alt="Icon"></h3>
                        <span class="cartList flex">
                            <span class="subTitle">Subtotal:</span>
                            <span class="cost">$<?= $subTotal ?></span>
                        </span>
                        <span class="cartList flex">
                            <span class="subTitle">Total:</span>
                            <span class="gradCost">
                                <input type="hidden" name="cartID" value="<?= $cartID ?>">
                                <input type="hidden" name="subTotal" value="<?= $subTotal ?>">
                                $<?= $subTotal ?>
                            </span>
                        </span>
                        <button type="submit" name="submit" class="btn">Order Now</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!-- Check Out Page End -->

<?php include('clientPartials/clientFooter.php'); ?>
