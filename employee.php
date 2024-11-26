<?php
// Include the database connection file
require_once("dbConnection.php");

// Fetch data in ascending order (Employee_ID)
$result = mysqli_query($conn, "SELECT * FROM employee ORDER BY Employee_ID ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employ Employee</title>
    <link rel="stylesheet" href="css/employee.css"> <!-- Link to external CSS -->
   
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
        <h2>EMPLOYEE LIST</h2>

        <div class="employee-container">
            <?php
            while ($res = mysqli_fetch_assoc($result)) {
                echo "<div class='employee-card'>";

                // Display the uploaded image (if available)
                if (!empty($res['Image'])) {
                    echo "<img src='img/".$res['Image']."' alt='Employee Image' class='employee-img'>";
                } else {
                    echo "<img src='images/default.jpg' alt='Default Image' class='employee-img'>"; // Default image if no image uploaded
                }

                // Employee information
                echo "<div class='employee-details'>";
                echo "<h2>".$res['First_Name']." ".$res['Last_Name']."</h2>";
                echo "<p>Employee ID: ".$res['Employee_ID']."</p>";
                echo "<p>Age: ".$res['Age']."</p>";
                echo "<p>Email: ".$res['E-mail']."</p>";
                echo "<p>Address: ".$res['Address']."</p>";

                // Edit and Delete links
                echo "<div class='employee-actions'>";
                echo "<a href='edit.php?id=".$res['id']."' class='edit-btn'>Edit</a>";
                echo " | ";
                echo "<a href='del.php?id=".$res['id']."' class='delete-btn' onClick='return confirm(\"Are you sure you want to delete?\")'>Delete</a>";
                echo "</div>"; // employee-actions

                echo "</div>"; // employee-details
                echo "</div>"; // employee-card
            }
            ?>
        </div> <!-- employee-container -->

        <p class="Addbutton"><a class="add-button" href="add.php">Add New Employee</a></p>
    </div>

</body>
</html>
