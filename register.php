<?php
session_start();
include 'config/database.php';
include 'objects/user.php';

$database = new Database();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $role = $_POST['role']; // Get the selected role

    $stmt = $database -> connect()->prepare('SELECT * FROM `users` WHERE email = ?');
    $stmt->execute([$email]);

    if ($stmt -> rowCount() > 0) {
        echo "user already exists";
        exit();
    }

    
    try {
        // Insert the new user into the database
        $query = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $database->connect() ->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        
        // Registration successful, redirect to login page
        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        $error = "Registration failed: " . $e->getMessage();
    }
}
include 'templates/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        .login {
            border: 2px solid green;
            width: 350px;
            height: fit-content;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
        }
        #btn {
            border: 2px solid green;
            background-color: green;
            color: white;
            width: 320px;
            margin-right: 10px;
            height: 30px;
            border-radius: 10px;
            cursor: pointer;
        }
        #email, #password, #name, #role{
            border: 2px solid green;
            margin-right: 10px;
            width: 300px;
        }
      
    </style>
</head>
<body>
<div class="login">
    <h2>Register</h2>
    <?php if (isset($error)) echo '<p>' . $error . '</p>'; ?>
    <form action="register.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        
        <label for="role">Role:</label>
        <select id="role" name="role" >
            <option value="buyer">Buyer</option>
            <option value="seller">Seller</option>
        </select><br>
        
        <input type="submit" value="Register" class="btn">
    </form>
    <?include 'templates/footer.php';?>
    <script src='script.js'></script>
</body>
</html>
