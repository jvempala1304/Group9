<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') : 'Automobile Parts Store'; ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap">

</head>
<body>
    <header>
        <div class="logo">
            <a href="index.php"><img src="../images/logo.jpg" alt="Automobile Parts Store Logo"></a>
        </div>
        <div class="titlee"><a href="index.php"><p>Auto Parts Store</p></a></div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id']): ?>
					<li><a href="product.php">Products</a></li>
					<li><a href="cart.php">Cart</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
