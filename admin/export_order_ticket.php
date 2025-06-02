<?php
// Incluir librerías FPDF y Code128

require_once '../code128.php';  // Asegúrate de que exista y esté correcto el path

// Conexión a base de datos y sesión
include '../config/config.php';


// Validar ID de pedido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID de pedido inválido');
}
$orderId = intval($_GET['id']);

// Obtener datos del pedido
$sqlOrder = "SELECT * FROM orders WHERE id = $orderId LIMIT 1";
$resOrder = mysqli_query($conn, $sqlOrder);
if (!$resOrder || mysqli_num_rows($resOrder) === 0) {
    die('Pedido no encontrado');
}
$order = mysqli_fetch_assoc($resOrder);

// Obtener productos del pedido
$sqlItems = "
    SELECT oi.quantity, oi.price, f.food_name
    FROM order_items oi
    JOIN food f ON oi.food_id = f.id
    WHERE oi.order_id = $orderId
";
$resItems = mysqli_query($conn, $sqlItems);

// Crear PDF tamaño ticket (80x258 mm)
$pdf = new PDF_Code128('P', 'mm', array(80, 258));
$pdf->SetMargins(4, 10, 4);
$pdf->AddPage();

// Encabezado de la empresa
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(0, 0, 0);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", strtoupper("Cevicheria Morales")), 0, 'C', false);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "RUC: 0000000000"), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Dirección: San Antonio 701, Sullana, Piura, Peru"), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Teléfono: 963 507 851"), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Email: cevicheriamorales@gmail.com"), 0, 'C', false);

$pdf->Ln(1);
$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(5);

// Fecha y datos del cajero (ajustar según corresponda)
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Fecha: " . date("d/m/Y H:i")), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Caja Nro: 1"), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Cajero: .". $order['updated_by']), 0, 'C', false);
$pdf->SetFont('Arial', 'B', 10);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", strtoupper("Ticket Nro: " . $orderId)), 0, 'C', false);
$pdf->SetFont('Arial', '', 9);

$pdf->Ln(1);
$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(5);

// Datos del cliente
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Cliente: " . $order['cust_fname'] . " " . $order['cust_sname']), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Documento: DNI 00000000"), 0, 'C', false); // Cambia si tienes DNI
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Teléfono: " . $order['contact']), 0, 'C', false);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "Dirección: " . $order['location'] . ", " . $order['street'] . ", N° " . $order['building']), 0, 'C', false);

$pdf->Ln(1);
$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "-------------------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(3);

// Tabla de productos encabezado
$pdf->Cell(10, 5, iconv("UTF-8", "ISO-8859-1", "Cant."), 0, 0, 'C');
$pdf->Cell(19, 5, iconv("UTF-8", "ISO-8859-1", "Precio"), 0, 0, 'C');
$pdf->Cell(15, 5, iconv("UTF-8", "ISO-8859-1", "Producto"), 0, 0, 'C');
$pdf->Cell(28, 5, iconv("UTF-8", "ISO-8859-1", "Total"), 0, 0, 'C');
$pdf->Ln(3);
$pdf->Cell(72, 5, iconv("UTF-8", "ISO-8859-1", "-------------------------------------------------------------------"), 0, 0, 'C');
$pdf->Ln(3);

// Detalles de productos
$totalProductos = 0;
$totalCost = 0;
while ($item = mysqli_fetch_assoc($resItems)) {
    $subtotal = $item['quantity'] * $item['price'];
    $totalCost += $subtotal;
    $totalProductos += $item['quantity'];

    $pdf->Cell(10, 5, $item['quantity'], 0, 0, 'C');
    $yStart = $pdf->GetY();
    $pdf->MultiCell(15, 5, iconv("UTF-8", "ISO-8859-1", strtoupper(substr($item['food_name'], 0, 12))), 0, 'L', false);
    $yEnd = $pdf->GetY();
    $pdf->SetXY(34, $yStart);
    $pdf->Cell(19, 5, "S/. " . number_format($item['price'], 2), 0, 0, 'C');
    $pdf->SetXY(53, $yStart);
    $pdf->Cell(28, 5, "S/. " . number_format($subtotal, 2), 0, 1, 'C');
    $pdf->SetY($yEnd);
}

$pdf->Ln(5);

// Totales
$pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1", "Total Productos: " . $totalProductos), 0, 0, 'L');
$pdf->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", "Total: S/. " . number_format($totalCost, 2)), 0, 1, 'R');

$pdf->Ln(5);

// Nota final
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", "*** Precios incluyen impuestos. Guardar este ticket para reclamos ***"), 0, 'C', false);

$pdf->Ln(10);

// Código de barras dinámico basado en ID de pedido
$codigo = "PEDIDO-" . $orderId;
$pdf->Code128(5, $pdf->GetY(), $codigo, 70, 20);
$pdf->SetXY(0, $pdf->GetY() + 21);
$pdf->SetFont('Arial', '', 14);
$pdf->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", $codigo), 0, 'C', false);

// Salida PDF
$pdf->Output("I", "Ticket_Pedido_{$orderId}.pdf", true);
exit();
?>
