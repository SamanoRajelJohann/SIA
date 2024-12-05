<?php
// Include the function.php file which contains the login function
require_once 'functions.php';

// Establish the database connection
$conn = dbconnection();

// Call the login function to process the login request
login($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/png" href="img/LOGO.png">
</head>
<body>
    
    <!-- The form action points to index.php so the same page handles the login -->
    <form action="index.php" method="POST">
        <h2>Login</h2>
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required><br><br>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Login">
</form>

</body>
</html>
