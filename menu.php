<?php 
include('clientPartials/clientHeader.php');

?>
       
    <!-- Menu Top Section -->
   <?php 

   if(isset($_SESSION['addedToCart'])){
    echo $_SESSION['addedToCart'];
    unset($_SESSION['addedToCart']);
   }
   ?>
    <section class="container section menuPage">
        <div class="secContent">
            <div class="sectionIntro">
                <h1 class="secTitle">All Menu</h1>
                <p class="subTitle">Welcome to our chefs' listing.</p>

                <img src="./Assests/titleDesign.png" alt="Design Image">
            </div>
            <div class="optionMenu flex">
                <div class=" option" data-filter="food">
                  <img src="./Assests/diet.png" alt="Best Online food delivery in Nigeria">
                  <small>Foods</small>
                </div>
                <div class=" option" data-filter="drinks">
                  <img src="./Assests/drink.png" alt="Best Online restaurant in Nigeria">
                  <small>Drinks</small>
                </div>
                <div class=" option categoryActive" data-filter="fastfood">
                  <img src="./Assests/pizza.png" alt="Food Image">
                  <small>Fast</small>
                </div>
                <div class=" option" data-filter="cakes">
                  <img src="./Assests/cake.png" alt="Best Online restaurant in Nigeria">
                  <small>Cakes</small>
                </div>
                <div class=" option"  data-filter="dessert">
                  <img src="./Assests/dessert.png" alt="Best Online restaurant in Nigeria">
                  <small>Dessert</small>
                </div>
            </div>

            <div class="allItems">
                <div class="categoryWrapper grid hide" data-target="food">

                    <?php 
                        $sql = "SELECT * FROM food where category = 'localfood'";
                        $res = mysqli_query($conn, $sql);
                        if($res == TRUE){
                            $count = mysqli_num_rows($res);
                            if($count > 0){
                                while($row = mysqli_fetch_assoc($res)){
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
                                                if($img!=""){   
                                                    ?>
                                                    <div class="imgDiv">
                                                        <img src="<?php echo SITEURL;?>databaseImages/foodie<?php echo $img;?>">
                                                    </div>
                                                    <?php
                                                    
                                                }
                                                else{
                                                    echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image 1</span>';
                                                }
                                            ?>

                                            <h2 class="foodTitle">
                                            <?php echo $foodName?>
                                            </h2>

                                            <p>
                                            <?php echo $foodDesc?>
                                            </p>

                                            <h4 class="price flex">
                                                <span>$<?php echo $foodPrice?></span>
                                                <a href="<?php echo SITEURL?>details.php?id=<?php echo $id?>" class="btn flex">View Details <i class="uil uil-shopping-bag icon"></i> </a>

                                            </h4>

                                        </div>

                                    <?php 
                                    
                                }
                            }

                            else{
                                echo '<span class="blank">No local food in the database yet, please add!</span>';
                            }
                        }
                    ?>

                </div>

                <div class="categoryWrapper grid hide" data-target="drinks">

                    <?php 
                        $sql = "SELECT * FROM food where category = 'drinks'";
                        $res = mysqli_query($conn, $sql);
                        if($res == TRUE){
                            $count = mysqli_num_rows($res);
                            if($count > 0){
                                while($row = mysqli_fetch_assoc($res)){
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
                                                if($img!=""){   
                                                    ?>
                                                    <div class="imgDiv">
                                                        <img src="<?php echo SITEURL;?>databaseImages/foodie<?php echo $img;?>">
                                                    </div>
                                                    <?php
                                                    
                                                }
                                                else{
                                                    echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image 1</span>';
                                                }
                                            ?>

                                            <h2 class="foodTitle">
                                            <?php echo $foodName?>
                                            </h2>

                                            <p>
                                            <?php echo $foodDesc?>
                                            </p>

                                            <h4 class="price flex">
                                                <span>$<?php echo $foodPrice?></span>
                                                <a href="<?php echo SITEURL?>details.php?id=<?php echo $id?>" class="btn flex">View Details <i class="uil uil-shopping-bag icon"></i> </a>

                                            </h4>

                                        </div>

                                    <?php 
                                    
                                }
                            }

                            else{
                                echo '<span class="blank">No local food in the database yet, please add!</span>';
                            }
                        }
                    ?>

                </div>

                <div class="categoryWrapper grid" data-target="fastfood">

                    <?php 
                        $sql = "SELECT * FROM food where category = 'fastfood'";
                        $res = mysqli_query($conn, $sql);
                        if($res == TRUE){
                            $count = mysqli_num_rows($res);
                            if($count > 0){
                                while($row = mysqli_fetch_assoc($res)){
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
                                                if($img!=""){   
                                                    ?>
                                                    <div class="imgDiv">
                                                        <img src="<?php echo SITEURL;?>databaseImages/foodie<?php echo $img;?>">
                                                    </div>
                                                    <?php
                                                    
                                                }
                                                else{
                                                    echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image 1</span>';
                                                }
                                            ?>

                                            <h2 class="foodTitle">
                                            <?php echo $foodName?>
                                            </h2>

                                            <p>
                                            <?php echo $foodDesc?>
                                            </p>

                                            <h4 class="price flex">
                                                <span>$<?php echo $foodPrice?></span>
                                                <a href="<?php echo SITEURL?>details.php?id=<?php echo $id?>" class="btn flex">View Details <i class="uil uil-shopping-bag icon"></i> </a>

                                            </h4>

                                        </div>

                                    <?php 
                                    
                                }
                            }

                            else{
                                echo '<span class="blank">No local food in the database yet, please add!</span>';
                            }
                        }
                    ?>

                </div>

                <div class="categoryWrapper grid hide" data-target="cakes">

                    <?php 
                        $sql = "SELECT * FROM food where category = 'cakes'";
                        $res = mysqli_query($conn, $sql);
                        if($res == TRUE){
                            $count = mysqli_num_rows($res);
                            if($count > 0){
                                while($row = mysqli_fetch_assoc($res)){
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
                                                if($img!=""){   
                                                    ?>
                                                    <div class="imgDiv">
                                                        <img src="<?php echo SITEURL;?>databaseImages/foodie<?php echo $img;?>">
                                                    </div>
                                                    <?php
                                                    
                                                }
                                                else{
                                                    echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image 1</span>';
                                                }
                                            ?>

                                            <h2 class="foodTitle">
                                            <?php echo $foodName?>
                                            </h2>

                                            <p>
                                            <?php echo $foodDesc?>
                                            </p>

                                            <h4 class="price flex">
                                                <span>$<?php echo $foodPrice?></span>
                                                <a href="<?php echo SITEURL?>details.php?id=<?php echo $id?>" class="btn flex">View Details <i class="uil uil-shopping-bag icon"></i> </a>

                                            </h4>

                                        </div>

                                    <?php 
                                    
                                }
                            }

                            else{
                                echo '<span class="blank">No local food in the database yet, please add!</span>';
                            }
                        }
                    ?>

                </div>

                <div class="categoryWrapper grid hide" data-target="dessert">

                    <?php 
                        $sql = "SELECT * FROM food where category = 'dessert'";
                        $res = mysqli_query($conn, $sql);
                        if($res == TRUE){
                            $count = mysqli_num_rows($res);
                            if($count > 0){
                                while($row = mysqli_fetch_assoc($res)){
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
                                                if($img!=""){   
                                                    ?>
                                                    <div class="imgDiv">
                                                        <img src="<?php echo SITEURL;?>databaseImages/foodie<?php echo $img;?>">
                                                    </div>
                                                    <?php
                                                    
                                                }
                                                else{
                                                    echo '<span class="fail" style="color:red; margin: 0px 10px;">No Image 1</span>';
                                                }
                                            ?>

                                            <h2 class="foodTitle">
                                            <?php echo $foodName?>
                                            </h2>

                                            <p>
                                            <?php echo $foodDesc?>
                                            </p>

                                            <h4 class="price flex">
                                                <span>$<?php echo $foodPrice?></span>
                                                <a href="<?php echo SITEURL?>details.php?id=<?php echo $id?>" class="btn flex">View Details <i class="uil uil-shopping-bag icon"></i> </a>

                                            </h4>

                                        </div>

                                    <?php 
                                    
                                }
                            }

                            else{
                                echo '<span class="blank">No local food in the database yet, please add!</span>';
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