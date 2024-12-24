<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT posts.*, users.username 
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
            <form method="POST" action="create_post.php">
                <textarea name="content" placeholder="What's on your mind?"></textarea>
                <button type="submit" name="submit">Post</button>
            </form>

            <div class="posts">
                <?php while($post = mysqli_fetch_assoc($result)) { ?>
                    <div class="post">
                        <h3><?php echo $post['username']; ?></h3>
                        <p><?php echo $post['content']; ?></p>
                        <small><?php echo $post['created_at']; ?></small>
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
    </script>
</body>
</html>