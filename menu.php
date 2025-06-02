<?php
include('clientPartials/clientHeader.php');

?>

<!-- Menu Top Section -->
<?php

if (isset($_SESSION['addedToCart'])) {
    echo $_SESSION['addedToCart'];
    unset($_SESSION['addedToCart']);
}
?>

<!-- Sección principal del menú -->

<section class="container section menuPage">
    <div class="secContent">
        <div class="sectionIntro">
            <h1 class="secTitle">Nuestro Menú</h1>
            <p class="subTitle">Descubre los sabores del mar y más, preparados por nuestros chefs expertos.</p>

            <img src="./Assests/titleDesign.png" alt="Design Image">
        </div>

        <div class="optionMenu flex">
            <!-- Opción para platos a la carta -->
            <div class="option" data-filter="food">
                <img src="./Assests/diet.png" alt="Platos a la carta">
                <small>A la carta</small>
            </div>

            <!-- Opción para bebidas -->
            <div class="option" data-filter="drinks">
                <img src="./Assests/drink.png" alt="Bebidas refrescantes">
                <small>Bebidas</small>
            </div>

            <!-- Opción para mariscos (activo por defecto) -->
            <div class="option categoryActive" data-filter="seafood">
                <img src="./Assests/pizza.png" alt="Deliciosos mariscos">
                <small>Mariscos</small>
            </div>

            <!-- Opción para pescados -->
            <div class="option" data-filter="dishes">
                <img src="./Assests/cake.png" alt="Pescados frescos">
                <small>Pescados</small>
            </div>

            <!-- Opción para carnes -->
            <div class="option" data-filter="meats">
                <img src="./Assests/dessert.png" alt="Carnes a la parrilla">
                <small>Carnes</small>
            </div>

            <!-- Opción para ceviches -->
            <div class="option" data-filter="ceviches">
                <img src="./Assests/dessert.png" alt="Ceviches">
                <small>Ceviches</small>
            </div>
        </div>

        <!-- Contenedor para mostrar los items según categoría -->
        <div class="allItems">
            <div class="categoryWrapper grid hide" data-target="food">

                <?php
                $sql = "SELECT * FROM food where category = 'localfood'";
                $res = mysqli_query($conn, $sql);
                if ($res == TRUE) {
                    $count = mysqli_num_rows($res);
                    if ($count > 0) {

                        // Recorremos los productos encontrados

                        while ($row = mysqli_fetch_assoc($res)) {
                            $id = $row['id'];
                            $img = $row['image'];
                            $foodName = $row['food_name'];
                            $foodDesc = $row['food_desc'];
                            $foodPrice = $row['price'];
                            $category = $row['category'];

                ?>
                            <!-- Item individual -->
                            <div class="singleItem">
                                <div class="rating">
                                    <i class='bx bxs-star icon'></i>
                                    4.5
                                </div>

                                <?php
                                if ($img != "") {
                                ?>
                                    <div class="imgDiv">
                                        <img src="<?php echo SITEURL; ?>databaseImages/foodie<?php echo $img; ?>">
                                    </div>
                                <?php

                                } else {
                                    // Mensaje si no hay imagen
                                    echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image 1</span>';
                                }
                                ?>
                                <!-- Nombre del plato -->
                                <h2 class="foodTitle">
                                    <?php echo $foodName ?>
                                </h2>

                                <p>
                                    <?php echo $foodDesc ?>
                                </p>
                                <!-- Precio y botón para ver detalles -->
                                <h4 class="price flex">
                                    <span>S/.<?php echo $foodPrice ?></span>
                                    <a href="<?php echo SITEURL ?>details.php?id=<?php echo $id ?>" class="btn flex">Ver Mas <i class="uil uil-shopping-bag icon"></i> </a>

                                </h4>

                            </div>

                <?php

                        }
                    } else {
                        echo '<span class="blank">No hay platos a la carta en la base de datos. ¡Por favor agrega!</span>';
                    }
                }
                ?>

            </div>
            <!-- Contenedor para bebidas -->
            <div class="categoryWrapper grid hide" data-target="drinks">

                <?php
                $sql = "SELECT * FROM food where category = 'drinks'";
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
                            $category = $row['category'];

                ?>
                            <!-- SingleItem -->
                            <div class="singleItem">
                                <div class="rating">
                                    <i class='bx bxs-star icon'></i>
                                    4.5
                                </div>

                                <?php
                                if ($img != "") {
                                ?>
                                    <div class="imgDiv">
                                        <img src="<?php echo SITEURL; ?>databaseImages/foodie<?php echo $img; ?>">
                                    </div>
                                <?php

                                } else {
                                    echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image 1</span>';
                                }
                                ?>

                                <h2 class="foodTitle">
                                    <?php echo $foodName ?>
                                </h2>

                                <p>
                                    <?php echo $foodDesc ?>
                                </p>

                                <h4 class="price flex">
                                    <span>S/.<?php echo $foodPrice ?></span>
                                    <a href="<?php echo SITEURL ?>details.php?id=<?php echo $id ?>" class="btn flex">Ver Mas <i class="uil uil-shopping-bag icon"></i> </a>

                                </h4>

                            </div>

                <?php

                        }
                    } else {
                        echo '<span class="blank">No hay bebidas disponibles en la base de datos. ¡Por favor agrega!</span>';
                    }
                }
                ?>

            </div>
            <!-- Contenedor para Mariscos -->
            <div class="categoryWrapper grid" data-target="seafood">

                <?php
                $sql = "SELECT * FROM food where category = 'seafood'";
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
                            $category = $row['category'];

                ?>
                            <!-- SingleItem -->
                            <div class="singleItem">
                                <div class="rating">
                                    <i class='bx bxs-star icon'></i>
                                    4.5
                                </div>

                                <?php
                                if ($img != "") {
                                ?>
                                    <div class="imgDiv">
                                        <img src="<?php echo SITEURL; ?>databaseImages/foodie<?php echo $img; ?>">
                                    </div>
                                <?php

                                } else {
                                    echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image 1</span>';
                                }
                                ?>

                                <h2 class="foodTitle">
                                    <?php echo $foodName ?>
                                </h2>

                                <p>
                                    <?php echo $foodDesc ?>
                                </p>

                                <h4 class="price flex">
                                    <span>S/.<?php echo $foodPrice ?></span>
                                    <a href="<?php echo SITEURL ?>details.php?id=<?php echo $id ?>" class="btn flex">Ver Mas<i class="uil uil-shopping-bag icon"></i> </a>

                                </h4>

                            </div>

                <?php

                        }
                    } else {
                        echo '<span class="blank">No hay mariscos en la base de datos. ¡Por favor agrega!</span>';
                    }
                }
                ?>

            </div>
            <!-- Contenedor para Pescados -->
            <div class="categoryWrapper grid hide" data-target="dishes">

                <?php
                $sql = "SELECT * FROM food where category = 'dishes'";
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
                            $category = $row['category'];

                ?>
                            <!-- SingleItem -->
                            <div class="singleItem">
                                <div class="rating">
                                    <i class='bx bxs-star icon'></i>
                                    4.5
                                </div>

                                <?php
                                if ($img != "") {
                                ?>
                                    <div class="imgDiv">
                                        <img src="<?php echo SITEURL; ?>databaseImages/foodie<?php echo $img; ?>">
                                    </div>
                                <?php

                                } else {
                                    echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image 1</span>';
                                }
                                ?>

                                <h2 class="foodTitle">
                                    <?php echo $foodName ?>
                                </h2>

                                <p>
                                    <?php echo $foodDesc ?>
                                </p>

                                <h4 class="price flex">
                                    <span>S/.<?php echo $foodPrice ?></span>
                                    <a href="<?php echo SITEURL ?>details.php?id=<?php echo $id ?>" class="btn flex">Ver Mas <i class="uil uil-shopping-bag icon"></i> </a>

                                </h4>

                            </div>

                <?php

                        }
                    } else {
                        echo '<span class="blank">No hay pescados frescos en la base de datos. ¡Por favor agrega!</span>';
                    }
                }
                ?>

            </div>
            <!-- Contenedor para Carnes -->
            <div class="categoryWrapper grid hide" data-target="meats">

                <?php
                $sql = "SELECT * FROM food where category = 'meats'";
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
                            $category = $row['category'];

                ?>
                            <!-- SingleItem -->
                            <div class="singleItem">
                                <div class="rating">
                                    <i class='bx bxs-star icon'></i>
                                    4.5
                                </div>

                                <?php
                                if ($img != "") {
                                ?>
                                    <div class="imgDiv">
                                        <img src="<?php echo SITEURL; ?>databaseImages/foodie<?php echo $img; ?>">
                                    </div>
                                <?php

                                } else {
                                    echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image 1</span>';
                                }
                                ?>

                                <h2 class="foodTitle">
                                    <?php echo $foodName ?>
                                </h2>

                                <p>
                                    <?php echo $foodDesc ?>
                                </p>

                                <h4 class="price flex">
                                    <span>$<?php echo $foodPrice ?></span>
                                    <a href="<?php echo SITEURL ?>details.php?id=<?php echo $id ?>" class="btn flex">View Details <i class="uil uil-shopping-bag icon"></i> </a>

                                </h4>

                            </div>

                <?php

                        }
                    } else {
                        echo '<span class="blank">No hay carnes en la base de datos. ¡Por favor agrega!</span>';
                    }
                }
                ?>

            </div>
            <!-- Contenedor para Ceviches -->
            <div class="categoryWrapper grid hide" data-target="ceviches">

                <?php
                $sql = "SELECT * FROM food where category = 'ceviches'";
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
                            $category = $row['category'];

                ?>
                            <!-- SingleItem -->
                            <div class="singleItem">
                                <div class="rating">
                                    <i class='bx bxs-star icon'></i>
                                    4.5
                                </div>

                                <?php
                                if ($img != "") {
                                ?>
                                    <div class="imgDiv">
                                        <img src="<?php echo SITEURL; ?>databaseImages/foodie<?php echo $img; ?>">
                                    </div>
                                <?php

                                } else {
                                    echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image 1</span>';
                                }
                                ?>

                                <h2 class="foodTitle">
                                    <?php echo $foodName ?>
                                </h2>

                                <p>
                                    <?php echo $foodDesc ?>
                                </p>

                                <h4 class="price flex">
                                    <span>$<?php echo $foodPrice ?></span>
                                    <a href="<?php echo SITEURL ?>details.php?id=<?php echo $id ?>" class="btn flex">View Details <i class="uil uil-shopping-bag icon"></i> </a>

                                </h4>

                            </div>

                <?php

                        }
                    } else {
                        echo '<span class="blank">No hay ceviches en la base de datos. ¡Por favor agrega!</span>';
                    }
                }
                ?>

            </div>
        </div>
    </div>
</section>
<!-- Menu Top Section Ends -->

<?php
include('clientPartials/clientFooter.php');
?>