<?php
// Database connection
include_once("dbconnection.php");

// When form is submitted, save the attendance
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];

    foreach ($_POST['employee'] as $employee_id => $data) {
        $time = $data['time'];
        $status = $data['status'];
        $late_hours = intval($data['late_hours']);
        $late_minutes = intval($data['late_minutes']);
        $overtime_hours = intval($data['overtime_hours']);
        $overtime_minutes = intval($data['overtime_minutes']);

        // Insert or update the attendance record
        $sql = "INSERT INTO attendance (employee_id, time, date, status, late_hours, late_minutes, overtime_hours, overtime_minutes)
                VALUES ('$employee_id', '$time', '$date', '$status', '$late_hours', '$late_minutes', '$overtime_hours', '$overtime_minutes')
                ON DUPLICATE KEY UPDATE 
                    status='$status', 
                    late_hours='$late_hours', 
                    late_minutes='$late_minutes',
                    overtime_hours='$overtime_hours', 
                    overtime_minutes='$overtime_minutes'";

        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Attendance</title>
    <link rel="icon" type="image/png" href="img/LOGO.png">
    <style>
        .form-container {
            margin-bottom: 30px;
        }
        .employee-list table {
            margin-right: 100px;
            width: 100%;
            border-collapse: collapse;
        }
        .employee-list th, .employee-list td {
            border: 1px solid #ddd;
            padding: 20px;
            
        }
        .employee-list th {
            background-color: black;
            font-weight: bold;
        } 
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
        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            margin-bottom: 10px;
            text-align: left;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }  
        .sidebar img {
            border-radius: 10px; /* Add rounded corners to sidebar images */
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
            height: 100vh;
            overflow: auto;
            position: relative;
            justify-content: flex-start; /* Keeps content at the top */
            text-align: left; /* Aligns text to the right */
        }
        button {
            padding: 10px 20px; /* Same padding for both buttons */
            margin-top: 10px;
            text-decoration: none;
            color: white;
            background-color: #0066CC;
            border-radius: 4px;
            transition: background-color 0.3s;
            width: 100px; /* Same width for both buttons */
        }
        button:hover {
            background-color:#0153a5;
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


    <!-- Main Content -->
    <div class="content">
    <div class="sidebar">
    <img src="img/LOGO.png" alt="Logo" style="width: 100%; height: auto; margin-bottom: 20px;">
    <a href="home.php">Home</a>
    <a href="employee.php">Employees</a>
    <a href="displayattendance.php">Attendance</a>
    <a href="report.php">Reports</a>
    <a href="index.php" onClick="return confirm('Are you sure you want to Logout?')">Log Out</a>
</div>
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

    <!-- Updated Employee List with Hours and Minutes -->
<div class="employee-list">
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Time</th>
                <th>Status</th>
                <th>Late (Hours:Minutes)</th>
                <th>Overtime (Hours:Minutes)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT id, First_Name, Last_Name FROM employee");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['First_Name']) . " " . htmlspecialchars($row['Last_Name']) . "</td>";
                echo "<td>
                        <select name='employee[" . $row['id'] . "][time]' required>
                            <option value='AM'>AM</option>
                            <option value='PM'>PM</option>
                        </select>
                      </td>";
                echo "<td>
                        <label>
                            <input type='radio' name='employee[" . $row['id'] . "][status]' value='Present' required> Present
                        </label>
                        <label>
                            <input type='radio' name='employee[" . $row['id'] . "][status]' value='Absent'> Absent
                        </label>
                      </td>";
                echo "<td>
                        <input type='number' name='employee[" . $row['id'] . "][late_hours]' min='0' max='12' placeholder='HH' style='width: 50px;' required>:
                        <input type='number' name='employee[" . $row['id'] . "][late_minutes]' min='0' max='59' placeholder='MM' style='width: 50px;' required>
                      </td>";
                echo "<td>
                        <input type='number' name='employee[" . $row['id'] . "][overtime_hours]' min='0' max='12' placeholder='HH' style='width: 50px;' required>:
                        <input type='number' name='employee[" . $row['id'] . "][overtime_minutes]' min='0' max='59' placeholder='MM' style='width: 50px;' required>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>


                <button type="submit" class="submit-btn">Save</button>
            </form>
        </div>
    </div>
</body>
</html>
