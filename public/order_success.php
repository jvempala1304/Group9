<?php
session_start();

if (!isset($_GET['order_id'])) {
    die('Order ID not specified.');
}

$order_id = $_GET['order_id'];
$invoice_filename = '../invoices/invoice_' . $order_id . '.pdf';

$pageTitle = 'Order Success'; // Set the page title
include '../templates/header.php';
?>

<h1>Order Successful!</h1>
<p>Your order has been placed successfully. Thank you for shopping with us!</p>

<div class="order-summary">
    <h2>Order Summary</h2>
    <p>Order ID: <?= htmlspecialchars($order_id, ENT_QUOTES, 'UTF-8') ?></p>
    <p>Date: <?= date('F j, Y') ?></p>
</div>

<div class="next-steps">
    <h2>Next Steps</h2>
    <p>You will receive a confirmation email with your order details and tracking information once your order has been processed.</p>
    
</div>

<a href="index.php" class="btn btn-secondary">Return to Home</a>
<br><br>

<!-- Trigger the PDF download -->
<a href="download_invoice.php?order_id=<?= $order_id ?>" class="btn btn-primary">Download Invoice</a>

<?php
include '../templates/footer.php';
?>
