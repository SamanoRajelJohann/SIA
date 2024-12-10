<?php
// Include the database connection file
require_once("dbConnection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
            border-radius: 10px;
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

        /* Main content styling */
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
    gap: 20px; /* Adds space between cards */
}

/* Card container styling to organize cards */
.card-container {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap; /* Allow cards to wrap on smaller screens */
    margin-bottom: 20px; /* Space between the main content and the bottom card */
}

/* Styling for each intro-card */
.intro-cardA, .intro-cardB, .intro-cardC {
    background-color: white;
    color: black;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 45%; /* Allows two cards to be side by side */
    width: 100%;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align: left;
}

/* Position intro-cardC at the bottom center */
.intro-cardC {
    background-color: white;
    max-width: 600px;
    margin: 0 auto;
    width: 100%;
}

/* Card hover effects */
.intro-cardA:hover, .intro-cardB:hover, .intro-cardC:hover {
    transform: translateY(-5px);
}

/* Heading styles inside cards */
.intro-card h4 {
    font-size: 22px;
    margin-bottom: 10px;
    color: #2c3e50;
    border-bottom: 2px solid #3498db;
    padding-bottom: 5px;
}

/* Text inside cards */
.intro-card p {
    font-size: 16px;
    color: black;
    line-height: 1.6;
    text-align: justify;
}

/* Responsive Design */
@media (max-width: 768px) {
    .content {
        padding: 15px;
    }

    .card-container {
        flex-direction: column;
    }

    .intro-cardA, .intro-cardB {
        max-width: 100%; /* Stack cards vertically on smaller screens */
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

<!-- Main content -->
<div class="content">
    <h2>Welcome to Employee Management System</h2>
    <h3>Manage Your Workforce with Ease</h3>
     <div class="card-container">
    <div class="intro-cardA">
        <h4>About the System</h4>
        <p>The Employee Management System is designed to streamline employee management processes, allowing you to handle records, attendance, and reports effortlessly. Enjoy a user-friendly interface that enhances productivity and provides detailed insights at your fingertips.</p>
    </div>
    
    <div class="intro-cardB">
        <h4>Seamless Integration</h4>
        <p>This system integrates seamlessly with various tools and software, ensuring that your workflow remains smooth and uninterrupted. Whether you need to generate reports, track attendance, or manage employee data, everything is just a click away.</p>
    </div>

    <div class="intro-cardA">
        <h4>Real-Time Insights</h4>
        <p>Stay ahead with real-time analytics and insights. The system offers detailed reports and data visualizations to help you make informed decisions about your workforce, ensuring that you always have the information you need when you need it.</p>
    </div>

    <div class="intro-cardB">
        <h4>User-Centric Design</h4>
        <p>Designed with the user in mind, the interface is simple and intuitive, making it easy to navigate. The system reduces the need for training, so your team can start using it immediately without hassle.</p>
    </div>

    <div class="intro-cardC">
        <h4>Security First</h4>
        <p>Your data security is our top priority. The system is built with the latest security protocols, ensuring that sensitive information remains protected against unauthorized access. Stay confident knowing that your employee data is in safe hands.</p>
    </div>
</div>
</div>

</body>
</html>
