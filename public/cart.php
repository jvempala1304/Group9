<?php
session_start();
require_once '../classes/Cart.php';
require_once '../classes/Product.php';

$pageTitle = 'Cart'; // Set the page title
include '../templates/header.php';

$cart = new Cart();
$product = new Product();

// Handle form submission to add or remove items from the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        // Handle removal of item
        if ($_POST['action'] === 'remove') {
            $cart_item_id = filter_input(INPUT_POST, 'cart_item_id', FILTER_SANITIZE_NUMBER_INT);
            if ($cart_item_id && $cart->removeItemFromCart($cart_item_id)) {
                header('Location: cart.php');
                exit;
            } else {
                echo 'Failed to remove item from cart.';
            }
        }
    } else {
        // Handle adding items to the cart
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_NUMBER_INT);

        if (!$_SESSION['cart_id']) {
            $_SESSION['cart_id'] = $cart->createCart($_SESSION['user_id']);
            if (!$_SESSION['cart_id']) {
                echo 'Failed to create cart.';
                exit;
            }
        }

        if ($product_id && $quantity) {
            // Fetch the product price from the Products table based on product_id
            $product_info = $product->getProductById($product_id);
            
            if ($product_info) {
                $price_at_purchase = $product_info['price']; // Get the price from the product info
                
                if ($cart->addItemToCart($_SESSION['cart_id'], $product_id, $quantity)) {
                    // Redirect to the cart page after adding item
                    header('Location: cart.php');
                    exit;
                } else {
                    echo 'Failed to add item to cart.';
                }
            } else {
                echo 'Product not found.';
            }
        } else {
            echo 'Invalid input.';
        }
    }
}

if(isset($_SESSION['cart_id'])) {
    // Fetch and display cart items
    $cart_items = $cart->getCartItems($_SESSION['cart_id']);

    // Display cart items
    if ($cart_items) {
        echo '<div class="cart-container">';
        echo '<ul class="cart-items">';
        foreach ($cart_items as $item) {
            echo '<li>
                    <div class="cart-item-details">
                        <img height=100 src="../' . htmlspecialchars($item['image_url'], ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8') . '" class="cart-item-image">
                        <span>' . htmlspecialchars($item['product_name'], ENT_QUOTES, 'UTF-8') . '</span>
                        <span>Quantity: ' . htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8') . '</span>
                        <span>Price: $' . htmlspecialchars($item['price_at_purchase'], ENT_QUOTES, 'UTF-8') . '</span>
                    </div>
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="action" value="remove">
                        <input type="hidden" name="cart_item_id" value="' . htmlspecialchars($item['cart_item_id'], ENT_QUOTES, 'UTF-8') . '">
                        <input type="submit" value="Remove">
                    </form>
                  </li>';
        }
        echo '</ul>';
        echo '</div>';
    } else {
        echo 'Your cart is empty.';
    }
} else {
    echo 'Your cart is empty.';
}

// Add checkout button
if (!empty($cart_items)) {
	echo '<div class="checkout-button-wrapper">';
    echo '<div class="checkout-button">
            <form method="GET" action="checkout.php">
                <input type="submit" value="Proceed to Checkout">
            </form>
          </div>';
	echo '</div>';
}

include '../templates/footer.php';
?>
