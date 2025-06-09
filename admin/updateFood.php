<?php 
include('./adminPartials/adminHeader.php');
ob_start();
?>

<div class="adminPage flex">
    <?php 
    include('./adminPartials/sideMenu.php');
    ?>

    <div class="mainBody">
        <div class="topSection flex">
            <div class="title">
                <span><strong>Edit Food</strong> Item</span>
            </div>

            <?php 
                include('./adminPartials/headerAdminAccount.php');
            ?> 
        </div>

        <div class="mainBodyContentContainer">
            <div class="settingsPage updateSettings">
                <div class="heading flex">
                    <span>Fill the form below</span>
                    <button class="btn">
                        <a href="menu.php" class="flex">All Food <i class="uil uil-arrow-right icon"></i></a>
                    </button>
                </div>

                <div class="informationContainer flex">

                <?php 
                    // Obtener los valores desde la base de datos=========>
                    $singleFoodID = $_GET['id']; // Obtener el ID del alimento a editar
                    $sql = "SELECT * FROM food WHERE id = $singleFoodID";
                    $res = mysqli_query($conn, $sql);
                    if ($res == TRUE) {
                        $count = mysqli_num_rows($res);
                        if ($count == 1) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $id = $row['id'];
                                $foodName = $row['food_name'];
                                $foodDesc = $row['food_desc'];
                                $category_id = $row['category_id']; // Cambié `category` a `category_id`
                                $price = $row['price'];
                                $foodImage = $row['image'];
                                $status = $row['status']; // Obtener el estado (En stock o Agotado)
                            }
                        }
                    } else {
                        header('location:' . SITEURL . 'admin/adminMenu.php');
                        exit();
                    }
                ?>
                    <form method="post" enctype="multipart/form-data" class="flex">
                        <div class="grid">
                            <span class="flex span">
                                <label for="name">Item Name</label>
                                <input type="text" name="foodName" value="<?php echo $foodName ?>" required>
                            </span>
                            <span class="flex span">
                                <label for="Username">Description</label>
                                <textarea name="desc" required><?php echo $foodDesc ?></textarea>
                            </span>
                            <span class="flex span">
                                <label for="price">Price</label>
                                <input type="number" name="price" value="<?php echo $price ?>" step="0.01" min="0" required>
                            </span>
                        </div>

                        <div class="grid">
                            <span class="flex span">
                                <label for="Picture">Food Image</label>
                                <input type="file" name="foodImage">
                                <?php if ($foodImage != ""): ?>
                                    <img src="<?php echo SITEURL; ?>databaseImages/foodie<?php echo $foodImage; ?>" width="100" />
                                <?php endif; ?>
                            </span>

                            <span class="flex span">
                                <label for="category">Food Category</label>
                                <select name="category" required>
                                    <?php
                                    // Obtener categorías desde la base de datos
                                    $category_sql = "SELECT * FROM categories";
                                    $category_res = mysqli_query($conn, $category_sql);
                                    if ($category_res == TRUE) {
                                        while ($category_row = mysqli_fetch_assoc($category_res)) {
                                            $category_id_selected = $category_row['id'];
                                            $category_name = $category_row['category_name'];
                                            // Marcar la categoría actual como seleccionada
                                            $selected = ($category_id == $category_id_selected) ? 'selected' : '';
                                            echo "<option value='$category_id_selected' $selected>$category_name</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </span>

                            <!-- Combo box para seleccionar el estado (En stock o Agotado) -->
                            <span class="flex span">
                                <label for="status">Product Status</label>
                                <select name="status" required>
                                    <option value="1" <?php echo ($status == 1) ? 'selected' : ''; ?>>En stock</option>
                                    <option value="0" <?php echo ($status == 0) ? 'selected' : ''; ?>>Agotado</option>
                                </select>
                            </span>

                            <button class="btn bg" name="submit">Update Food</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<?php 
include('./adminPartials/adminFooter.php');
?>

<?php 
if (isset($_POST['submit'])) {

    $foodName = $_POST['foodName'];
    $foodDesc = $_POST['desc'];
    $foodPrice = $_POST['price'];
    $category = $_POST['category'];  // Aquí obtienes el `category_id`
    $status = $_POST['status'];  // El estado (En stock o Agotado)

    // Subida de imagen =====================>
    if (isset($_FILES['foodImage']['name']) && $_FILES['foodImage']['name'] != "") {
        $image = $_FILES['foodImage']['name'];
        // Fuente de la imagen
        $imageSource = $_FILES['foodImage']['tmp_name'];
        // Destino de la imagen
        $imageDestination = "../databaseImages/foodie" . $image;
        // Subir la imagen
        $uploadImage = move_uploaded_file($imageSource, $imageDestination);

        if ($uploadImage == false) {
            $_SESSION['imgUpload']  = '<span class="fail">Failed to upload image!</span>';
        }
    } else {
        // Si no se sube una nueva imagen, mantenemos la imagen existente
        $image = $foodImage;
    }

    // Consulta SQL para actualizar el alimento
    $sql = "UPDATE food SET
        food_name = '$foodName',
        image = '$image',
        food_desc = '$foodDesc',
        price = '$foodPrice',
        category_id = '$category',
        status = '$status'  -- Corregido la sintaxis del SQL: eliminada coma extra
        WHERE id = $singleFoodID";

    $result = mysqli_query($conn, $sql);

    if ($result == TRUE) {
        $_SESSION['updatedFood'] = '<span class="success">Food Details Updated Successfully!</span>';
        header('location:' . SITEURL . 'admin/adminMenu.php');
        exit();
    } else {
        die('Failed to connect to database!');
    }
}
?>
