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
                <span><strong>Editar</strong> Categoria</span>
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
                    $sql = "SELECT * FROM categories WHERE id = $singleFoodID";
                    $res = mysqli_query($conn, $sql);
                    if ($res == TRUE) {
                        $count = mysqli_num_rows($res);
                        if ($count == 1) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $id = $row['id'];
                                $category_name = $row['category_name'];
                                $categoryimage = $row['image'];
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
                                <label for="name">Categoria</label>
                                <input type="text" name="category_name" value="<?php echo $category_name ?>" required>
                            </span>
                        </div>

                        <div class="grid">
                            <span class="flex span">
                                <label for="Picture">Food Image</label>
                                <input type="file" name="categoryimage">
                                <?php if ($categoryimage != ""): ?>
                                    <img src="<?php echo SITEURL; ?>databaseCategory/category<?php echo $categoryimage; ?>" width="10" />
                                <?php endif; ?>
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

    $category_name = $_POST['category_name'];

    // Subida de imagen =====================>
    if (isset($_FILES['categoryimage']['name']) && $_FILES['categoryimage']['name'] != "") {
        $image = $_FILES['categoryimage']['name'];
        // Fuente de la imagen
        $imageSource = $_FILES['categoryimage']['tmp_name'];
        // Destino de la imagen
        $imageDestination = "../databaseCategory/category" . $image;
        // Subir la imagen
        $uploadImage = move_uploaded_file($imageSource, $imageDestination);

        if ($uploadImage == false) {
            $_SESSION['imgUpload']  = '<span class="fail">Failed to upload image!</span>';
        }
    } else {
        // Si no se sube una nueva imagen, mantenemos la imagen existente
        $image = $categoryimage;
    }

    // Consulta SQL para actualizar el alimento
    $sql = "UPDATE categories SET
    image = '$image',
        category_name = '$category_name'
        
        WHERE id = $singleFoodID";

    $result = mysqli_query($conn, $sql);

    if ($result == TRUE) {
        $_SESSION['updateCategory'] = '<span class="success">¡Categoria actualizados con éxito!</span>';
        header('location:' . SITEURL . 'admin/adminCategory.php');
        exit();
    } else {
        die('Failed to connect to database!');
    }
}
?>