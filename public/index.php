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

	$conn->query("CREATE TABLE Categories (
        category_id INT AUTO_INCREMENT PRIMARY KEY,
        category_name VARCHAR(100) NOT NULL
    )");

    $conn->query("CREATE TABLE Products (
        product_id INT AUTO_INCREMENT PRIMARY KEY,
        product_name VARCHAR(100) NOT NULL,
        category_id INT,
        price DECIMAL(10,2) NOT NULL,
        description TEXT,
        stock_quantity INT DEFAULT 0,
        image_url VARCHAR(255),
        FOREIGN KEY (category_id) REFERENCES Categories(category_id)
    )");

	$conn->query("CREATE TABLE Cart (
        cart_id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES Users(user_id)
    )");

    $conn->query("CREATE TABLE Cart_Items (
        cart_item_id INT AUTO_INCREMENT PRIMARY KEY,
        cart_id INT,
        product_id INT,
        quantity INT NOT NULL,
        price_at_purchase DECIMAL(10,2) NOT NULL,
        FOREIGN KEY (cart_id) REFERENCES Cart(cart_id),
        FOREIGN KEY (product_id) REFERENCES Products(product_id)
    )");
}

// Select the database
$conn->select_db('auto_parts_store');

// Check if the Categories and Products tables have data
$categories_check = $conn->query("SELECT COUNT(*) FROM Categories");
$products_check = $conn->query("SELECT COUNT(*) FROM Products");

if ($categories_check->fetch_row()[0] == 0 && $products_check->fetch_row()[0] == 0) {
    // Insert dummy data into Categories and Products tables
    $conn->query("INSERT INTO Categories (category_name) VALUES
    ('Engine Parts'),
    ('Brakes'),
    ('Suspension'),
    ('Electrical Parts'),
    ('Exhaust'),
    ('Wheels & Tires'),
    ('Body Parts'),
    ('Interior Accessories')");

    $conn->query("INSERT INTO Products (product_name, category_id, price, description, stock_quantity, image_url) VALUES
    ('Spark Plug', 1, 9.99, 'High-performance spark plug for maximum engine efficiency.', 150, 'images/spark_plug.jpg'),
    ('Brake Pads', 2, 29.99, 'Durable brake pads for safe and reliable braking.', 200, 'images/brake_pads.jpg'),
    ('Shock Absorbers', 3, 79.99, 'Premium shock absorbers for a smooth ride.', 100, 'images/shock_absorbers.jpg'),
    ('Alternator', 4, 139.99, 'High output alternator for reliable electrical power.', 50, 'images/alternator.jpg'),
    ('Muffler', 5, 49.99, 'Performance muffler to enhance exhaust flow.', 80, 'images/muffler.jpg'),
    ('Alloy Wheels', 6, 199.99, 'Stylish alloy wheels to enhance your car\'s appearance.', 40, 'images/alloy_wheels.jpg'),
    ('Front Bumper', 7, 149.99, 'Replacement front bumper for added protection.', 30, 'images/front_bumper.jpg'),
    ('Seat Covers', 8, 39.99, 'Comfortable and stylish seat covers for your car interior.', 120, 'images/seat_covers.jpg'),
    ('Air Filter', 1, 19.99, 'High-flow air filter for improved engine performance.', 160, 'images/air_filter.jpg'),
    ('Brake Disc', 2, 59.99, 'Precision-engineered brake disc for consistent stopping power.', 70, 'images/brake_disc.jpg'),
    ('Coil Spring', 3, 89.99, 'Heavy-duty coil springs for improved suspension.', 60, 'images/coil_spring.jpg'),
    ('Battery', 4, 89.99, 'Long-lasting battery for dependable vehicle start-up.', 90, 'images/battery.jpg'),
    ('Exhaust Manifold', 5, 99.99, 'Durable exhaust manifold for better exhaust flow.', 40, 'images/exhaust_manifold.jpg'),
    ('Tire', 6, 109.99, 'All-season tire for reliable traction and durability.', 100, 'images/tire.jpg'),
    ('Rear Bumper', 7, 159.99, 'Sturdy rear bumper for enhanced vehicle protection.', 25, 'images/rear_bumper.jpg'),
    ('Steering Wheel Cover', 8, 19.99, 'Grip-enhancing steering wheel cover for a comfortable driving experience.', 140, 'images/steering_wheel_cover.jpg')");
}

$conn->close();
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