<?php
require_once 'DB.php';

class User {
    private $conn;

    public function __construct() {
        $database = new DB();
        $this->conn = $database->connect();
    }


    public function register($username, $email, $password, $first_name, $last_name, $address, $phone) {
        $query = 'INSERT INTO Users (username, email, password, first_name, last_name, address, phone)
                  VALUES (:username, :email, :password, :first_name, :last_name, :address, :phone)';

        $stmt = $this->conn->prepare($query);

        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        // Prevent XSS by sanitizing inputs
        $username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
        $first_name = htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8');
        $last_name = htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8');
        $address = htmlspecialchars($address, ENT_QUOTES, 'UTF-8');
        $phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password_hashed);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);

        if ($stmt->execute()) {
            return true;
        }
        return false;
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