<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management System - Registration</title>
</head>
<body>
    <h2>Register for the Blog Management System</h2>

    <!-- Display error or success messages -->
    <?php
    if (isset($error)) {
        echo '<p style="color: red;">' . $error . '</p>';
    }
    if (isset($success)) {
        echo '<p style="color: green;">' . $success . '</p>';
    }
    ?>

    <form action="register.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="User_Name" name="User_Name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="Email" name="Email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="Password" name="Password" required><br><br>

        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="Confirm_Password" name="Confirm_Password" required><br><br>

        <button type="submit" name="submit">Register</button>
    </form>
</body>
</html>

<?php
// Start session
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'blog_management';

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Handle form submission
if (isset($_POST['submit'])) {

    // Sanitize and fetch form data
    //$User_Name$_POST['User_Name']);
    $User_Name=$_POST['User_Name'];
    $Email=$_POST['Email'];
    $Password=$_POST['Password'];
    $Confirm_Password=$_POST['Confirm_Password'];

    // Check if passwords match
    if ($Password !== $Confirm_Password) {
        $error = 'Passwords do not match!';
    } else {
        // Hash password
        $hashed_password = password_hash($Password, PASSWORD_DEFAULT);

        // Check if username or email already exists
        $query = "SELECT * FROM registration WHERE User_Name='$User_Name' OR Email='$Email'";
        $result = $conn->query($query);

        if ($result === false) {
            // Handle SQL error and debug
            $error = 'Error executing query: ' . $conn->error . ' Query: ' . $query;
        } else if ($result->num_rows > 0) {
            $error = 'Username or email already exists!';
        } else {
            // Insert new user into database
            $sql = "INSERT INTO registration (User_Name, Email, Password) VALUES ('$User_Name', '$Email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                $success = 'Registration successful! You can now log in.';
            } else {
                $error = 'Error: ' . $conn->error;
            }
        }
    }

    // Display error or success messages
    if (isset($error)) {
        echo '<p style="color: red;">' . $error . '</p>';
    }
    if (isset($success)) {
        echo '<p style="color: green;">' . $success . '</p>';
    }
}

// Close connection
$conn->close();
?>
