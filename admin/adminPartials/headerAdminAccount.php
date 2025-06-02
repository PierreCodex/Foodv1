<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$name = $_SESSION['name'] ?? 'Admin';
$image = $_SESSION['admin_image'] ?? '';
$adminRole = $_SESSION['role'] ?? '';

// Obtener cantidad de órdenes pendientes
$sql = "SELECT * FROM orders WHERE order_status = 'ordered'";
$res = mysqli_query($conn, $sql);
$currentOrders = ($res) ? mysqli_num_rows($res) : 0;
?>

<div class="adminDiv flex">
    <div class="notDiv">
        <i class='bx bxs-bell icon' title="New Food Order"></i>
        <span class="count"><?php echo $currentOrders; ?></span>
    </div>

    <?php if ($image != ''): ?>
        <div class="imgDiv flex">
            <img src="<?php echo SITEURL; ?>databaseImages/foodie/<?php echo htmlspecialchars($image); ?>" alt="Account Admin Image" />
            <span class="name"><?php echo htmlspecialchars($name); ?> <br><small><?php echo htmlspecialchars($adminRole); ?></small></span>
        </div>
    <?php else: ?>
        <span class="fail" style="color:red; margin: 0px 10px;">No Image</span>
    <?php endif; ?>

    <a href="logOut.php" title="Log Out">
        <img src="../Assests/logOutIcon.png" alt="" style="width: 40px; transform: translateY(5px);" />
    </a>
</div>
