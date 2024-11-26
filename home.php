<?php
// Include the database connection file
require_once("dbConnection.php");

// Fetch data in ascending order based on Employee ID
$result = mysqli_query($conn, "SELECT * FROM employee ORDER BY Employee_ID ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <img src="img/LOGO.png" alt="Logo" style="width: 100%; height: auto; margin-bottom: 20px;">
    <a href="home.php">Home</a>
    <a href="employee.php">Employees</a>
    <a href="displayattendance.php">Attendance</a>
    <a href="#">Reports</a>
    <a href="index.php" onClick="return confirm('Are you sure you want to Logout?')">Log Out</a>
</div>

<!-- Main content -->
<div class="content">
    <h2>Welcome to Employee Management System</h2>
    <h3>Here you can manage your employees efficiently</h3>
    
</div> <!-- content -->

</body>
</html>
