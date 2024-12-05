<?php
require 'dbconnection.php';

// Initialize variables
$dateFilter = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d'); // Default to today's date if no date is selected

// Fetch attendance records for the selected date
$sql = "SELECT a.date, a.status, e.First_Name, e.Last_Name 
        FROM attendance a
        INNER JOIN employee e ON a.employee_id = e.id
        WHERE a.date = ?
        ORDER BY a.date ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dateFilter);
$stmt->execute();
$result = $stmt->get_result();

$attendance = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Records</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="icon" type="image/png" href="img/LOGO.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: black;
            color: white;
        }
        .filter-form {
            margin-bottom: 20px;
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
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <img src="img/LOGO.png" alt="Logo" style="width: 100%; height: auto; margin-bottom: 20px;">
            <a href="home.php">Home</a>
            <a href="employee.php">Employees</a>
            <a href="displayattendance.php">Attendance</a>
            <a href="report.php">Reports</a>
            <a href="index.php" onClick="return confirm('Are you sure you want to Logout?')">Log Out</a>
        </div>
        <div class="content">
            <h1>Employee Attendance Records</h1>
            <form method="GET" action="" class="filter-form">
                <label for="date">Select Date:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($dateFilter); ?>">
                <button type="submit">Filter</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($attendance)): ?>
                        <?php foreach ($attendance as $record): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($record['date']); ?></td>
                                <td><?php echo htmlspecialchars($record['First_Name'] . ' ' . $record['Last_Name']); ?></td>
                                <td><?php echo htmlspecialchars($record['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No attendance records found for <?php echo htmlspecialchars($dateFilter); ?>.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <form method="GET" action="generate_report.php">
             <button type="submit">Generate Report</button>
            </form>
        </div>
    </div>
</body>
</html>
