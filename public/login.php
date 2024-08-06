<?php
session_start();
require_once '../classes/User.php';
require_once '../classes/Cart.php';

$pageTitle = 'Login'; // Set the page title
include '../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();
    $user_data = $user->login($email, $password);

    if ($user_data) {
        $_SESSION['user_id'] = $user_data['user_id'];

        // Get the user's cart ID or create a new cart if none exists
        $cart = new Cart();
        $cart_id = $user->getUserCartId($_SESSION['user_id']);

        $_SESSION['cart_id'] = $cart_id;

        // Redirect to the home page or the intended page
        header('Location: index.php');
        exit;
    } else {
        echo 'Invalid email or password!';
    }
}

?>

<main>
        <section class="login-section">
            <div class="container">
                <h2>Login to Your Account</h2>
                <p>Access your account to manage your vehicle preferences, track orders, and more.</p>
                
                <form method="POST" action="login.php">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email address" required><br>

                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required><br>

                    <input type="submit" value="Login">
                </form>

                <p class="forgot-password"><a href="register.php">Forgot your password?</a></p>
                <p>Don't have an account? <a href="register.php">Create one here</a>.</p>
            </div>
        </section>
    </main>

<?php
include '../templates/footer.php';
?>