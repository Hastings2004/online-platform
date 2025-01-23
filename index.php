<?php
session_start();
?>

<?php include 'templates/header.php'; ?>

<link rel="stylesheet" href="home.css">
<link rel="stylesheet" href="styles.css">

<div class="wrapper">
    <h2>Welcome to Online Platform</h2>
    <p>This is the place where you can buy and sell products with ease.</p>
    
    <?php if (!isset($_SESSION['user_id'])): ?>
        <p>Please <a href="login.php">login</a> or <a href="register.php">register</a> to get started.</p>
    <?php else: ?>
        <p>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
        
        <?php if ($_SESSION['user_role'] === 'seller'): ?>
            <ul>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="orders.php">View Orders</a></li>
            </ul>
        <?php else: ?>
            <ul>
                <li><a href="browse_products.php">Browse Products</a></li>
                <li><a href="cart.php">View Cart</a></li>
            </ul>
        <?php endif; ?>
        
        <p><a href="dashboard.php">Go to Dashboard</a> | <a href="logout.php">Logout</a></p>
    <?php endif; ?>
</div>

<?php include 'templates/footer.php'; ?>
