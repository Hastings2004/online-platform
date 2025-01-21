<?php
session_start();

// Include database configuration file and Product class
require_once 'config/database.php';
require_once 'objects/Product.php';

// Initialize Product object
$product = new Product();

// Fetch all products
$products = $product->getAllProducts();

unset($pdo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    
<div  style="margin-top:40%;">
    <?php
        include 'templates/header.php';
    ?>
     <div class="content" style="background-color:white; padding: 30px;"> 
         
     <h2>Available Products</h2> 
     <?php foreach ($products as $product) : ?> 
     <div class="products" style="display: flex;">
       
        <form action="cart.php" method="post" style="width: fit-content; border:2px solid green; padding:20px; border-radius:10px">
          <div> 
          <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['product_name']; ?>" style="width: 100px; margin:30px;">
          <h3><?php echo $product['product_name']; ?></h3> 
          <p><?php echo $product['description']; ?></p> 
          <p>Price: $<?php echo $product['price']; ?></p> 
          <input type="number" name="quantity"  value="1" min="1">
          <input type="hidden" name="price" value="<?php
              echo $product['price'];
          ?>"> 
          <input type="hidden" name="product_id" value="<?php
              echo $product['id'];
          ?>">

          <button type="submit" name="add-cart">Add to Cart</button>
        </form> 
      </div>
          <?php endforeach; ?> 
          </div>
       
       </div> 
       </div>  
    <? include 'templates/footer.php';?>
    <script src='scripts.js'></script>    
</body>
</html>
