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
                    <img src="../Assests/icons8-supplier-40.png" class="icono" alt="icono">
                    <span><strong>Pedidos Realizados</strong></span>
                </div>

                <?php 
                   if (isset($_SESSION['orderUpdated'])) {
                    echo $_SESSION['orderUpdated'];
                    unset($_SESSION['orderUpdated']);
                   }
                ?> 

                <?php 
                    include('./adminPartials/headerAdminAccount.php');
                ?> 
            </div>

            <div class="mainBodyContentContainer">

                <div class="orderDiv">
                    <table class="table">
                        <tr class="tblHeader">
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Telefono</th>
                            <th>Total Costo</th>
                            <th>Estado</th>
                            <th>Medio</th>
                            <th>Accion</th>
                        </tr>

                        <?php 
$username = $_SESSION['username']; // Obtén el nombre de usuario desde la sesión
// Filtra las órdenes por el nombre de usuario en 'updated_by' o por estado 'Entregado'
$sql = "SELECT * FROM orders WHERE updated_by = '$username' AND order_status = 'Entregado'";
$res = mysqli_query($conn, $sql);
$tableID = 1;
if($res == TRUE){
    $count = mysqli_num_rows($res);
    if($count > 0){
        while($row = mysqli_fetch_assoc($res)){
            $id = $row['id'];
            $cust_fname = $row['cust_fname'];
            $contact = $row['contact'];
            $total_cost = $row['total_cost'];
            $order_status = $row['order_status'];
            $payment = $row['payment'];
            ?>
            
            <tr class="tblRow orderRow">
                <td class="id"><?php echo $tableID++?></td>
                <td class="customerName">
                    <span class="name"><?php echo $cust_fname?></span>
                </td>

                <td class="contact">
                    <p><?php echo $contact?></p>
                </td>

                <td class="cost">
                    <p>S/.<?php echo $total_cost?></p>
                </td>

                <?php 
                if($order_status == 'Entregado'){
                    ?>
                    <td class="status">            
                        <p class="delivered"><?php echo $order_status?></p>
                    </td>
                    <?php
                } elseif ($order_status == 'Cancelado') {
                    ?>
                    <td class="status">            
                        <p class="canceled"><?php echo $order_status?></p>
                    </td>
                    <?php
                } elseif ($order_status == 'En camino') {
                    ?>
                    <td class="status">            
                        <p class="OTW"><?php echo $order_status?></p>
                    </td>
                    <?php
                } else {
                    ?>
                    <td class="status" style="text-transform: capitalize;">            
                        <p><?php echo $order_status?></p>
                    </td>
                    <?php
                }
                ?>

                <td class="payments">
                    <p><?php echo $payment?></p>
                </td>

                <td class="action">
                    <a href="<?php echo SITEURL?>admin/orderDetails_user.php?id=<?php echo $id?>">
                    <i class="uil uil-eye icon"></i>
                    </a>
                </td>
            </tr>

            <?php 
        }
    } else {
        echo '<span class="blank">Aún no hay pedidos completados! <i class="bx bxs-check-circle"></i></span>';


    }
}
?>
                    </table>
                </div>
                
               
            </div>

         </div>
    </div>


<?php 
include('./adminPartials/adminFooter.php');
?>