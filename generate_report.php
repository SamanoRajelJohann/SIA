<?php
// Include FPDF Library
require('fpdf/fpdf.php');

// Database Connection
$servername = "localhost";
$username = "root";  // Use your DB username
$password = "";      // Use your DB password
$dbname = "EMS";     // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch attendance and employee data
$query = "
    SELECT 
        e.Employee_ID, 
        CONCAT(e.First_Name, ' ', e.Last_Name) AS Name, 
        e.Salary, 
        a.date, 
        a.status, 
        a.late_hours, 
        a.late_minutes, 
        a.overtime_hours, 
        a.overtime_minutes
    FROM employee e
    LEFT JOIN attendance a ON e.Employee_ID = a.employee_id
    ORDER BY e.Employee_ID, a.date
";
$result = $conn->query($query);

// Check if query execution is successful
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Define deduction and addition rules
$daily_deduction = 1 / 30; // Deduction as a fraction of the monthly salary
$hourly_deduction = $daily_deduction / 8;
$minute_deduction = $hourly_deduction / 60;
$overtime_rate_per_hour = 50; // Overtime rate per hour
$overtime_rate_per_minute = $overtime_rate_per_hour / 60;

// Process data for report
$employee_data = [];
while ($row = $result->fetch_assoc()) {
    $id = $row['Employee_ID'];

    // Ensure employee data exists
    if (!isset($employee_data[$id])) {
        $employee_data[$id] = [
            'Name' => $row['Name'],
            'Salary' => $row['Salary'],
            'Deductions' => 0,
            'Additions' => 0,
        ];
    }

    // Fetch values with defaults for safety
    $late_hours = isset($row['late_hours']) ? $row['late_hours'] : 0;
    $late_minutes = isset($row['late_minutes']) ? $row['late_minutes'] : 0;
    $overtime_hours = isset($row['overtime_hours']) ? $row['overtime_hours'] : 0;
    $overtime_minutes = isset($row['overtime_minutes']) ? $row['overtime_minutes'] : 0;
    $status = $row['status'];

    // Handle absent status
    if ($status == 'Absent') {
        $employee_data[$id]['Deductions'] += $row['Salary'] * $daily_deduction;
    }

    // Handle present status with lateness or overtime
    if ($status == 'Present') {
        // Deduct for lateness
        if ($late_hours > 0 || $late_minutes > 0) {
            $employee_data[$id]['Deductions'] += ($late_hours * $row['Salary'] * $hourly_deduction) +
                                                 ($late_minutes * $row['Salary'] * $minute_deduction);
        }

        // Add for overtime
        if ($overtime_hours > 0 || $overtime_minutes > 0) {
            $employee_data[$id]['Additions'] += ($overtime_hours * $overtime_rate_per_hour) +
                                                ($overtime_minutes * $overtime_rate_per_minute);
        }
    }
}

// Final calculation for each employee
foreach ($employee_data as $id => &$data) {
    $data['FinalSalary'] = $data['Salary'] + $data['Additions'] - $data['Deductions'];
}
unset($data); // Clean up reference

// Initialize FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);

// Report Title
$pdf->Cell(190, 10, 'Employee Income Report', 0, 1, 'C');

// Table Header
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Employee ID', 1);
$pdf->Cell(70, 10, 'Name', 1);
$pdf->Cell(35, 10, 'Final Salary', 1);
$pdf->Ln();

// Table Data
$pdf->SetFont('Arial', '', 12);
foreach ($employee_data as $id => $data) {
    $pdf->Cell(50, 10, $id, 1);
    $pdf->Cell(70, 10, $data['Name'], 1);
    $pdf->Cell(35, 10, number_format($data['FinalSalary'], 2), 1);
    $pdf->Ln();
}

// Output PDF
$pdf->Output();

$conn->close();
?>
