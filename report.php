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
    <link rel="icon" type="image/png" href="img/LOGO.png">
    <style>
        /* Form Styling */
table {
    background-color: white;  /* White background */
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
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
    justify-content: flex-start;
    border-radius: 10px;

}

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

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #1f3d5b;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #1f3d5b;
            color: white;
            font-weight: bold;
        }

        tr:hover {
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
</head>
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

    <!-- Main Content -->
    <div class="content">
        <h1>Employee Attendance Records</h1>
        <form method="GET" action="">
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

</body>
</html>
