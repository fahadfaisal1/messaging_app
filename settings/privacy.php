<?php
// Get current privacy settings
$privacy_sql = "SELECT post_privacy, friend_privacy FROM users WHERE id = {$_SESSION['user_id']}";
$privacy_result = mysqli_query($con, $privacy_sql);
$privacy_data = mysqli_fetch_assoc($privacy_result);

// Handle form submission
if(isset($_POST['save_privacy'])) {
    $post_privacy = mysqli_real_escape_string($con, $_POST['post_privacy']);
    $friend_privacy = mysqli_real_escape_string($con, $_POST['friend_privacy']);
    
    $query = "UPDATE users SET 
              post_privacy='$post_privacy', 
              friend_privacy='$friend_privacy'
              WHERE id={$_SESSION['user_id']}";
    
    if(mysqli_query($con, $query)) {
        $success_msg = "Privacy settings updated successfully!";
    } else {
        $error_msg = "Error updating privacy settings: " . mysqli_error($con);
    }
}
?>

<h2>Privacy Settings</h2>

<?php if(isset($success_msg)): ?>
    <div class="alert success"><?php echo $success_msg; ?></div>
<?php endif; ?>

<?php if(isset($error_msg)): ?>
    <div class="alert error"><?php echo $error_msg; ?></div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label>Who can see your posts?</label>
        <select name="post_privacy" class="form-control">
            <option value="public" <?php echo ($privacy_data['post_privacy'] == 'public') ? 'selected' : ''; ?>>Everyone</option>
            <option value="friends" <?php echo ($privacy_data['post_privacy'] == 'friends') ? 'selected' : ''; ?>>Friends Only</option>
            <option value="private" <?php echo ($privacy_data['post_privacy'] == 'private') ? 'selected' : ''; ?>>Only Me</option>
        </select>
        <small style="color: var(--text-secondary);">Control who can see your posts on your timeline</small>
    </div>

    <div class="form-group">
        <label>Who can send you friend requests?</label>
        <select name="friend_privacy" class="form-control">
            <option value="everyone" <?php echo ($privacy_data['friend_privacy'] == 'everyone') ? 'selected' : ''; ?>>Everyone</option>
            <option value="friends_of_friends" <?php echo ($privacy_data['friend_privacy'] == 'friends_of_friends') ? 'selected' : ''; ?>>Friends of Friends</option>
            <option value="none" <?php echo ($privacy_data['friend_privacy'] == 'none') ? 'selected' : ''; ?>>Nobody</option>
        </select>
        <small style="color: var(--text-secondary);">Control who can send you friend requests</small>
    </div>

    <button type="submit" name="save_privacy" class="btn-save">Save Privacy Settings</button>
</form>

<script>
    // Auto-hide alerts after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                
                // Remove the element after fade out
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 3000); // 3 seconds delay
        });
    });
</script>

<style>
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: var(--text-color);
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        background: var(--bg-color);
        color: var(--text-color);
    }

    .btn-save {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-save:hover {
        opacity: 0.9;
    }

    .alert {
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 20px;
        opacity: 1;
        transition: opacity 0.5s ease;
    }

    .alert.success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert.error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* Dark mode styles */
    [data-theme="dark"] .form-group label,
    [data-theme="dark"] .form-control,
    [data-theme="dark"] small {
        color: #ffffff;
    }

    [data-theme="dark"] .form-control {
        background: var(--bg-secondary);
        border-color: var(--border-color);
    }

    [data-theme="dark"] .form-control option {
        background: var(--bg-secondary);
    }
</style> 