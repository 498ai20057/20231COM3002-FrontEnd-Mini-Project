<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'author') {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'blog');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    header('Location: my_blogs.php');
    exit;
}

$blog_id = $_GET['id'];
$author_id = $_SESSION['user_id'];

// Fetch the blog for editing
$result = $conn->query("SELECT * FROM blogs WHERE id = $blog_id AND author_id = $author_id");
if ($result->num_rows === 0) {
    header('Location: my_blogs.php');
    exit;
}

$blog = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);

    // Update the blog in the database
    $update_query = "UPDATE blogs SET title = '$title', content = '$content', updated_at = NOW() WHERE id = $blog_id AND author_id = $author_id";
    if ($conn->query($update_query)) {
        header('Location: my_blogs.php');
        exit;
    } else {
        $error = "Failed to update the blog. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f9;
        color: #333;
        line-height: 1.6;
    }

    header {
        background-color: #2c3e50;
        color: white;
        padding: 10px 20px;
    }
    .navbar {
    display: flex;
    
    align-items: center;
    background: #2c3e50;
    padding: 10px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.navbar h1{
    color:white;
    margin-right:900px;
}
   /* .navbar {
        display: flex;
        
        align-items: center;
        max-width: 1200px;
        margin: 20px auto;
    }
    .navbar h1{
color:white;
margin-right:800px;
    }*/

    .navbar a {
        color: white;
        text-decoration: none;
        font-size: 16px;
        margin: 0 30px;
        transition: color 0.3s ease;
    }

    .navbar a:hover {
        color: #1abc9c;
    }

    main {
        max-width: 800px;
        margin: 40px auto;
        background: white;
        padding: 30px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        margin-top:80px;
    }

    h1 {
        font-size: 28px;
        margin-bottom: 20px;
        text-align: center;
        color: #2c3e50;
        font-weight: bold;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    label {
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    input[type="text"]:focus,
    textarea:focus {
        border-color: #1abc9c;
        outline: none;
        box-shadow: 0 0 5px rgba(26, 188, 156, 0.5);
    }

    textarea {
        resize: vertical;
    }

    button {
        background-color: #1abc9c;
        color: white;
        border: none;
        padding: 12px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    button:hover {
        background-color: #16a085;
        transform: translateY(-2px);
    }

    button:active {
        transform: scale(0.98);
    }

        footer {
            background: #2c3e50;
            color: #ecf0f1;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 150px;
            opacity: 1; /* For animation */
            transform: translateY(0); /* Initial position for animation */
            transition: all 1s ease-in-out;
        }
        .footer-container {
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
  max-width: 1200px;
  margin: 0 auto;
}

.footer-section {
  flex: 1;
  margin: 0 20px;
}

.footer-section h4 {
  font-size: 18px;
  margin-bottom: 15px;
}

.footer-section p {
  font-size: 14px;
  line-height: 1.6;
}

.footer-section ul {
  list-style: none;
  padding: 0;
}

.footer-section ul li {
  font-size: 14px;
  margin-bottom: 10px;
}

.footer-section ul li i {
  margin-right: 10px;
}

.footer-bottom {
  text-align: center;
  margin-top: 20px;
  font-size: 14px;
}

.footer-section ul li:hover {
  color: #1abc9c;
  cursor: pointer;
}

.footer-bottom p {
  margin: 0;
  font-size: 14px;
}

.footer-section ul li i {
  color: #ecf0f1;
}


        /* Responsive Design */
        @media (max-width: 768px) {
            main {
                padding: 15px 20px;
            }

            .navbar {
                flex-direction: column;
            }

            .navbar a {
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <h1>Blog Management System</h1>
            <a href="author.php">Home</a>
            <a href="#about">About Us</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h1>Edit Blog</h1>
        <?php if (isset($error)): ?>
            <p style="color: red; text-align: center;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <div>
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
            </div>
            <div>
                <label for="content">Content:</label>
                <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($blog['content']); ?></textarea>
            </div>
            <button type="submit">Update Blog</button>
        </form>
    </main>
    <footer id="footer">
        <div class="footer-container">
            <div class="footer-section about">
                <h4>BLOG MANAGEMENT SYSTEM</h4>
                <p>Seamlessly manage your blogs with our user-friendly platform. Write, edit, and publish your stories while staying connected with your readers.</p>
            </div>
            <div class="footer-section features">
                <h4>FEATURES</h4>
                <ul>
                    <li>Post Management</li>
                    <li>Comment Moderation</li>
                    <li>Author Profiles</li>
                    <li>Analytics Dashboard</li>
                </ul>
            </div>
            <div class="footer-section contact">
                <h4>CONTACT US</h4>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Presidency University, Bangalore</li>
                    <li><i class="fas fa-envelope"></i> presidencyuniversity.in</li>
                    <li><i class="fas fa-phone"></i> +91 8082314566</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2024 Blog Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

