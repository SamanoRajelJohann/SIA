<?php
// Database connection
include_once("dbconnection.php");

// When form is submitted, save the attendance
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];

    foreach ($_POST['employee'] as $employee_id => $status) {
        $present = isset($status['present']) ? 'Present' : 'Absent';
        $late = isset($status['late']) ? 1 : 0;
        $overtime = isset($status['overtime']) ? 1 : 0;

        // Insert into attendance table
        $sql = "INSERT INTO attendance (employee_id, date, status, late, overtime)
                VALUES ('$employee_id', '$date', '$present', '$late', '$overtime')
                ON DUPLICATE KEY UPDATE status='$present', late='$late', overtime='$overtime'";

        mysqli_query($conn, $sql);
    }

    echo "Attendance saved successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Attendance</title>
    <link rel="stylesheet" href="css/home.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            padding-top: 20px;
        }
        .sidebar img {
            display: block;
            margin: 0 auto;
            width: 80%;
            height: auto;
            margin-bottom: 20px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 5px 0;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
        }
        .form-container {
            margin-bottom: 30px;
        }
        .employee-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .employee-list th, .employee-list td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .employee-list th {
            background-color: black;
            font-weight: bold;
        }
        .employee-list tr:hover {
            background-color: #f1f1f1;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        // Function to count the statuses
        function countStatus(status) {
            let count = document.querySelectorAll('input[name*="' + status + '"]:checked').length;
            document.getElementById(status + 'Count').innerText = count;
        }

        // Display selected date dynamically
        function updateDate() {
            let selectedDate = document.getElementById('attendanceDate').value;
            document.getElementById('displayDate').innerText = selectedDate;
        }
    </script>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="img/LOGO.png" alt="Logo">
        <a href="home.php">Home</a>
        <a href="employee.php">Employees</a>
        <a href="displayattendance.php">Attendance</a>
        <a href="#">Reports</a>
        <a href="index.php" onClick="return confirm('Are you sure you want to Logout?')">Log Out</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <!-- Date Selector -->
        <div class="form-container">
            <form method="post" action="">
                <label for="date">Select Date:</label>
                <select id="attendanceDate" name="date" onChange="updateDate()" required>
                    <?php
                    // Loop for days of the month (e.g., 1 to 31)
                    for ($i = 1; $i <= 31; $i++) {
                        echo "<option value='" . date('Y-m-') . sprintf('%02d', $i) . "'>" . date('Y-m-') . sprintf('%02d', $i) . "</option>";
                    }
                    ?>
                </select>
                <p>Date Selected: <span id="displayDate"><?php echo date('Y-m-d'); ?></span></p>

                <!-- Employee List with Checkboxes for Attendance and Statuses -->
                <div class="employee-list">
                    <table>
                        <tr>
                            <th>Employee</th>
                            <th>Present</th>
                            <th>Absent</th>
                            <th>Late</th>
                            <th>Overtime</th>
                        </tr>
                        <?php
                        // SQL query to fetch all employees from the database
                        $result = mysqli_query($conn, "SELECT id, First_Name, Last_Name FROM employee");
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>".$row['First_Name']." ".$row['Last_Name']."</td>";
                            echo "<td><input type='radio' name='employee[".$row['id']."][present]' onClick='countStatus(\"present\")'></td>";
                            echo "<td><input type='radio' name='employee[".$row['id']."][absent]' onClick='countStatus(\"absent\")'></td>";
                            echo "<td><input type='radio' name='employee[".$row['id']."][late]' onClick='countStatus(\"late\")'></td>";
                            echo "<td><input type='radio' name='employee[".$row['id']."][overtime]' onClick='countStatus(\"overtime\")'></td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>

                <!-- Display total present, absent, late, and overtime counts -->
                <p>Total Present: <span id="presentCount">0</span></p>
                <p>Total Absent: <span id="absentCount">0</span></p>
                <p>Total Late: <span id="lateCount">0</span></p>
                <p>Total Overtime: <span id="overtimeCount">0</span></p>

                <!-- Save Attendance Button -->
                <button type="submit">Save Attendance</button>
            </form>
        </div>
    </div>
</body>
</html>
