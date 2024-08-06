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
	
	public function getCartItems($cart_id) {
        $query = 'SELECT ci.cart_item_id, ci.product_id, ci.quantity, ci.price_at_purchase, p.product_name, p.image_url
                  FROM Cart_Items ci
                  JOIN Products p ON ci.product_id = p.product_id
                  WHERE ci.cart_id = :cart_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeItemFromCart($cart_item_id) {
        $query = 'DELETE FROM Cart_Items WHERE cart_item_id = :cart_item_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_item_id', $cart_item_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

	public function clearCartAndCartItems($cart_id) {
		$query1 = "DELETE FROM cart_items WHERE cart_id = ?";
		$stmt1 = $this->conn->prepare($query1);

		$query2 = "DELETE FROM cart WHERE cart_id = ?";
		$stmt2 = $this->conn->prepare($query2);

		$stmt1->execute([$cart_id]);
		return $stmt2->execute([$cart_id]);
	}
}
?>