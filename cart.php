<?php 
include('./clientPartials/clientHeader.php');
// clientHeader.php arranca sesión y te da $conn

// 0) Si el usuario está logueado, migrar los ítems de esta sesión a su user_id
if (!empty($_SESSION['user_id'])) {
    $session_id = session_id();
    $user_id    = $_SESSION['user_id'];

    $stmtM = mysqli_prepare($conn, "
        UPDATE cart
           SET user_id = ?
         WHERE session_id = ?
    ");
    mysqli_stmt_bind_param($stmtM, "is", $user_id, $session_id);
    mysqli_stmt_execute($stmtM);
}
?>

<!-- Cart Section -->
<section class="section container cart">
  <div class="secTitle">
    <h2 class="title flex">
      Cart <img src="./Assests/cart.png" alt="Icon">
    </h2>
  </div>

  <div class="secContent">
    <div class="gridDiv grid">

      <div class="cartDiv grid">
        <?php 
        // Saludo personalizado
        if (!empty($_SESSION['user_id'])) {
            $uid  = $_SESSION['user_id'];
            $stmt = mysqli_prepare($conn, "SELECT name FROM users WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "i", $uid);
            mysqli_stmt_execute($stmt);
            $res  = mysqli_stmt_get_result($stmt);
            $row  = mysqli_fetch_assoc($res);
            $greeting = htmlspecialchars($row['name']);
        } else {
            $greeting = "Customer";
        }
        ?>
        <h3 class="title">
          Estimada <span style="text-transform: capitalize;"><?php echo $greeting; ?></span>, estos son los detalles de tu carrito:
        </h3>

        <?php 
        if (isset($_SESSION['deletedCartItem'])) {
            echo $_SESSION['deletedCartItem'];
            unset($_SESSION['deletedCartItem']);
        }
        ?>

        <?php 
        // 1) Preparar identificadores
        $session_id = session_id();
        $user_id    = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

        // 2) Cargar items del carrito (invitado o usuario)
        $sql = "
          SELECT id, food_id, qty, total_cost 
            FROM cart 
           WHERE session_id = ? 
              OR user_id = ?
        ";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $session_id, $user_id);
        mysqli_stmt_execute($stmt);
        $res_cart = mysqli_stmt_get_result($stmt);

        $subTotal = 0;
        if ($res_cart && mysqli_num_rows($res_cart) > 0) {
          while ($c = mysqli_fetch_assoc($res_cart)) {
            $cartID    = $c['id'];
            $foodID    = $c['food_id'];
            $qty       = $c['qty'];
            $totalCost = $c['total_cost'];
            $subTotal += $totalCost;

            // 3) Obtener datos del producto
            $stmt2 = mysqli_prepare($conn, "SELECT image, food_name FROM food WHERE id = ?");
            mysqli_stmt_bind_param($stmt2, "i", $foodID);
            mysqli_stmt_execute($stmt2);
            $res2 = mysqli_stmt_get_result($stmt2);
            $food = mysqli_fetch_assoc($res2);
            ?>
            <div class="singleCart flex">
              <?php if (!empty($food['image'])): ?>
                <img src="<?php echo SITEURL; ?>databaseImages/foodie<?php echo htmlspecialchars($food['image']); ?>" alt="">
              <?php else: ?>
                <span class="fail" style="color:red; margin:0 10px;">No Image</span>
              <?php endif; ?>

              <div class="foodDetails">
                <span class="name_closeIcon flex">
                  <?php echo htmlspecialchars($food['food_name']); ?>
                  <a href="<?php echo SITEURL; ?>deleteCartItem.php?id=<?php echo $cartID; ?>" class="deleteCartItem">
                    <i class='bx bx-x icon'></i>
                  </a>
                </span>
                <span class="qty_price flex">
                  <span>Cantidad: <?php echo $qty; ?></span>
                  <span>S/.<?php echo $totalCost; ?></span>
                </span>
              </div>
            </div>
            <?php
          }
        } else {
          echo '<span class="blank">Todavía no hay ningún artículo en el carrito.</span>';
        }
        ?>
      </div>

      <div class="amountDiv">
        <h3 class="title flex">
          Detalle de  Compra: <img src="./Assests/order.png" alt="Icon">
        </h3>
        <span class="cartList flex">
          <span class="subTitle">Subtotal:</span>
          <span class="cost">S/.<?php echo number_format($subTotal, 2); ?></span>
        </span>
        <span class="cartList flex">
          <span class="subTitle">Total:</span>
          <span class="gradCost">S/.<?php echo number_format($subTotal, 2); ?></span>
        </span>

        <a href="menu.php" class="btn shopping">Continuar comprando</a>

        <?php if ($subTotal > 0): ?>
          <?php if (!empty($_SESSION['user_id'])): ?>
            <!-- Usuario logueado → checkout -->
            <a href="checkout.php" class="btn">Ordenar</a>
          <?php else: ?>
            <?php 
              // Guardar ruta para volver tras login
              $_SESSION['after_login_redirect'] = 'checkout.php';
              $_SESSION['loginMessage'] = '<span class="fail">Por favor, inicia sesión para finalizar tu pedido.</span>';
            ?>
            <!-- Invitado → primero login -->
            <a href="login.php" class="btn">Check Out</a>
          <?php endif; ?>
        <?php else: ?>
          <script>alert("Su carrito está vacía")</script>
        <?php endif; ?>
      </div>

    </div>
  </div>
</section>
<!-- Cart Section End -->

<?php include('./clientPartials/clientFooter.php'); ?>
