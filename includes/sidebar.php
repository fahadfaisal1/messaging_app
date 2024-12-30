<?php
// Get current page directory depth
$isInSubfolder = strpos($_SERVER['PHP_SELF'], '/chat/') !== false;
$baseUrl = $isInSubfolder ? '../' : '';

$notif_sql = "SELECT COUNT(*) as count FROM notifications WHERE user_id = {$_SESSION['user_id']} 
AND is_read = 0";
$notif_result = mysqli_query($con, $notif_sql);
$unread_count = mysqli_fetch_assoc($notif_result)['count'];
?>

<div class="sidebar">
    <div class="sidebar-menu">
        <a href="<?php echo $baseUrl; ?>index.php">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="<?php echo $baseUrl; ?>profile.php">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>
        <a href="<?php echo $baseUrl; ?>chat/messages.php">
            <i class="fas fa-comments"></i>
            <span>Messages</span>
        </a>
        <a href="<?php echo $baseUrl; ?>friends.php">
            <i class="fas fa-users"></i>
            <span>Friends</span>
        </a>
        <a href="<?php echo $baseUrl; ?>games.php">
            <i class="fas fa-gamepad"></i>
            <span>Games</span>
        </a>
        <a href="<?php echo $baseUrl; ?>notifications.php">
            <i class="fas fa-bell"></i>
            <span>Notifications</span>
            <?php if($unread_count > 0): ?>
                <span class="notification-badge"><?php echo $unread_count; ?></span>
            <?php endif; ?>
        </a>
        <a href="<?php echo $baseUrl; ?>settings.php">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
        <a href="<?php echo $baseUrl; ?>logout.php">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
      
    </div>
</div> 