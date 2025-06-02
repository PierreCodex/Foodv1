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
                  if(isset($_SESSION['addedFood'])){
                    echo $_SESSION['addedFood'];
                    unset ($_SESSION['addedFood']);
                  }
                  
                  if(isset($_SESSION['deletedFood'])){
                    echo $_SESSION['deletedFood'];
                    unset ($_SESSION['deletedFood']);
                  }

                  if(isset($_SESSION['updatedFood'])){
                    echo $_SESSION['updatedFood'];
                    unset ($_SESSION['updatedFood']);
                  }
                ?>

                <?php 
                    include('./adminPartials/headerAdminAccount.php');
                ?> 
            </div>

            <div class="mainBodyContentContainer">  
              <div class="menuContainer grid">
                <!-- Food Category -->
                <div class="foodCategoryDiv">
                    <div class="heading flex">
                        <span class="">Platos a  la carta</span>
                        <button class="btn">
                            <a href="addFood.php" class="flex">Add Food <i class="uil uil-plus icon"></i></a>
                        </button>
                    </div>

                    <div class="itemsContainer flex">
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

                                    <div class="singleItem">

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
                                      
            
                                      <div class="itemInfo">
                                          <span class="itemName"><?php echo $foodName?></span>
                                          <p class="desc"><?php echo $foodDesc?></p>
                                          <div class="itemBottom flex">
                                            <span class="price">$<?php echo $foodPrice?></span>
                                            <div>
                                            <a href="<?php echo SITEURL?>admin/updateFood.php?id=<?php echo $id?>"><i class="uil uil-edit icon"></i></a>
                
                                            <a href="<?php echo SITEURL?>admin/deleteFood.php?id=<?php echo $id?>"><i class="uil uil-times-circle deleteIcon icon"></i></a>
                                          </div>
                                          </div>
                                      </div>
                                    </div>

                                    <?php 
                                    
                                  }
                              }

                              else{
                                echo '<span class="blank">Aún no hay alimentos locales en la base de datos, ¡añádalos!</span>';
                              }
                          }
                        ?>
                    </div>
                </div>

                 <!-- Drinks Category -->
                <div class="drinksCategoryDiv">
                    <div class="heading flex">
                        <span class="">Drinks Category</span>
                        <button class="btn">
                            <a href="addFood.php" class="flex">Add Food <i class="uil uil-plus icon"></i></a>
                        </button>
                    </div>

                      <div class="itemsContainer flex">
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

                                    <div class="singleItem">

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
                                      
            
                                      <div class="itemInfo">
                                          <span class="itemName"><?php echo $foodName?></span>
                                          <p class="desc"><?php echo $foodDesc?></p>
                                          <div class="itemBottom flex">
                                            <span class="price">$<?php echo $foodPrice?></span>
                                            <div>
                                            <a href="<?php echo SITEURL?>admin/updateFood.php?id=<?php echo $id?>"><i class="uil uil-edit icon"></i></a>
                
                                            <a href="<?php echo SITEURL?>admin/deleteFood.php?id=<?php echo $id?>"><i class="uil uil-times-circle deleteIcon icon"></i></a>
                                          </div>
                                          </div>
                                      </div>
                                    </div>

                                    <?php 
                                    
                                  }
                              }

                              else{
                                echo '<span class="blank">No drinks in the database yet, please add!</span>';
                              }
                          }
                      ?>
                    </div>
                </div>

                <!-- Fast Food Category -->
                <div class="fastFoodCategoryDiv foodCategoryDiv" >
                    <div class="heading flex">
                        <span class="">Fast Food Category</span>
                        <button class="btn">
                            <a href="addFood.php" class="flex">Add Food <i class="uil uil-plus icon"></i></a>
                        </button>
                    </div>

                      <div class="itemsContainer flex">
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

                                    <div class="singleItem">

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
                                      
            
                                      <div class="itemInfo">
                                          <span class="itemName"><?php echo $foodName?></span>
                                          <p class="desc"><?php echo $foodDesc?></p>
                                          <div class="itemBottom flex">
                                            <span class="price">$<?php echo $foodPrice?></span>
                                            <div>
                                            <a href="<?php echo SITEURL?>admin/updateFood.php?id=<?php echo $id?>"><i class="uil uil-edit icon"></i></a>
                
                                            <a href="<?php echo SITEURL?>admin/deleteFood.php?id=<?php echo $id?>"><i class="uil uil-times-circle deleteIcon icon"></i></a>
                                          </div>
                                          </div>
                                      </div>
                                    </div>

                                    <?php 
                                    
                                  }
                              }

                              else{
                                echo '<span class="blank">No Fast Food in the database yet, please add!</span>';
                              }
                          }
                      ?>
                    </div>
                </div>

                <!-- Cakes Category -->
                <div class="cakesCategoryDiv foodCategoryDiv">
                    <div class="heading flex">
                        <span class="">Cakes Category</span>
                        <button class="btn">
                            <a href="addFood.php" class="flex">Add Food <i class="uil uil-plus icon"></i></a>
                        </button>
                    </div>

                      <div class="itemsContainer flex">
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

                                    <div class="singleItem">

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
                                      
            
                                      <div class="itemInfo">
                                          <span class="itemName"><?php echo $foodName?></span>
                                          <p class="desc"><?php echo $foodDesc?></p>
                                          <div class="itemBottom flex">
                                            <span class="price">$<?php echo $foodPrice?></span>
                                            <div>
                                            <a href="<?php echo SITEURL?>admin/updateFood.php?id=<?php echo $id?>"><i class="uil uil-edit icon"></i></a>
                
                                            <a href="<?php echo SITEURL?>admin/deleteFood.php?id=<?php echo $id?>"><i class="uil uil-times-circle deleteIcon icon"></i></a>
                                          </div>
                                          </div>
                                      </div>
                                    </div>

                                    <?php 
                                    
                                  }
                              }

                              else{
                                echo '<span class="blank">No cakes in the database yet, please add!</span>';
                              }
                          }
                      ?>
                    </div>
                </div>

                <!-- Dessert Category -->
                <div class="dessertCategoryDiv foodCategoryDiv" >
                    <div class="heading flex">
                        <span class="">Dessert Category</span>
                        <button class="btn">
                            <a href="addFood.php" class="flex">Add Food <i class="uil uil-plus icon"></i></a>
                        </button>
                    </div>

                      <div class="itemsContainer flex">
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

                                    <div class="singleItem">

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
                                      
            
                                      <div class="itemInfo">
                                          <span class="itemName"><?php echo $foodName?></span>
                                          <p class="desc"><?php echo $foodDesc?></p>
                                          <div class="itemBottom flex">
                                            <span class="price">$<?php echo $foodPrice?></span>
                                          <div>
                                            <a href="<?php echo SITEURL?>admin/updateFood.php?id=<?php echo $id?>"><i class="uil uil-edit icon"></i></a>
                
                                            <a href="<?php echo SITEURL?>admin/deleteFood.php?id=<?php echo $id?>"><i class="uil uil-times-circle deleteIcon icon"></i></a>
                                          </div>
                                          </div>
                                      </div>
                                    </div>

                                    <?php 
                                    
                                  }
                              }

                              else{
                                echo '<span class="blank">No desserts in the database yet, please add!</span>';
                              }
                          }
                      ?>
                    </div>
                </div>
              </div>
         </div>
    </div>


<?php 
include('./adminPartials/adminFooter.php');
?>