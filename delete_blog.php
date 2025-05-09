
<?php
session_start();

// Ensure only authorized users can access this script
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['author', 'admin'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'blog');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $blog_id = intval($_GET['id']);
    $user_id = $_SESSION['user_id'];
    $user_role = $_SESSION['role'];

    if ($user_role === 'admin') {
        // Admin can delete any blog
        $delete_query = "DELETE FROM blogs WHERE id = ?";
    } elseif ($user_role === 'author') {
        // Author can delete only their own blogs
        $delete_query = "DELETE FROM blogs WHERE id = ? AND author_id = ?";
    }

    $stmt = $conn->prepare($delete_query);
    if ($user_role === 'admin') {
        $stmt->bind_param("i", $blog_id);
    } elseif ($user_role === 'author') {
        $stmt->bind_param("ii", $blog_id, $user_id);
    }

    if ($stmt->execute()) {
        header('Location: ' . ($user_role === 'admin' ? 'admin.php' : 'my_blogs.php'));
        exit;
    } else {
        echo "Failed to delete the blog. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>

