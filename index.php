
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
        }

        /* Header and Navbar */
        header {
            background: #2c3e50;
            padding: 10px 20px;
            color: #ecf0f1;
            opacity: 0; /* For animation */
            transform: translateY(-50px); /* Initial position for animation */
            transition: all 0.8s ease-in-out;
        }

        .navbar {
            display: flex;
            align-items: center;
        }

        .navbar h1 {
            margin-right: 100px;
        }

        .navbar a {
            color: #ecf0f1;
            text-decoration: none;
            margin-right: 15px;
            padding: 8px 15px;
            font-size: 16px;
            border-radius: 4px;
        }

        .navbar a:hover {
            background: #1abc9c;
            color: #fff;
            transition: 0.3s ease-in-out;
        }

        /* Main Section */
        main {
            padding: 20px;
            background-color: #eaf4fd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 90vh;
            opacity: 0; /* For animation */
            transform: translateY(50px); /* Initial position for animation */
            transition: all 1s ease-in-out;
        }

        .text-content {
            flex: 1;
            text-align: left;
            padding: 20px;
        }

        .text-content h1 {
            font-size: 36px;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .text-content p {
            font-size: 18px;
            margin-bottom: 20px;
            color: #34495e;
        }

        .text-content a {
            display: inline-block;
            text-decoration: none;
            padding: 10px 20px;
            background: #1abc9c;
            color: white;
            border-radius: 4px;
            margin: 10px;
            font-size: 18px;
        }

        .text-content a:hover {
            background: #16a085;
            animation: bounce 0.4s ease-in-out;
        }

        .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .image-container img {
            max-width: 80%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Footer */
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

        /* Bounce Animation */
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        /* Scroll Reveal Animation */
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 1s ease-in-out;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                text-align: center;
            }

            main {
                flex-direction: column;
                text-align: center;
                height: auto;
            }

            .image-container img {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <header id="header">
        <nav class="navbar">
            <h1>Blog Management System</h1>
            <a href="index.php">Home</a>
            <a href="#about">About Us</a>
            <a href="#contact">Contact Us</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </nav>
    </header>
    <main id="main-content">
        <div class="text-content">
            <h1>Welcome to Blog Management System</h1>
            <p>
                Effortlessly create, edit, and manage your blog posts with our intuitive and user-friendly interface. Stay connected with your audience through engaging content and real-time interactions. Track your blog's performance with detailed analytics, improve your reach, and grow your audience with powerful tools designed for bloggers of all levels.
            </p>
            <a href="register.php">Get Started</a>
            
        </div>
        <div class="image-container">
            <img src="blog_img2.webp" alt="Blog Management Illustration">
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

    <script>
        // Page Load Animation
        window.addEventListener('load', function () {
            document.getElementById('header').style.opacity = 1;
            document.getElementById('header').style.transform = 'translateY(0)';
            document.getElementById('main-content').style.opacity = 1;
            document.getElementById('main-content').style.transform = 'translateY(0)';
            document.getElementById('footer').style.opacity = 1;
            document.getElementById('footer').style.transform = 'translateY(0)';
        });

        // Scroll Reveal Animation
        const reveals = document.querySelectorAll('.reveal');

        window.addEventListener('scroll', () => {
            reveals.forEach((reveal) => {
                const windowHeight = window.innerHeight;
                const revealTop = reveal.getBoundingClientRect().top;
                const revealPoint = 150;

                if (revealTop < windowHeight - revealPoint) {
                    reveal.classList.add('visible');
                } else {
                    reveal.classList.remove('visible');
                }
            });
        });
    </script>
</body>
</html>



