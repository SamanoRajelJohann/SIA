<?php
// Include the database connection file
require_once("dbConnection.php");

// Get id from URL parameter and ensure it's an integer
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Prepare the SQL query to select user data
    $result = mysqli_query($conn, "SELECT * FROM employee WHERE id = $id");

    // Check if data was found
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the data as an associative array
        $resultData = mysqli_fetch_assoc($result);

        // Assign the values from the database to variables
        $employee_id = $resultData['Employee_ID'];
        $first_name = $resultData['First_Name'];
        $last_name = $resultData['Last_Name'];
        $age = $resultData['Age'];
        $email = $resultData['E-mail'];
        $address = $resultData['Address'];
    } else {
        echo "No user found with the provided ID.";
        exit;
    }
} else {
    echo "Invalid ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link rel="stylesheet" href="css/add.css">
</head>
<body>
    <div class="sidebar">
        <img src="img/LOGO.png" alt="Logo" style="width: 100%; height: auto; margin-bottom: 20px;">
        <a href="home.php">Home</a>
        <a href="employee.php">Employees</a>
        <a href="#">Attendance</a>
        <a href="#">Reports</a>
        <a href="index.php" onClick="return confirm('Are you sure you want to Logout?')">Log Out</a>
    </div>

    <div class="content">
        <form name="edit" method="post" action="edit_employee.php" class="employee-form">
            <div class="form-group">
                <div class="form-field">
                    <label for="employee_id">Employee ID:</label>
                    <input type="text" name="employee_id" value="<?php echo htmlspecialchars($employee_id); ?>" readonly>
                </div>
                <div class="form-field">
                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="form-field">
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>">
                </div>
                <div class="form-field">
                    <label for="age">Age:</label>
                    <input type="number" name="age" value="<?php echo htmlspecialchars($age); ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="form-field">
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="form-field">
                    <label for="address">Address:</label>
                    <textarea name="address"><?php echo htmlspecialchars($address); ?></textarea>
                </div>
            </div>
       

                    <input type="submit" name="update" value="Update" class="submit-btn">
    
            </div>
        </form>
    </div>
</body>
</html>
