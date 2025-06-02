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
                <span><strong>Panel de</strong> Reportes</span>
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

            <!-- Formulario de filtros -->
            <form method="GET" action="" style="margin-bottom: 1rem; display: flex; align-items: center; gap: 1rem;">
                <input
                    type="text"
                    name="search_name"
                    placeholder="Buscar por nombre"
                    value="<?php echo isset($_GET['search_name']) ? htmlspecialchars($_GET['search_name']) : ''; ?>"
                    style="padding: .5rem; flex: 1;">

                <select name="filter_status" style="padding: .5rem;">
                    <option value="">Todos los estados</option>
                    <option value="Entregado" <?php if (isset($_GET['filter_status']) && $_GET['filter_status'] == 'Entregado') echo 'selected'; ?>>Entregado</option>
                    <option value="Pendiente" <?php if (isset($_GET['filter_status']) && $_GET['filter_status'] == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                    <option value="Cancelado" <?php if (isset($_GET['filter_status']) && $_GET['filter_status'] == 'Cancelado') echo 'selected'; ?>>Cancelado</option>
                    <option value="En camino" <?php if (isset($_GET['filter_status']) && $_GET['filter_status'] == 'En camino') echo 'selected'; ?>>En camino</option>
                </select>

                <button type="submit" class="btn">Filtrar</button>
          
                <a
                    href="export_orders_pdf.php?search_name=<?php echo urlencode($_GET['search_name'] ?? '') ?>&filter_status=<?php echo urlencode($_GET['filter_status'] ?? '') ?>"
                    class="btn"
                    target="_blank">
                    PDF
                </a>
       
            </form>

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
                    $username = $_SESSION['username']; // Nombre usuario

                    // Construir cláusula WHERE con filtros
                    $whereClauses = ["updated_by = '$username'"];

                    if (!empty($_GET['search_name'])) {
                        $name = mysqli_real_escape_string($conn, $_GET['search_name']);
                        $whereClauses[] = "cust_fname LIKE '%$name%'";
                    }

                    if (!empty($_GET['filter_status'])) {
                        $status = mysqli_real_escape_string($conn, $_GET['filter_status']);
                        $whereClauses[] = "order_status = '$status'";
                    }

                    $whereSql = implode(' AND ', $whereClauses);

                    $sql = "SELECT * FROM orders WHERE $whereSql ORDER BY id DESC";
                    $res = mysqli_query($conn, $sql);
                    $tableID = 1;

                    if ($res == TRUE) {
                        $count = mysqli_num_rows($res);
                        if ($count > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $id = $row['id'];
                                $cust_fname = $row['cust_fname'];
                                $contact = $row['contact'];
                                $total_cost = $row['total_cost'];
                                $order_status = $row['order_status'];
                                $payment = $row['payment'];
                    ?>
                                <tr class="tblRow orderRow">
                                    <td class="id"><?php echo $tableID++ ?></td>
                                    <td class="customerName">
                                        <span class="name"><?php echo $cust_fname ?></span>
                                    </td>
                                    <td class="contact">
                                        <p><?php echo $contact ?></p>
                                    </td>
                                    <td class="cost">
                                        <p>S/.<?php echo $total_cost ?></p>
                                    </td>
                                    <?php
                                    if ($order_status == 'Entregado') {
                                    ?>
                                        <td class="status">
                                            <p class="delivered"><?php echo $order_status ?></p>
                                        </td>
                                    <?php
                                    } elseif ($order_status == 'Cancelado') {
                                    ?>
                                        <td class="status">
                                            <p class="canceled"><?php echo $order_status ?></p>
                                        </td>
                                    <?php
                                    } elseif ($order_status == 'En camino') {
                                    ?>
                                        <td class="status">
                                            <p class="OTW"><?php echo $order_status ?></p>
                                        </td>
                                    <?php
                                    } else {
                                    ?>
                                        <td class="status" style="text-transform: capitalize;">
                                            <p><?php echo $order_status ?></p>
                                        </td>
                                    <?php
                                    }
                                    ?>
                                    <td class="payments">
                                        <p><?php echo $payment ?></p>
                                    </td>
                                  
                                    <td class="action">

                                        &nbsp;|&nbsp;
                                        <a href="<?php echo SITEURL ?>admin/export_order_ticket.php?id=<?php echo $id ?>" title="Generar ticket PDF" target="_blank" class="btn btn-small">
                                            🧾
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
            </div><br>
           
        </div>

    </div>
</div>

<?php
include('./adminPartials/adminFooter.php');
?>