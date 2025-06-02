<?php 

include('./config/config.php');

// get individual ID ====================>
$deleteCartBtn = $_GET['id'];

$sql = "DELETE FROM cart WHERE id= $deleteCartBtn";
$result = mysqli_query($conn, $sql);
if($result==TRUE){
    $_SESSION['deletedCartItem'] = '<span class="success">¡Articulo eliminado con éxito!</span>';
    header('location:' .SITEURL. 'cart.php');
}
else{
    $_SESSION['deletedCartItem'] = '<span class="fail">No se ha podido eliminar el articulo!</span>';
    header('location:' .SITEURL. 'admin/cart.php');
}

?>