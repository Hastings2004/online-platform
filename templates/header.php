<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Platform</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js" defer></script>
</head>
<body>
    <header>
        <h1>Online Platform</h1>
        <nav >
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['user_role'] === 'seller'): ?>
                        <li><a href="manage_products.php">Manage Products</a></li>
                        <li><a href="orders.php">Orders</a></li>
                    <?php else: ?>
                        <li><a href="browse_products.php">Browse Products</a></li>
                        <li><a href="cart.php">Cart</a></li>
                    <?php endif; ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
