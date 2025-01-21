<?php
session_start();

// Check if the user is logged in and is a customer
if (!isset($_SESSION['user_id']) ) {
    header("location: login.php");
    
}

// Include database configuration file and Cart class
require_once 'config/database.php';
require_once 'objects/Cart.php';

// Initialize Cart object
$customer_id = $_SESSION['user_id'];
$cart = new Cart();

// Handle add to cart
if (isset($_POST['add-cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    if ($cart->addToCart($_SESSION['user_id'], $product_id, $quantity, $_POST['price'])) {
        $success_msg = "Product added to cart successfully.";
    } else {
        $error_msg = "Something went wrong. Please try again.";
    }
}

// Handle remove from cart
if (isset($_POST['action']) && $_POST['action'] == 'remove') {
    $product_id = $_POST['product_id'];
    if ($cart->removeFromCart($product_id)) {
        $success_msg = "Product removed from cart successfully.";
    } else {
        $error_msg = "Something went wrong. Please try again.";
    }
}

// Handle checkout
if (isset($_POST['place-order'])) {
    if ($cart->checkout($_SESSION['user_id'])) {
        $success_msg = "Checkout successful.";
    } else {
        $error_msg = "Something went wrong. Please try again.";
    }
}

// View cart contents
$cart_items = $cart->viewCart($_SESSION["user_id"]);

unset($pdo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div style="margin-top:200px;">
        <?php
            include 'templates/header.php';
        ?>

    </div>
<div class="wrapper">
   <h2>Shopping Cart</h2> 
   <table> 
    <thead>
       <tr>
     <th>Product Name</th>
    <th>Quantity</th>
     <th>Price</th>
     <th>Total Price</th> 
     <th>Actions</th>
     </tr> 
    </thead>
      <tbody>
         <?php foreach ($cart_items as $item) : ?> 
          <tr>
             <td><?php echo $item['product_name']; ?></td>
              <td><?php echo $item['quantity']; ?></td>
               <td><?php echo $item['price']; ?></td> 
               <td><?php echo $item['price'] * $item['quantity']; ?></td> 
               <td> 
                <form action="cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?php
                        echo $item['product_id']; ?>" 
                    >
                    <button data-product-id="<?php echo $item['id']; ?>" onclick="removeFromCart(<?php echo $item['id']; ?>)">Remove</button>
                </form>
               </td> 
              </tr> 
              <?php endforeach; ?> 
            </tbody> 
          </table>
          <form action="cart.php" method="post">
                <button id="checkoutButton" type="submit" name="place-order">Checkout</button> 
           </form>
</div>
    <? include 'templates/footer.php';?>
    <script src='scripts.js'></script>    
</body>
</html>
