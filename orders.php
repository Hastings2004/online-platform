<?php
session_start();

// Check if the user is logged in and is a seller
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'seller') {
    header("location: login.php");
    exit;
}

// Include database configuration file and Order class
require_once 'config/database.php';
require_once 'objects/Order.php';

// Fetch all orders for the logged-in seller
$seller_id = $_SESSION['user_id'];
$order = new Order();
$orders = $order->viewOrdersForSeller($_SESSION['user_id']);

unset($pdo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Orders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div  style="margin-top:75%;">
    <?php
        include 'templates/header.php';
    ?>
     <div class="content" style="background-color:white; padding: 30px;"> 
   
        <h2>View Orders</h2>
        <p>Orders placed by customers for your products.</p>
        <table border="1" style="border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Customer ID</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) : ?>
                    <tr>
                        <td style="padding: 20px;"> <?php echo $order['id']; ?></td>
                        <td style="padding: 20px;"><?php echo $order['product_name']; ?></td>
                        <td style="padding: 20px;"><?php echo $order['customer_id']; ?></td>
                        <td style="padding: 20px;"><?php echo $order['quantity']; ?></td>
                        <td style="padding: 20px;"><?php echo $order['total_price']; ?></td>
                        <td style="padding: 20px;"><?php echo $order['order_date']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> 
    <? include 'templates/footer.php';?>
    <script src='scripts.js'></script>   
</body>
</html>
