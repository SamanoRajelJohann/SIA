<?php
require 'config.php';

$name = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';

$sql = "SELECT date, status FROM attendance WHERE employee_name = '$name'";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}

$attendance = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $attendance[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report for <?php echo htmlspecialchars($name); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Attendance Report for <?php echo htmlspecialchars($name); ?></h1>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Attendance Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($attendance)): ?>
                    <?php foreach ($attendance as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['date']); ?></td>
                            <td><?php echo htmlspecialchars($record['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No attendance records found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
