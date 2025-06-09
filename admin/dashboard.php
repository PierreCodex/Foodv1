<?php
include('./adminPartials/adminHeader.php');

?>

<div class="adminPage flex">
  <?php
  include('./adminPartials/sideMenu.php');
  ?>

  <div class="mainBody">
    <div class="topSection flex">
      <div class="title">
        <span><strong>Bienvenido </strong><?php echo htmlspecialchars($_SESSION['name'] ?? 'Admin'); ?></span>
      </div>

      <?php
      include('./adminPartials/headerAdminAccount.php');
      ?>
    </div>

    <div class="mainBodyContentContainer">

      <?php
      // Get the values from the database=========>
      $sql = "SELECT * FROM orders";
      $res = mysqli_query($conn, $sql);
      if ($res == TRUE) {
        $count = mysqli_num_rows($res);
      }
      ?>

      <?php
      // Get the values from the database=========>
      $sql = "SELECT * FROM orders WHERE order_status = 'delivered'";
      $res = mysqli_query($conn, $sql);
      $totalIncome = 0;
      if ($res == TRUE) {
        $deliveredItems = mysqli_num_rows($res);
        if ($deliveredItems > 0) {
          while ($eachRow = mysqli_fetch_assoc($res)) {
            $id = $eachRow['id'];
            $eachItemTotalCost = $eachRow['total_cost'];
            $totalIncome += $eachItemTotalCost;
          }
        }
      }
      ?>
      <?php
      // Get the values from the database=========>
      $sql = "SELECT * FROM tablereservations WHERE status = 'closed'";
      $res = mysqli_query($conn, $sql);
      $expensesRevenue = 0;
      if ($res == TRUE) {
        $closedReservations = mysqli_num_rows($res);
        if ($closedReservations > 0) {
          while ($eachRow = mysqli_fetch_assoc($res)) {
            $id = $eachRow['id'];
            $eachExpense = $eachRow['expenses'];
            $expensesRevenue += $eachExpense;
          }
        }
      }
      // Calculate total revenue
      $revenue =  $expensesRevenue + $totalIncome;

      ?>
      <div class="summarySection grid">
        <div class="summaryCard">
          <span class="flex">
            <img src="../Assests/cart.png" alt="">
            <span class="cardTitle">
              Pedidos Totales
            </span>
          </span>
          <h1 class="count">
            <?php echo $count ?>
          </h1>

          <span class="overlayText"><?php echo $count ?></span>
        </div>

        <div class="summaryCard">
          <span class="flex">
            <img src="../Assests/clock.png" alt="">
            <span class="cardTitle">
              Pedidos entregados
            </span>
          </span>
          <h1 class="count">
            <?php echo $deliveredItems ?>
          </h1>

          <span class="overlayText"><?php echo $deliveredItems ?></span>
        </div>

        <div class="summaryCard">
          <span class="flex">
            <img src="../Assests/rating.png" alt="">
            <span class="cardTitle">
              Table Bookings
            </span>
          </span>
          <h1 class="count">
            8
          </h1>

          <span class="overlayText">8</span>
        </div>

        <div class="summaryCard incomeCard">
          <span class="flex">
            <img src="../Assests/customer.png" alt="">
            <span class="cardTitle">
              Total Ingresos
            </span>
          </span>
          <h1 class="count">
            S/.<?php echo $revenue ?>
          </h1>

          <span class="overlayText"><?php echo $totalIncome ?></span>
        </div>
      </div>
      <!-- CATEGORIA DE PLATOS -->
<!-- CATEGORIA DE PLATOS -->
        <div class="categoriesSection">
            <div class="secHeader flex">
                <div class="subTitle">
                    <h3><strong>Food</strong> Categorias</h3>
                </div>
                <div class="btn">
                    <a href="adminMenu.php">
                      Ver todos <i class="uil uil-angle-right icon"></i>
                    </a>
                </div>
            </div>

            <div class="optionMenu flex">
                <?php
                // Obtener las categorías desde la base de datos
                $category_sql = "SELECT * FROM categories";
                $category_res = mysqli_query($conn, $category_sql);

                // Verificar si hay categorías
                if ($category_res == TRUE) {
                    while ($category_row = mysqli_fetch_assoc($category_res)) {
                        $category_name = $category_row['category_name'];
                        $category_slug = strtolower(str_replace(' ', '', $category_name));  // Filtro de categoría en minúsculas y sin espacios
                         $category_image = $category_row['image']; // Obtener la imagen de la categoría desde la base de datos
                    $category_image_path = SITEURL . "databaseCategory/category" . $category_image; // Ruta de la imagen de la categoría
                ?>
                    <!-- Opción para cada categoría -->
                    <div class="option" data-filter="<?php echo $category_slug; ?>">
                        <img src="<?php echo $category_image_path; ?>" alt="<?php echo $category_name; ?>">
                        <small><?php echo $category_name; ?></small>
                    </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>

      <div class="mostOrdered">
        <div class="secHeader flex">
          <div class="subTitle">
            <h3><strong>Ranking</strong> Pedidos</h3>
          </div>
        </div>

        <div class="flex popularItemsContainer">
          <?php
          $sql = "SELECT * FROM food order by RAND() LIMIT 0,4 ";
          $res = mysqli_query($conn, $sql);
          if ($res == true) {
            $count = mysqli_num_rows($res);
            if ($count > 0) {
              while ($row = mysqli_fetch_assoc($res)) {
                $id = $row['id'];
                $img = $row['image'];
                $foodName = $row['food_name'];
                $foodDesc = $row['food_desc'];

          ?>
                <div class="singleItem">
                  <?php

                  if ($img != "") {
                  ?>
                    <div class="imgDiv">
                      <img src="<?php echo SITEURL; ?>databaseImages/foodie<?php echo $img; ?>">
                    </div>

                  <?php
                  } else {
                    echo '<span class="fail" style="color:red; margin: 0px 10px;">No Food Image</span>';
                  }

                  ?>

                  <div class="itemInfo">
                    <span class="itemName"><?php echo $foodName ?></span>
                    <p class="desc"><?php echo $foodDesc ?></p>
                  </div>
                </div>
          <?php
              }
            }
          }
          ?>
        </div>

      </div>
    </div>


  </div>
</div>

<?php
include('./adminPartials/adminFooter.php');
?>