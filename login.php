<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management System - Login</title>
</head>
<body>
    <h2>Login to Blog Management System</h2>

    <!-- Display error or success messages -->
    <?php
    if (isset($error)) {
        echo '<p style="color: red;">' . $error . '</p>';
    }
    if (isset($success)) {
        echo '<p style="color: green;">' . $success . '</p>';
    }
    ?>

    <form action="login.php" method="post">
        <label for="User Name">User Name:</label><br>
        <input type="text" id="User Name" name="User Name" required><br><br>

        <label for="Password">Password:</label><br>
        <input type="Password" id="Password" name="Password" required><br><br>

        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>

<?php
// Start the session
session_start();

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
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if username exists
    $query = "SELECT * FROM registration WHERE User_Name='$User_Name'";
    $result = $conn->query($query);

    if ($result === false) {
        $error = 'Error executing query: ' . $conn->error;
    } else if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($Password, $user['Password'])) {
            // Set session variables
            $_SESSION['User_Name'] = $user['User_Name'];
            $_SESSION['loggedin'] = true;
            $success = 'Login successful! Redirecting...';

            // Redirect to the dashboard or home page after successful login
            header("Location: dashboard.php");
            exit;
        } else {
            $error = 'Incorrect password!';
        }
    } else {
        $error = 'No user found with that username!';
    }
}

// Close connection
$conn->close();
?>
