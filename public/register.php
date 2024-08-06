<?php
require_once '../classes/User.php';

$pageTitle = 'Register'; // Set the page title
include '../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $user = new User();
    if ($user->register($username, $email, $password, $first_name, $last_name, $address, $phone)) {
        echo '<p class="message success">User registered successfully!</p>';
    } else {
        echo '<p class="message">User registration failed!</p>';
    }
}
?>

<div class="registration-container">
    <h1>Register</h1>
    <p class="intro-text">Welcome to our registration page! Please fill out the form below to create a new account. By registering, you'll be able to enjoy a personalized shopping experience, track your orders, and access exclusive offers. If you have any questions, feel free to <a href="contact.php">contact us</a>.</p>
    
    <form method="POST" action="register.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" placeholder="Username" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="Email" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" placeholder="Password" required>

        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" placeholder="First Name">

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" placeholder="Last Name">

        <label for="address">Address:</label>
        <textarea name="address" id="address" placeholder="Address"></textarea>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" placeholder="Phone">

        <input type="submit" value="Register">
    </form>

    <p class="additional-info">Already have an account? <a href="login.php">Log in here</a>. If you need help with the registration process, visit our <a href="index.php">Help Center</a> or read our <a href="index.php">Terms of Service</a> and <a href="index.php">Privacy Policy</a>.</p>
    
    <div class="benefits">
        <h2>Why Register?</h2>
        <ul>
            <li><strong>Exclusive Offers:</strong> Receive special discounts and offers tailored just for you.</li>
            <li><strong>Order Tracking:</strong> Keep track of your orders and manage your purchases easily.</li>
            <li><strong>Personalized Experience:</strong> Enjoy a more personalized shopping experience with recommendations based on your preferences.</li>
            <li><strong>Fast Checkout:</strong> Save your information for faster checkout in the future.</li>
        </ul>
    </div>
</div>

<?php
include '../templates/footer.php';
?>
