<?php
require_once 'DB.php';

class Cart {
    private $conn;

    public function __construct() {
        $database = new DB();
        $this->conn = $database->connect();
    }

    public function createCart($user_id) {
        $query = 'INSERT INTO Cart (user_id) VALUES (:user_id)'; // Assuming the total_amount starts at 0
        $stmt = $this->conn->prepare($query);

        // Bind the user_id
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Return the last inserted cart_id
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function addItemToCart($cart_id, $product_id, $quantity) {
		// First, fetch the product price from the database
		$product_query = 'SELECT price FROM Products WHERE product_id = :product_id';
		$product_stmt = $this->conn->prepare($product_query);
		$product_stmt->bindParam(':product_id', $product_id);
		$product_stmt->execute();
		$product = $product_stmt->fetch(PDO::FETCH_ASSOC);

		if ($product) {
			$unit_price = $product['price'];
			$price_at_purchase = $quantity * $unit_price;

			// Now insert the item into the cart
			$query = 'INSERT INTO Cart_Items (cart_id, product_id, quantity, price_at_purchase)
					VALUES (:cart_id, :product_id, :quantity, :price_at_purchase)';

			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(':cart_id', $cart_id);
			$stmt->bindParam(':product_id', $product_id);
			$stmt->bindParam(':quantity', $quantity);
			$stmt->bindParam(':price_at_purchase', $price_at_purchase);

			if ($stmt->execute()) {
				return true;
			} else {
				return false;
			}
		} else {
			// Product not found
			return false;
		}
	}
}
?>