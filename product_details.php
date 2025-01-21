<?php
session_start();

// Include database configuration file and Product class
require_once 'config/database.php';
require_once 'objects/Product.php';

// Initialize variables
$product_id = isset($_GET['id']) ? $_GET['id'] : "";

// Fetch product details
$product = new Product(null, null, null, null, null, null);
$product_details = $product->viewProduct($pdo, $product_id);

if (!$product_details) {
    echo "Product not found.";
    exit;
}

unset($pdo);
include 'templates/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="wrapper">
   <h2>Product Details</h2> 
   <div class="product-details">
     <img src="<?php echo $product_details['image']; ?>" alt="<?php echo $product_details['name']; ?>"> 
     <h3><?php echo $product_details['name']; ?></h3> 
     <p><?php echo $product_details['description']; ?></p>
      <p>Price: $<?php echo $product_details['price']; ?></p> 
      <input type="number" id="quantityInput" value="1" min="1"> 
      <button data-product-id="<?php echo $product_details['id']; ?>" onclick="addToCart(<?php echo $product_details['id']; ?>, document.getElementById('quantityInput').value)">Add to Cart</button>
     </div>
          <a href="browse_products.php">Back to Browse Products</a>
    </div>
    <? include 'templates/footer.php';?>
    <script src='scripts.js'></script>    
</body>
</html>
