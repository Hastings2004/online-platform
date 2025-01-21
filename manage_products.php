<?php
session_start();

// Check if the user is logged in and is a seller
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'seller') {
    header("location: login.php");
    exit;
}

// Include database configuration file and Product class
require_once 'config/database.php';
require_once 'objects/Product.php';

// Initialize variables
$product_id = $name = $description = $price = $image = "";
$name_err = $description_err = $price_err = $image_err = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate product name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a product name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate product description
    if (empty(trim($_POST["description"]))) {
        $description_err = "Please enter a product description.";
    } else {
        $description = trim($_POST["description"]);
    }

    // Validate product price
    if (empty(trim($_POST["price"]))) {
        $price_err = "Please enter a product price.";
    } elseif (!is_numeric(trim($_POST["price"]))) {
        $price_err = "Please enter a valid price.";
    } else {
        $price = trim($_POST["price"]);
    }

    // Validate product image
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            $image_err = "Sorry, your file is too large.";
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $image_err = "Sorry, only JPG, JPEG & PNG files are allowed.";
        }
        // Check if $image_err is empty and move the uploaded file
        if (empty($image_err)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image = $target_file;
            } else {
                $image_err = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $image_err = "Please upload an image.";
    }

    // Check input errors before inserting/updating in database
    if (empty($name_err) && empty($description_err) && empty($price_err) && empty($image_err)) {
        // Initialize Product object
        $product = new Product();

        if (empty($_POST['product_id'])) {
            // Add a new product
            if ($product->addProduct($_SESSION['user_id'],$name, $description, $price, $image)) {
                $success_msg = "Product added successfully.";
            } else {
                $error_msg = "Something went wrong. Please try again.";
            }
        } else {
            // Update an existing product
            if ($product->updateProduct($pdo, $_POST['product_id'])) {
                $success_msg = "Product updated successfully.";
            } else {
                $error_msg = "Something went wrong. Please try again.";
            }
        }
    }

    unset($pdo);
}

// Fetch all products for the logged-in seller
$seller_id = $_SESSION['user_id'];
$product = new Product(null, $seller_id, null, null, null, null);
$products = $product->getAllProducts($pdo);

unset($pdo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>  
<div  style="margin-top:40%;">
    <?php
        include 'templates/header.php';
    ?>
     <div class="content" style="background-color:white; padding: 30px;"> 
        <h2>Manage Products</h2>
        <p>Add, update, delete, and view your products.</p>
        <?php 
        if (isset($success_msg)) {
            echo '<div class="alert alert-success">' . $success_msg . '</div>';
        }
        if (isset($error_msg)) {
            echo '<div class="alert alert-danger">' . $error_msg . '</div>';
        }
        ?>
        <form action="manage_products.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($description_err)) ? 'has-error' : ''; ?>">
                <label>Description</label>
                <textarea name="description" class="form-control"><?php echo $description; ?></textarea>
                <span class="help-block"><?php echo $description_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($price_err)) ? 'has-error' : ''; ?>">
                <label>Price</label>
                <input type="text" name="price" class="form-control" value="<?php echo $price; ?>">
                <span class="help-block"><?php echo $price_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($image_err)) ? 'has-error' : ''; ?>">
                <label>Image</label>
                <input type="file" name="image" class="form-control">
                <span class="help-block"><?php echo $image_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
        <h3>Your Products</h3>
        <table border="1" style="border-collapse: collapse; padding: 10px;">
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
                    <tr>
                        <td style="padding: 20px;"><?php echo $product['product_name']; ?></td>
                        <td style="padding: 20px;"><?php echo $product['description']; ?></td>
                        <td style="padding: 20px;"><?php echo $product['price']; ?></td>
                        <td style="padding: 20px;"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['product_name']; ?>" width="50"></td>
                        <td style="padding: 20px;">
                            <a href="manage_products.php?edit=<?php echo $product['id']; ?>">Edit</a>
                            <a href="delete_product.php?id=<?php echo $product['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?include 'templates/footer.php';?>
    <script src='scripts.js'></script>    
</body>
</html>
