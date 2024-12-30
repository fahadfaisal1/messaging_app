<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Mark all notifications as read when page is opened
$mark_read_sql = "UPDATE notifications 
                  SET is_read = 1 
                  WHERE user_id = {$_SESSION['user_id']} 
                  AND is_read = 0";
mysqli_query($con, $mark_read_sql);

// Get notifications
$sql = "SELECT n.*, u.username, u.profile_pic 
        FROM notifications n 
        JOIN users u ON n.from_user_id = u.id 
        WHERE n.user_id = {$_SESSION['user_id']} 
        ORDER BY n.created_at DESC";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        // Check dark mode on page load
        document.addEventListener('DOMContentLoaded', function() {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        });

        // When page loads, force the notification badge to update
        document.addEventListener('DOMContentLoaded', function() {
            // Hide all notification badges
            const badges = document.querySelectorAll('.notification-badge');
            badges.forEach(badge => {
                badge.style.display = 'none';
            });
        });
    </script>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <button class="toggle-sidebar" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Notifications</h1>
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
            <div class="notifications-container">
                <?php while($notification = mysqli_fetch_assoc($result)): ?>
                    <div class="notification-card <?php echo $notification['is_read'] ? '' : 'unread'; ?>">
                        <?php 
                        $profile_pic = !empty($notification['profile_pic']) 
                            ? 'uploads/profile/' . htmlspecialchars($notification['profile_pic'])
                            : 'assets/images/default-avatar.jpg';
                        ?>
                        <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" class="profile-pic">
                        <div class="notification-content">
                            <p><?php echo htmlspecialchars($notification['content']); ?></p>
                            <small><?php echo date('F j, Y g:i a', strtotime($notification['created_at'])); ?></small>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html> 