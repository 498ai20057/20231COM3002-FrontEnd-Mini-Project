
<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'author') {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'blog');
$author_id = $_SESSION['user_id'];
$blogs = $conn->query("SELECT * FROM blogs WHERE author_id = $author_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Author Dashboard</title>
    <link rel="stylesheet" href="style1.css">
    <style>
       /* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background: #f5f7fa;
    color: #333;
    line-height: 1.6;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* Navigation Bar */
.navbar {
    display: flex;
    
    align-items: center;
    background: #2c3e50;
    padding: 10px 20px;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.navbar a {
    color: #fff;
    text-decoration: none;
    margin: 0 15px;
    font-size: 1rem;
    transition: color 0.3s ease;
}

.navbar a:hover {
    color: #1abc9c;
}
main {
    padding: 30px 15%;
    background-color: #ffffff;
}

main h1 {
    font-size: 2.5em;
    color: #2c3e50;
    margin-bottom: 30px;
    text-align: center;
}



/* Blog List Section */

.blog-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(1000px, 1fr));
    gap: 20px;
}

.blog-item {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.blog-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
}

.blog-item h2 {
    font-size: 1.8rem;
    color: #2c3e50;
    margin-bottom: 10px;
}

.blog-item p {
    font-size:1rem;
    color: #555;
    line-height: 1.5;
    margin-bottom: 15px;
}

.blog-item a {
    display: inline-block;
    padding: 8px 16px;
    background: #1abc9c;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 0.9rem;
    transition: background-color 0.3s ease;
}

.blog-item a:hover {
    background: #16a085;
}

/* Footer *
footer {
    background: #2c3e50;
    color: #fff;
    text-align: center;
    padding: 15px 20px;
    font-size: 0.9rem;
}

footer p {
    margin: 0;
}*/
footer {
            background: #2c3e50;
            color: #ecf0f1;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 20px;
            opacity: 1; /* For animation */
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


/* Responsive Design */
@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
    }

    .navbar a {
        margin: 10px 0;
    }

    main h1 {
        font-size: 2rem;
    }

    .blog-item h2 {
        font-size: 1.3rem;
    }
}
</style>
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="author.php">Home</a>
            <a href="#about">About Us</a>
            <a href="logout.php">Logout</a>
            <a href="my_blogs.php">My Blogs</a>
        </nav>
    </header>
    <main>
        <h1>Welcome, Author</h1>
        
            
    <?php include 'fetch.php'; ?>
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

