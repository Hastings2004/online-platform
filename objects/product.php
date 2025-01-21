<?php

class Product extends Database{
    private $product_id;
    private $user_id;
    private $name;
    private $description;
    private $price;
    private $image;

    public function __construct() {
        /*$this->product_id = $id;
        $this->user_id = $user_id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->image = $image;*/
    }

    // Add a new product
    public function addProduct($user_id,$name, $description, $price, $image) {
        $stmt = $this-> connect()->prepare("INSERT INTO products (user_id, product_name, description, price, image) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$user_id, $name, $description, $price, $image]);
    }

    // Update an existing product
    public function updateProduct($pdo, $product_id) {
        $stmt = $this-> connect()->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ? AND seller_id = ?");
        return $stmt->execute([$this->name, $this->description, $this->price, $this->image, $product_id, $this->user_id]);
    }

    // Delete a product
    public function deleteProduct($user_id, $productId) {
        $stmt = $this-> connect()->prepare("DELETE FROM products WHERE id = ? AND user_id = ?");
        return $stmt->execute([$productId, $user_id]);
    }

    // View a specific product
    public function viewProduct($pdo, $product_id) {
        $stmt = $this-> connect() ->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        return $stmt->fetch();
    }

    // Get all products for a seller
    public function getAllProducts() {
        $stmt = $this -> connect()->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Search for products by name, category, or merchandise
    public function searchProducts($pdo, $query) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ? OR category LIKE ?");
        $searchQuery = '%' . $query . '%';
        $stmt->execute([$searchQuery, $searchQuery, $searchQuery]);
        return $stmt->fetchAll();
    }
}
