<?php
include('./config/config.php');
include('./clienteDashboard/adminHeader.php');
include('clientPartials/clientHeader.php');
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
                    <span><strong>My</strong> Dashboard</span>
                </div>
            </div>

            <div class="greeting">
                <h4>Hola, <?php
                            if (isset($_SESSION['user_id'])) {
                                $user_id = $_SESSION['user_id']; // Obtener el ID del cliente desde la sesión
                                $sql_user = "SELECT name FROM users WHERE id = '$user_id'";
                                $res_user = mysqli_query($conn, $sql_user);
                                if ($res_user && mysqli_num_rows($res_user) > 0) {
                                    $row_user = mysqli_fetch_assoc($res_user);
                                    $user_name = $row_user['name'];
                                    echo $user_name;
                                }
                            }
                            ?></h4>

                <p>Desde tu panel de cuenta puedes ver el resumen de tu actividad reciente y actualizar tu informacion personal</>
            </div>
            
            <div class="mainBodyContentContainer">

                <?php
                // Get the values from the database=========>
                $sql = "SELECT * FROM orders";
                $res = mysqli_query($conn, $sql);
                if ($res == TRUE) {
                    $count = mysqli_num_rows($res);
                }
                ?>

                <?php
                // Get the values from the database=========>
                $sql = "SELECT * FROM orders WHERE order_status = 'delivered'";
                $res = mysqli_query($conn, $sql);
                $totalIncome = 0;
                if ($res == TRUE) {
                    $deliveredItems = mysqli_num_rows($res);
                    if ($deliveredItems > 0) {
                        while ($eachRow = mysqli_fetch_assoc($res)) {
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
                if ($res == TRUE) {
                    $closedReservations = mysqli_num_rows($res);
                    if ($closedReservations > 0) {
                        while ($eachRow = mysqli_fetch_assoc($res)) {
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
                            <img src="./Assests/cart.png" alt="">
                            <span class="cardTitle">
                                Total de Ordenes
                            </span>
                        </span>
                        <h1 class="count">
                        <?php echo $revenue ?>
                        </h1>

                        <span class="overlayText"></span>
                    </div>

                    <div class="summaryCard">
                        <span class="flex">
                            <img src="./Assests/clock.png" alt="">
                            <span class="cardTitle">
                            Pedidos entregados
                            </span>
                        </span>
                        <h1 class="count">
                        <?php echo $revenue ?>
                        </h1>

                        <span class="overlayText"></span>
                    </div>

                   

                    <div class="summaryCard incomeCard">
                        <span class="flex">
                            <img src="./Assests/rating.png" alt="">
                            <span class="cardTitle">
                                Total Reseñas
                            </span>
                        </span>
                        <h1 class="count">
                            <?php echo $revenue ?>
                        </h1>

                        <span class="overlayText"><?php echo $totalIncome ?></span>
                    </div>
                </div>


                <div class="mostOrdered">
                    <div class="secHeader flex">
                        <div class="subTitle">
                          
                        </div>
                    </div>

                    <div class="flex popularItemsContainer">
                       
                    </div>

                </div>
            </div>


        </div>
    </div>
</section>






<?php
include('clientPartials/clientFooter.php');
?>