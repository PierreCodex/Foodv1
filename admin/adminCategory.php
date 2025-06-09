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

            if (isset($_SESSION['updateCategory'])) {
                echo $_SESSION['updateCategory'];
                unset($_SESSION['updateCategory']);
            }
            ?>

            <?php
            include('./adminPartials/headerAdminAccount.php');
            ?>
        </div>

        <div class="mainBodyContentContainer">
            <div class="menuContainer grid">

                <!-- Mostrar las categorías dinámicamente -->
                <div class="foodCategoryDiv">
                    <div class="heading flex">
                        <span class="">Categorias</span>
                    </div>

                    <div class="itemsContainer flex">
                        <?php
                        // Obtener los productos de esta categoría
                        $sql = "SELECT * FROM categories";
                        $res = mysqli_query($conn, $sql);
                        if ($res == TRUE) {
                            $count = mysqli_num_rows($res);
                            if ($count > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $id = $row['id'];
                                    $img = $row['image'];
                                    $category_name = $row['category_name'];

                        ?>
                                    <div class="singleItem">
                                        <?php
                                        if ($img != "") {
                                        ?>
                                            <div class="imgDiv">
                                                <img src="<?php echo SITEURL; ?>databaseCategory/category<?php echo $img; ?>">
                                            </div>
                                        <?php
                                        } else {
                                            echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image</span>';
                                        }
                                        ?>
                                        <div class="itemInfo">
                                            <span class="itemName"><?php echo $category_name; ?></span>

                                            <div class="itemBottom flex">

                                                <div>
                                                    <a href="<?php echo SITEURL ?>admin/updateCategory.php?id=<?php echo $id ?>"><i class="uil uil-edit icon"></i></a>
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

            </div>
        </div>
    </div>
</div>


<?php
include('./adminPartials/adminFooter.php');
?>