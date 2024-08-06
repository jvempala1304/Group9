<?php
require_once 'DB.php';

class User {
    private $conn;

    public function __construct() {
        $database = new DB();
        $this->conn = $database->connect();
    }

    public function login($email, $password) {
        $query = 'SELECT * FROM Users WHERE email = :email';
        $stmt = $this->conn->prepare($query);

        // Prevent XSS by sanitizing inputs
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

	public function getUserCartId($user_id) {
        $query = 'SELECT cart_id FROM Cart WHERE user_id = :user_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            return $cart['cart_id'];
        }
        return false;
    }
}
?>