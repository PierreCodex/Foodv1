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
                <span><strong>Add Food</strong> Item</span>

                <?php 
                // Verificar si category_id está presente en la URL
                if (isset($_GET['category_id'])) {
                    $category_id = $_GET['category_id'];

                    // Obtener el nombre de la categoría usando el category_id
                    $category_sql = "SELECT category_name FROM categories WHERE id = $category_id";
                    $category_res = mysqli_query($conn, $category_sql);

                    if ($category_res == TRUE) {
                        $category_row = mysqli_fetch_assoc($category_res);
                        $category_name = $category_row['category_name'];
                    }
                }
                ?>
                <!-- Mostrar el nombre de la categoría seleccionada -->
                <p><strong>Category: </strong><?php echo $category_name; ?></p>
            </div>

            <?php 
                include('./adminPartials/headerAdminAccount.php');
            ?> 
        </div>

        <div class="mainBodyContentContainer">
            <div class="settingsPage updateSettings">
                <div class="heading flex">
                    <span>Fill the form below</span>
                    <?php 
                        if (isset($_SESSION['addedFood'])) {
                            echo $_SESSION['addedFood'];
                            unset($_SESSION['addedFood']);
                        }
                    ?>
                    <button class="btn">
                        <a href="adminMenu.php" class="flex">All Food <i class="uil uil-arrow-right icon"></i></a>
                    </button>
                </div>

                <div class="informationContainer flex">
                    <form method="post" enctype="multipart/form-data" class="flex">
                        <div class="grid">
                            <span class="flex span">
                                <label for="name">Item Name</label>
                                <input type="text" name="itemName" placeholder="Item Name" required>
                            </span>
                            <span class="flex span">
                                <label for="Username">Description</label>
                                <textarea name="desc" placeholder="Describe the item" required></textarea>
                            </span>
                            <span class="flex span">
                                <label for="nationality">Price</label>
                                <input type="number" name="price" placeholder="Item price" step="0.01" min="0" required>
                            </span>
                        </div>

                        <div class="grid">
                            <span class="flex span">
                                <label for="Picture">Food Image</label>
                                <input type="file" name="itemImage" required>
                            </span>

                            <!-- Oculto la categoría seleccionada -->
                            <input type="hidden" name="category" value="<?php echo $category_id; ?>" />

                            <!-- Combo box para seleccionar el estado -->
                            <span class="flex span">
                                <label for="status">Product Status</label>
                                <select name="status" required>
                                    <option value="1">En stock</option> <!-- 1 para "En stock" -->
                                    <option value="0">Agotado</option> <!-- 0 para "Agotado" -->
                                </select>
                            </span>

                            <button class="btn bg" name="submit">Add Item</button>
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

    $foodName = $_POST['itemName'];
    $foodDesc = $_POST['desc'];
    $foodPrice = $_POST['price'];
    $status = $_POST['status']; // 1 para "En stock", 0 para "Agotado"
    $category = $_POST['category'];  // Aquí obtienes la categoría seleccionada

    // Subida de imagen =====================>
    if (isset($_FILES['itemImage']['name'])) {
        $image = $_FILES['itemImage']['name'];
        // Fuente de la imagen
        $imageSource = $_FILES['itemImage']['tmp_name'];
        // Destino de la imagen
        $imageDestination = "../databaseImages/foodie" . $image;
        // Subir la imagen
        $uploadImage = move_uploaded_file($imageSource, $imageDestination);

        if ($uploadImage == false) {
            $_SESSION['imgUpload']  = '<span class="fail">Failed to upload image!</span>';
        }
    } else {
        $image = "";
    }

    // Consulta SQL para insertar el nuevo alimento
    $sql = "INSERT INTO food SET
        food_name = '$foodName',
        image = '$image',
        food_desc = '$foodDesc',
        price = '$foodPrice',
        category_id = '$category',
        status = '$status'";  // Usamos `status` para el estado (1 para "En stock", 0 para "Agotado")

    $result = mysqli_query($conn, $sql);

    if ($result == TRUE) {
        $_SESSION['addedFood'] = '<span class="success">Item Added Successfully, add more?</span>';
        // Redirigir y mantener el `category_id` en la URL
        header('location:' . SITEURL . 'admin/addFood.php?category_id=' . $category);
        exit();
    } else {
        die('Failed to connect to database!');
    }
}
?>
