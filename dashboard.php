<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

// Include database configuration file and necessary classes
require_once 'config/database.php';
require_once 'objects/User.php';
require_once 'objects/Product.php';
require_once 'objects/Order.php';

// Get user details
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_role = $_SESSION['user_role'];

// Initialize objects
$product = new Product();
$order = new Order();

if ($user_role === 'seller') {
    // Fetch seller-specific data
    $products = $product->getAllProducts();
    $orders = $order->viewOrdersForSeller($_SESSION['user_id']);
} else {
    // Fetch customer-specific data
    $orders = $order->viewOrders($_SESSION['user_id']);
}

if(isset($_POST['delete'])){
    $product ->deleteProduct($_POST['product_id'], $_SESSION['user_id']);
}
unset($pdo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
   

<div  style="margin-top:100%;">
    <?php
        include 'templates/header.php';
    ?>
     <div class="content"> 
   
    
        <div style="background-color:white; padding: 30px;">
        <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
        <p>This is your dashboard.</p>
        
        <?php if ($user_role === 'seller'): ?>
            <h3>Your Products</h3>
            <table border="1" style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) : ?>
                        <tr >
                            <td style="padding: 20px;"><?php echo htmlspecialchars($product['product_name']); ?></td>
                            <td style="padding: 20px;"><?php echo htmlspecialchars($product['description']); ?></td>
                            <td style="padding: 20px;" ><?php echo htmlspecialchars($product['price']); ?></td>
                            <td style="padding: 20px;"><img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" style="width: 100px;"></td>
                            <td style="padding: 20px;">
                                <a href="manage_products.php?edit=<?php echo $product['id']; ?>">Edit</a>
                                <form action="dashboard.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>
                                ">
                                <button type="submit" name="delete">delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Your Orders</h3>
            <table border="1" style="border-collapse: collapse; padding: 10px;">
                <thead>
                    <tr>
                        <th style="padding: 20px;">Order ID</th>
                        <th style="padding: 20px;">Customer Name</th>
                        <th style="padding: 20px;">Customer email</th>
                        <th style="padding: 20px;">Product</th>
                        <th style="padding: 20px;">Quantity</th>
                        <th style="padding: 20px;">Total Price</th>
                        <th style="padding: 20px;">Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) : ?>
                        <tr>
                            <td style="padding: 20px;"><?php echo htmlspecialchars($order['id']); ?></td>
                            <td style="padding: 20px;"><?php echo htmlspecialchars($order['name']); ?></td>
                            <td style="padding: 20px;"><?php echo htmlspecialchars($order['email']); ?></td>
                            <td style="padding: 20px;"><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td style="padding: 20px;"><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td style="padding: 20px;"><?php echo htmlspecialchars($order['total_price']); ?></td>
                            <td style="padding: 20px;"><?php echo htmlspecialchars($order['order_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <h3>Your Orders</h3>
            <table border="1" style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['id']); ?></td>
                            <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($order['total_price']); ?></td>
                            <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <p><a href="logout.php">Logout</a></p>
    </div> 
    </div>
    <? include 'templates/footer.php';?>
    <script src= 'scripts.js'></script>  
</body>
</html>
