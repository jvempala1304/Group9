<?php
session_start();
require_once '../classes/Order.php';
require_once '../classes/Cart.php';
require_once '../libs/fpdf/fpdf.php';

// Create instances of Cart and Order classes
$cart = new Cart();
$order = new Order();

// Get cart items and calculate the total amount
$cart_items = $cart->getCartItems($_SESSION['cart_id']);
$subtotal = array_sum(array_column($cart_items, 'price_at_purchase'));

// Define tax rate (e.g., 10%)
$tax_rate = 0.10; // 10%
$tax = $subtotal * $tax_rate;
$total_amount = $subtotal + $tax;

// Create a new order
$order_id = $order->createOrder($_SESSION['user_id'], $total_amount);

// Add items to the order
foreach ($cart_items as $item) {
    $order->addOrderItem($order_id, $item['product_id'], $item['quantity'], $item['price_at_purchase']);
}

// Generate PDF invoice
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Invoice Header
$pdf->Cell(40, 10, 'Invoice');
$pdf->Ln();
$pdf->Ln(); // Add some space after the title

// Table Header
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 10, 'S.No', 1); // Increased width for padding
$pdf->Cell(85, 10, 'Product', 1); // Increased width for padding
$pdf->Cell(35, 10, 'Quantity', 1); // Increased width for padding
$pdf->Cell(45, 10, 'Price', 1); // Increased width for padding
$pdf->Ln();

// Table Rows
$pdf->SetFont('Arial', '', 12);
$sn = 1;
foreach ($cart_items as $item) {
    $pdf->Cell(15, 10, $sn, 1); // Adjusted width
    $pdf->Cell(85, 10, $item['product_name'], 1); // Adjusted width
    $pdf->Cell(35, 10, $item['quantity'], 1); // Adjusted width
    $pdf->Cell(45, 10, '$' . number_format($item['price_at_purchase'], 2), 1); // Adjusted width
    $pdf->Ln();
    $sn++;
}

// Add totals to the PDF
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(135, 10, 'Subtotal', 0, 0, 'R');
$pdf->Cell(45, 10, '$' . number_format($subtotal, 2), 0, 1, 'R');

$pdf->Cell(135, 10, 'Tax (10%)', 0, 0, 'R');
$pdf->Cell(45, 10, '$' . number_format($tax, 2), 0, 1, 'R');

$pdf->Cell(135, 10, 'Total', 0, 0, 'R');
$pdf->Cell(45, 10, '$' . number_format($total_amount, 2), 0, 1, 'R');

// Output the PDF to a file
$invoice_filename = '../invoices/invoice_' . $order_id . '.pdf';
$pdf->Output('F', $invoice_filename);

// Save the invoice path to the database
$order->saveInvoice($order_id, $invoice_filename);

// Clear the user's cart
$cart->clearCartAndCartItems($_SESSION['cart_id']);

// Clear the cart_id from the session
unset($_SESSION['cart_id']);

// Redirect to order success page with order_id
header('Location: order_success.php?order_id=' . $order_id);
exit;
?>