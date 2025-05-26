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
                    $category = $row['category'];
                } else {
                    echo '<span class="blank">Something went wrong</span>';
                    exit();
                }
            ?>

            <div class="sectionIntro">
                <h1 class="secTitle">Details Page</h1>
                <p class="subTitle">All about this item.</p>
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
                       <span class="availability">In stock</span>
                       <span class="delivery">Delivery In: 30 Min</span>
                    </div>
                    <div class="composition">
                        <span class="flex"><small>Food Type:</small><small><?php echo htmlspecialchars($category)?></small></span>
                        <span class="flex"><small>Temperature:</small><small>Warm &amp; Fresh</small></span>
                    </div>

                     <?php 
                        if(isset($_SESSION['qtyZero'])){
                            echo $_SESSION['qtyZero'];
                            unset($_SESSION['qtyZero']);
                        }
                     ?>

                     <div class="actionBtn flex">
                          <span class="price flex"><span>$<?php echo number_format($foodPrice,2)?></span></span>

                          <form method="post" class="flex" style="gap: .5rem;">
                            <input type="number" name="qty" value="1" min="1">
                            <input type="hidden" name="foodID" value="<?php echo $id?>">
                            <button class="btn flex" name="submit">
                              Add to cart <i class="uil uil-shopping-bag icon"></i>
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
            <small>Item Added to <strong>Cart</strong>, <br>
            Continue shopping or check-out now!</small>
        <br><br>
        - Thank you! -
        </span>
     </div>';

    header('Location: menu.php');
    exit();
}
?>
