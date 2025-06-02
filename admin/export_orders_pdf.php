<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dompdf\Dompdf;

include('../config/config.php'); // Incluye solo conexión sin salida
session_start(); // Asegúrate de iniciar sesión para $_SESSION

// Obtener filtros desde GET
$username = $_SESSION['username'] ?? '';
$search_name = $_GET['search_name'] ?? '';
$filter_status = $_GET['filter_status'] ?? '';

$search_name_safe = mysqli_real_escape_string($conn, $search_name);
$filter_status_safe = mysqli_real_escape_string($conn, $filter_status);

$whereClauses = [];
if ($username !== '') {
    $whereClauses[] = "updated_by = '$username'";
}
if ($search_name_safe !== '') {
    $whereClauses[] = "cust_fname LIKE '%$search_name_safe%'";
}
if ($filter_status_safe !== '') {
    $whereClauses[] = "order_status = '$filter_status_safe'";
}

$whereSql = count($whereClauses) ? implode(' AND ', $whereClauses) : '1';

$sql = "SELECT * FROM orders WHERE $whereSql ORDER BY id DESC";
$res = mysqli_query($conn, $sql);

$html = '<h2>Reporte de Pedidos</h2>';
$html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%" style="border-collapse: collapse;">';
$html .= '<thead><tr style="background-color:#f2f2f2;">';
$html .= '<th>ID</th><th>Nombre</th><th>Teléfono</th><th>Total</th><th>Estado</th><th>Método de Pago</th>';
$html .= '</tr></thead><tbody>';

if ($res && mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $html .= '<tr>';
        $html .= '<td>' . $row['id'] . '</td>';
        $html .= '<td>' . htmlspecialchars($row['cust_fname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['contact']) . '</td>';
        $html .= '<td>S/. ' . $row['total_cost'] . '</td>';
        $html .= '<td>' . htmlspecialchars($row['order_status']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['payment']) . '</td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr><td colspan="6" style="text-align:center;">No hay datos para mostrar.</td></tr>';
}

$html .= '</tbody></table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Limpiar buffer para evitar salida previa corrupta
if (ob_get_length()) ob_end_clean();

$dompdf->stream("reporte_pedidos.pdf", ["Attachment" => true]);
exit();
