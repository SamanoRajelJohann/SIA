<?php
function dbconnection(){
    $servername = "localhost";
    $username = "root";  
    $password = "";     
    $dbname = "EMS"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function login($conn){
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        print_r($_POST); // Debugging to see if data is received
        
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            
            // Direct comparison (not secure, just for testing)
            $query = "SELECT * FROM accounts WHERE email = '$email'";
            $result = mysqli_query($conn, $query);
        
            if (mysqli_num_rows($result) == 1) {
                $user = mysqli_fetch_assoc($result);
                
                // Simple comparison (not hashed)
                if ($password === $user['Password']) {
                    $_SESSION['email'] = $user['Email'];
                    header('Location: home.php');
                    exit;
                } else {
                    echo "Invalid password.";
                }
            } else {
                echo "Invalid email.";
            }
        } else {
            echo "Email or password not set.";
        }
    }
}

function addEmployee($conn){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $employee_id = $_POST['Employee_ID'];
        $first_name = $_POST['First_Name'];
        $last_name = $_POST['Last_Name'];
        $age = $_POST['Age'];
        $email = $_POST['Email'];
        $address = $_POST['Address'];
        $salary = $_POST['Salary'];

    // Handle image upload
    $target_dir = "img/"; // Directory to store images
    $image_file = $target_dir . basename($_FILES["employee_img"]["name"]); // Image file path

    // Check if the file is an actual image or fake image
    $check = getimagesize($_FILES["employee_img"]["tmp_name"]);
    if ($check !== false) {
        // Upload the file
        if (move_uploaded_file($_FILES["employee_img"]["tmp_name"], $image_file)) {
            // Insert employee data along with image file name into the database
            $query = "INSERT INTO employee (Employee_ID, First_Name, Last_Name, Age, `Email`, Address, Salary, Image) 
                      VALUES ('$employee_id', '$first_name', '$last_name', '$age', '$email', '$address', '$salary', '".basename($_FILES["employee_img"]["name"])."')";

            $result = mysqli_query($conn, $query);
            if ($result) {
                echo "Employee added successfully!";
                header("Location: employee.php");

            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            echo "Sorry, there was an error uploading the image.";
        }
    } else {
        echo "File is not an image.";
    }

    }
}

function editEmployee($conn) {
    if (isset($_POST['update'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $age = mysqli_real_escape_string($conn, $_POST['age']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $salary = mysqli_real_escape_string($conn, $_POST['salary']);
        
        // Collect error messages
        $errors = [];
        if (empty($employee_id)) $errors[] = "Employee ID field is empty.";
        if (empty($first_name)) $errors[] = "First Name field is empty.";
        if (empty($last_name)) $errors[] = "Last Name field is empty.";
        if (empty($age) || !is_numeric($age)) $errors[] = "Age field is empty or invalid.";
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid Email field.";
        if (empty($address)) $errors[] = "Address field is empty.";
        if (empty($salary) || !is_numeric($salary)) $errors[] = "Salary field is empty or invalid.";

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<font color='red'>$error</font><br/>";
            }
        } else {
            // Use prepared statement
            $stmt = $conn->prepare("UPDATE employee SET 
                Employee_ID = ?, 
                First_Name = ?, 
                Last_Name = ?, 
                Age = ?, 
                `E-mail` = ?, 
                Address = ?, 
                Salary = ? 
                WHERE id = ?");
            $stmt->bind_param("sssisssi", $employee_id, $first_name, $last_name, $age, $email, $address, $salary, $id);

            if ($stmt->execute()) {
                echo "<p><font color='green'>Data updated successfully!</font></p>";
                header("Location: home.php");
                exit(); // Ensure no further processing occurs
            } else {
                echo "<p><font color='red'>Error updating data: " . $stmt->error . "</font></p>";
            }

            $stmt->close();
        }
    }
}


function delEmployee($conn){
    $id = $_GET['id'];

    $result = mysqli_query($conn, "DELETE FROM employee WHERE id = $id");

    if ($result) {
    header("Location: employee.php");
    exit();
        } else {
    echo "Error: " . mysqli_error($conn);
        }
    }
?>
