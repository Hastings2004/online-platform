<?php
class User extends Database{
    private $id;
    private $name;
    private $email;
    private $password;
    private $role;

    public function __construct($id, $name, $email, $password, $role) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password ? password_hash($password, PASSWORD_BCRYPT) : null;
        $this->role = $role;
    }

    public function register($pdo) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$this->name, $this->email, $this->password, $this->role]);
    }

    public function login($email, $password) {
        $stmt = $this -> connect()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        session_destroy();
    }


    // Code for sellers to manage their products
    public function manageProducts($pdo) {
        // Example: Fetch all products for the seller
        $stmt = $pdo->prepare("SELECT * FROM products WHERE seller_id = ?");
        $stmt->execute([$this->id]);
        return $stmt->fetchAll();
    }

    // Code for sellers to view orders placed by customers
    public function viewOrders($pdo) {
        // Example: Fetch all orders for the seller's products
        $stmt = $pdo->prepare(
            "SELECT orders.*, products.name AS product_name FROM orders 
             JOIN products ON orders.product_id = products.id 
             WHERE products.seller_id = ?"
        );
        $stmt->execute([$this->id]);
        return $stmt->fetchAll();
    }

    // Code for customers to browse products
    public function browseProducts($pdo) {
        // Example: Fetch all products
        $stmt = $pdo->query("SELECT * FROM products");
        return $stmt->fetchAll();
    }

    // Code for customers to place an order
    public function placeOrder($pdo, $productId, $quantity) {
        // Example: Place an order for a product
        $stmt = $pdo->prepare("INSERT INTO orders (product_id, customer_id, quantity, total_price) VALUES (?, ?, ?, ?)");
        $totalPrice = $this->calculateTotalPrice($pdo, $productId, $quantity);
        return $stmt->execute([$productId, $this->id, $quantity, $totalPrice]);
    }

    // Helper method to calculate total price of an order
    private function calculateTotalPrice($pdo, $productId, $quantity) {
        $stmt = $pdo->prepare("SELECT price FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch();
        return $product['price'] * $quantity;
    }

    // Code to search for products by name, category, or merchandise
    public function searchProducts($pdo, $query) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ? OR category LIKE ? OR merchandise LIKE ?");
        $searchQuery = '%' . $query . '%';
        $stmt->execute([$searchQuery, $searchQuery, $searchQuery]);
        return $stmt->fetchAll();
    }
}
