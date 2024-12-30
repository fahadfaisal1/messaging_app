<?php
// Handle password update
if(isset($_POST['save_security'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Check if new passwords match
    if($new_password === $confirm_password) {
        // Hash new password and update
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = "UPDATE users SET password = '$hashed_password' 
                      WHERE id = {$_SESSION['user_id']}";
        
        if(mysqli_query($con, $update_sql)) {
            $success_msg = "Password updated successfully!";
        } else {
            $error_msg = "Error updating password!";
        }
    } else {
        $error_msg = "New passwords do not match!";
    }
}
?>

<h2>Security and Login</h2>

<?php if(isset($success_msg)): ?>
    <div class="alert success"><?php echo $success_msg; ?></div>
<?php endif; ?>

<?php if(isset($error_msg)): ?>
    <div class="alert error"><?php echo $error_msg; ?></div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label>Current Password</label>
        <input type="password" value="********" readonly>
        <small style="color: var(--text-secondary);">Your current password is securely stored</small>
    </div>

    <div class="form-group">
        <label>New Password</label>
        <input type="password" name="new_password" required>
    </div>

    <div class="form-group">
        <label>Confirm New Password</label>
        <input type="password" name="confirm_password" required>
    </div>

    <button type="submit" name="save_security" class="btn-save">Change Password</button>
</form>

<style>
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: var(--text-color);
    }

    .form-group input {
        width: 100%;
        padding: 8px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        background: var(--bg-color);
        color: var(--text-color);
    }

    .form-group input[readonly] {
        background: var(--bg-secondary);
        cursor: not-allowed;
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
    [data-theme="dark"] .form-group input,
    [data-theme="dark"] small {
        color: #ffffff;
    }

    [data-theme="dark"] .form-group input {
        background: var(--bg-secondary);
        border-color: var(--border-color);
    }

    [data-theme="dark"] .form-group input[readonly] {
        background: var(--bg-color);
    }
</style> 