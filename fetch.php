<?php
$conn = new mysqli('localhost', 'root', '', 'blog');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch blogs and authors
$query = "SELECT blogs.id, blogs.title, blogs.content, blogs.created_at, users.name AS author_name 
          FROM blogs 
          JOIN users ON blogs.author_id = users.id 
          ORDER BY blogs.created_at DESC";

$result = $conn->query($query);

// Fetch comments for each blog
$comments_query = "SELECT * FROM comments ORDER BY created_at DESC";
$comments_result = $conn->query($comments_query);
$comments = [];
if ($comments_result) {
    while ($row = $comments_result->fetch_assoc()) {
        $comments[$row['blog_id']][] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 20px auto;
    }
    


    .blog-container {
        
        background-color: #fff;
        border: 1px solid #dee2e6;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .blog-container:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.15);
    }

    .blog-container h2 {
        color: #343a40;
        font-size: 24px;
        margin-bottom: 10px;
    }

    .blog-container p {
        color: #495057;
        line-height: 1.6;
        margin-bottom: 10px;
    }

    .blog-container small {
        color: #868e96;
    }

    .action-buttons {
        margin-top: 15px;
        display: flex;
        gap: 20px;
    }

    .action-button {
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #6c757d;
        transition: color 0.3s ease;
    }

    .action-button i {
        font-size: 18px;
    }

    .action-button:hover {
        color: #495057;
    }

    .action-button.active {
        color: #007bff;
    }

    .share-options {
        display: none;
        margin-top: 10px;
        margin-right:1000px;
        padding: 10px;
        background-color: #f1f3f5;
        border-radius: 5px;
        border: 1px solid #ced4da;
        font-size: 14px;
    }

    .share-options a {
        color: #007bff;
        text-decoration: none;
        margin-right: 50px;
        transition: color 0.3s ease;
    }

    .share-options a:hover {
        color: #0056b3;
    }

    .comments-section {
        margin-top: 20px;
    }

    .comments-section input {
        width: calc(100% - 80px);
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        margin-right: 10px;
        outline: none;
        font-size: 14px;
    }

    .comments-section input:focus {
        border-color: #007bff;
    }

    .comments-section button {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .comments-section button:hover {
        background-color: #0056b3;
    }

    .comments-list {
        margin-top: 15px;
    }

    .comments-list p {
        background-color: #f8f9fa;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        margin-bottom: 10px;
        color: #495057;
    }


      /* .blog-container {
            border: 1px solid #ccc;
            margin: 10px;
            padding: 10px;
            border-radius: 8px;
        }
*/
        /*.action-buttons {
            margin-top: 10px;
            display: flex;
            gap: 15px;
        }

        .action-button {
            cursor: pointer;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: gray;
            transition: color 0.3s ease;
        }

        .action-button.active {
            color: blue;
        }*/
        .action-buttons {
    display: flex;
    
    justify-content: space-between; /* Adds equal spacing between buttons */
    margin-top: 15px;
}

.action-button {
    flex-direction:row;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #6c757d;
    transition: color 0.3s ease;
}

.action-button i {
    font-size: 18px;
}

.action-button:hover {
    color: #495057;
}

.action-button.active {
    color: #007bff;
}


        .share-options {
            display: none;
            margin-top: 10px;
        }

        .comments-section {
            margin-top: 15px;
            display:none;
        }

        .comments-section input, .comments-section button {
            margin-top: 5px;
        }

        .comments-list {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="blog-container" data-id="<?php echo $row['id']; ?>">
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                <p><strong>By:</strong> <?php echo htmlspecialchars($row['author_name']); ?></p>
                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                <small><i>Posted on: <?php echo htmlspecialchars($row['created_at']); ?></i></small>
                <div class="actions-button">
                    <span class="action-button like-btn">
                        <i class="fas fa-thumbs-up"></i>like
                    </span>
                    <span class="action-button dislike-btn">
                        <i class="fas fa-thumbs-down"></i> dislike
                    </span>
                    <span class="action-button share-btn">
                    <i class="fas fa-share"></i> share
                    </span>
                    <span class="action-button comment-btn">
                    <i class="fas fa-comment"></i>comment
                    </span>
                </div>
                <div class="share-options">
                    <a href="https://web.whatsapp.com/send?text=<?php echo urlencode($row['title'] . ' - ' . $row['content']); ?>" target="_blank">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                    <a href="mailto:?subject=<?php echo urlencode($row['title']); ?>&body=<?php echo urlencode($row['content']); ?>" target="_blank">
                        <i class="fas fa-envelope"></i> Email
                    </a>
                    <a href="https://web.facebook.com/send?text=<?php echo urlencode($row['title'] . ' - ' . $row['content']); ?>" target="_blank">
                        <i class="fab fa-facebook"></i> Facebook
                    </a>
                </div>
                <div class="comments-section">
                    <form method="POST" action="post_comment.php">
                        <input type="hidden" name="blog_id" value="<?php echo $row['id']; ?>">
                         
                        <input type="text" name="comment" placeholder="Write a comment..." required>
                        <button type="submit">Post</button>
                    </form>
                   
            <div class="comments-list">
                        <?php if (isset($comments[$row['id']])): ?>
                            <?php foreach ($comments[$row['id']] as $comment): ?>
                                <p><?php echo htmlspecialchars($comment['comment']); ?> - <small><i><?php echo htmlspecialchars($comment['created_at']); ?></i></small></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No blogs available.</p>
    <?php endif; ?>

    <script>
        document.querySelectorAll('.blog-container').forEach(container => {
            const likeBtn = container.querySelector('.like-btn');
            const dislikeBtn = container.querySelector('.dislike-btn');
            const shareBtn = container.querySelector('.share-btn');
            const shareOptions = container.querySelector('.share-options');
            
            likeBtn.addEventListener('click', () => {
                likeBtn.classList.toggle('active');
                dislikeBtn.classList.remove('active');
            });

            dislikeBtn.addEventListener('click', () => {
                dislikeBtn.classList.toggle('active');
                likeBtn.classList.remove('active');
            });

            shareBtn.addEventListener('click', () => {
                shareOptions.style.display = shareOptions.style.display === 'none' ? 'block' : 'none';
            });
            
            const commentBtn = container.querySelector('.comment-btn');
            const commentsSection = container.querySelector('.comments-section');

            commentBtn.addEventListener('click', () => {
                // Toggle the visibility of the comment section
                if (commentsSection.style.display === 'none'|| commentsSection.style.display==='') {
                    commentsSection.style.display = 'block';
                } else {
                    commentsSection.style.display = 'none';
                }
            });

        });
    </script>
</body>
</html>