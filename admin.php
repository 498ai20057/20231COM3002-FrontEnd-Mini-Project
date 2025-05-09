<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'blog');
$blogs = $conn->query("SELECT blogs.id, blogs.title, blogs.content, users.name AS author_name 
                       FROM blogs 
                       JOIN users ON blogs.author_id = users.id");
$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        
/* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
    color: #333;
}

header {
    background-color: #2c3e50;
    padding: 10px 20px;
}

.navbar {
    display: flex;
    
    align-items: center;
}

.navbar a {
    
    font-size: 16px;
    color: white;
   /* padding: 0.5rem 1rem;*/
    text-decoration: none;
    margin-right:30px;
}
.navbar h1 {
    color: #ffffff;
    text-decoration: none;
    margin-right: 1250px;
    margin-left:50px;
    font-size: 21px;
}

.navbar a:hover {
    background-color: #575757;
}

/* Main Content */
main {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

h1 {
    color: #333;
    font-size: 28px;
    margin-bottom: 20px;
    text-align: center;
}

h2 {
    color: #333;
    font-size: 24px;
    margin-top: 40px;
    margin-bottom: 20px;
    border-bottom: 2px solid #1abc9c;
    padding-bottom: 10px;
}

/* Blog Cards */
.blogs{
    display: flex;
    flex-wrap: wrap;
    width:1600px;
    gap: 20px;
}
 .users {
    display: flex;
    flex-wrap: wrap;
    
    gap: 20px;
}

.blog, .users p {
    background: #ffffff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    width: calc(48% - 10px); /* For two-column layout */
}

.blog:hover {
    transform: translateY(-2px);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.blog h2 {
    margin-top: 0;
    font-size: 20px;
    color: #1abc9c;
}

.blog p {
    font-size: 14px;
    line-height: 1.6;
    margin: 10px 0;
    color: #666;
}

/* Buttons */
.blog a {
    display: inline-block;
    background-color: #e74c3c;
    color: #ffffff;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 14px;
    margin-top: 10px;
}

.blog a:hover {
    background-color: #c0392b;
    transition: 0.3s;
}

/* Users Section */
.users p {
    font-size: 14px;
    line-height: 1.5;
    border-left: 4px solid #1abc9c;
    padding-left: 10px;
    margin-bottom: 10px;
}



footer {
            background: #2c3e50;
            color: #ecf0f1;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 20px;
            opacity: 0; /* For animation */
            transform: translateY(50px); /* Initial position for animation */
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

        </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <h1>Blog Management system</h1>
            <a href="admin.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <h1> Welcome Admin </h1>
        <h2>Manage Blogs</h2>
        <div class="blogs">
            <?php while ($blog = $blogs->fetch_assoc()): ?>
                <div class="blog">
                    <h2><?php echo $blog['title']; ?></h2>
                    <p>By: <?php echo $blog['author_name']; ?></p>
                    <p><?php echo $blog['content']; ?></p>
                   <!-- <a href="delete_blog.php?id=?php echo $blog['id']; ?>">Delete</a>-->
                    <a href="delete_blog.php?id=<?php echo $blog['id']; ?>" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>

                </div>
            <?php endwhile; ?>
        </div>

        <h2>Manage Users</h2>
        <div class="users">
            <?php while ($user = $users->fetch_assoc()): ?>
                <p><?php echo $user['name']; ?> (<?php echo $user['role']; ?>)</p>
            <?php endwhile; ?>
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
