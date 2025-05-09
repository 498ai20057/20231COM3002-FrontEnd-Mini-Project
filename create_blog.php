<?php
session_start();

// Check if the logged-in user is an author
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'author') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['user_id']; // Assuming the author's ID is stored in the session

    $conn = new mysqli('localhost', 'root', '', 'blog');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO blogs (author_id, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param('iss', $author_id, $title, $content);

    if ($stmt->execute()) {
        header("Location: author.php?msg=Blog created successfully!");
        exit;
    } else {
        $error = "Failed to create blog: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Blog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    

        /* General Reset *
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }*/

        h1 {
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
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
    main h1{
        margin-left:200px;
    }
        form {
            
            background: #ffffff;
            max-width: 500px;
            width: 90%;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-left:100px;
        }

        form input, form textarea, form button {
            width: 100%;
            margin-bottom: 20px;
            
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        form input:focus, form textarea:focus {
            border-color: #2cc49c;
            outline: none;
            box-shadow: 0 0 8px rgba(44, 196, 156, 0.3);
        }

        form textarea {
            resize: vertical;
            min-height: 150px;
        }

        form button {
            background: #2cc49c;
            color: #ffffff;
            border: none;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        form button:hover {
            background: #1d8c6d;
        }

        .error {
            color: #e74c3c;
            text-align: center;
            font-weight: bold;
        }

        /* Add a subtle hover effect on inputs */
        form input:hover, form textarea:hover {
            background: #f9f9f9;
        }

        /* Add a subtle animation when focusing on form elements */
        form input:focus, form textarea:focus {
            animation: focusGlow 0.6s ease-out forwards;
        }

        @keyframes focusGlow {
            from {
                box-shadow: 0 0 0px rgba(44, 196, 156, 0.3);
            }
            to {
                box-shadow: 0 0 8px rgba(44, 196, 156, 0.5);
            }
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

        /* Make the page responsive */
        @media (max-width: 768px) {
            form {
                padding: 20px;
            }

            h1 {
                font-size: 1.5rem;
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
    <h1>Create Blog</h1>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="title" placeholder="Enter Blog Title" required>
        <textarea name="content" placeholder="Write your blog content here..." required></textarea>
        <button type="submit"><i class="fas fa-paper-plane"></i> Post Blog</button>
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

