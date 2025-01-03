<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT 
        posts.*, 
        users.username, 
        users.profile_pic,
        (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as likes_count,
        (SELECT COUNT(*) > 0 FROM likes WHERE likes.post_id = posts.id AND likes.user_id = {$_SESSION['user_id']}) as user_liked
        FROM posts 
        JOIN users ON posts.user_id = users.id 
        ORDER BY posts.created_at DESC";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="header-left">
            <button class="toggle-sidebar" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1>MySocialApp</h1>
        </div>
        <div class="header-right">
            <span class="username">Welcome, <?php echo $_SESSION['username']; ?></span>
            <button class="dark-mode-toggle" onclick="toggleDarkMode()">
                <i class="fas fa-moon"></i>
            </button>
        </div>
    </div>

    <div class="container" id="container">
        <?php include 'includes/sidebar.php'; ?>

        <div class="main-content">
            <form method="POST" action="create_post.php" enctype="multipart/form-data" class="create-post">
                <textarea name="content" placeholder="What's on your mind?"></textarea>
                <div class="post-actions">
                    <div class="image-preview" id="imagePreview" style="display: none;">
                        <img src="" alt="Preview" id="previewImage">
                        <button type="button" onclick="removeImage()" class="remove-image">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="action-buttons">
                        <label for="postImage" class="post-action">
                            <i class="fas fa-image"></i> Photo
                            <input type="file" id="postImage" name="post_image" accept="image/*" style="display: none;" onchange="previewImage(this)">
                        </label>
                        <button type="submit" name="submit">Post</button>
                    </div>
                </div>
            </form>

            <div class="posts">
                <?php while($post = mysqli_fetch_assoc($result)) { ?>
                    <div class="post">
                        <div class="post-header">
                            <?php 
                            // Debug line to see what's coming from database
                            // var_dump($post['profile_pic']);
                            
                            $profile_pic = !empty($post['profile_pic']) 
                                ? 'uploads/profile/' . htmlspecialchars($post['profile_pic'])
                                : 'assets/images/default-avatar.jpg';
                            ?>
                            <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" onerror="this.src='assets/images/default-avatar.jpg'">
                            <div>
                                <h3><?php echo htmlspecialchars($post['username']); ?></h3>
                                <small><?php echo date('F j, Y g:i a', strtotime($post['created_at'])); ?></small>
                            </div>
                        </div>
                        <p class="post-content"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                        <?php if($post['image']): ?>
                            <div class="post-image">
                                <img src="uploads/posts/<?php echo $post['image']; ?>" alt="Post Image">
                            </div>
                        <?php endif; ?>
                        <div class="post-actions flex">
                            <button class="like-button <?php echo $post['user_liked'] ? 'liked' : ''; ?>" 
                                    onclick="handleLike(<?php echo $post['id']; ?>, this)">
                                <i class="<?php echo $post['user_liked'] ? 'fas' : 'far'; ?> fa-thumbs-up"></i> 
                                Like <span class="like-count"><?php echo $post['likes_count']; ?></span>
                            </button>
                            <button><i class="far fa-comment"></i> Comment</button>
                            <button><i class="far fa-share-square"></i> Share</button>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle function
        function toggleSidebar() {
            const container = document.getElementById('container');
            container.classList.toggle('sidebar-hidden');
            localStorage.setItem('sidebarHidden', container.classList.contains('sidebar-hidden'));
        }

        // Dark Mode Toggle
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.getAttribute('data-theme') === 'dark';
            const icon = document.querySelector('.dark-mode-toggle i');
            
            if (isDark) {
                html.removeAttribute('data-theme');
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
                localStorage.setItem('darkMode', 'light');
            } else {
                html.setAttribute('data-theme', 'dark');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                localStorage.setItem('darkMode', 'dark');
            }
        }

        // Check preferences on load
        window.addEventListener('load', () => {
            // Check sidebar state
            const isHidden = localStorage.getItem('sidebarHidden') === 'true';
            if (isHidden) {
                document.getElementById('container').classList.add('sidebar-hidden');
            }
            
            // Check dark mode state
            const darkMode = localStorage.getItem('darkMode');
            const icon = document.querySelector('.dark-mode-toggle i');
            
            if (darkMode === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
        });

        function handleLike(postId, button) {
            fetch('like_post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `post_id=${postId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const likeCount = button.querySelector('.like-count');
                    const icon = button.querySelector('i');
                    
                    likeCount.textContent = data.likes;
                    
                    if (data.action === 'liked') {
                        button.classList.add('liked');
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                    } else {
                        button.classList.remove('liked');
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>