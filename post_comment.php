
<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'blog');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blog_id = $_POST['blog_id'];
    $comment = $conn->real_escape_string($_POST['comment']);

    $query = "INSERT INTO comments (blog_id, comment, created_at) VALUES ('$blog_id', '$comment', NOW())";

    if ($conn->query($query) === TRUE) {
        // Redirect back to the same page using the HTTP_REFERER
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit; // Ensure no further code executes after the redirection
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

