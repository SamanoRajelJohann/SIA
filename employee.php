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
    <link rel="icon" type="image/png" href="img/LOGO.png">
</head>
<style>
    /* Sidebar styling */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: rgba(58, 74, 97, 0.9);
            padding: 20px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
        }

        .sidebar img {
            border-radius: 10px; /* Add rounded corners to sidebar images */
            margin-bottom: 30px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 15px;
            margin-bottom: 15px;
            text-align: left;
            border-radius: 4px;
            transition: background-color 0.3s ease, padding-left 0.3s ease;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            padding-left: 25px;
        }
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    margin: 0;
    padding: 0;
    color: white;
    font-family: Arial, sans-serif;
    height: 100vh;
    display: flex;
    overflow: hidden;
}

html, body {
    height: 100%;
}

body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(rgb(94, 143, 157), rgb(43, 43, 98));
    z-index: -1;
}
.content {
    margin-left: 270px;
    padding: 20px;
    width: calc(100% - 270px);
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100vh;
    overflow: auto;
    position: relative;
}

/* Position the Add New Employee button at the top-left corner */
.add-button {
    position: absolute;
    top: 20px;
    left: 20px;
    background-color: #506178;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s;
}

.add-button:hover {
    background-color: #48526b;
}

.employee-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin: 80px auto 20px; /* Adjusted margin to account for the Add button */
    max-width: 1000px;
}

@media (max-width: 800px) {
    .employee-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 500px) {
    .employee-container {
        grid-template-columns: 1fr;
    }
}

.employee-card {
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 16px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s;
    background-color: rgba(255, 255, 255, 0.05);
    width: 100%;
}

.employee-card:hover {
    transform: scale(1.05);
}

.employee-img {
    width: 100%;
    height: 400px;
    object-fit: cover;
    border-radius: 8px;
}

.employee-details {
    text-align: left; /* Align details to the left */
}

.employee-details h2 {
    font-size: 1.5em;
    margin: 10px 0;
    color: #fff;
    text-align: center;
}

.employee-details p {
    font-size: 1em;
    margin: 6px 0;
    color: #ccc;
}

.employee-actions {
    margin-top: 10px;
    text-align: center; /* Center the buttons */
}

.edit-btn, .delete-btn {
    padding: 10px 20px; /* Same padding for both buttons */
    text-decoration: none;
    color: white;
    background-color: #007BFF;
    border-radius: 4px;
    transition: background-color 0.3s;
    width: 100px; /* Same width for both buttons */
    text-align: center; /* Center text */
    display: inline-block; /* Ensures buttons align properly */
}

.delete-btn {
    background-color: #DC3545;
}

.edit-btn:hover, .delete-btn:hover {
    opacity: 0.8;
}

</style>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <img src="img/LOGO.png" alt="Logo" style="width: 100%; height: auto; margin-bottom: 20px;">
    <a href="home.php">Home</a>
    <a href="employee.php">Employees</a>
    <a href="displayattendance.php">Attendance</a>
    <a href="report.php">Reports</a>
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
                echo "<p>Email: ".$res['Email']."</p>";
                echo "<p>Address: ".$res['Address']."</p>";
                echo "<p>Salary: ".$res['Salary']."</p>";

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
