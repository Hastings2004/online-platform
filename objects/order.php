<?php

class Order extends Database {
    private $id;
    private $product_id;
    private $customer_id;
    private $quantity;
    private $total_price;
    private $order_date;

    public function __construct() {
        /*$this->id = $id;
        $this->product_id = $product_id;
        $this->customer_id = $customer_id;
        $this->quantity = $quantity;
        $this->total_price = $total_price;
        $this->order_date = $order_date;*/
    }

    // Place an order
    public function placeOrder($pdo) {
        $stmt = $this -> connect()->prepare("INSERT INTO orders (product_id, user_id, quantity, total_price, order_date) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$this->product_id, $this->customer_id, $this->quantity, $this->total_price, $this->order_date]);
    }

    // View all orders for a specific customer
    public function viewOrders($customer_id) {
        $stmt = $this -> connect() ->prepare("SELECT * FROM `orders`
         INNER JOIN products ON orders.product_id = products.id WHERE orders.customer_id =? ORDER BY orders.id DESC limit 10");
        $stmt->execute([$customer_id]);
        return $stmt->fetchAll();
    }

    // View all orders for a specific seller
    public function viewOrdersForSeller($seller_id) {
        $stmt = $this -> connect()->prepare(
            "SELECT * FROM users INNER JOIN orders ON users.id = orders.customer_id INNER JOIN products AS product_name JOIN products ON orders.product_id = products.id WHERE products.user_id = ? ORDER BY orders.id DESC limit 10"
        );
        $stmt->execute([$seller_id]);
        return $stmt->fetchAll();
    }

    // Update the status of an order
    public function updateOrderStatus($pdo, $order_id, $status) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $order_id]);
    }
}
