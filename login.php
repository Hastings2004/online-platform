<?php
session_start();
include 'config/database.php';
include 'objects/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = new User(null, null, $email, null, null);

    if ($user->login($email, $password)) {
        // Redirect to the dashboard
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
include 'templates/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
        #email, #password{
            border: 2px solid green;
            margin-right: 10px;
            width: 300px;
        }
      
    </style>
</head>
<body>
    <div class="login">
    <h2>Login</h2>
    <?php if (isset($error)) echo '<p>' . $error . '</p>'; ?>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Login" id="btn">
    </form>
    </div>
    <?include 'templates/footer.php';?>
    <script src='scripts.js'></script>
</body>
</html>
