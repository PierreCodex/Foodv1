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
        <span><strong>Panel</strong> Menu</span>
      </div>

      <?php
      if (isset($_SESSION['addedFood'])) {
        echo $_SESSION['addedFood'];
        unset($_SESSION['addedFood']);
      }

      if (isset($_SESSION['deletedFood'])) {
        echo $_SESSION['deletedFood'];
        unset($_SESSION['deletedFood']);
      }

      if (isset($_SESSION['updatedFood'])) {
        echo $_SESSION['updatedFood'];
        unset($_SESSION['updatedFood']);
      }
      ?>

      <?php
      include('./adminPartials/headerAdminAccount.php');
      ?>
    </div>

    <div class="mainBodyContentContainer">
      <div class="menuContainer grid">
        <?php
        // Obtener todas las categorías desde la base de datos
        $category_sql = "SELECT * FROM categories";
        $category_res = mysqli_query($conn, $category_sql);

        // Verificar si hay categorías
        if ($category_res == TRUE) {
          // Recorrer las categorías
          while ($category_row = mysqli_fetch_assoc($category_res)) {
            $category_name = $category_row['category_name'];
            $category_slug = strtolower(str_replace(' ', '', $category_name));  // Para el filtro de categoría (sin espacios y en minúsculas)
        ?>
            <!-- Mostrar las categorías dinámicamente -->
            <div class="foodCategoryDiv">
              <div class="heading flex">
                <span class=""><?php echo $category_name; ?></span>
                <!-- Solo usa el enlace <a> para redirigir -->
                <a href="addFood.php?category_id=<?php echo $category_row['id']; ?>" class="btn flex">
                  Añadir plato <i class="uil uil-plus icon"></i>
                </a>
              </div>

              <div class="itemsContainer flex">
                <?php
                // Obtener los productos de esta categoría
                $sql = "SELECT * FROM food WHERE category_id = (SELECT id FROM categories WHERE category_name = '$category_name')";
                $res = mysqli_query($conn, $sql);
                if ($res == TRUE) {
                  $count = mysqli_num_rows($res);
                  if ($count > 0) {
                    while ($row = mysqli_fetch_assoc($res)) {
                      $id = $row['id'];
                      $img = $row['image'];
                      $foodName = $row['food_name'];
                      $foodDesc = $row['food_desc'];
                      $foodPrice = $row['price'];
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
                          echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image</span>';
                        }
                        ?>
                        <div class="itemInfo">
                          <span class="itemName"><?php echo $foodName; ?></span>
                          <p class="desc"><?php echo $foodDesc; ?></p>
                          <div class="itemBottom flex">
                            <span class="price">S/.<?php echo $foodPrice; ?></span>
                            <div>
                              <a href="<?php echo SITEURL ?>admin/updateFood.php?id=<?php echo $id ?>"><i class="uil uil-edit icon"></i></a>
                              <a href="<?php echo SITEURL ?>admin/deleteFood.php?id=<?php echo $id ?>"><i class="uil uil-times-circle deleteIcon icon"></i></a>
                            </div>
                          </div>
                        </div>
                      </div>
                <?php
                    }
                  } else {
                    echo '<span class="blank">No se encontraron productos en la categoría ' . $category_name . ', ¡por favor añádelos!</span>';
                  }
                }
                ?>
              </div>
            </div> <!-- End of foodCategoryDiv -->
        <?php
          }
        }
        ?>
      </div>
    </div>
  </div>
</div>


<?php
include('./adminPartials/adminFooter.php');
?>