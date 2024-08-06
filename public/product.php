<?php
session_start();

require_once '../classes/Product.php';

$pageTitle = 'Product'; // Set the page title
include '../templates/header.php';

$product = new Product();
$products = $product->getAllProducts();
?>

<h1>Products</h1>

<div class="product-container">
    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <img src="../<?php echo htmlspecialchars($product['image_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?>">
            
            <h2><?php echo htmlspecialchars($product['product_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <p class="price">Price: $<?php echo htmlspecialchars($product['price'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p class="description"><?php echo htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8'); ?></p>
            
            <form method="POST" action="cart.php">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id'], ENT_QUOTES, 'UTF-8'); ?>">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" id="quantity" value="1" min="1">
                <input type="submit" value="Add to Cart">
            </form>
        </div>
    <?php endforeach; ?>
</div>

<?php
include '../templates/footer.php';
?>
