<?php 
include('clientPartials/clientHeader.php');
ob_start();
?>

<!-- Details Section -->
<section class="details container section">
    <div class="secContent">

        <?php 
            $foodMenuId = intval($_GET['id']);
            $sql = "SELECT * FROM food WHERE id = ?";
            $stmtF = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmtF, "i", $foodMenuId);
            mysqli_stmt_execute($stmtF);
            $resF = mysqli_stmt_get_result($stmtF);
            if ($resF && mysqli_num_rows($resF) === 1) {
                $row = mysqli_fetch_assoc($resF);
                $id = $row['id'];
                $img = $row['image'];
                $foodName = $row['food_name'];
                $foodDesc = $row['food_desc'];
                $foodPrice = $row['price'];
                $category_id = $row['category_id']; // Obtener category_id
                $status = $row['status']; // Obtener la cantidad de stock
            } else {
                echo '<span class="blank">Algo salió mal</span>';
                exit();
            }

            // Obtener el nombre de la categoría usando el category_id
            $category_sql = "SELECT category_name FROM categories WHERE id = ?";
            $stmtCategory = mysqli_prepare($conn, $category_sql);
            mysqli_stmt_bind_param($stmtCategory, "i", $category_id);
            mysqli_stmt_execute($stmtCategory);
            $resCategory = mysqli_stmt_get_result($stmtCategory);
            if ($resCategory && mysqli_num_rows($resCategory) === 1) {
                $category_row = mysqli_fetch_assoc($resCategory);
                $category_name = $category_row['category_name'];
            } else {
                $category_name = 'Unknown Category';
            }

            // Determinar la disponibilidad
            if ($status > 0) {
                $availability = 'En stock';
            } else {
                $availability = 'Agotado';
            }
        ?>

        <div class="sectionIntro">
            <h1 class="secTitle">Detalle del Plato</h1>
            <p class="subTitle">Toda la información sobre este delicioso platillo.</p>
            <img src="./Assests/titleDesign.png" alt="Design Image">
        </div>

        <div class="mainContent grid">
            <div class="imgDiv_InfoDiv grid">
                <?php if ($img !== ""): ?>
                    <div class="imgDiv">
                        <img src="<?php echo SITEURL;?>databaseImages/foodie<?php echo htmlspecialchars($img);?>">
                    </div>
                <?php else: ?>
                    <span class="fail" style="color:red; margin: 0px 10px;">No Image</span>
                <?php endif; ?>

                <div class="itemInfo">
                    <h2 class="itemTitle"><?php echo htmlspecialchars($foodName)?></h2>
                    <div class="status flex">
                        <span class="availability"><?php echo $availability; ?></span>
                        <span class="delivery">Entrega en: 30 Min</span>
                    </div>
                    <div class="composition">
                        <span class="flex"><small>Tipo de Comida:</small><small><?php echo htmlspecialchars($category_name)?></small></span>
                        <span class="flex"><small>Temperature:</small><small>Warm &amp; Fresh</small></span>
                    </div>

                    <?php 
                        if(isset($_SESSION['qtyZero'])){
                            echo $_SESSION['qtyZero'];
                            unset($_SESSION['qtyZero']);
                        }
                    ?>

                    <div class="actionBtn flex">
                        <span class="price flex"><span>S/.<?php echo number_format($foodPrice,2)?></span></span>

                        <form method="post" class="flex" style="gap: .5rem;">
                            <input type="number" name="qty" value="1" min="1">
                            <input type="hidden" name="foodID" value="<?php echo $id?>">
                            <button class="btn flex" name="submit">
                                Añadir al carrito <i class="uil uil-shopping-bag icon"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ... resto de detail.php ... -->
        </div>
    </div>
</section>
<!-- Details Section Ends -->

<?php 
include('clientPartials/clientFooter.php');
?>

<?php 
if (isset($_POST['submit'])) {
    $qty       = intval($_POST['qty']);
    $foodID    = intval($_POST['foodID']);
    $sessionID = session_id();

    if ($qty <= 0) {
        $_SESSION['qtyZero'] = '<span class="fail" style="color:red;">Item Quantity Cannot be Zero</span>';
        header("Location: detail.php?id={$foodID}");
        exit();
    }

    // Obtener precio actual
    $stmtP = mysqli_prepare($conn, "SELECT price FROM food WHERE id = ?");
    mysqli_stmt_bind_param($stmtP, "i", $foodID);
    mysqli_stmt_execute($stmtP);
    $resP = mysqli_stmt_get_result($stmtP);
    $rowP = mysqli_fetch_assoc($resP);
    $price = floatval($rowP['price']);
    $totalPrice = $price * $qty;

    // Determinar user_id (NULL si no hay sesión)
    $user_id = !empty($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Insertar en cart incluyendo user_id
    $sql = "
      INSERT INTO cart
        (food_id, session_id, qty, total_cost, user_id)
      VALUES
        (?, ?, ?, ?, ?)
    ";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param(
        $stmt,
        "isidi",        // i:food_id, s:session_id, i:qty, d:total_cost, i:user_id
        $foodID,
        $sessionID,
        $qty,
        $totalPrice,
        $user_id
    );
    mysqli_stmt_execute($stmt);

    $_SESSION['addedToCart'] = '
     <div class="messageConatainer flex">
        <span class="messageCard">
            <img src="./Assests/shopping-cart.png" class="checkIcon">
            <small>Artículo añadido al<strong>Carrito</strong>, <br>
            Siga comprando o realice la orden.</small>
        <br><br>
        - Gracias! -
        </span>
     </div>';

    header('Location: menu.php');
    exit();
}
?>
