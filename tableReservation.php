<?php
include('clientPartials/clientHeader.php');
include('./clienteDashboard/adminHeader.php');
ob_start();
?>
<section class="container section tableReservationPage">
<div class="adminPage flex">
       <?php 
       include('./clienteDashboard/sideMenu.php');
       ?>

      <div class="mainBody">
        <div class="topSection flex">
            <div class="title">
                <span><strong>Foodie</strong> Dashboard</span>
            </div>

            <?php 
                include('./adminPartials/headerAdminAccount.php');
            ?> 
        </div>

            <div class="mainBodyContentContainer">

            <?php 
                // Get the values from the database=========>
                $sql = "SELECT * FROM orders";
                $res = mysqli_query($conn, $sql);
                if($res==TRUE){
                    $count = mysqli_num_rows($res);
                }
            ?>

            <?php 
              // Get the values from the database=========>
              $sql = "SELECT * FROM orders WHERE order_status = 'delivered'";
              $res = mysqli_query($conn, $sql);
              $totalIncome = 0;
              if($res==TRUE){
                  $deliveredItems = mysqli_num_rows($res);
                  if($deliveredItems > 0){
                      while($eachRow = mysqli_fetch_assoc($res)){
                              $id = $eachRow['id'];
                              $eachItemTotalCost = $eachRow['total_cost'];
                              $totalIncome += $eachItemTotalCost; 
                      }
                  }
              }
            ?>
            <?php 
              // Get the values from the database=========>
              $sql = "SELECT * FROM tablereservations WHERE status = 'closed'";
              $res = mysqli_query($conn, $sql);
              $expensesRevenue = 0;
              if($res==TRUE){
                  $closedReservations = mysqli_num_rows($res);
                  if($closedReservations > 0){
                      while($eachRow = mysqli_fetch_assoc($res)){
                        $id = $eachRow['id'];
                        $eachExpense = $eachRow['expenses'];
                        $expensesRevenue += $eachExpense; 
                      }
                  }
              }
              // Calculate total revenue
              $revenue =  $expensesRevenue + $totalIncome;

            ?>
                <div class="summarySection grid">
                    <div class="summaryCard">
                      <span class="flex"> 
                          <img src="../Assests/cart.png" alt="">
                          <span class="cardTitle">
                               Total Orders
                          </span>
                      </span>
                      <h1 class="count">
                          <?php echo $count?>
                      </h1>
  
                      <span class="overlayText"><?php echo $count?></span>
                    </div>
  
                    <div class="summaryCard">
                      <span class="flex">
                          <img src="../Assests/clock.png" alt="">
                          <span class="cardTitle">
                            Delivered Orders
                       </span>
                      </span>
                      <h1 class="count">
                            <?php echo $deliveredItems?>
                      </h1>
  
                      <span class="overlayText"><?php echo $deliveredItems?></span>
                    </div>
  
                    <div class="summaryCard">
                      <span class="flex">
                          <img src="../Assests/rating.png" alt="">
                          <span class="cardTitle">
                            Table Bookings
                       </span>
                      </span>
                      <h1 class="count">
                        8
                      </h1>
  
                      <span class="overlayText">8</span>
                    </div>
  
                    <div class="summaryCard incomeCard">
                      <span class="flex">
                          <img src="../Assests/customer.png" alt="">
                          <span class="cardTitle">
                            Total Income
                       </span>
                      </span>
                      <h1 class="count">
                          $<?php echo $revenue?>
                      </h1>
  
                      <span class="overlayText"><?php echo $totalIncome?></span>
                    </div>
              </div>
  
              <div class="categoriesSection ">
                 <div class="secHeader flex">
                  <div class="subTitle">
                      <h3><strong>Food</strong> Categories</h3>
                  </div>
                  <div class="btn">
                      <a href="adminMenu.php">
                        See All <i class="uil uil-angle-right icon"></i>
                      </a>
                  </div>
                 </div>
  
                 <div class="optionMenu flex">
                  <div class=" option">
                    <img src="../Assests/diet.png" alt="Best Online food delivery in Nigeria">
                    <small>Foods</small>
                  </div>
                  <div class=" option">
                    <img src="../assests/drink.png" alt="Best Online restaurant in Nigeria">
                    <small>Drinks</small>
                  </div>
                  <div class=" option" >
                    <img src="../assests/pizza.png" alt="Food Image">
                    <small>Fast Food</small>
                  </div>
                  <div class=" option">
                    <img src="../assests/cake.png" alt="Best Online restaurant in Nigeria">
                    <small>Party</small>
                  </div>
                  <div class=" option">
                    <img src="../assests/dessert.png" alt="Best Online restaurant in Nigeria">
                    <small>Dessert</small>
                  </div>
                  <div class=" option">
                    <img src="../assests/dessert.png" alt="Best Online restaurant in Nigeria">
                    <small>Dessert</small>
                  </div>
                  <div class=" option">
                    <img src="../assests/dessert.png" alt="Best Online restaurant in Nigeria">
                    <small>Dessert</small>
                  </div>
                  <div class=" option">
                    <img src="../assests/dessert.png" alt="Best Online restaurant in Nigeria">
                    <small>Dessert</small>
                  </div>
              </div>
              </div>
  
              <div class="mostOrdered">
                  <div class="secHeader flex">
                      <div class="subTitle">
                          <h3><strong>Most</strong> Ordered Food</h3>
                      </div>
                  </div>
  
                 <div class="flex popularItemsContainer">
                    <?php 
                          $sql = "SELECT * FROM food order by RAND() LIMIT 0,4 " ;
                          $res = mysqli_query($conn, $sql);
                          if ($res == true){
                            $count = mysqli_num_rows($res);
                            if($count>0){
                              while($row = mysqli_fetch_assoc($res)){
                                $id = $row['id'];
                                $img = $row['image'];
                                $foodName = $row['food_name'];
                                $foodDesc = $row['food_desc'];

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
                                      echo '<span class="fail" style="color:red; margin: 0px 10px;">No Food Image</span>';
                                    }

                                  ?>
            
                                    <div class="itemInfo">
                                        <span class="itemName"><?php echo $foodName?></span>
                                        <p class="desc"><?php echo $foodDesc?></p>
                                      </div>
                                  </div>
                                <?php
                              }
                            }
                          }
                    ?>
                 </div>
  
              </div>
            </div>

            
         </div>
    </div>
</section>
<!-- Table Section Ends -->

<?php
include('clientPartials/clientFooter.php');
?>

<?php
if (isset($_POST['submit'])) {

    $guestName = $_POST['guestName'];
    $guestEmail = $_POST['guestEmail'];
    $guestPhone = $_POST['guestPhone'];
    $totalPeople = $_POST['totalPeople'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $status = $_POST['status'];
    $guestMessage = $_POST['guestMessage'];

    $sql = "INSERT INTO tablereservations SET
  guest_name = '$guestName',
  email = '$guestEmail',
  contact = '$guestPhone',
  people = '$totalPeople',
  date = '$date',
  time = '$time',
  status = '$status',
  message = '$guestMessage'
  ";

    $result = mysqli_query($conn, $sql);

    if ($result == TRUE) {
        $_SESSION['TableReserved'] = '
        <div class="messageConatainerHome flex">
        <span class="messageCard">
            <img src="./Assests/checkIcon.png" class="checkIconHome">
            <small>Table Resereved successfully! <br>So glad to serve you!</small>
        <br><br>
        - Thank you! -

        </span>
    </div>';
        header('location:' . SITEURL);
        exit();
    } else {

        die('Failed to connect to database!');
    }
}
?>