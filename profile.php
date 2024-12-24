<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);

// Get user's posts
$posts_sql = "SELECT posts.*, users.username 
              FROM posts 
              JOIN users ON posts.user_id = users.id 
              WHERE posts.user_id = $user_id 
              ORDER BY created_at DESC";
$posts_result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile - <?php echo $user['username']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="header-left">
            <button class="toggle-sidebar" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Profile</h1>
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
            <div class="profile-container">
                <!-- Cover Photo Section -->
                <div class="cover-photo">
                    <img src="assets/images/default-cover.jpg" alt="Cover Photo">
                    <button class="edit-cover">
                        <i class="fas fa-camera"></i> Edit Cover Photo
                    </button>
                </div>

                <!-- Profile Info Section -->
                <div class="profile-info">
                    <div class="profile-picture">
                        <img src="assets/images/default-avatar.jpg" alt="Profile Picture">
                        <button class="edit-profile-pic">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <div class="profile-details">
                        <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                        <p class="bio">Click to add bio</p>
                        <div class="profile-stats">
                            <div class="stat">
                                <i class="fas fa-users"></i>
                                <span>0 Friends</span>
                            </div>
                            <div class="stat">
                                <i class="fas fa-image"></i>
                                <span>0 Photos</span>
                            </div>
                            <div class="stat">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Add Location</span>
                            </div>
                        </div>
                    </div>
                    <button class="edit-profile-btn">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                </div>

                <!-- Profile Navigation -->
                <div class="profile-nav">
                    <a href="#posts" class="active">Posts</a>
                    <a href="#about">About</a>
                    <a href="#friends">Friends</a>
                    <a href="#photos">Photos</a>
                </div>

                <!-- Posts Section -->
                <div class="profile-posts">
                    <!-- Create Post -->
                    <form method="POST" action="create_post.php" class="create-post">
                        <textarea name="content" placeholder="What's on your mind?"></textarea>
                        <div class="post-actions">
                            <button type="button" class="post-action">
                                <i class="fas fa-image"></i> Photo
                            </button>
                            <button type="submit" name="submit">Post</button>
                        </div>
                    </form>

                    <!-- Posts Display -->
                    <div class="posts">
                        <?php while($post = mysqli_fetch_assoc($posts_result)) { ?>
                            <div class="post">
                                <div class="post-header">
                                    <img src="assets/images/default-avatar.jpg" alt="Profile Picture">
                                    <div>
                                        <h3><?php echo $post['username']; ?></h3>
                                        <small><?php echo date('F j, Y g:i a', strtotime($post['created_at'])); ?></small>
                                    </div>
                                </div>
                                <p class="post-content"><?php echo htmlspecialchars($post['content']); ?></p>
                                <div class="post-actions">
                                    <button>
                                        <i class="far fa-thumbs-up"></i> Like
                                    </button>
                                    <button>
                                        <i class="far fa-comment"></i> Comment
                                    </button>
                                    <button>
                                        <i class="far fa-share-square"></i> Share
                                    </button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const container = document.getElementById('container');
            container.classList.toggle('sidebar-hidden');
            localStorage.setItem('sidebarHidden', container.classList.contains('sidebar-hidden'));
        }

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
            const isHidden = localStorage.getItem('sidebarHidden') === 'true';
            if (isHidden) {
                document.getElementById('container').classList.add('sidebar-hidden');
            }
            
            const darkMode = localStorage.getItem('darkMode');
            const icon = document.querySelector('.dark-mode-toggle i');
            
            if (darkMode === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
        });
    </script>
</body>
</html> 