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
       /* Global Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    color: white;
    height: 100vh;
    display: flex;
    background: linear-gradient(135deg, #607d8b, #3b1f5e);
    overflow: hidden;
}

html, body {
    height: 100%;
}

/* Background overlay */
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

/* Content Section */
.content {
    margin-left: 270px;
    padding: 20px;
    width: calc(100% - 270px);
    display: flex;
    flex-direction: column;
    height: 100vh;
    overflow: auto;
    position: relative;
    justify-content: flex-start;
    border-radius: 10px;
}

/* Form Styling */
.form-container {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
}

label {
    font-weight: bold;
    margin-bottom: 10px;
    display: block;
}

select, input[type="number"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ddd;
    font-size: 14px;
}

/* Table Styling */
.employee-list table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    color: #1f3d5b;
}

.employee-list th, .employee-list td {
    border: 1px solid #ddd;
    padding: 15px;
    text-align: left;
    font-size: 14px;
}

.employee-list th {
    background-color: #1f3d5b;
    color: white;
    font-weight: bold;
}

.employee-list tr:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

/* Button Styling */
button {
    background-color: #0066CC;
    color: white;
    padding: 12px 20px;
    border-radius: 5px;
    border: none;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 120px;
    margin-top: 20px;
}

button:hover {
    background-color: #004b8e;
}

/* Responsive Design */
@media (max-width: 768px) {
    .sidebar {
        width: 200px;
    }

    .content {
        margin-left: 220px;
    }

    button {
        width: 100%;
    }
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
