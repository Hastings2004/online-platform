<?php

class Cart extends Database{
    private $id;
    private $customer_id;

    public function __construct() {
       
    }

    // Add a product to the cart
    public function addToCart($user_id, $product_id, $quantity, $price) {
        $stmt = $this -> connect() ->prepare("INSERT INTO cart_items (customer_id, product_id, quantity,price) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$user_id, $product_id, $quantity, $price]);
    }

    // View the contents of the cart
    public function viewCart($user_id) {
        $stmt = $this -> connect()->prepare("SELECT * FROM `cart_items` 
        INNER JOIN products ON cart_items.product_id = products.id WHERE cart_items.customer_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }

    // Remove a product from the cart
    public function removeFromCart($product_id) {
        $stmt = $this -> connect()->prepare("DELETE FROM cart_items WHERE  product_id = ? LIMIT 1");
        return $stmt->execute([$product_id]);
    }

    // Checkout the cart
    public function checkout($user_id) {
        // Example: Create orders from cart items and clear the cart
        $stmt = $this -> connect()->prepare("SELECT * FROM cart_items WHERE customer_id = ?");
        $stmt->execute([$user_id]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cartItems as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $total = $item['price'] * $item['quantity'];
            $stmt = $this -> connect()->prepare("INSERT INTO orders (product_id, customer_id, quantity, total_price)VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $product_id, 
                $user_id, 
                $quantity, 
                $total
            ]);
        }
        // Clear the cart
        $stmt =$this -> connect() ->prepare("DELETE FROM cart_items WHERE customer_id = ?");
        return $stmt->execute([$user_id]);
    }
}
