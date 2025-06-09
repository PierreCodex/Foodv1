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
            <?php
            // Obtener todas las categorías desde la tabla `categories`
            $category_sql = "SELECT * FROM categories";
            $category_res = mysqli_query($conn, $category_sql);

            // Verificar si hay categorías disponibles
            if ($category_res == TRUE) {
                while ($category_row = mysqli_fetch_assoc($category_res)) {
                    $category_name = $category_row['category_name'];
                    $category_slug = strtolower(str_replace(' ', '', $category_name));  // Para el filtro de categoría (sin espacios y en minúsculas)
                    $category_image = $category_row['image']; // Obtener la imagen de la categoría desde la base de datos
                    $category_image_path = SITEURL . "databaseCategory/category" . $category_image; // Ruta de la imagen de la categoría
            ?>
                    <!-- Opción para cada categoría -->
                    <div class="option <?php echo ($category_slug == 'seafood') ? 'categoryActive' : ''; ?>" data-filter="<?php echo $category_slug; ?>" onclick="loadCategory('<?php echo $category_slug; ?>')">
                        <div class="imgDiv">
                            <img src="<?php echo $category_image_path; ?>" alt="<?php echo $category_name; ?>">
                        </div>
                        <small><?php echo $category_name; ?></small>
                    </div>
            <?php
                }
            }
            ?>
        </div>

        <!-- Contenedor para mostrar los items según categoría -->
        <div class="allItems">
            <?php
            // Obtener todas las categorías desde la tabla `categories` para los contenedores
            mysqli_data_seek($category_res, 0);  // Restablecer el puntero del resultado para volver a recorrer las categorías

            // Recorremos cada categoría y generamos los contenedores de alimentos
            if ($category_res == TRUE) {
                while ($category_row = mysqli_fetch_assoc($category_res)) {
                    $category_name = $category_row['category_name'];
                    $category_id = $category_row['id'];
                    $category_slug = strtolower(str_replace(' ', '', $category_name));  // Para la clase del contenedor

                    // Obtener los productos de esta categoría
                    $food_sql = "SELECT * FROM food WHERE category_id = $category_id";
                    $food_res = mysqli_query($conn, $food_sql);

                    // Verificar si hay productos para esta categoría
                    if ($food_res == TRUE) {
                        $count = mysqli_num_rows($food_res);
                        if ($count > 0) {
            ?>
                            <!-- Contenedor de categoría -->
                            <div class="categoryWrapper grid hide" data-target="<?php echo $category_slug; ?>" id="category-<?php echo $category_slug; ?>">

                                <?php
                                // Recorremos los productos de esta categoría
                                while ($row = mysqli_fetch_assoc($food_res)) {
                                    $id = $row['id'];
                                    $img = $row['image'];
                                    $foodName = $row['food_name'];
                                    $foodDesc = $row['food_desc'];
                                    $foodPrice = $row['price'];
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
                                            echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image</span>';
                                        }
                                        ?>

                                        <h2 class="foodTitle"><?php echo $foodName ?></h2>
                                        <p><?php echo $foodDesc ?></p>
                                        <h4 class="price flex">
                                            <span>S/.<?php echo $foodPrice ?></span>
                                            <a href="<?php echo SITEURL ?>details.php?id=<?php echo $id ?>" class="btn flex">Ver Más <i class="uil uil-shopping-bag icon"></i> </a>
                                        </h4>
                                    </div>

                                <?php
                                }
                                ?>

                            </div> <!-- End of categoryWrapper -->
                        <?php
                        } else {
                            // Solo se mostrará el mensaje cuando la categoría haya sido seleccionada
                        ?>
                            <div class="categoryWrapper grid hide" data-target="<?php echo $category_slug; ?>" id="category-<?php echo $category_slug; ?>">
                                <span class="blank">No hay productos en la categoría <?php echo $category_name; ?>. ¡Por favor agrega!</span>
                            </div>
            <?php
                        }
                    }
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- JavaScript para manejar la carga de categorías -->
<script>
    function loadCategory(categorySlug) {
        // Ocultar todas las categorías
        const allCategories = document.querySelectorAll('.categoryWrapper');
        allCategories.forEach(category => category.classList.add('hide'));

        // Mostrar la categoría seleccionada
        const selectedCategory = document.getElementById('category-' + categorySlug);
        selectedCategory.classList.remove('hide');

        // Mostrar mensaje de "No productos" si la categoría está vacía
        const messageDiv = selectedCategory.querySelector('.blank');
        if (messageDiv && messageDiv.innerText.includes('No hay productos')) {
            messageDiv.style.display = 'block';
        } else {
            messageDiv.style.display = 'none';
        }
    }
</script>


<!-- Menu Top Section Ends -->

<?php
include('clientPartials/clientFooter.php');
?>