<?php
require_once 'DB.php';

class Product {
    private $conn;

    public function __construct() {
        $database = new DB();
        $this->conn = $database->connect();
    }

    public function getAllProducts() {
        $query = 'SELECT * FROM Products';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($product_id) {
        $query = 'SELECT * FROM Products WHERE product_id = :product_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductsByCategory($category_id) {
        $query = 'SELECT * FROM Products WHERE category_id = :category_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct($product_name, $category_id, $price, $description, $stock_quantity, $image_url) {
        $query = 'INSERT INTO Products (product_name, category_id, price, description, stock_quantity, image_url)
                  VALUES (:product_name, :category_id, :price, :description, :stock_quantity, :image_url)';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':stock_quantity', $stock_quantity);
        $stmt->bindParam(':image_url', $image_url);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>