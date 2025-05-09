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

$author_id = $_SESSION['user_id'];
$my_blogs = $conn->query("SELECT * FROM blogs WHERE author_id = $author_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Blogs</title>
    <link rel="stylesheet" href="style1.css">
    <style>
        /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background: #f4f4f9;
    color: #333;
    margin: 0;
    padding: 0;
}
body, html {
    height: 100%; /* Ensure the entire viewport is considered */
}

/* Navbar */
.navbar {
    display: flex;
    
    align-items: center;
    background: #2c3e50;
    padding: 10px 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.navbar h1{
    color:white;
    margin-right:890px;
}
.navbar a {
    color: white;
    text-decoration: none;
    margin: 0 10px;
    font-weight: bold;
    transition: color 0.3s ease;
}

.navbar a:hover {
    color: #2cc49c;
}

.navbar .btn {
    background: #2cc49c;
    color: white;
    padding: 10px 20px;
    border-radius: 20px;
    text-transform: uppercase;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.navbar .btn:hover {
    background: #1d8c6d;
}

/* Main Content */
main {
    flex: 1; /* Ensures the main section grows to fill available space */
    display: flex;
    flex-direction:column;
    justify-content: center;
    align-items: center;
    /*padding:40px 20px;*/
    padding: 30px 20%;
    
    background:  #f4f4f4;
    border-radius: 12px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    
    margin: 20px auto;
    max-width: 1200px;
    width: 95%;
}

main h1 {
    margin-bottom: 30px;
    font-size: 2.5rem;
    color: #2c3e50;
    text-align: center;
}



    .blogs {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .blog {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-left: 5px solid #2cc49c;
        max-width: 100%; /* Adjust the maximum width */
        width: 100%; /* Full width of the parent container */
        margin: 0 auto; /* Center align */
    }

    .blog:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }





.blog h2 {
    margin-bottom: 10px;
    font-size: 1.5rem;
    color: #2c3e50;
}

.blog small {
    display: block;
    margin-bottom: 15px;
    font-size: 0.85rem;
    width:900px;
    color: #888;
}

.blog p {
    margin-bottom: 15px;
    font-size: 1rem;
    color: #555;
    line-height: 1.6;
}

/* Buttons */
.blog .btn {
    display: inline-block;
    padding: 10px 15px;
    font-size: 0.9rem;
    font-weight: bold;
    text-decoration: none;
    border-radius: 5px;
    color: white;
    background: #2c3e50;
    margin-right: 10px;
    transition: background 0.3s ease;
}

.blog .btn:hover {
    background: #2cc49c;
}

.blog .delete-btn {
    background: #d9534f;
}

.blog .delete-btn:hover {
    background: #c9302c;
}


        footer {
    background: #2c3e50;
    color: white;
    text-align: center;
    padding: 10px 0;
    font-size: 0.9rem;
    width: 100%;
    margin-top: 1000px; /* Adjust space above the footer */
    opacity: 1; /* Ensure visibility */
    transform: translateY(0); /* Remove animation shift */
    transition: all 0.3s ease-in-out; /* Optional animation for smooth appearance */
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


        .blog h2 {
            margin: 0;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px 5px 0 0;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn:hover {
            background: #575757;
        }
        .delete-btn {
            background-color: #d9534f;
            border: none;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar"><h1>Blog Management System</h1>
            <a href="author.php">Home</a>
            <a href="#about">About Us</a>
            <a href="create_blog.php" class="btn">Create New Blog</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h1>My Blogs</h1>
        <div class="blogs">
            <?php if ($my_blogs->num_rows > 0): ?>
                <?php while ($blog = $my_blogs->fetch_assoc()): ?>
                    <div class="blog">
                        <h2><?php echo htmlspecialchars($blog['title']); ?></h2>
                        <small>Posted on <?php echo htmlspecialchars($blog['created_at']); ?></small>
                        <p><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>
                        <!-- Edit Button -->
                        <a href="edit_blog.php?id=<?php echo $blog['id']; ?>" class="btn">Edit</a>
                        <!-- Delete Button -->
                         <a href="delete_blog.php?id=<?php echo $blog['id']; ?>" class="btn" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
                        
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No blogs found. <a href="create_blog.php" class="btn">Create Your First Blog</a></p>
            <?php endif; ?>
        </div>
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
<!--?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'author') {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'blog');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$author_id = $_SESSION['user_id'];
$my_blogs = $conn->query("SELECT * FROM blogs WHERE author_id = $author_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Blogs</title>
    <link rel="stylesheet" href="style1.css">
    <style>
        .blog {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
        }
        .blog h2 {
            margin: 0;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px 5px 0 0;
            background: #333;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn:hover {
            background: #575757;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="author.php">Home</a>
            <a href="#about">About Us</a>
            <a href="create_blog.php" class="btn">Create New Blog</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h1>My Blogs</h1>
        <div class="blogs">
            ?php if ($my_blogs->num_rows > 0): ?>
                ?php while ($blog = $my_blogs->fetch_assoc()): ?>
                    <div class="blog">
                        <h2>?php echo htmlspecialchars($blog['title']); ?></h2>
                        <small>Posted on ?php echo htmlspecialchars($blog['created_at']); ?></small>
                        <p>?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>
                        <a href="edit_blog.php?id=?php echo $blog['id']; ?>" class="btn">Edit</a>
                        <a href="delete_blog.php?id=?php echo $blog['id']; ?>" class="btn">Delete</a>
                    </div>
                ?php endwhile; ?>
            ?php else: ?>
                <p>No blogs found. <a href="create_blog.php" class="btn">Create Your First Blog</a></p>
            ?php endif; ?>
        </div>
       
    </main>
    <footer>
        <p>© 2024 Blog Management System. All rights reserved.</p>
    </footer>
</body>
</html>-->
