<?php
session_start();
$pageTitle = 'Home'; 
include '../templates/header.php';

// Database configuration
$host = 'localhost';  
$username = 'root';   
$password = '';       

// Create a connection
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the database exists
$db_check = $conn->query("SHOW DATABASES LIKE 'auto_parts_store'");
if ($db_check->num_rows == 0) {
    // Create database if it doesn't exist
    $conn->query("CREATE DATABASE auto_parts_store");
    $conn->select_db('auto_parts_store');

    // Create tables
    $conn->query("CREATE TABLE Users (
        user_id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        first_name VARCHAR(50),
        last_name VARCHAR(50),
        address TEXT,
        phone VARCHAR(15),
        registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

}

?>


<main>
        <section class="hero">
            <div class="container">
                <h2>Find Your Car parts</h2>
                <p>Explore a wide range of vehicle parts tailored to your needs.</p>
                <a href="product.php" class="btn">Browse Inventory</a>
            </div>
        </section>

        <section class="featured">
            <div class="container">
                <h2>Featured Vehicle Parts</h2>
                <div class="vehicle-list">
                    <div class="vehicle-item">
                        <img src="../images/air_filter.jpg" alt="Car 1">
                        <h3>Air Filter</h3>
                        <p>High performance</p>
                        <a href="product.php" class="btn">Learn More</a>
                    </div>
                    <div class="vehicle-item">
                        <img src="../images/brake_disc.jpg" alt="Car 2">
                        <h3>Brake Disc</h3>
                        <p>High Precision</p>
                        <a href="product.php" class="btn">Learn More</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="testimonials">
            <div class="container">
                <h2>What Our Customers Say</h2>
                <div class="testimonial-list">
                    <div class="testimonial-item">
                        <blockquote>
                            <p>"I had an amazing experience buying my new car from Automobile World. The service was top-notch and the selection was fantastic!"</p>
                            <footer>- Jane Doe</footer>
                        </blockquote>
                    </div>
                    <div class="testimonial-item">
                        <blockquote>
                            <p>"Professional and friendly staff, great prices, and a wide range of cars to choose from. Highly recommend!"</p>
                            <footer>- John Smith</footer>
                        </blockquote>
                    </div>
                </div>
            </div>
        </section>

        <section class="call-to-action">
            <div class="container">
                <h2>Ready to Drive Away?</h2>
                <p>Contact us today to schedule a test drive or get more information about our vehicles.</p>
                <a href="login.php" class="btn">Contact Us</a>
            </div>
        </section>

        <section class="brands">
            <div class="container">
                <h2>Popular Car Brands</h2>
                <div class="brand-list">
                    <div class="brand-item">
                        <img src="../images/brand1.jpg" alt="Brand 1">
                        <p>Hyundai</p>
                    </div>
                    <div class="brand-item">
                        <img src="../images/brand2.jpg" alt="Brand 2">
                        <p>Toyota</p>
                    </div>
                    <div class="brand-item">
                        <img src="../images/brand3.jpg" alt="Brand 3">
                        <p>Audi</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

<?php
include '../templates/footer.php';
?>